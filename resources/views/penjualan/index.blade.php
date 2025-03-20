@extends('layout.header')
@section('title', 'Penjualan')
@php
$breadcrumbs = [
['label' => 'Transaksi', 'route' => 'penjualan.index'],
['label' => 'Penjualan', 'route' => 'penjualan.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header pb-0 fw-bold">Data Penjualan</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No. Transaksi</th>
                            <th class="fw-bold">User</th>
                            <th class="fw-bold">Member</th>
                            <th class="fw-bold">Daftar Buku</th>
                            <th class="fw-bold">Total (+PPn)</th>
                            <th class="fw-bold">Tanggal</th>
                            <th class="fw-bold">Metode Bayar</th>
                            <th class="fw-bold">No. Rekening</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan as $data)
                        <tr>
                            <td>{{ $data->no_transaksi }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ optional($data->member)->nama }}</td>
                            <td>
                                <div class="">
                                    <ul class="list-group list-group-timeline">
                                        @foreach ($data->detailPenjualan as $detail)
                                        <li class="list-group-item list-group-timeline-primary">
                                            {{ $detail->buku->judul }}
                                            ({{ $detail->jumlah }} x Rp. {{ number_format($detail->harga_jual, 0, ',', '.') }}
                                            = Rp. {{ number_format($detail->subtotal, 0, ',', '.') }})
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($data->total_bayar, 0, ',', '.') }}</td>
                            <td>{{ $data->tgl }}</td>
                            <td>{{ $data->metode_bayar }}</td>
                            <td>{{ $data->no_rekening }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
@endsection