<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 *
 * Controller untuk mengelola data user, termasuk menampilkan, menambah, mengedit, dan menghapus user.
 */
class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     *
     * @return \Illuminate\View\View
     */
    function index()
    {
        $user = User::all();
        return view('user.index', compact('user'));
    }


    public function create()
    {
        // 
    }

    /**
     * Menyimpan data user baru ke database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:50',
                'username' => 'required|string|max:25',
                'password' => 'required|string',
                'role' => 'required|string|in:owner,admin,kasir',
            ]
        );
        try {
            $validated['password'] = Hash::make($validated['password']);
            User::create($validated);
            return redirect()->back()->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'User gagal ditambahkan: ' . $e->getMessage());
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

    /**
     * Memperbarui data user berdasarkan ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate(
            [
                'name' => 'required|string|max:50',
                'username' => 'nullable|string|max:25',
                'password' => 'nullable|string',
                'role' => 'nullable|string',
            ]
        );

        try {
            $validated['password'] = Hash::make($validated['password']);
            $user->update($validated);
            return redirect()->back()->with('success', 'User berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'User gagal diedit: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus data user berdasarkan ID.
     *
     * @param string $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun aktif.');
        }

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        try {
            $user->delete();
            return redirect()->back()->with('success', 'User berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
}
