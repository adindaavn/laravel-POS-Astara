<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pemasok;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{

    function index()
    {
        $penjualan = Penjualan::all();
        $detail = PenjualanDetail::all();
        $buku = Buku::all();
        $member = Member::all();
        return view('penjualan.index', compact('penjualan', 'detail', 'buku', 'member'));
    }

    public function create()
    {
        $member = Member::all();
        $buku = Buku::all();
        return view('penjualan.create', compact('member', 'buku'));
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
                'total_bayar' => 'required|numeric|min:0',
                'member_id' => 'nullable|exists:member,id',
                'buku' => 'required|array',
                'buku.*.buku_id' => 'required|integer|exists:buku,id',
                'buku.*.harga_jual' => 'required|numeric|min:0',
                'buku.*.jumlah' => 'required|integer|min:1',
                'metode_bayar' => 'nullable|in:cash,transfer,e-wallet,debit',
                'no_rekening' => 'nullable|string',
            ]
        );

        try {
            DB::beginTransaction();

            $penjualan = Penjualan::create([
                'total_bayar' => $request->total_bayar,
                'member_id' => $request->member_id,
                'user_id' => $request->user_id,
                'metode_bayar' => $request->metode_bayar,
                'no_rekening' => $request->no_rekening
            ]);

            foreach ($request->buku as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'buku_id' => $item['buku_id'],
                    'harga_jual' => $item['harga_jual'],
                    'jumlah' => $item['jumlah'],
                    'sub_total' => $item['harga_jual'] * $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Transaksi berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('penjualan.index')->with('error', 'Transaksi gagal! ' . $e->getMessage());
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
