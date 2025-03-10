<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    function index()
    {
        $pembelian = Pembelian::with(['detailPembelian.buku', 'pemasok', 'user'])->get();

        return view('pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $pemasok = Pemasok::all();
        $buku = Buku::all();
        $kategori = Kategori::all();
        return view('pembelian.create', compact('pemasok', 'buku', 'kategori'));
    }

    function store(Request $request)
    {
        $bukuArray = json_decode($request->buku, true);
        if ($bukuArray === null) {
            return redirect()->route('penjualan.index')->with('error', 'Data buku tidak valid!');
        }
        $request->merge(['buku' => $bukuArray]);
        $request->validate(
            [
                'total' => 'required|numeric',
                'pemasok_id' => 'required|integer|exists:pemasok,id',
                'buku' => 'required|array',
                'buku.*.buku_id' => 'required|integer|exists:buku,id',
                'buku.*.harga_beli' => 'required|numeric|min:0',
                'buku.*.jumlah' => 'required|integer|min:1',
            ]
        );

        try {
            DB::beginTransaction();

            $pembelian = Pembelian::create([
                'tgl' => $request->tgl,
                'total' => $request->total,
                'pemasok_id' => $request->pemasok_id,
                'user_id' => $request->user_id
            ]);

            foreach ($request->buku as $item) {
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'buku_id' => $item['buku_id'],
                    'harga_beli' => $item['harga_beli'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga_beli'] * $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pembelian gagal ditambahkan :' . $e->getMessage());
        }
    }
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
