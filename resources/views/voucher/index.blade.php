@extends('layout.header')
@section('title', 'Voucher')
@section('content')
@php
$breadcrumbs = [
['label' => 'Toko', 'route' => 'voucher.index'],
['label' => 'Voucher', 'route' => 'voucher.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <button type="button" class="btn btn-primary btn-add"
                data-bs-toggle="modal"
                data-bs-target="#modalVoucher">
                <i class="icon-base bx bx-plus me-1"></i>
                <span>Tambah</span>
            </button>
            <h5 class="card-header pb-0 fw-bold">Data Voucher</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Kode</th>
                            <th class="fw-bold">Diskon</th>
                            <th class="fw-bold">Deskripsi</th>
                            <th class="fw-bold">Expired</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voucher as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->kode}}</td>
                            <td>{{$data->diskon}}</td>
                            <td>{{$data->deskripsi}}</td>
                            <td>{{$data->expired}}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalVoucher"
                                        data-id="{{$data->id}}"
                                        data-kode="{{$data->kode}}"
                                        data-diskon="{{$data->diskon}}"
                                        data-deskripsi="{{$data->deskripsi}}"
                                        data-expired="{{$data->expired}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('voucher.destroy', $data->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn"><span class="badge rounded-pill bg-label-danger"><i class="bx bx-trash text-danger"></i></span></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- edit modal -->
<div class="modal fade" id="modalVoucher" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="jenis-form" action="{{ route('voucher.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle"></h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="row">

                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="id" id="id">

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="diskon" class="form-label">Diskon <small>(Persen)</small></label>
                                <input
                                    type="number"
                                    id="diskon"
                                    class="form-control"
                                    placeholder="Diskon"
                                    name="diskon" />
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label">Berlaku Sampai</label>
                                <input name="expired" class="form-control" type="date" id="expired">
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-btn"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('.btn-add').click(function() {
            $('.modal-title').text('Tambah Voucher');
            $('#jenis-form').attr('action', "{{ route('voucher.store') }}");
            $('#form-method').val('POST');
            $('#submit-btn').text('Tambah');

            $('#diskon').val('');
            $('#deskripsi').val('');
            $('#expired').val('');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let diskon = $(this).data('diskon');
            let deskripsi = $(this).data('deskripsi');
            let expired = $(this).data('expired');

            $('.modal-title').text('Edit Voucher');
            $('#jenis-form').attr('action', `/voucher/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');

            $('#id').val(id);
            $('#kode').val(kode);
            $('#diskon').val(diskon);
            $('#deskripsi').val(deskripsi);
            $('#expired').val(expired);
        });

    });
</script>
@endsection