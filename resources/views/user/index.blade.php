@extends('layout.header')
@section('title', 'User')
@php
$breadcrumbs = [
['label' => 'Toko', 'route' => 'user.index'],
['label' => 'User', 'route' => 'user.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <button type="button" class="btn btn-primary btn-add"
                data-bs-toggle="modal"
                data-bs-target="#modalUser">
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
            <h5 class="card-header pb-0 fw-bold">Data User</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered" data-tipe="user">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Nama</th>
                            <th class="fw-bold">Username</th>
                            <th class="fw-bold">Password</th>
                            <th class="fw-bold">Role</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->name}}</td>
                            <td>{{$data->username}}</td>
                            <td>{{$data->password}}</td>
                            <td>{{$data->role}}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalUser"
                                        data-id="{{$data->id}}"
                                        data-username="{{$data->username}}"
                                        data-name="{{$data->name}}"
                                        data-password="{{$data->password}}"
                                        data-role="{{$data->role}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('user.destroy', $data->id) }}" method="post">
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
</div>
@include('user.modal')
@include('import.modal')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('.btn-add').click(function() {
            $('.modal-title').text('Tambah User');
            $('#jenis-form').attr('action', "{{ route('user.store') }}");
            $('#form-method').val('POST');
            $('#name').val('');
            $('#username').val('');
            $('#password').val('');
            $('#role').val('');
            $('#submit-btn').text('Tambah');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let point = $(this).data('point');
            let name = $(this).data('name');
            let username = $(this).data('username');
            let password = $(this).data('password');
            let role = $(this).data('role');

            $('.modal-title').text('Edit User');
            $('#jenis-form').attr('action', `/user/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');
            $('#id').val(id);
            $('#point').val(point);
            $('#name').val(name);
            $('#username').val(username);
            $('#password').val(password);
            $('#role').val(role);
            $('#submit-btn').text('Edit');
        });

    });
</script>
@endsection