<?php

namespace App\Http\Controllers;

use App\Exports\FormatImport;
use Illuminate\Http\Request;
use App\Imports\UniversalImport;
use App\Models\Absensi;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pemasok;
use App\Models\Pembelian;
use App\Models\PengajuanBuku;
use App\Models\Penjualan;
use Maatwebsite\Excel\Facades\Excel;

class importLaporan extends Controller
{
    protected $importConfig = [
        'buku' => [
            'model' => Buku::class,
            'fields' => ['isbn', 'judul', 'penulis', 'penerbit', 'kategori_id', 'harga', 'gambar', 'thn_terbit'], 
        ],
        'kategori' => [
            'model' => Kategori::class,
            'fields' => ['nama'],
        ],
        'member' => [
            'model' => Member::class,
            'fields' => ['nama', 'point', 'telp', 'email'],
        ],
        'pemasok' => [
            'model' => Pemasok::class,
            'fields' => ['nama', 'telp', 'email', 'alamat'],
        ],
        'pengajuan' => [
            'model' => PengajuanBuku::class,
            'fields' => ['nama_pengaju', 'no_telp','member_id','judul','penulis','qty','catatan','status', 'tgl'],
        ],
        'penjualan' => [
            'model' => Penjualan::class,
            'fields' => ['no_transaksi','member_id','user_id','tgl','total_bayar','total_bersih','diskon','metode_bayar'],
        ],
        'pembelian' => [
            'model' => Pembelian::class,
            'fields' => ['pemasok_id','user_id','tgl','total'],
        ],
        'absensi' => [
            'model' => Absensi::class,
            'fields' => ['nama_karyawan', 'tgl_masuk', 'jam_masuk', 'jam_selesai', 'status'],
        ],
    ];

    public function importExcel(Request $request)
    {
        $request->validate([
            'tipe' => 'required|in:' . implode(',', array_keys($this->importConfig)),
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $tipe = $request->tipe;
        $config = $this->importConfig[$tipe];

        Excel::import(new UniversalImport($config['model'], $config['fields']), $request->file('file'));

        return redirect()->back()->with('success', 'Data berhasil diimport!');
    }


    public function formatImport(Request $request)
    {
        $tipe = $request->get('tipe');

        if (!array_key_exists($tipe, $this->importConfig)) {
            return response()->json(['error' => 'Jenis laporan tidak ditemukan'], 404);
        }

        $config = $this->importConfig[$tipe];

        return Excel::download(
            new FormatImport($config['fields']),
            "{$tipe}-import-format.xlsx"
        );
    }
}
