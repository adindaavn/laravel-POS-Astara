<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    // Menampilkan semua voucher
    function index()
    {
        $voucher = Voucher::all();
        return view('voucher.index', compact('voucher'));
    }

    // Menampilkan form untuk membuat voucher baru (belum diimplementasi)
    public function create()
    {
        //
    }

    // Menyimpan voucher baru ke database
    function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'diskon' => 'required|numeric', // Wajib, harus angka
            'deskripsi' => 'nullable|string', // Boleh kosong, harus string
            'expired' => 'nullable|date' // Boleh kosong, harus format tanggal
        ]);

        try {
            // Menyimpan data voucher ke database
            Voucher::create($validated);

            return redirect()->back()->with('success', 'Voucher berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Voucher gagal ditambahkan: ' . $e->getMessage());
        }
    }

    // Menampilkan detail voucher tertentu (belum diimplementasi)
    public function show(string $id)
    {
        //
    }

    // Menampilkan form untuk mengedit voucher (belum diimplementasi)
    public function edit(string $id)
    {
        //
    }

    // Mengupdate data voucher yang sudah ada
    public function update(Request $request, $id)
    {
        // Cari voucher berdasarkan ID, jika tidak ditemukan akan throw error 404
        $voucher = Voucher::findOrFail($id);

        // Validasi input dari request
        $validated = $request->validate([
            'diskon' => 'required|numeric', // Wajib, harus angka
            'deskripsi' => 'nullable|string', // Boleh kosong, harus string
            'expired' => 'nullable|date' // Boleh kosong, harus format tanggal
        ]);

        try {
            // Update voucher dengan data yang divalidasi
            $voucher->update($validated);

            return redirect()->back()->with('success', 'Voucher berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Voucher gagal diedit: ' . $e->getMessage());
        }
    }

    // Menghapus voucher berdasarkan ID
    public function destroy($id)
    {
        // Mencari voucher berdasarkan ID
        $voucher = Voucher::where('id', $id)->first();

        // Jika voucher tidak ditemukan, kembalikan pesan error
        if (!$voucher) {
            return redirect()->back()->with('error', 'Voucher tidak ditemukan');
        }

        try {
            // Hapus voucher dari database
            $voucher->delete();
            return redirect()->back()->with('success', 'Voucher berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus voucher: ' . $e->getMessage());
        }
    }
}
