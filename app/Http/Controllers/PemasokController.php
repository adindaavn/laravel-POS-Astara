<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{
    /**
     * Menampilkan daftar semua pemasok.
     * 
     * @return \Illuminate\View\View
     */
    function index()
    {
        $pemasok = Pemasok::all();
        return view('pemasok.index', compact('pemasok'));
    }

    /**
     * Menampilkan form untuk menambahkan pemasok baru.
     * (Saat ini belum diimplementasikan)
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan data pemasok baru ke dalam database.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate(
            [
                'nama'      => 'required|string|max:100',
                'alamat'    => 'nullable|string',
                'telp'      => 'nullable|string|max:20',
                'email'     => 'nullable|email'
            ]
        );

        try {
            // Menyimpan data pemasok ke dalam database
            Pemasok::create($validated);

            return redirect()->back()->with('success', 'Pemasok berhasil ditambahkan');
        } catch (\Exception $e) {
            // Menangani kesalahan jika gagal menyimpan
            return redirect()->back()->with('error', 'Pemasok gagal ditambahkan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pemasok berdasarkan ID.
     * (Saat ini belum diimplementasikan)
     * 
     * @param  string  $id
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form edit pemasok berdasarkan ID.
     * (Saat ini belum diimplementasikan)
     * 
     * @param  string  $id
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Memperbarui data pemasok berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Mencari pemasok berdasarkan ID
        $pemasok = Pemasok::findOrFail($id);

        // Validasi input dari request
        $validated = $request->validate(
            [
                'nama'      => 'required|string|max:100',
                'alamat'    => 'nullable|string',
                'telp'      => 'nullable|string|max:20',
                'email'     => 'nullable|email'
            ]
        );

        try {
            // Memperbarui data pemasok
            $pemasok->update($validated);
            return redirect()->back()->with('success', 'Pemasok berhasil diedit');
        } catch (\Exception $e) {
            // Menangani kesalahan jika gagal mengupdate
            return redirect()->back()->with('error', 'Pemasok gagal diedit: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data pemasok berdasarkan ID.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Mencari pemasok berdasarkan ID
        $pemasok = Pemasok::where('id', $id)->first();

        // Jika pemasok tidak ditemukan, kembalikan error
        if (!$pemasok) {
            return redirect()->back()->with('error', 'Pemasok tidak ditemukan.');
        }

        try {
            // Menghapus pemasok dari database
            $pemasok->delete();
            return redirect()->back()->with('success', 'Pemasok berhasil dihapus.');
        } catch (\Exception $e) {
            // Menangani kesalahan jika gagal menghapus
            return redirect()->back()->with('error', 'Gagal menghapus pemasok: ' . $e->getMessage());
        }
    }
}
