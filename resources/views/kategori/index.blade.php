@extends('layout.header')
@section('title', 'Kategori')
@php
$breadcrumbs = [
['label' => 'Produk', 'route' => 'kategori.index'],
['label' => 'Kategori', 'route' => 'kategori.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-4 mb-4 order-0">
        <div class="accordion" id="accordionExample">
            <div class="card accordion-item p-1 active">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        type="button"
                        class="accordion-button"
                        data-bs-toggle="collapse"
                        data-bs-target="#accordionAdd"
                        aria-expanded="true"
                        aria-controls="accordionAdd">
                        <h5 class="mb-0 ms-1 fw-bold">
                            Tambah Kategori
                        </h5>
                    </button>
                </h2>
                <div
                    id="accordionAdd"
                    class="accordion-collapse collapse show"
                    aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="{{ route('kategori.store') }}" method="post">
                            @csrf
                            <div class="input-group">
                                <input
                                    type="text"
                                    class="form-control"
                                    name="nama"
                                    placeholder="Nama kategori"
                                    aria-label="Nama kategori"
                                    aria-describedby="button-addon2" />
                                <button class="btn btn-outline-primary" type="submit" id="button-addon2">Tambah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header pb-0 fw-bold">Data Kategori</h5>
            <div id="tableData" class="table-responsive text-nowrap p-5">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Nama Kategori</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kategori as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->nama}}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEdit"
                                        data-id="{{$data->id}}"
                                        data-nama="{{$data->nama}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('kategori.destroy', $data->id) }}" method="post">
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

<!-- edit modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="jenis-form" action="{{ route('kategori.store') }}" method="post">
                @csrf
                @method('put')
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Edit Kategori</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <input type="hidden" name="id" id="id">

                        <div class="col mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input
                                type="text"
                                id="nama"
                                class="form-control"
                                placeholder="Nama"
                                name="nama" />
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let nama = $(this).data('nama');

            $('#jenis-form').attr('action', '/kategori/' + id);
            $('#nama').val(nama);
            $('#id').val(id);
        });
    });
</script>
@endsection