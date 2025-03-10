<?php

namespace App\Http\Controllers;

use App\Models\Pemasok;
use Illuminate\Http\Request;

class PemasokController extends Controller
{

    function index()
    {
        $pemasok = Pemasok::all();
        return view('pemasok.index', compact('pemasok'));
    }
    public function create()
    {
        //
    }

    function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nama'      => 'required|string|max:100',
                'alamat'    => 'nullable|string',
                'telp'     => 'nullable|string|max:20',
                'email'     => 'nullable|email'
            ]
        );

        try {

            pemasok::create($validated);

            return redirect()->back()->with('success', 'pemasok berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'pemasok gagal ditambahkan :' . $e->getMessage());
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
        $pemasok = Pemasok::findOrFail($id);

        $validated = $request->validate(
            [
                'nama'      => 'required|string|max:100',
                'alamat'    => 'nullable|string',
                'telp'     => 'nullable|string|max:20',
                'email'     => 'nullable|email'
            ]
        );

        try {
            $pemasok->update($validated);
            return redirect()->back()->with('success', 'pemasok berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'pemasok gagal diedit :' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $pemasok = Pemasok::where('id', $id)->first();

        if (!$pemasok) {
            return redirect()->back()->with('error', 'pemasok not found.');
        }

        try {
            $pemasok->delete();
            return redirect()->back()->with('success', 'pemasok deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete pemasok : ' . $e->getMessage());
        }
    }
}
