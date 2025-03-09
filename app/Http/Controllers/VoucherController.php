<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{

    function index()
    {
        $voucher = Voucher::all();
        return view('voucher.index', compact('voucher'));
    }
    public function create()
    {
        //
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'diskon' => 'required|string|in:fixed,percent',
            'deskripsi' => 'nullable|string',
            'expired' => 'nullable|date'
        ]);

        try {

            Voucher::create($validated);

            return redirect()->route('voucher.index')->with('success', 'voucher berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('voucher.index')->with('error', 'voucher gagal ditambahkan :' . $e->getMessage());
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
        $voucher = Voucher::findOrFail($id);

        $validated = $request->validate([
            'diskon' => 'required|string|in:fixed,percent',
            'deskripsi' => 'nullable|string',
            'expired' => 'nullable|date'
        ]);

        try {

            $voucher->update($validated);

            return redirect()->route('voucher.index')->with('success', 'voucher berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->route('voucher.index')->with('error', 'voucher gagal diedit :' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $voucher = Voucher::where('id', $id)->first();

        if (!$voucher) {
            return redirect()->route('voucher.index')->with('error', 'voucher not found.');
        }

        try {
            $voucher->delete();
            return redirect()->route('voucher.index')->with('success', 'voucher deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('voucher.index')->with('error', 'Failed to delete voucher : ' . $e->getMessage());
        }
    }
}
