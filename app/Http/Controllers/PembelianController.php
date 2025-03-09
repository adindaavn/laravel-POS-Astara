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
        $pembelian  = Pembelian::all();
        $detail     = PembelianDetail::all();
        $buku       = Buku::all();
        $pemasok    = Pemasok::all();
        return view('pembelian.index', compact('pembelian','detail','pemasok','buku'));
    }

    public function create()
    {
        $pemasok = Pemasok::all();
        $buku = Buku::all();
        $kategori = Kategori::all();
        return view('pembelian.create', compact('pemasok', 'buku','kategori'));
    }

    function store(Request $request)
    {
        $request->validate(
            [
                'tgl' => 'required|date',
                'total' => 'required|numeric',
                'pemasok_id' => 'nullable|integer|exists:pemasok,id',
                'user_id' => 'nullable|integer|exists:users,id',
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

            return redirect()->route('pembelian.index')->with('success', 'Pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pembelian.index')->with('error', 'Pembelian gagal ditambahkan :' . $e->getMessage());
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
