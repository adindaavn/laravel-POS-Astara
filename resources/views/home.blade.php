@extends('layout.header')
@section('title', 'Dashboard')
@section('content')
<div class="row">
    <div class="col-md-12 col-xxl-4 mb-6">
        <div class="card h-100">
            <div class="d-flex align-items-end row">
                <div class="col-7">
                    <div class="card-body">
                        <h5 class="card-title mb-1 text-nowrap">Keep up the good work! 🎉</h5>
                        <p class="card-subtitle text-nowrap mb-3">Have fun serving customers :D</p>

                        <h5 class="card-title text-primary mb-0">Rp. {{ number_format($performaKasir['total_penjualan'], 0, ',', '.') }}</h5>
                        <p class="mb-3">{{ $performaKasir['total_transaksi'] }} transaksi today 🚀</p>

                        <a href="javascript:;" class="btn btn-sm btn-primary mb-1">View sales</a>
                    </div>
                </div>
                <div class="col-5">
                    <div class="card-body pb-0 text-end">
                        <img src="../../assets/img/illustrations/prize-light.png" width="91" height="144" class="rounded-start" alt="View Sales" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Visitors & Activity -->
    <div class="col-xxl-8 mb-6">
        <div class="card h-100">
            <div class="card-body row g-4 p-0">
                <div class="col-md-6 card-separator">
                    <div class="p-6">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <h5 class="mb-0">Penjualan</h5>
                            <small>Last Week</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="mt-auto">
                                <h3 class="mb-1">{{ $rowPenjualan }}</h3>
                                <small class="text-success text-nowrap fw-medium"><i class="icon-base bx bx-up-arrow-alt"></i> 13.5%</small>
                            </div>
                            <div id="visitorsChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-6">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <h5 class="mb-0">Pembelian</h5>
                            <small>Last Week</small>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="mt-auto">
                                <h3 class="mb-1">{{ $rowPembelian }}</h3>
                                <small class="text-success text-nowrap fw-medium"><i class="icon-base bx bx-up-arrow-alt"></i> 24.8%</small>
                            </div>
                            <div id="activityChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ New Visitors & Activity -->

    <div class="col-lg-12 col-xxl-4">
        <div class="row">
            <div class="col-xxl-6 col-md-3 col-sm-6 col-12 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0 w-px-40 h-px-40">
                                <img src="../../assets/img/icons/unicons/wallet-info.png" alt="wallet info" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <p class="mb-1">Sales</p>
                        <h5 class="card-title mb-3">Rp. {{ number_format($penjualan['current']) }}</h5>
                        <small class="text-{{ $penjualan['percent'] >= 0 ? 'success' : 'danger' }} fw-medium">
                            <i class="icon-base bx {{ $penjualan['percent'] >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}"></i>
                            {{ $penjualan['percent'] >= 0 ? '+' : '' }}{{ $penjualan['percent'] }}%
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-md-3 col-sm-6 col-12 mb-6">
                <div class="card h-100">
                    <div class="card-body pb-2">
                        <span class="d-block fw-medium mb-1">Profit</span>
                        <h5 class="card-title mb-4">Rp. {{ number_format($profit['profit']) }}</h5>
                        <div id="profitChart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-md-3 col-sm-6 col-12 mb-6">
                <div class="card h-100">
                    <div class="card-body pb-0">
                        <span class="d-block fw-medium mb-1">Expenses</span>
                    </div>
                    <div id="expensesChart" class="mb-2"></div>
                    <div class="p-4 pt-2">
                        <small class="d-block text-center">Rp. {{ number_format($pembelian['current']) }}</small>
                    </div>
                </div>
            </div>
            <div class="col-xxl-6 col-md-3 col-sm-6 col-12 mb-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between mb-4">
                            <div class="avatar flex-shrink-0">
                                <img src="../../assets/img/icons/unicons/cc-primary.png" alt="Credit Card" class="rounded" />
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-base bx bx-dots-vertical-rounded text-body-secondary"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cardOpt1">
                                    <a class="dropdown-item" href="javascript:void(0);">View More</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                </div>
                            </div>
                        </div>
                        <p class="mb-1">Transactions</p>
                        <h5 class="card-title mb-3">Rp. {{ number_format($transactions['transactions']) }}</h5>
                        <small class="text-{{ $transactions['percent'] >= 0 ? 'success' : 'danger' }} fw-medium">
                            <i class="icon-base bx {{ $transactions['percent'] >= 0 ? 'bx-up-arrow-alt' : 'bx-down-arrow-alt' }}"></i>
                            {{ $transactions['percent'] >= 0 ? '+' : '' }}{{ $transactions['percent'] }}%
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Income -->
    <div class="col-md-12 col-xxl-8 mb-6">
        <div class="card h-100">
            <div class="row row-bordered g-0">
                <div class="col-md-12">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <h5 class="card-title mb-1">Total Income</h5>
                            <p class="card-subtitle">Yearly report overview</p>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="totalIncome" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalIncome">
                                <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="totalIncomeChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Total Income -->
    </div>
    <!--/ Total Income -->
</div>
<div class="row">
    <div class="col-lg-12 col-xxl-12 mb-6 mb-lg-0">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title m-0 me-2">Top Penjualan Buku</h5>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-sm text-nowrap table-border-top-0">
                    <!-- <thead>
                        <tr>
                            <th>No</th>
                            <th>Buku</th>
                            <th>Kategori</th>
                            <th>Volume</th>
                            <th>Sales</th>
                        </tr>
                    </thead> -->
                    <tbody class="table-border-bottom-0">
                        @foreach ($mostSoldBooks as $book)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="/gambar/{{ $book->gambar }}" alt="Oneplus" height="100" class="me-3" />
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-0">{{ $book->judul }}</h6>
                                        <small class="text-body">{{ $book->penulis }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-label-primary rounded-pill p-1_5 me-3">{{ $book->nama_kategori }}</span>
                            </td>
                            <td>
                                <div class="text-body"><span class="text-primary fw-medium">{{ $book->total_terjual }}</span></div>
                            </td>
                            <td>
                                <div class="text-body"><span class="fw-medium">Rp. {{ number_format($book->total_nominal, 0, ',', '.') }}</span></div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Total Balance -->
    <!-- <div class="col-lg-5 col-xxl-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title m-0 me-2">Total Balance</h5>
                <div class="dropdown">
                    <button class="btn p-0" type="button" id="totalBalance" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon-base bx bx-dots-vertical-rounded icon-lg text-body-secondary"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="totalBalance">
                        <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                        <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                    </div>
                </div>
            </div>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col d-flex">
                        <div class="me-3">
                            <span class="badge rounded-2 bg-label-warning p-2"><i class="icon-base bx bx-wallet icon-lg text-warning"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0">$2.54k</h6>
                            <small>Wallet</small>
                        </div>
                    </div>
                    <div class="col d-flex">
                        <div class="me-3">
                            <span class="badge rounded-2 bg-label-secondary p-2"><i class="icon-base bx bx-dollar icon-lg text-secondary"></i></span>
                        </div>
                        <div>
                            <h6 class="mb-0">$4.2k</h6>
                            <small>Paypal</small>
                        </div>
                    </div>
                </div>
                <div id="totalBalanceChart"></div>
            </div>
            <hr class="m-0" />
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <small class="text-body">You have done 57.6% more sales.<br />Check your new badge in your profile.</small>
                    <div>
                        <span class="badge bg-label-warning rounded-2 p-2"><i class="icon-base bx bx-chevron-right icon-md text-warning"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!--/ Total Balance -->
</div>
<!-- / Content -->
<script>
    // Load the chart on DOM ready
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize variables for the chart
        let chart;

        // Function to render the chart
        function renderChart(data, categories) {
            const options = {
                chart: {
                    height: 290,
                    type: "area",
                    toolbar: {
                        show: false
                    },
                    dropShadow: {
                        enabled: true,
                        top: 14,
                        left: 2,
                        blur: 3,
                        color: config.colors.primary,
                        opacity: 0.15,
                    }
                },
                series: [{
                    data: data
                }],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 3,
                    curve: "straight"
                },
                colors: [config.colors.primary],
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        gradientToColors: [config.colors.cardColor],
                        opacityTo: 0.3,
                        stops: [0, 100],
                    }
                },
                grid: {
                    show: true,
                    borderColor: config.colors.borderColor,
                    padding: {
                        top: -15,
                        bottom: -10,
                        left: 0,
                        right: 0
                    }
                },
                xaxis: {
                    categories: categories,
                    labels: {
                        style: {
                            colors: config.colors.textMuted,
                            fontFamily: config.fontFamily,
                            fontSize: "13px"
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        offsetX: -15,
                        formatter: function(value) {
                            return "Rp. " + parseInt(value / 1000) + "k";
                        },
                        style: {
                            fontSize: "13px",
                            fontFamily: config.fontFamily,
                            colors: config.colors.textMuted
                        }
                    },
                    tickAmount: 5,
                }
            };

            const chartElement = document.querySelector("#totalIncomeChart");
            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        }

        // Function to fetch new data from the server
        function fetchData() {
            fetch('/home/daily-penjualan') 
                .then(response => response.json())
                .then(data => {
                    renderChart(data.data, data.categories);
                    console.log(data);
                })
                .catch(error => console.error('Error fetching data:', error));
            fetch('/home/daily-pembelian') 
                .then(response => response.json())
                .then(data => {
                    renderChart(data.data, data.categories);
                    console.log(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        // Initial data fetch and chart render
        fetchData();

        // Set an interval to fetch data every 60 seconds
        setInterval(fetchData, 60000);
    });
</script>
@endsection