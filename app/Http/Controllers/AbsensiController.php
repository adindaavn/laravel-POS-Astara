<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Log;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{

    /**
     * Menampilkan daftar absensi karyawan.
     * 
     * @return \Illuminate\View\View
     */
    function index()
    {
        $absensi = Absensi::all();
        return view('absensi.index', compact('absensi'));
    }

    public function create()
    {
        //
    }

    /**
     * Menyimpan absensi karyawan baru ke database.
     * 
     * @return \Illuminate\View\View
     */
    function store(Request $request)
    {
        $validated = $request->validate([
            'nama_karyawan' => 'required|string',
            'tgl_masuk' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'status' => 'required|string|in:masuk,sakit,cuti',
        ]);

        // dd($validated);
        try {
            $data = Absensi::create($validated);
            Log::createLog('absensi', 'create', $data);
            return redirect()->back()->with('success', 'Absensi karyawan berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Absensi karyawan gagal ditambahkan :' . $e->getMessage());
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
     * Memperbarui data absensi karyawan berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail($id);

        $validated = $request->validate([
            'nama_karyawan' => 'required|string',
            'tgl_masuk' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
            'status' => 'required|string|in:masuk,sakit,cuti',
        ]);

        dd($validated);

        try {
            $absensi->update($validated);
            Log::createLog('absensi', 'update', $absensi);
            return redirect()->back()->with('success', 'Absensi karyawan berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Absensi karyawan gagal diedit :' . $e->getMessage());
        }
    }

    /**
     * Memperbarui data absensi karyawan berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $absensi = Absensi::where('id', $id)->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Absensi karyawan tidak ditemukan');
        }

        try {
            Log::createLog('absensi', 'delete', $absensi);
            $absensi->delete();
            return redirect()->back()->with('success', 'Absensi karyawan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus absensi karyawan : ' . $e->getMessage());
        }
    }

    /**
     * Memperbarui status absensi karyawan berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function updateStatus(Request $request)
    {
        $absensi = Absensi::findOrFail($request->id);
        $absensi->status = $request->status;
        $absensi->save();
        Log::createLog('absensi', 'updateStatus', $absensi);
        return response()->json([
            'message' => 'Status berhasil diperbarui!',
            'status' => $absensi->status
        ]);
    }

    /**
     * Tambah jam selesai kerja karyawan berdasarkan ID.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function selesaiKerja(Request $request)
    {
        $absensi = Absensi::findOrFail($request->id);
        $absensi->jam_selesai = now();
        $absensi->save();
        Log::createLog('absensi', 'selesaiKerja', $absensi);
        return response()->json([
            'message' => 'Waktu selesai kerja berhasil diperbarui!',
            'jam_selesai' => $absensi->jam_selesai
        ]);
    }
}
