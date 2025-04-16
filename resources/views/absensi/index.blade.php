@extends('layout.header')
@section('title', 'Absensi')
@php
$breadcrumbs = [
['label' => 'Karyawan', 'route' => 'absensi.index'],
['label' => 'Absensi', 'route' => 'absensi.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
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
            <button type="button" class="btn btn-primary btn-add"
                data-bs-toggle="modal"
                data-bs-target="#modalAbsensi">
                <div class="d-flex align-content-center py-1">
                    <i class="icon-base bx bx-plus me-1"></i>
                    <span>Tambah</span>
                </div>
            </button>
            <h5 class="card-header pb-0 fw-bold">Absensi</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered" data-tipe="absensi">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Nama Karyawan</th>
                            <th class="fw-bold">Tanggal Masuk</th>
                            <th class="fw-bold">Waktu Masuk</th>
                            <th class="fw-bold">Status</th>
                            <th class="fw-bold">Waktu Selesai Kerja</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->nama_karyawan}}</td>
                            <td>{{$data->tgl_masuk}}</td>
                            <td>{{$data->jam_masuk}}</td>
                            <td>
                                <select class="form-select update-status" data-id="{{ $data->id }}" data-allow-clear="true">
                                    <option value="masuk" {{ $data->status == "masuk" ? 'selected' : ''}}>Masuk</option>
                                    <option value="sakit" {{ $data->status == "sakit" ? 'selected' : ''}}>Sakit</option>
                                    <option value="cuti" {{ $data->status == "cuti" ? 'selected' : ''}}>Cuti</option>
                                </select>
                            </td>
                            <td>
                                @if($data->jam_selesai)
                                {{ $data->jam_selesai }}
                                @else
                                <button type="button" class="btn btn-primary selesai-kerja" data-id="{{ $data->id }}">Selesai</button>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalAbsensi"
                                        data-id="{{$data->id}}"
                                        data-nama_karyawan="{{$data->nama_karyawan}}"
                                        data-tgl_masuk="{{$data->tgl_masuk}}"
                                        data-jam_masuk="{{$data->jam_masuk}}"
                                        data-jam_selesai="{{$data->jam_selesai}}"
                                        data-status="{{$data->status}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('absensi.destroy', $data->id) }}" method="post">
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

@include('absensi.modal')
@include('import.modal')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).on('change', '.update-status', function() {
        let id = $(this).data('id');
        let status = $(this).val();

        $.ajax({
            url: "{{ route('absensi.updateStatus') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
                status: status
            },
            success: function(response) {
                setTimeout(function() {
                    location.reload();
                }, 500);
                showToast(response.message);
            },
            error: function(xhr) {
                showToast('Gagal memperbarui status!', 'bg-danger');
            }
        });
    });

    $(document).on('click', '.selesai-kerja', function() {
        let id = $(this).data('id');

        $.ajax({
            url: "{{ route('absensi.selesaiKerja') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id,
            },
            success: function(response) {
                setTimeout(function() {
                    location.reload();
                }, 500);
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
            $('.modal-title').text('Tambah Absensi');
            $('#jenis-form').attr('action', "{{ route('absensi.store') }}");
            $('#form-method').val('POST');
            $('#nama_karyawan').val('');
            $('#jam_masuk').val('');
            $('#jam_selesai').val('');
            $('#status').val('');
            $('#tgl_masuk').val('');
            $('#submit-btn').text('Tambah');
            $('.input-selesai').addClass('d-none');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let nama_karyawan = $(this).data('nama_karyawan');
            let jam_masuk = $(this).data('jam_masuk');
            let jam_selesai = $(this).data('jam_selesai');
            let status = $(this).data('status');
            let tgl_masuk = $(this).data('tgl_masuk');

            $('.input-selesai').removeClass('d-none');
            $('.modal-title').text('Edit Absensi');
            $('#jenis-form').attr('action', `/absensi/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');

            $('#id').val(id);
            $('#nama_karyawan').val(nama_karyawan);
            $('#jam_masuk').val(jam_masuk);
            $('#jam_selesai').val(jam_selesai);
            $('#status').val(status);
            $('#tgl_masuk').val(tgl_masuk);
        });

    });
</script>
@endsection