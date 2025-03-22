@extends('layout.header')
@section('title', 'Pengajuan Buku')
@php
$breadcrumbs = [
['label' => 'Produk', 'route' => 'pengajuan.index'],
['label' => 'Pengajuan Buku', 'route' => 'pengajuan.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <button type="button" class="btn btn-primary btn-add"
                data-bs-toggle="modal"
                data-bs-target="#modalPengajuan">
                <div class="d-flex align-content-center py-1">
                    <i class="icon-base bx bx-plus me-1"></i>
                    <span>Tambah</span>
                </div>
            </button>
            <h5 class="card-header pb-0 fw-bold">Pengajuan Buku</h5>
            <div id="tablePengajuan" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Nama Pengaju</th>
                            <th class="fw-bold">Nama Buku</th>
                            <th class="fw-bold">Tanggal Pengajuan</th>
                            <th class="fw-bold">Qty</th>
                            <th class="fw-bold">Terpenuhi?</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengajuan as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->member->nama}}</td>
                            <td>{{$data->nama}}</td>
                            <td>{{$data->tgl}}</td>
                            <td>{{$data->qty}}</td>
                            <td>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input update-status" style="inline-size: 2.12rem;"
                                        data-id="{{$data->id}}"
                                        id="status{{$data->id}}"
                                        {{ $data->status ? 'checked' : '' }}>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalPengajuan"
                                        data-id="{{$data->id}}"
                                        data-nama="{{$data->nama}}"
                                        data-member_id="{{$data->member_id}}"
                                        data-tgl="{{$data->tgl}}"
                                        data-qty="{{$data->qty}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('pengajuan.destroy', $data->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-destroy"><span class="badge rounded-pill bg-label-danger"><i class="bx bx-trash text-danger"></i></span></button>
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

    <div class="bs-toast toast toast-placement-ex m-2 bg-success bottom-0 end-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-medium">Success!</div>
        </div>
        <div class="toast-body">
            <i class="bx bx-check-circle"></i>
            {{ Session::get('success') }}
        </div>
    </div>
</div>

@include('pengajuan.modal')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).on('change', '.update-status', function() {
        let id = $(this).data('id');
        let status = $(this).prop('checked') ? 1 : 0;

        $.ajax({
            url: "{{ route('pengajuan.updateStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                status: status
            },
            success: function(response) {
                showToast(response.message);
            },
            error: function(xhr) {
                showToast('Gagal memperbarui status!', 'bg-danger');
            }
        });
    });

    $(document).ready(function() {
        $('.toast').hide();
    });

    function showToast(message, type = 'bg-success') {
        var toastEl = $('.toast');
        toastEl.hide();
        toastEl.find('.toast-body').text(message);
        toastEl.removeClass('bg-success bg-danger').addClass(type);
        toastEl.fadeIn().toast({
            delay: 1500
        }).toast('show');
    }
</script>

<script>
    $(document).ready(function() {
        $('.btn-add').click(function() {
            $('.modal-title').text('Tambah Pengajuan Buku');
            $('#jenis-form').attr('action', "{{ route('pengajuan.store') }}");
            $('#form-method').val('POST');
            $('#nama').val('');
            $('#member_id').val('');
            $('#qty').val('');
            $('#status').val('');
            $('#tgl').val('');
            $('#submit-btn').text('Tambah');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');
            let member_id = $(this).data('member_id');
            let qty = $(this).data('qty');
            let status = $(this).data('status');
            let tgl = $(this).data('tgl');

            $('.modal-title').text('Edit Pengajuan Buku');
            $('#jenis-form').attr('action', `/pengajuan/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');

            $('#id').val(id);
            $('#nama').val(nama);
            $('#member_id').val(member_id);
            $('#qty').val(qty);
            $('#status').val(status);
            $('#tgl').val(tgl);
        });

    });
</script>
@endsection