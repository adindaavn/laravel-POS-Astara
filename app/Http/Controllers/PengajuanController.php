<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\PengajuanBuku;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;
use App\Exports\PengajuanBukuExport;
use Maatwebsite\Excel\Facades\Excel;

class PengajuanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan buku.
     */
    function index()
    {
        $pengajuan = PengajuanBuku::all(); // Mengambil semua data pengajuan buku
        $member = Member::all(); // Mengambil semua data member
        return view('pengajuan.index', compact('pengajuan', 'member'));
    }

    /**
     * Menampilkan form pembuatan pengajuan buku (tidak digunakan saat ini).
     */
    public function create()
    {
        //
    }

    /**
     * Menyimpan pengajuan buku baru ke database.
     */
    function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'qty' => 'nullable|integer',
            'member_id' => 'required|integer|exists:member,id',
        ]);

        try {
            $pengajuan = PengajuanBuku::create($validated); // Membuat data pengajuan baru
            return redirect()->back()->with('success', 'Pengajuan buku berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pengajuan buku gagal ditambahkan :' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail pengajuan buku tertentu (belum diimplementasikan).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan form edit pengajuan buku (belum diimplementasikan).
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Memperbarui data pengajuan buku.
     */
    public function update(Request $request, $id)
    {
        $pengajuan = PengajuanBuku::findOrFail($id); // Mencari data berdasarkan ID

        $validated = $request->validate([
            'nama' => 'required|string',
            'qty' => 'nullable|integer',
            'member_id' => 'required|integer|exists:member,id',
        ]);

        try {
            $pengajuan->update($validated); // Memperbarui data pengajuan
            return redirect()->back()->with('success', 'Pengajuan buku berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Pengajuan buku gagal diedit :' . $e->getMessage());
        }
    }

    /**
     * Menghapus pengajuan buku berdasarkan ID.
     */
    public function destroy($id)
    {
        $pengajuan = PengajuanBuku::where('id', $id)->first(); // Mencari data

        if (!$pengajuan) {
            return redirect()->back()->with('error', 'Pengajuan buku tidak ditemukan');
        }

        try {
            $pengajuan->delete(); // Menghapus data
            return redirect()->back()->with('success', 'Pengajuan buku berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus pengajuan buku : ' . $e->getMessage());
        }
    }

    /**
     * Menghasilkan file PDF dari daftar pengajuan buku.
     */
    public function generatePdf()
    {
        $pengajuan = PengajuanBuku::all(); // Mengambil semua data pengajuan
        $data = [
            'title' => 'Pengajuan Buku',
            'date' => date('m/d/Y'),
            'pengajuan' => $pengajuan
        ];

        $html = View::make('pengajuan.pdf_view', $data)->render(); // Mengubah data menjadi HTML

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait'); // Ukuran kertas A4
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="pengajuan.pdf"');
    }

    /**
     * Mengekspor data pengajuan buku ke dalam format Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new PengajuanBukuExport, 'pengajuan.xlsx');
    }

    /**
     * Memperbarui status pengajuan buku berdasarkan ID.
     */
    public function updateStatus(Request $request)
    {
        $pengajuan = PengajuanBuku::findOrFail($request->id); // Mencari data berdasarkan ID
        $pengajuan->status = $request->status; // Memperbarui status
        $pengajuan->save(); // Menyimpan perubahan

        return response()->json([
            'message' => 'Status berhasil diperbarui!',
            'status' => $pengajuan->status
        ]);
    }
}
