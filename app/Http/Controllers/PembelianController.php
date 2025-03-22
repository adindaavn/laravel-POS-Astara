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
    /**
     * Menampilkan daftar semua pembelian.
     * 
     * @return \Illuminate\View\View
     */
    function index()
    {
        // Mengambil data pembelian beserta relasi detail pembelian, pemasok, dan user
        $pembelian = Pembelian::with(['detailPembelian.buku', 'pemasok', 'user'])->get();

        return view('pembelian.index', compact('pembelian'));
    }

    /**
     * Menampilkan form untuk menambahkan pembelian baru.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pemasok = Pemasok::all();
        $buku = Buku::all();
        $kategori = Kategori::all();

        return view('pembelian.create', compact('pemasok', 'buku', 'kategori'));
    }

    /**
     * Menyimpan data pembelian baru ke dalam database.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        // Mengubah data buku dari JSON ke array
        $bukuArray = json_decode($request->buku, true);
        if ($bukuArray === null) {
            return redirect()->route('pembelian.index')->with('error', 'Data buku tidak valid!');
        }

        // Memasukkan kembali array ke dalam request agar bisa divalidasi
        $request->merge(['buku' => $bukuArray]);

        // Validasi input dari request
        $request->validate([
            'total'        => 'required|numeric',
            'pemasok_id'   => 'required|integer|exists:pemasok,id',
            'buku'         => 'required|array',
            'buku.*.buku_id' => 'required|integer|exists:buku,id',
            'buku.*.harga_beli' => 'required|numeric|min:0',
            'buku.*.jumlah'  => 'required|integer|min:1',
        ]);
        try {
            DB::beginTransaction();

            // Menyimpan data pembelian ke dalam database
            $pembelian = Pembelian::create([
                'total'      => $request->total,
                'pemasok_id' => $request->pemasok_id,
                'user_id'    => $request->user_id
            ]);

            // Menyimpan detail pembelian
            foreach ($request->buku as $item) {
                PembelianDetail::create([
                    'pembelian_id' => $pembelian->id,
                    'buku_id'      => $item['buku_id'],
                    'harga_beli'   => $item['harga_beli'],
                    'jumlah'       => $item['jumlah'],
                    'subtotal'     => $item['harga_beli'] * $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Pembelian berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Pembelian gagal ditambahkan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pembelian berdasarkan ID.
     * (Saat ini belum diimplementasikan)
     * 
     * @param  string  $id
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form edit pembelian berdasarkan ID.
     * (Saat ini belum diimplementasikan)
     * 
     * @param  string  $id
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Memperbarui data pembelian berdasarkan ID.
     * (Saat ini belum diimplementasikan)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Menghapus data pembelian berdasarkan ID.
     * (Saat ini belum diimplementasikan)
     * 
     * @param  int  $id
     */
    public function destroy($id)
    {
        //
    }
}
