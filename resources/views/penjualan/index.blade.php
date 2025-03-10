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
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">No Transaksi</th>
                            <th class="fw-bold">Tanggal</th>
                            <th class="fw-bold">Total</th>
                            <th class="fw-bold">Member</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->no_transaksi}}</td>
                            <td>{{$data->tgl_transaksi}}</td>
                            <td>{{$data->total_bayar}}</td>
                            <td>
                                @foreach($member as $m)
                                @if($m->id == $data->member_id)
                                {{$m->nama}}
                                @endif
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">ID Transaksi</th>
                            <th class="fw-bold">Judul</th>
                            <th class="fw-bold">Harga</th>
                            <th class="fw-bold">Jumlah</th>
                            <th class="fw-bold">SUb tOtal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detail as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->penjualan_id}}</td>
                            <td>
                                @foreach($buku as $b)
                                @if($b->id == $data->buku_id)
                                {{$b->judul}}
                                @endif
                                @endforeach
                            </td>
                            <td>{{$data->harga_jual}}</td>
                            <td>{{$data->jumlah}}</td>
                            <td>{{$data->sub_total}}</td>
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