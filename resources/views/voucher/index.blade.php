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
            @if(auth()->user()->role == 'owner' || auth()->user()->role == 'admin')
            <button type="button" class="btn btn-primary btn-add"
                data-bs-toggle="modal"
                data-bs-target="#modalVoucher">
                <i class="icon-base bx bx-plus me-1"></i>
                <span>Tambah</span>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-secondary btn-import"
                    data-bs-toggle="modal"
                    data-bs-target="#modalImport">
                    <i class="icon-base bx bx-import me-1"></i>
                    <span>Import</span>
                </button>
                <button type="button" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <button type="button" class="btn btn-outline-secondary btn-format-import">
                        <span>Unduh format import</span>
                    </button>
                </ul>
            </div>
            @endif
            <h5 class="card-header pb-0 fw-bold">Data Voucher</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5" data-tipe="voucher">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Kode</th>
                            <th class="fw-bold">Diskon</th>
                            <th class="fw-bold">Tipe</th>
                            <th class="fw-bold">Min. Beli</th>
                            <th class="fw-bold">Max. Diskon</th>
                            <th class="fw-bold">Kuota</th>
                            <th class="fw-bold">Point</th>
                            <th class="fw-bold">Deskripsi</th>
                            <th class="fw-bold">Expired</th>
                            @if(auth()->user()->role == 'owner' || auth()->user()->role == 'admin')
                            <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voucher as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->kode}}</td>
                            <td>{{$data->diskon}}</td>
                            <td>{{$data->tipe}}</td>
                            <td>{{$data->min_beli}}</td>
                            <td>{{$data->max_diskon}}</td>
                            <td>{{$data->kuota}}</td>
                            <td>{{$data->point}}</td>
                            <td>{{$data->deskripsi}}</td>
                            <td>{{$data->kadaluarsa}}</td>
                            @if(auth()->user()->role == 'owner' || auth()->user()->role == 'admin')
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalVoucher"
                                        data-id="{{$data->id}}"
                                        data-kode="{{$data->kode}}"
                                        data-diskon="{{$data->diskon}}"
                                        data-tipe="{{$data->tipe}}"
                                        data-min_beli="{{$data->min_beli}}"
                                        data-max_diskon="{{$data->max_diskon}}"
                                        data-kuota="{{$data->kuota}}"
                                        data-point="{{$data->point}}"
                                        data-deskripsi="{{$data->deskripsi}}"
                                        data-kadaluarsa="{{$data->kadaluarsa}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('voucher.destroy', $data->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-destroy"><span class="badge rounded-pill bg-label-danger"><i class="bx bx-trash text-danger"></i></span></button>
                                    </form>
                                </div>
                            </td>
                            @endif
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
                                <label for="diskon" class="form-label">Diskon</label>
                                <input
                                    type="number"
                                    id="diskon"
                                    class="form-control"
                                    placeholder="Diskon"
                                    name="diskon" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="tipe" class="form-label">Tipe</label>
                                <select name="tipe" id="tipe" class="form-select">
                                    <option value="persen">Persen</option>
                                    <option value="nominal">Nominal</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="min_beli" class="form-label">Min. Beli</label>
                                <input
                                    type="number"
                                    id="min_beli"
                                    class="form-control"
                                    placeholder="Min. Beli"
                                    name="min_beli" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="max_diskon" class="form-label">Max. Diskon</label>
                                <input
                                    type="number"
                                    id="max_diskon"
                                    class="form-control"
                                    placeholder="Max. Diskon"
                                    name="max_diskon" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="kuota" class="form-label">Kuota</label>
                                <input
                                    type="number"
                                    id="kuota"
                                    class="form-control"
                                    placeholder="Kuota"
                                    name="kuota" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="point" class="form-label">Point</label>
                                <input
                                    type="number"
                                    id="point"
                                    class="form-control"
                                    placeholder="Point"
                                    name="point" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label">Berlaku Sampai</label>
                                <input name="kadaluarsa" class="form-control" type="date" id="kadaluarsa">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea name="deskripsi" id="deskripsi" class="form-control"></textarea>
                            </div>
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

@include('import.modal')
<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('.btn-add').click(function() {
            $('.modal-title').text('Tambah Voucher');
            $('#jenis-form').attr('action', "{{ route('voucher.store') }}");
            $('#form-method').val('POST');
            $('#submit-btn').text('Tambah');

            $('#diskon').val('');
            $('#tipe').val('persen');
            $('#min_beli').val('');
            $('#max_diskon').val('');
            $('#kuota').val('');
            $('#point').val('');
            $('#deskripsi').val('');
            $('#kadaluarsa').val('');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let diskon = $(this).data('diskon');
            let tipe = $(this).data('tipe');
            let min_beli = $(this).data('min_beli');
            let max_diskon = $(this).data('max_diskon');
            let kuota = $(this).data('kuota');
            let point = $(this).data('point');
            let deskripsi = $(this).data('deskripsi');
            let kadaluarsa = $(this).data('kadaluarsa');

            $('.modal-title').text('Edit Voucher');
            $('#jenis-form').attr('action', `/voucher/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');

            $('#id').val(id);
            $('#kode').val(kode);
            $('#diskon').val(diskon);
            $('#tipe').val(tipe);
            $('#min_beli').val(min_beli);
            $('#max_diskon').val(max_diskon);
            $('#kuota').val(kuota);
            $('#point').val(point);
            $('#deskripsi').val(deskripsi);
            $('#kadaluarsa').val(kadaluarsa);
        });

    });
</script>
@endsection