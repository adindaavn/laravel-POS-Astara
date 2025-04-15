<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $dashboard;

    public function __construct(DashboardService $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    public function index()
    {
        $userId = Auth::id();
        $from = Carbon::now()->startOfMonth();
        $to = Carbon::now()->endOfMonth();

        return view('home', [
            'penjualan' => $this->dashboard->getMonthlyComparison('penjualan'),
            'pembelian' => $this->dashboard->getMonthlyComparison('pembelian'),
            'profit' => $this->dashboard->getProfit($from, $to),
            'transactions' => $this->dashboard->getTransactions($from, $to),
            'mostSoldBooks' => $this->dashboard->getMostSoldBooks($from, $to),
            'rowPenjualan' => $this->dashboard->getTotalRows('penjualan', $from, $to),
            'rowPembelian' => $this->dashboard->getTotalRows('pembelian', $from, $to),
            'performaKasir' => $this->dashboard->getKasirPerformanceToday($userId),
        ]);
    }

    public function dailyPenjualan()
    {
        $from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to = Carbon::now()->endOfMonth()->format('Y-m-d');

        $results = DB::table('penjualan')
            ->select(DB::raw('DAY(tgl) as day'), DB::raw('SUM(total_bersih) as total'))
            ->whereBetween('tgl', [$from, $to])
            ->groupBy(DB::raw('DAY(tgl)'))
            ->orderBy('day')
            ->get();

        $daysInMonth = Carbon::now()->daysInMonth;
        $data = [];
        $categories = [];

        for ($i = 1; $i <= $daysInMonth; $i++) {
            $categories[] = str_pad($i, 2, '0', STR_PAD_LEFT);

            $found = $results->firstWhere('day', $i);
            $total = $found ? (int)$found->total : 0;

            $data[] = $total;
        }

        return response()->json([
            'data' => $data,
            'categories' => $categories,
        ]);
    }
}
