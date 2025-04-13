<?php

namespace App\Http\Controllers;

use App\Exports\UniversalExport;
use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\PengajuanBuku;
use App\Models\Penjualan;
use App\Models\StokBuku;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\View;

class exportLaporan extends Controller
{
    protected $laporanConfig = [
        'buku' => [
            'model' => StokBuku::class,
            'headers' => ['ISBN', 'Judul', 'Penulis', 'Kategori', 'Harga', 'Stok', 'Penerbit', 'Tahun Terbit', 'Gambar'],
            'view' => 'export.pdf'
        ],
        'kategori' => [
            'model' => Kategori::class,
            'withCount' => ['buku'],
            'headers' => ['ID', 'Nama', 'Total Buku'],
            'view' => 'export.pdf'
        ],
        'member' => [
            'model' => Member::class,
            'headers' => ['ID', 'Nama', 'Point', 'No. Telepon', 'E-mail'],
            'view' => 'export.pdf'
        ],
        'pengajuan' => [
            'model' => PengajuanBuku::class,
            'headers' => ['ID', 'Pengaju', 'No. Telepon', 'Member ID', 'Judul', 'Penulis', 'Qty', 'Catatan','Status', 'Tanggal'],
            'view' => 'export.pdf'
        ],
        'penjualan' => [
            'model' => Penjualan::class,
            'with' => ['detailPenjualan.buku', 'member', 'user'],
            'headers' => ['No. Transaksi', 'Kasir', 'Member', 'Buku', 'Total', 'Tanggal'],
            'view' => 'export.pdf'
        ],
        'pembelian' => [
            'model' => Pembelian::class,
            'with' => ['detailPembelian.buku', 'pemasok', 'user'],
            'headers' => ['User', 'Pemasok', 'Buku', 'Total', 'Tanggal'],
            'view' => 'export.pdf'
        ],
    ];

    public function exportExcel(Request $request)
    {
        $tipe = $request->get('tipe');

        if (!array_key_exists($tipe, $this->laporanConfig)) {
            return response()->json(['error' => 'Jenis laporan tidak ditemukan'], 404);
        }

        $config = $this->laporanConfig[$tipe];
        $query = $config['model']::query();

        if (isset($config['with'])) {
            $query->with($config['with']);
        }

        if (isset($config['withCount'])) {
            $query->withCount($config['withCount']);
        }

        $data = $query->get()->map->toExportArray();

        return Excel::download(
            new UniversalExport($data->toArray(), $config['headers']),
            "{$tipe}.xlsx"
        );
    }

    public function exportPDF(Request $request)
    {
        $tipe = $request->get('tipe');

        if (!array_key_exists($tipe, $this->laporanConfig)) {
            return response()->json(['error' => 'Jenis laporan tidak ditemukan'], 404);
        }

        $config = $this->laporanConfig[$tipe];
        $query = $config['model']::query();

        if (isset($config['with'])) {
            $query->with($config['with']);
        }

        if (isset($config['withCount'])) {
            $query->withCount($config['withCount']);
        }

        $data = $query->get()->map->toExportArray();

        $html = View::make($config['view'], [
            'title' => ucfirst($tipe),
            'date' => date('m/d/Y'),
            'headings' => $config['headers'],
            'data' => $data
        ])->render();

        $options = new Options();
        $options->set('defaultFont', 'Helvetica');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', "attachment; filename=\"{$tipe}.pdf\"");
    }
}
