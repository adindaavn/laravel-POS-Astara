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
    <!-- Breadcrumbs -->
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="row">
                <div class="mb-4 order-0">
                    <button type="button" class="btn btn-primary btn-add"
                        data-bs-toggle="modal"
                        data-bs-target="#modalBuku">
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
                </div>

                <div class="col-lg-12 mb-4 order-0">
                    <h5 class="card-header pb-0 fw-bold">Data Buku</h5>
                    <div id="tableData" class="table-responsive text-nowrap p-5">
                        <table class="table table-striped table-bordered" data-tipe="buku">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold">No</th>
                                    <th class="fw-bold">Buku</th>
                                    <th class="fw-bold">ISBN</th>
                                    <th class="fw-bold">Kategori</th>
                                    <th class="fw-bold">Harga</th>
                                    <th class="fw-bold">Stok</th>
                                    <th class="fw-bold">Penerbit (Thn terbit)</th>
                                    <th class="fw-bold">Barcode</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $data)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar-wrapper">
                                                <div class="me-2 me-sm-4 bg-label-secondary">
                                                    @if($data->gambar != null)
                                                    <img src="/gambar/{{ $data->gambar }}" width="50px" class="rounded">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="text-nowrap mb-0">{{$data->judul}}</h6>
                                                <small class="text-truncate d-none d-sm-block">{{$data->penulis}}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{$data->isbn}}</td>
                                    <td>{{$data->kategori}}</td>
                                    <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                                    <td>
                                        @if($data->stok <= 0)
                                            <span class="badge rounded-pill bg-label-danger">{{$data->stok}}</span>
                                            @elseif($data->stok <= 5)
                                                <span class="badge rounded-pill bg-label-warning">{{$data->stok}}</span>
                                                @else
                                                <span class="badge rounded-pill bg-label-success">{{$data->stok}}</span>
                                                @endif
                                    </td>
                                    <td>{{$data->penerbit}} ({{$data->thn_terbit}})</td>
                                    <td><img src="data:image/png;base64,{{ $data->barcode }}" alt="Barcode ISBN"></td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <button type="button"
                                                class="btn mx-0 px-1 btn-edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalBuku"
                                                data-id="{{$loop->iteration}}"
                                                data-isbn="{{$data->isbn}}"
                                                data-gambar="{{$data->gambar}}"
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
                                                <button type="submit" class="btn mx-0 px-1"><span class="badge rounded-pill bg-label-danger"><i class="bx bx-trash text-danger"></i></span></button>
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

@include('buku.modal')
@include('import.modal')
<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('#icon-placeholder').on('click', function() {
            $('#gambar').trigger('click');
        });

        $('#preview-gambar').on('click', function() {
            $('#gambar').trigger('click');
        });

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

            $('#gambar').on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-gambar').attr('src', e.target.result).show().removeClass('d-none');
                        $('#icon-placeholder').hide().addClass('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#preview-gambar').hide().addClass('d-none');
                    $('#icon-placeholder').show().removeClass('d-none');
                }
            });
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

            $('#modalBuku').on('shown.bs.modal', function() {
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
                $('#gambar').val('');
                $('#old_img').val(gambar);
                $('#thn_terbit').val(thn_terbit);

                if (gambar) {
                    $('#preview-gambar').attr('src', '/gambar/' + gambar).show().removeClass('d-none');
                    $('#icon-placeholder').hide().addClass('d-none');
                } else {
                    $('#preview-gambar').hide().addClass('d-none');
                    $('#icon-placeholder').show().removeClass('d-none');
                }

            });

            $('#gambar').on('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-gambar').attr('src', e.target.result).show().removeClass('d-none');
                        $('#icon-placeholder').hide().addClass('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#preview-gambar').hide().addClass('d-none');
                    $('#icon-placeholder').show().removeClass('d-none');
                }
            });

        });

    });
</script>
@endsection