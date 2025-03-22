<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar semua member.
     *
     * @return \Illuminate\View\View
     */
    function index()
    {
        $member = Member::all();
        return view('member.index', compact('member'));
    }

    /**
     * Menampilkan form untuk membuat member baru.
     */
    public function create()
    {
        // Tidak ada implementasi saat ini
    }

    /**
     * Menyimpan data member baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        $validated = $request->validate(
            [
                'nama' => 'required|string|max:100',
                'alamat' => 'nullable|string',
                'telp' => 'nullable|string|max:20',
                'email' => 'nullable|email'
            ]
        );
        try {
            Member::create($validated);
            return redirect()->back()->with('success', 'Member berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Member gagal ditambahkan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail member berdasarkan ID.
     *
     * @param string $id
     */
    public function show(string $id)
    {
        // Tidak ada implementasi saat ini
    }

    /**
     * Menampilkan form untuk mengedit data member berdasarkan ID.
     *
     * @param string $id
     */
    public function edit(string $id)
    {
        // Tidak ada implementasi saat ini
    }

    /**
     * Memperbarui data member berdasarkan ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $validated = $request->validate(
            [
                'nama' => 'required|string|max:100',
                'alamat' => 'nullable|string',
                'telp' => 'nullable|string|max:20',
                'email' => 'nullable|string'
            ]
        );

        try {
            $member->update($validated);
            return redirect()->back()->with('success', 'Member berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Member gagal diedit: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data member berdasarkan ID.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $member = Member::where('id', $id)->first();

        if (!$member) {
            return redirect()->back()->with('error', 'Member tidak ditemukan.');
        }

        try {
            $member->delete();
            return redirect()->back()->with('success', 'Member berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus member: ' . $e->getMessage());
        }
    }
}
