<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

/**
 * Class KategoriController
 * Mengelola kategori buku, termasuk CRUD (Create, Read, Update, Delete).
 */
class KategoriController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $kategori = Kategori::all(); // Ambil semua data kategori
        return view('kategori.index', compact('kategori')); // Kirim data ke view
    }

    public function create()
    {
    }

    /**
     * Menyimpan kategori baru ke database.
     *
     * @param Request $request Permintaan HTTP yang berisi data kategori baru.
     * @return \Illuminate\Http\RedirectResponse Redirect kembali dengan pesan sukses atau error.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|min:1|max:50'
        ]);

        try {
            // Simpan kategori baru ke database
            Kategori::create($validated);
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->with('error', 'Kategori gagal ditambahkan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
    }

    /**
     * Memperbarui data kategori berdasarkan ID.
     *
     * @param Request $request Permintaan HTTP berisi data kategori yang diperbarui.
     * @param int $id ID kategori yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse Redirect ke daftar kategori dengan pesan sukses atau error.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|min:1|max:50'
        ]);

        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, kembali ke halaman kategori dengan pesan error
        if (!$kategori) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
        }

        try {
            // Update kategori
            $kategori->update($validated);
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->with('error', 'Kategori gagal diperbarui: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus kategori berdasarkan ID.
     *
     * @param int $id ID kategori yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse Redirect ke daftar kategori dengan pesan sukses atau error.
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);

        // Jika kategori tidak ditemukan, kembali ke halaman kategori dengan pesan error
        if (!$kategori) {
            return redirect()->route('kategori.index')->with('error', 'Kategori tidak ditemukan');
        }

        try {
            // Hapus kategori
            $kategori->delete();
            return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')->with('error', 'Kategori gagal dihapus: ' . $e->getMessage());
        }
    }
}
