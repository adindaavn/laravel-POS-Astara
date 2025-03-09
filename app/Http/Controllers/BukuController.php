<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{

    function index()
    {
        $buku = Buku::all();
        $kategori = Kategori::all();
        return view('buku.index', compact('buku', 'kategori'));
    }

    public function create()
    {
        //
    }

    function store(Request $request)
    {
        $validated = $request->validate(
            [
                'judul'         => 'required|string',
                'penulis'       => 'required|string',
                'kategori_id'   => 'nullable|integer',
                'harga'         => 'nullable|numeric||min:0',
                'stok'          => 'nullable|integer|min:0',
                'pemasok'       => 'nullable|string',
                'isbn'          => 'required|string|max:20',
                'thn_terbit'    => 'nullable|integer'
            ]
        );
        try {

            Buku::create($validated);

            return redirect()->route('buku.index')->with('success', 'buku berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('buku.index')->with('error', 'buku gagal ditambahkan :' . $e->getMessage());
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
        $buku = Buku::findOrFail($id);

        $validated = $request->validate(
            [
                'judul'         => 'required|string',
                'penulis'       => 'required|string',
                'kategori_id'   => 'nullable|integer',
                'harga'         => 'nullable|numeric||min:0',
                'stok'          => 'nullable|integer|min:0',
                'pemasok'       => 'nullable|string',
                'isbn'          => 'required|string|min:0|max:20',
                'thn_terbit'    => 'nullable|integer'
            ]
        );

        try {
            $buku->update($validated);
            return redirect()->route('buku.index')->with('success', 'buku berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->route('buku.index')->with('error', 'buku gagal diedit :' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $buku = Buku::where('id', $id)->first();

        if (!$buku) {
            return redirect()->route('buku.index')->with('error', 'buku not found.');
        }

        try {
            $buku->delete();
            return redirect()->route('buku.index')->with('success', 'buku deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('buku.index')->with('error', 'Failed to delete buku : ' . $e->getMessage());
        }
    }
}
