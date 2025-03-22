<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Class BukuController
 * Controller untuk mengelola data buku, termasuk menampilkan, menambah, mengedit, dan menghapus buku.
 */
class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stok = DB::table('view_buku_stok')->get();
        $kategori = Kategori::all(); // Mengambil semua data buku dari database
        $buku = Buku::all(); // Mengambil semua data buku dari database
        return view('buku.index', compact('buku','stok', 'kategori')); // Mengirim data ke view
    }

    /**
     * Menampilkan formulir untuk menambahkan buku baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('buku.create');
    }

    /**
     * Menyimpan buku baru ke dalam database.
     *
     * @param Request $request Permintaan HTTP berisi data buku.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman daftar buku setelah berhasil menambahkan.
     */
    public function store(Request $request)
    {
        // Validasi input sebelum disimpan
        $validated = $request->validate([
            'isbn' => 'required|unique:buku|max:20',
            'judul' => 'required|max:255',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'kategori_id' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thn_terbit' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        // Menyimpan data ke database
        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail buku berdasarkan ID.
     *
     * @param int $id ID buku.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $buku = Buku::findOrFail($id); // Mencari buku berdasarkan ID atau gagal jika tidak ditemukan
        return view('buku.show', compact('buku'));
    }

    /**
     * Menampilkan formulir untuk mengedit buku.
     *
     * @param int $id ID buku.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }

    /**
     * Memperbarui data buku di database.
     *
     * @param Request $request Permintaan HTTP dengan data buku yang diperbarui.
     * @param int $id ID buku yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman daftar buku setelah berhasil diperbarui.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'isbn' => 'required|max:20|unique:buku,isbn,' . $id,
            'judul' => 'required|max:255',
            'penulis' => 'required|max:100',
            'penerbit' => 'required|max:100',
            'kategori_id' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'thn_terbit' => 'required|integer|min:1900|max:' . date('Y'),
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Menghapus buku dari database.
     *
     * @param int $id ID buku yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman daftar buku setelah berhasil dihapus.
     */
    public function destroy($id)
    {
        $buku = Buku::where('id', $id)->first();

        if (!$buku) {
            return redirect()->back()->with('error', 'buku not found.');
        }
        if ($buku->gambar) {
            Storage::disk('public')->delete($buku->gambar);
        }
        try {
            $buku->delete();
            return redirect()->back()->with('success', 'buku deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete buku : ' . $e->getMessage());
        }
    }
}
