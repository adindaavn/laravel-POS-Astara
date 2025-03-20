<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // laporan perbulan
        $bulanIni = Carbon::now()->month;
        $tahunIni = Carbon::now()->year;

        $bulanLalu = Carbon::now()->subMonth()->month;
        $tahunLalu = Carbon::now()->subMonth()->year;

        $totalTransaksi = Penjualan::count();

        $penjualan = Penjualan::whereMonth('tgl', $bulanIni)
            ->whereYear('tgl', $tahunIni)
            ->sum('total_bayar');
        $penjualanLalu = Penjualan::whereMonth('tgl', $bulanLalu)
            ->whereYear('tgl', $tahunLalu)
            ->sum('total_bayar');

        if ($penjualanLalu > 0) {
            $persenJual = number_format(((($penjualan - $penjualanLalu) / $penjualanLalu) * 100), 2);
        } else {
            $persenJual = $penjualan > 0 ? 100 : 0;
        }

        $pembelian = Pembelian::whereMonth('tgl', $bulanIni)
            ->whereYear('tgl', $tahunIni)
            ->sum('total');
        $pembelianLalu = Pembelian::whereMonth('tgl', $bulanLalu)
            ->whereYear('tgl', $tahunLalu)
            ->sum('total');

        if ($pembelianLalu > 0) {
            $persenBeli = number_format(((($pembelian - $pembelianLalu) / $pembelianLalu) * 100), 2);
        } else {
            $persenBeli = $pembelian > 0 ? 100 : 0;
        }

        $pendapatan = $penjualan - $pembelian;
        $pendapatanLalu = $penjualanLalu - $pembelianLalu;
        if ($pendapatanLalu > 0) {
            $persenLaba = number_format(((($pendapatan - $pendapatanLalu) / $pendapatanLalu) * 100), 2);
        } else {
            $persenLaba = $pendapatan > 0 ? 100 : 0;
        }

        // laporan perminguu
        $mingguIniMulai = Carbon::now()->startOfWeek();
        $mingguIniAkhir = Carbon::now()->endOfWeek();

        $mingguLaluMulai = Carbon::now()->subWeek()->startOfWeek();
        $mingguLaluAkhir = Carbon::now()->subWeek()->endOfWeek();

        $penjualanMingguIni = Penjualan::whereBetween('tgl', [$mingguIniMulai, $mingguIniAkhir])
            ->sum('total_bayar');

        $penjualanMingguLalu = Penjualan::whereBetween('tgl', [$mingguLaluMulai, $mingguLaluAkhir])
            ->sum('total_bayar');

        if ($penjualanMingguLalu > 0) {
            $persenJualMinggu = number_format(((($penjualanMingguIni - $penjualanMingguLalu) / $penjualanMingguLalu) * 100), 2);
        } else {
            $persenJualMinggu = $penjualanMingguIni > 0 ? 100 : 0;
        }

        $pembelianMingguIni = Pembelian::whereBetween('tgl', [$mingguIniMulai, $mingguIniAkhir])
            ->sum('total');

        $pembelianMingguLalu = Pembelian::whereBetween('tgl', [$mingguLaluMulai, $mingguLaluAkhir])
            ->sum('total');

        if ($pembelianMingguLalu > 0) {
            $persenBeliMinggu = number_format(((($pembelianMingguIni - $pembelianMingguLalu) / $pembelianMingguLalu) * 100), 2);
        } else {
            $persenBeliMinggu = $pembelianMingguIni > 0 ? 100 : 0;
        }

        $pendapatanMingguIni = $penjualanMingguIni - $pembelianMingguIni;
        $pendapatanMingguLalu = $penjualanMingguLalu - $pembelianMingguLalu;
        if ($pendapatanMingguLalu > 0) {
            $persenLabaMinggu = number_format(((($pendapatanMingguIni - $pendapatanMingguLalu) / $pendapatanMingguLalu) * 100), 2);
        } else {
            $persenLabaMinggu = $pendapatanMingguIni > 0 ? 100 : 0;
        }

        //top produk 
        $topProductsByVolume = PenjualanDetail::select('buku_id', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('buku_id')
            ->orderByDesc('total_terjual')
            ->with('buku') 
            ->limit(5)
            ->get();
        $topProductsBySales = PenjualanDetail::select('buku_id', DB::raw('SUM(subtotal) as total_sales'))
            ->groupBy('buku_id')
            ->orderByDesc('total_sales')
            ->with('buku')
            ->limit(5) 
            ->get();

        $data = compact(
            'totalTransaksi',
            'penjualan',
            'persenJual',
            'pembelian',
            'persenBeli',
            'pendapatan',
            'persenLaba',
            'penjualanMingguIni',
            'persenJualMinggu',
            'pembelianMingguIni',
            'persenBeliMinggu',
            'pendapatanMingguIni',
            'persenLabaMinggu',
            'topProductsByVolume',
            'topProductsBySales'
        );

        return view('home', $data);
    }
}
