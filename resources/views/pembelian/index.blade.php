@extends('layout.header')
@section('title', 'Pembelian')
@php
$breadcrumbs = [
['label' => 'Transaksi', 'route' => 'pembelian.index'],
['label' => 'Pembelian', 'route' => 'pembelian.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header pb-0 fw-bold">Data Pembelian</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">User</th>
                            <th class="fw-bold">Pemasok</th>
                            <th class="fw-bold">Daftar Buku</th>
                            <th class="fw-bold">Subtotal</th>
                            <th class="fw-bold">Total</th>
                            <th class="fw-bold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->user->name }}</td>
                            <td>{{ $data->pemasok->nama }}</td>
                            <td>
                                <div class="">
                                    <ul class="list-group list-group-timeline">
                                        @foreach ($data->detailPembelian as $detail)
                                        <li class="list-group-item list-group-timeline-primary">
                                            {{ $detail->buku->judul }}
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="">
                                    <ul class="list-group list-group-timeline">
                                        @foreach ($data->detailPembelian as $detail)
                                        <li class="list-group-item list-group-timeline-primary">
                                            ({{ $detail->jumlah }} x Rp. {{ number_format($detail->harga_beli, 0, ',', '.') }}
                                            = Rp. {{ number_format($detail->subtotal, 0, ',', '.') }})
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </td>
                            <td>Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
                            <td>{{ $data->tgl }}</td>
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