<?php

namespace App\Services;

use App\Models\Penjualan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    public function getPenjualanTotal(Carbon $from, Carbon $to)
    {
        return DB::table('penjualan')
            ->whereBetween('tgl', [$from, $to])
            ->sum('total_bayar');
    }

    public function getPembelianTotal(Carbon $from, Carbon $to)
    {
        return DB::table('pembelian')
            ->whereBetween('tgl', [$from, $to])
            ->sum('total');
    }

    public function getTotalRows($table, Carbon $from, Carbon $to)
    {
        return DB::table($table)
            ->whereBetween('tgl', [$from, $to])
            ->count();
    }

    public function getMostSoldBooks($from, $to, $limit = 5)
    {
        return DB::table('detail_penjualan')
            ->join('penjualan', 'penjualan.id', '=', 'detail_penjualan.penjualan_id')
            ->join('buku', 'buku.id', '=', 'detail_penjualan.buku_id')
            ->whereBetween('penjualan.tgl', [$from, $to])
            ->select('buku.judul', 'buku.penulis', 'buku.gambar', 'buku.kategori_id', DB::raw('SUM(detail_penjualan.jumlah) as total_terjual'))
            ->groupBy('buku.id', 'buku.judul', 'buku.penulis', 'buku.gambar', 'buku.kategori_id',)
            ->orderByDesc('total_terjual')
            ->limit($limit)
            ->get();
    }

    public function getMonthlyComparison($type)
    {
        $now = now();
        $thisMonthRange = [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
        $lastMonthRange = [$now->copy()->subMonth()->startOfMonth(), $now->copy()->subMonth()->endOfMonth()];

        $current = $type === 'penjualan'
            ? $this->getPenjualanTotal(...$thisMonthRange)
            : $this->getPembelianTotal(...$thisMonthRange);

        $last = $type === 'penjualan'
            ? $this->getPenjualanTotal(...$lastMonthRange)
            : $this->getPembelianTotal(...$lastMonthRange);

        $diff = $current - $last;
        $percent = $last > 0 ? round(($diff / $last) * 100, 2) : 0;

        return [
            'current' => $current,
            'last' => $last,
            'diff' => $diff,
            'percent' => $percent,
        ];
    }

    public function getProfit(Carbon $from, Carbon $to)
    {
        $penjualan = $this->getPenjualanTotal($from, $to);
        $pembelian = $this->getPembelianTotal($from, $to);

        $profit = $penjualan - $pembelian;
        $percent = $pembelian > 0 ? round(($profit / $pembelian) * 100, 2) : 0;

        return [
            'profit' => $profit,
            'percent' => $percent,
        ];
    }

    public function getTransactions(Carbon $from, Carbon $to)
    {
        $penjualan = $this->getPenjualanTotal($from, $to);
        $pembelian = $this->getPembelianTotal($from, $to);

        $transactions = $penjualan + $pembelian;
        $percent = $pembelian > 0 ? round(($transactions / $pembelian) * 100, 2) : 0;

        return [
            'transactions' => $transactions,
            'percent' => $percent,
        ];
    }

    public function getDailyPenjualanThisMonth()
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');

        $results = DB::table('penjualan')
            ->select(DB::raw('DAY(tgl) as day'), DB::raw('SUM(total_bersih) as total'))
            ->whereBetween('tgl', [$from, $to])
            ->groupBy(DB::raw('DAY(tgl)'))
            ->orderBy('day')
            ->get();

        // Inisialisasi array untuk 1 - 31
        $daysInMonth = Carbon::now()->daysInMonth;
        $data = [];
        $categories = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $categories[] = str_pad($i, 2, '0', STR_PAD_LEFT);

            $found = $results->firstWhere('day', $i);
            $total = $found ? (int)$found->total : 0;

            // Duplikat sesuai format kamu (tiap hari dua kali)
            $data[] = $total;
            $data[] = $total;
        }

        return [
            'data' => $data,
            'categories' => $categories,
        ];
    }

    public function getKasirPerformanceToday($userId)
    {
        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow(); // biar aman buat pakai whereBetween

        $data = DB::table('penjualan')
            ->where('user_id', $userId)
            ->whereBetween('tgl', [$today, $tomorrow])
            ->selectRaw('SUM(total_bersih) as total_penjualan, COUNT(*) as total_transaksi')
            ->first();

        return [
            'total_penjualan' => $data->total_penjualan ?? 0,
            'total_transaksi' => $data->total_transaksi ?? 0,
        ];
    }
}
