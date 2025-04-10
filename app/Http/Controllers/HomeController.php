<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
            'dailyPenjualan' => $this->dashboard->getDailyPenjualanThisMonth(),
            'performaKasir' => $this->dashboard->getKasirPerformanceToday($userId),
        ]);
    }
}
