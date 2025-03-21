@extends('layout.header')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <!-- Customer Ratings -->
    <div class="col-12 col-xxl-8 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Daily Transactions</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="customerRatings" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="customerRatings">
                        <a class="dropdown-item" href="javascript:void(0);">Featured Ratings</a>
                        <a class="dropdown-item" href="javascript:void(0);">Based on Task</a>
                        <a class="dropdown-item" href="javascript:void(0);">See All</a>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body pb-0">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h2 class="mb-0">4.0</h2>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-label-primary me-2">+5.0</span>
                    <span>Points from last month</span>
                </div>
            </div> -->
            <div id="salesChart"></div>
        </div>
    </div>
    <!--/ Customer Ratings -->
    <div class="col-12 col-md-12 col-xxl-4">
        <div class="row">
            <div class="col-6 col-md-3 col-xxl-6 mb-6">
                <div class="card h-100">
                    <div class="card-body pb-4">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets') }}/img/icons/unicons/paypal.png" alt="paypal" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Pembelian</p>
                        <h4 class="card-title mb-3">Rp. {{ number_format($pembelian, 0, ',', '.') }}</h4>
                        <small class="{{ $persenBeli < 0 ? 'text-danger' : 'text-success' }} fw-medium"><i class="icon-base bx {{ $persenBeli < 0 ? 'bx-down-arrow-alt' : 'bx-up-arrow-alt' }}"></i> {{ $persenBeli < 0 ? '' : '+' }}{{ $persenBeli }}%</small>
                    </div>
                </div>
            </div>
            <div class=" col-lg-6 col-md-12 col-6 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="{{ asset('assets') }}/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                            </div>
                        </div>
                        <p class="mb-1">Penjualan</p>
                        <h4 class="card-title mb-3">Rp. {{ number_format($penjualan, 0, ',', '.') }}</h4>
                        <small class="{{ $persenJual < 0 ? 'text-danger' : 'text-success' }} fw-medium"><i class="icon-base bx {{ $persenJual < 0 ? 'bx-down-arrow-alt' : 'bx-up-arrow-alt' }}"></i> {{ $persenJual < 0 ? '' : '+' }}{{ $persenJual }}%</small>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xxl-12 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex flex-column">
                                <div class="card-title mb-auto">
                                    <h5 class="mb-0">Pendapatan</h5>
                                    <p class="mb-0">Laporan Perbulan</p>
                                </div>
                                <div class="chart-statistics">
                                    <h4 class="card-title mb-0">Rp. {{ number_format($pendapatan, 0, ',', '.') }}</h4>
                                    <p class="{{ $persenLaba < 0 ? 'text-danger' : 'text-success' }} text-nowrap mb-0"><i class="icon-base bx {{ $persenLaba < 0 ? 'bx-chevron-down' : 'bx-chevron-up' }} icon-lg"></i> {{ $persenLaba < 0 ? '' : '+' }}{{ $persenLaba }}%</p>
                                </div>
                            </div>
                            <div id="leadsReportChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Top Products by -->
    <div class="col-12 col-xxl-8 mb-6">
        <div class="card h-100">
            <div class="row row-bordered g-0 h-100">
                <div class="col-md-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Top Products by <span class="text-primary">Sales</span></h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="topSales" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topSales">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-6">
                        <ul class="p-0 m-0">
                            @foreach ($topProductsBySales as $product)
                            <li class="d-flex align-items-center mb-7">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="/gambar/{{ $product->buku->gambar }}" alt="{{ $product->buku->judul }}"  style="height:50px;"/>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $product->buku->judul }}</h6>
                                        <small class="d-block">{{ $product->buku->penulis }}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <span class="fw-medium">Rp. {{ number_format($product->total_sales, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Top Products by <span class="text-primary">Volume</span></h5>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="topVolume" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="topVolume">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-6">
                        <ul class="p-0 m-0">
                            @foreach ($topProductsByVolume as $product)
                            <li class="d-flex align-items-center mb-7">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="/gambar/{{ $product->buku->gambar }}" alt="{{ $product->buku->judul }}"  style="height:50px;"/>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{ $product->buku->judul }}</h6>
                                        <small class="d-block">{{ $product->buku->penulis }}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-3">
                                        <span class="fw-medium">{{ number_format($product->total_terjual, 0, ',', '.') }}</span>
                                        <span class="badge bg-label-success">+12.4%</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Top Products by -->

    <!-- Earning Reports -->
    <div class="col-md-6 col-xxl-4 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1 me-2">Earning Reports</h5>
                    <p class="card-subtitle">Weekly Earnings Overview</p>
                </div>
                <div class="dropdown">
                    <button class="btn text-body-secondary p-0" type="button" id="earningReports" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="earningReports">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <ul class="p-0 m-0">
                    <li class="d-flex mb-6 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-primary"><i class="icon-base bx bx-trending-up"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Net Profit</h6>
                                <small class="text-body-secondary">12.4k Sales</small>
                            </div>
                            <div class="user-progress"><span class="me-3">Rp. {{ number_format($pendapatanMingguIni, 0, ',', '.') }}</span><i class="icon-base bx {{ $persenLabaMinggu < 0 ? 'bx-chevron-down text-danger' : 'bx-chevron-up text-success' }} ms-1"></i> <span>{{ $persenLabaMinggu }}%</span></div>
                        </div>
                    </li>
                    <li class="d-flex mb-6 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-success"><i class="icon-base bx bx-dollar"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Total Income</h6>
                                <small class="text-body-secondary">Sales, Affiliation</small>
                            </div>
                            <div class="user-progress"><span class="me-3">Rp. {{ number_format($penjualanMingguIni, 0, ',', '.') }}</span><i class="icon-base bx {{ $persenJualMinggu < 0 ? 'bx-chevron-down text-danger' : 'bx-chevron-up text-success' }} ms-1"></i> <span>{{ $persenJualMinggu }}%</span></div>
                        </div>
                    </li>
                    <li class="d-flex mb-6 pb-1">
                        <div class="avatar flex-shrink-0 me-3">
                            <span class="avatar-initial rounded bg-label-secondary"><i class="icon-base bx bx-credit-card"></i></span>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <h6 class="mb-0">Total Expenses</h6>
                                <small class="text-body-secondary">ADVT, Marketing</small>
                            </div>
                            <div class="user-progress"><span class="me-3">Rp. {{ number_format($pembelianMingguIni, 0, ',', '.') }}</span><i class="icon-base bx {{ $persenBeliMinggu < 0 ? 'bx-chevron-down text-danger' : 'bx-chevron-up text-success' }} ms-1"></i> <span>{{ $persenBeliMinggu }}%</span></div>
                        </div>
                    </li>
                </ul>
                <div id="reportBarChart"></div>
            </div>
        </div>
    </div>
    <!--/ Earning Reports -->

    <!-- Sales Analytics -->
    <div class="col-md-6 col-xxl-4 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-start justify-content-between">
                <div>
                    <h5 class="card-title m-0 me-2 mb-2">Sales Analytics</h5>
                    <span class="badge bg-label-success me-1">+42.6%</span> <span>Than last year</span>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-label-primary">2022</button>
                    <button type="button" class="btn btn-sm btn-label-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:void(0);">2021</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">2020</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">2019</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-body pb-0">
                <div id="salesAnalyticsChart"></div>
            </div>
        </div>
    </div>
    <!--/ Sales Analytics -->

    <!-- Sales By Country -->
    <div class="col-md-6 col-xxl-4 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <div class="card-title mb-0">
                    <h5 class="mb-1 me-2">Sales by Countries</h5>
                    <p class="card-subtitle">Monthly Sales Overview</p>
                </div>
                <div class="dropdown">
                    <button class="btn text-body-secondary p-0" type="button" id="salesByCountry" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesByCountry">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <i class="fis fi fi-us rounded-circle fs-2"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-2">$8,567k</h6>
                                    <small class="text-success fw-medium d-flex align-items-center gap-1">
                                        <i class="icon-base bx bx-chevron-up icon-md"></i>
                                        25.8%
                                    </small>
                                </div>
                                <small>United states of america</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">884k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <i class="fis fi fi-br rounded-circle fs-2"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-2">$2,415k</h6>
                                    <small class="text-danger fw-medium d-flex align-items-center gap-1">
                                        <i class="icon-base bx bx-chevron-down icon-md"></i>
                                        6.2%
                                    </small>
                                </div>
                                <small>Brazil</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">645k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <i class="fis fi fi-in rounded-circle fs-2"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-2">$865k</h6>
                                    <small class="text-success fw-medium d-flex align-items-center gap-1">
                                        <i class="icon-base bx bx-chevron-up icon-md"></i>
                                        12.4%
                                    </small>
                                </div>
                                <small>India</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">148k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <i class="fis fi fi-au rounded-circle fs-2"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-2">$745k</h6>
                                    <small class="text-danger fw-medium d-flex align-items-center gap-1">
                                        <i class="icon-base bx bx-chevron-down icon-md"></i>
                                        11.9%
                                    </small>
                                </div>
                                <small>Australia</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">86k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center mb-6">
                        <div class="avatar flex-shrink-0 me-3">
                            <i class="fis fi fi-fr rounded-circle fs-2"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-2">$45</h6>
                                    <small class="text-success fw-medium d-flex align-items-center gap-1">
                                        <i class="icon-base bx bx-chevron-up icon-md"></i>
                                        16.2%
                                    </small>
                                </div>
                                <small>France</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">42k</h6>
                            </div>
                        </div>
                    </li>
                    <li class="d-flex align-items-center">
                        <div class="avatar flex-shrink-0 me-3">
                            <i class="fis fi fi-cn rounded-circle fs-2"></i>
                        </div>
                        <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                            <div class="me-2">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0 me-2">$12k</h6>
                                    <small class="text-success fw-medium d-flex align-items-center gap-1">
                                        <i class="icon-base bx bx-chevron-up icon-md"></i>
                                        14.8%
                                    </small>
                                </div>
                                <small>China</small>
                            </div>
                            <div class="user-progress">
                                <h6 class="mb-0">18k</h6>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--/ Sales By Country -->

    <!-- Sales Stats -->
    <div class="col-md-6 col-xxl-4 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Sales Stats</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="salesStatsID" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="salesStatsID">
                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                    </div>
                </div>
            </div>
            <div id="salesStats"></div>
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center gap-4">
                    <div class="d-flex align-items-center"><span class="badge badge-dot bg-success me-2"></span> Conversion Ratio</div>
                    <div class="d-flex align-items-center"><span class="badge badge-dot bg-label-secondary me-2"></span> Total requirements</div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Sales Stats -->

    <!-- Team Members -->
    <div class="col-xxl-5 mb-xxl-0 mb-6">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Team Members</h5>
                <div class="dropdown">
                    <button class="btn text-body-secondary p-0" type="button" id="teamMemberList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-base bx bx-dots-vertical-rounded icon-lg"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList">
                        <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                        <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                        <a class="dropdown-item" href="javascript:void(0);">Share</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-borderless table-sm">
                    <thead>
                        <tr>
                            <th class="ps-6">Name</th>
                            <th>Project</th>
                            <th>Task</th>
                            <th class="pe-6">Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3">
                                        <img src="../../assets/img/avatars/17.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-truncate">Nathan Wagner</h6>
                                        <small class="text-truncate text-body">iOS Developer</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-primary text-uppercase">Zipcar</span></td>
                            <td><span class="fw-medium">87/135</span></td>
                            <td>
                                <div class="chart-progress" data-color="primary" data-series="65"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3">
                                        <img src="../../assets/img/avatars/8.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-truncate">Emma Bowen</h6>
                                        <small class="text-truncate text-body">UI/UX Designer</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-danger text-uppercase">Bitbank</span></td>
                            <td><span class="fw-medium">320/440</span></td>
                            <td>
                                <div class="chart-progress" data-color="danger" data-series="85"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3">
                                        <span class="avatar-initial rounded-circle bg-label-warning">AM</span>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-truncate">Adrian McGuire</h6>
                                        <small class="text-truncate text-body">PHP Developer</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-warning text-uppercase">Payers</span></td>
                            <td><span class="fw-medium">50/82</span></td>
                            <td>
                                <div class="chart-progress" data-color="warning" data-series="73"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3">
                                        <img src="../../assets/img/avatars/2.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-truncate">Alma Gonzalez</h6>
                                        <small class="text-truncate text-body">Product Manager</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-info text-uppercase">Brandi</span></td>
                            <td><span class="fw-medium">98/260</span></td>
                            <td>
                                <div class="chart-progress" data-color="info" data-series="61"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar me-3">
                                        <img src="../../assets/img/avatars/11.png" alt="Avatar" class="rounded-circle" />
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0 text-truncate">Allan kristian</h6>
                                        <small class="text-truncate text-body">Frontend Designer</small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-label-info text-uppercase">Crypter</span></td>
                            <td><span class="fw-medium">690/760</span></td>
                            <td>
                                <div class="chart-progress" data-color="info" data-series="61"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Team Members -->

    <!-- Customer Table -->
    <div class="col-xxl-7 mb-0">
        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="invoice-list-table table table-border-top-0">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="cell-fit">Paid By</th>
                            <th class="cell-fit">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="../../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="pages-profile-user.html" class="text-heading text-truncate fw-medium">Henry Barnes</a>
                                        <small class="text-truncate text-body">jok@puc.co.uk</small>
                                    </div>
                                </div>
                            </td>
                            <td>$459.65</td>
                            <td><span class="badge bg-label-success"> Paid </span></td>
                            <td class="text-center">
                                <img src="../../assets/img/icons/payments/master-light.png" class="img-fluid" width="29" alt="masterCard" data-app-light-img="icons/payments/master-light.png" data-app-dark-img="icons/payments/master-dark.png" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md text-body"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="../../assets/img/avatars/20.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="pages-profile-user.html" class="text-heading text-truncate fw-medium">Hallie Warner</a>
                                        <small class="text-truncate text-body">hellie@war.co.uk</small>
                                    </div>
                                </div>
                            </td>
                            <td>$93.81</td>
                            <td><span class="badge bg-label-warning"> Pending </span></td>
                            <td class="text-center">
                                <img src="../../assets/img/icons/payments/master-light.png" class="img-fluid" width="29" alt="masterCard" data-app-light-img="icons/payments/master-light.png" data-app-dark-img="icons/payments/master-dark.png" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md text-body"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="../../assets/img/avatars/9.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="pages-profile-user.html" class="text-heading text-truncate fw-medium">Gerald Flowers</a>
                                        <small class="text-truncate text-body">initus@odemi.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>$934.35</td>
                            <td><span class="badge bg-label-warning"> Pending </span></td>
                            <td class="text-center">
                                <img src="../../assets/img/icons/payments/paypal_logo-light.png" class="img-fluid" width="29" alt="paypalCard" data-app-light-img="icons/payments/paypal_logo-light.png" data-app-dark-img="icons/payments/paypal_logo-dark.png" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md text-body"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="../../assets/img/avatars/14.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="pages-profile-user.html" class="text-heading text-truncate fw-medium">John Davidson</a>
                                        <small class="text-truncate text-body">jtum@upkesja.gov</small>
                                    </div>
                                </div>
                            </td>
                            <td>$794.97</td>
                            <td><span class="badge bg-label-success"> Paid </span></td>
                            <td class="text-center">
                                <img src="../../assets/img/icons/payments/master-light.png" class="img-fluid" width="29" alt="masterCard" data-app-light-img="icons/payments/master-light.png" data-app-dark-img="icons/payments/master-dark.png" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md text-body"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-warning">JH</span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="pages-profile-user.html" class="text-heading text-truncate fw-medium">Jayden Harris</a>
                                        <small class="text-truncate text-body">wipare@tin.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>$19.49</td>
                            <td><span class="badge bg-label-success"> Paid </span></td>
                            <td class="text-center">
                                <img src="../../assets/img/icons/payments/master-light.png" class="img-fluid" width="29" alt="masterCard" data-app-light-img="icons/payments/master-light.png" data-app-dark-img="icons/payments/master-dark.png" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md text-body"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex justify-content-start align-items-center">
                                    <div class="avatar-wrapper">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="../../assets/img/avatars/8.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="pages-profile-user.html" class="text-heading text-truncate fw-medium">Rena Ferguson</a>
                                        <small class="text-truncate text-body">nur@kaomor.edu</small>
                                    </div>
                                </div>
                            </td>
                            <td>$636.27</td>
                            <td><span class="badge bg-label-danger"> Failed </span></td>
                            <td class="text-center">
                                <img src="../../assets/img/icons/payments/paypal_logo-light.png" class="img-fluid" width="29" alt="paypalCard" data-app-light-img="icons/payments/paypal_logo-light.png" data-app-dark-img="icons/payments/paypal_logo-dark.png" />
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="dropdown">
                                        <a href="javascript:;" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded icon-md text-body"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a href="javascript:void(0);" class="dropdown-item">Edit</a>
                                            <a href="javascript:;" class="dropdown-item">Duplicate</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="javascript:;" class="dropdown-item delete-record text-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ Customer Table -->
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let chart; // Variabel untuk menyimpan instance chart

    function fetchDataAndUpdateChart() {
        $.ajax({
            url: "/home/transaksi-per-hari",
            type: "GET",
            dataType: "json",
            success: function(response) {
                updateChart(response.dates, response.transaksi, response.penjualan);
            },
            error: function() {
                console.error("Gagal mengambil data transaksi.");
            }
        });
    }

    function createChart(categories, transaksiData, penjualanData) {
        let minTransaksi = Math.min(...transaksiData);
        let maxTransaksi = Math.max(...transaksiData);
        let minPenjualan = Math.min(...penjualanData);
        let maxPenjualan = Math.max(...penjualanData);

        let options = {
            chart: {
                height: 300,
                type: "line",
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                },
                dropShadow: {
                    enabled: true,
                    enabledOnSeries: [1],
                    top: 13,
                    left: 4,
                    blur: 3,
                    color: "#3b82f6",
                    opacity: 0.09,
                },
            },
            series: [{
                    name: "Transaksi",
                    data: transaksiData
                },
                {
                    name: "Penjualan",
                    data: penjualanData
                },
                // {
                //     name: "Range Transaksi",
                //     data: Array(transaksiData.length).fill(maxTransaksi),
                //     strokeWidth: 2,
                //     strokeDashArray: 5,
                //     color: "#ff5733",
                // },
                // {
                //     name: "Range Penjualan",
                //     data: Array(penjualanData.length).fill(maxPenjualan),
                //     strokeWidth: 2,
                //     strokeDashArray: 5,
                //     color: "#3b82f6",
                // }
            ],
            stroke: {
                curve: "smooth",
                width: [3, 3, 2, 2],
                dashArray: [0, 0, 5, 5]
            },
            legend: {
                show: true,
                position: "top",
                markers: {
                    width: 10,
                    height: 10,
                    radius: 12
                }
            },
            colors: ["#ff5733", "#3b82f6", "#ff5733", "#3b82f6"],
            grid: {
                show: true,
                borderColor: "#E5E5E5",
                strokeDashArray: 5,
            },
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        fontSize: "13px",
                        color: "#777"
                    }
                },
                axisTicks: {
                    show: false
                },
                axisBorder: {
                    show: false
                },
            },
            yaxis: {
                show: true
            },
            markers: {
                size: 6,
                colors: ["#ff5733", "#3b82f6"],
                strokeWidth: 2,
                strokeColors: "#fff",
                hover: {
                    size: 7
                },
            },
        };

        let chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();
    }


    function updateChart(categories, transaksiData, penjualanData) {
        if (!chart) {
            createChart(categories, transaksiData, penjualanData);
        } else {
            chart.updateOptions({
                xaxis: {
                    categories: categories
                },
                series: [{
                        name: "Transaksi",
                        data: transaksiData
                    },
                    {
                        name: "Penjualan",
                        data: penjualanData
                    },
                ],
            });
        }
    }

    $(document).ready(function() {
        fetchDataAndUpdateChart();
        // setInterval(fetchDataAndUpdateChart, 5000);
    });
</script>
@endsection