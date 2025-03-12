@extends('layout.header')
@section('title', 'Buku')
@php
$breadcrumbs = [
['label' => 'Produk', 'route' => 'buku.index'],
['label' => 'Buku', 'route' => 'buku.index'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-xl-12">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-stok"
                        aria-controls="navs-stok"
                        aria-selected="true">
                        <i class="tf-icons bx bx-home"></i> Stok Buku
                    </button>
                </li>
                <li class="nav-item">
                    <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-data"
                        aria-controls="navs-data"
                        aria-selected="false">
                        <i class="tf-icons bx bx-user"></i> Data Buku
                    </button>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-stok" role="tabpanel">
                    <div class="card shadow-none">
                        <h5 class="card-header pb-0 fw-bold">Stok Buku</h5>
                        <div id="tableData" class="table-responsive text-nowrap p-5">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="fw-bold">No</th>
                                        <th class="fw-bold">ISBN</th>
                                        <th class="fw-bold">Judul</th>
                                        <th class="fw-bold">Kategori</th>
                                        <th class="fw-bold">Harga</th>
                                        <th class="fw-bold">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stok as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->isbn}}</td>
                                        <td>{{$data->judul}}</td>
                                        <td>{{$data->kategori}}</td>
                                        <td>{{$data->harga}}</td>
                                        <td>{{$data->stok}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-data" role="tabpanel">
                    <div class="card shadow-none">
                        <div class="row">
                            <div class="mb-4 order-0">
                                <button type="button" class="btn btn-primary btn-add"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalBuku">
                                    <i class="icon-base bx bx-plus me-1"></i>
                                    <span>Tambah</span>
                                </button>
                            </div>

                            <div class="col-lg-12 mb-4 order-0">
                                <h5 class="card-header pb-0 fw-bold">Data Buku</h5>
                                <div id="tableData" class="table-responsive text-nowrap p-5">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr class="table-primary">
                                                <th class="fw-bold">No</th>
                                                <th class="fw-bold">Cover</th>
                                                <th class="fw-bold">ISBN</th>
                                                <th class="fw-bold">Judul</th>
                                                <th class="fw-bold">Penulis</th>
                                                <th class="fw-bold">Kategori</th>
                                                <th class="fw-bold">Penerbit</th>
                                                <th class="fw-bold">Tahun Terbit</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($buku as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>
                                                    @if($data->gambar != null)
                                                    <img src="{{ asset('storage/' . $data->gambar) }}" width="100">
                                                    @endif
                                                </td>
                                                <td>{{$data->isbn}}</td>
                                                <td>{{$data->judul}}</td>
                                                <td>{{$data->penulis}}</td>
                                                <td>
                                                    @foreach ($kategori as $k)
                                                    @if ($k->id == $data->kategori_id)
                                                    {{ $k->nama }}
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$data->penerbit}}</td>
                                                <td>{{$data->thn_terbit}}</td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        <button type="button"
                                                            class="btn btn-edit"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalBuku"
                                                            data-id="{{$loop->iteration}}"
                                                            data-isbn="{{$data->isbn}}"
                                                            data-judul="{{$data->judul}}"
                                                            data-penulis="{{$data->penulis}}"
                                                            data-kategori_id="{{$data->kategori_id}}"
                                                            data-harga="{{$data->harga}}"
                                                            data-penerbit="{{$data->penerbit}}"
                                                            data-thn_terbit="{{$data->thn_terbit}}">
                                                            <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                                        </button>
                                                        <form action="{{ route('buku.destroy', $data->id) }}" method="post">
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
                </div>
            </div>
        </div>
    </div>
</div>

@include('buku.modal')
<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('.btn-add').click(function() {
            $('.modal-title').text('Tambah Buku');
            $('#jenis-form').attr('action', "{{ route('buku.store') }}");
            $('#form-method').val('POST');
            $('#judul').val('');
            $('#penulis').val('');
            $('#kategori_id').val('');
            $('#harga').val('');
            $('#penerbit').val('');
            $('#isbn').val('');
            $('#thn_terbit').val('');
            $('#gambar').val('');
            $('#submit-btn').text('Tambah');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let judul = $(this).data('judul');
            let penulis = $(this).data('penulis');
            let kategori_id = $(this).data('kategori_id');
            let harga = $(this).data('harga');
            let penerbit = $(this).data('penerbit');
            let isbn = $(this).data('isbn');
            let gambar = $(this).data('gambar');
            let thn_terbit = $(this).data('thn_terbit');

            $('.modal-title').text('Edit Buku');
            $('#jenis-form').attr('action', `/buku/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');
            $('#id').val(id);
            $('#kode').val(kode);
            $('#judul').val(judul);
            $('#penulis').val(penulis);
            $('#kategori_id').val(kategori_id);
            $('#harga').val(harga);
            $('#penerbit').val(penerbit);
            $('#isbn').val(isbn);
            $('#gambar').val(gambar);
            $('#thn_terbit').val(thn_terbit);
            $('#jml_halaman').val(jml_halaman);
        });

    });
</script>
@endsection