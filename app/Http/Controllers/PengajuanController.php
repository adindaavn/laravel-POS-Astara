<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PengajuanBuku;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use App\Exports\PengajuanBukuExport;
use App\Models\Log;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class PengajuanController
 *
 * Controller untuk mengelola data pengajuan buku, termasuk menampilkan, menambah, mengedit, dan menghapus pengajuan.
 */
class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan buku.
     * 
     * @return \Illuminate\View\View
     */
    function index()
    {
        $pengajuan = PengajuanBuku::all(); 
        $member = Member::all();
        return view('pengajuan.index', compact('pengajuan', 'member'));
    }

    public function create()
    {
        //
    }

    /**
     * Menyimpan pengajuan buku baru ke database.
     * 
     * @return \Illuminate\View\View
     */
    function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'qty' => 'nullable|integer',
            'catatan' => 'nullable|string',
            'member_id' => 'nullable|integer|exists:member,id',
            'nama_pengaju' => 'nullable|required_without:member_id|string',
            'no_telp' => 'nullable|required_without:member_id|string',
        ]);
        try {
            if (!empty($validated['member_id'])) {
                $member = Member::find($validated['member_id']);
                if ($member) {
                    $validated['nama_pengaju'] = $member->nama;
                    $validated['no_telp'] = $member->telp;
                }
            }

            $data = PengajuanBuku::create($validated); 
            Log::createLog('pengajuan', 'create', $data);
            return redirect()->back()->with('success', 'Pengajuan buku berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pengajuan buku gagal ditambahkan :' . $e->getMessage());
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
     * Memperbarui data pengajuan buku berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string',
            'nama_pengaju' => 'nullable|string',
            'qty' => 'nullable|integer',
            'member_id' => 'nullable|integer|exists:member,id',
        ]);

        try {
            $pengajuan->update($validated);

            Log::createLog('pengajuan', 'update', $pengajuan);
            return redirect()->back()->with('success', 'Pengajuan buku berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pengajuan buku gagal diedit :' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data pengajuan buku berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanBuku::where('id', $id)->first();

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan buku tidak ditemukan');
        }

        try {
            Log::createLog('pengajuan', 'delete', $pengajuan);
            $pengajuan->delete(); 
            return redirect()->back()->with('success', 'Pengajuan buku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pengajuan buku : ' . $e->getMessage());
        }
    }


    /**
     * Memperbarui status pengajuan buku berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateStatus(Request $request)
    {
        $pengajuan = PengajuanBuku::findOrFail($request->id); // Mencari data berdasarkan ID
        $pengajuan->status = $request->status; // Memperbarui status
        $pengajuan->save(); // Menyimpan perubahan
        Log::createLog('pengajuan', 'updateStatus', $pengajuan);
        return response()->json([
            'message' => 'Status berhasil diperbarui!',
            'status' => $pengajuan->status
        ]);
    }
}
