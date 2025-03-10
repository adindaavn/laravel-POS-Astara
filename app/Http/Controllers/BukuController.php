<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BukuController extends Controller
{

    function index()
    {
        $stok = DB::table('view_buku_stok')->get();
        $buku = Buku::all();
        $kategori = Kategori::all();
        return view('buku.index', compact('buku', 'kategori', 'stok'));
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
                'penerbit'       => 'nullable|string',
                'isbn'          => 'required|string|max:20',
                'thn_terbit'    => 'nullable|integer'
            ]
        );
        try {

            Buku::create($validated);

            return redirect()->back()->with('success', 'buku berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'buku gagal ditambahkan :' . $e->getMessage());
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
                'penerbit'       => 'nullable|string',
                'isbn'          => 'required|string|min:0|max:20',
                'thn_terbit'    => 'nullable|integer'
            ]
        );

        try {
            $buku->update($validated);
            return redirect()->back()->with('success', 'buku berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'buku gagal diedit :' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $buku = Buku::where('id', $id)->first();

        if (!$buku) {
            return redirect()->back()->with('error', 'buku not found.');
        }

        try {
            $buku->delete();
            return redirect()->back()->with('success', 'buku deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete buku : ' . $e->getMessage());
        }
    }
}
