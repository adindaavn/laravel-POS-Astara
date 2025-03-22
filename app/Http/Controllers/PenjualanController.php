<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi penjualan.
     */
    function index()
    {
        $penjualan = Penjualan::with(['detailPenjualan.buku', 'member', 'user'])->get();
        return view('penjualan.index', compact('penjualan'));
    }

    /**
     * Menampilkan form untuk membuat transaksi penjualan baru.
     */
    public function create()
    {
        $stok = DB::table('view_buku_stok')->where('stok', '>', 0)->get();
        $member = Member::all();
        $voucher = Voucher::all();
        $buku = Buku::all();
        $kategori = Kategori::all();
        return view('penjualan.create', compact('member', 'buku', 'stok', 'kategori', 'voucher'));
    }

    /**
     * Menyimpan transaksi penjualan baru ke database.
     */
    function store(Request $request)
    {
        // Mengubah JSON buku menjadi array
        $bukuArray = json_decode($request->buku, true);
        if ($bukuArray === null) {
            return redirect()->back()->with('error', 'Data buku tidak valid!');
        }
        $request->merge(['buku' => $bukuArray]);

        // Validasi data input
        $request->validate([
            'total_bayar' => 'required|numeric|min:0',
            'total_bersih' => 'required|numeric|min:0',
            'member_id' => 'nullable|exists:member,id',
            'buku' => 'required|array',
            'buku.*.buku_id' => 'required|integer|exists:buku,id',
            'buku.*.harga_jual' => 'required|numeric|min:0',
            'buku.*.jumlah' => 'required|integer|min:1',
            'metode_bayar' => 'nullable|in:cash,transfer,kartu',
            'no_rekening' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Membuat entri baru dalam tabel Penjualan
            $penjualan = Penjualan::create([
                'total_bayar' => $request->total_bayar,
                'total_bersih' => $request->total_bersih,
                'member_id' => $request->member_id,
                'user_id' => $request->user_id,
                'metode_bayar' => $request->metode_bayar,
                'no_rekening' => $request->no_rekening
            ]);

            // Menambahkan detail penjualan berdasarkan buku yang dipilih
            foreach ($request->buku as $item) {
                PenjualanDetail::create([
                    'penjualan_id' => $penjualan->id,
                    'buku_id' => $item['buku_id'],
                    'harga_jual' => $item['harga_jual'],
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $item['harga_jual'] * $item['jumlah'],
                ]);
            }

            DB::commit();

            return redirect()->route('penjualan.create', ['print' => 'true'])->with([
                'success' => 'Transaksi berhasil ditambahkan!',
                'no_transaksi' => $penjualan->no_transaksi,
                'kembali' => $request->kembali,
                'pajak' => $request->pajak,
                'total_bersih' => $request->total_bersih,
                'total_bayar' => $request->total_bayar,
                'bayar' => $request->bayar,
                'buku' => $bukuArray,
                'created_at' => $penjualan->created_at->format('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Transaksi gagal! ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail transaksi penjualan berdasarkan ID.
     */
    public function show(string $id)
    {
        // Implementasi jika diperlukan
    }

    /**
     * Menampilkan form edit transaksi penjualan.
     */
    public function edit(string $id)
    {
        // Implementasi jika diperlukan
    }

    /**
     * Memperbarui transaksi penjualan yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        // Implementasi jika diperlukan
    }

    /**
     * Menghapus transaksi penjualan berdasarkan ID.
     */
    public function destroy($id)
    {
        // Implementasi jika diperlukan
    }
}
