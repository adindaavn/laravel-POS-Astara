@extends('layout.header')
@section('title', 'Buku')
@section('content')
<div class="nav-align-top mb-4">
    <ul class="nav nav-tabs nav-fill" role="tablist">
        <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-stok" aria-controls="navs-top-stok" aria-selected="true">
                Stok Buku
            </button>
        </li>
        <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-data" aria-controls="navs-top-data" aria-selected="false">
                Data Buku
            </button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade active show" id="navs-top-stok" role="tabpanel">
            <div class="row">
                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <h5 class="card-header pb-0 fw-bold">Stok Buku</h5>
                        <div class="table-responsive text-nowrap p-3">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="fw-bold">No</th>
                                        <th class="fw-bold">ISBN</th>
                                        <th class="fw-bold">Judul</th>
                                        <th class="fw-bold">Harga</th>
                                        <th class="fw-bold">Stok</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($buku as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->isbn}}</td>
                                        <td>{{$data->judul}}</td>
                                        <td>{{$data->harga}}</td>
                                        <td>{{$data->stok}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="navs-top-data" role="tabpanel">
            <div class="row">
                <div class="mb-4 order-0">
                    <button type="button" class="btn btn-primary btn-add"
                        data-bs-toggle="modal"
                        data-bs-target="#modalBuku">
                        <div class="d-flex align-content-center py-1">
                            <i class="menu-icon tf-icons bx bx-plus"></i>
                            <h5 class="text-white m-0">Tambah</h5>
                        </div>
                    </button>
                </div>

                <div class="col-lg-12 mb-4 order-0">
                    <div class="card">
                        <h5 class="card-header pb-0 fw-bold">Data Buku</h5>
                        <div class="table-responsive text-nowrap p-3">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="fw-bold">No</th>
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
                                                    data-stok="{{$data->stok}}"
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
            $('#stok').val('');
            $('#penerbit').val('');
            $('#isbn').val('');
            $('#thn_terbit').val('');
            $('#submit-btn').text('Tambah');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let kode = $(this).data('kode');
            let judul = $(this).data('judul');
            let penulis = $(this).data('penulis');
            let kategori_id = $(this).data('kategori_id');
            let harga = $(this).data('harga');
            let stok = $(this).data('stok');
            let penerbit = $(this).data('penerbit');
            let isbn = $(this).data('isbn');
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
            $('#stok').val(stok);
            $('#penerbit').val(penerbit);
            $('#isbn').val(isbn);
            $('#thn_terbit').val(thn_terbit);
            $('#jml_halaman').val(jml_halaman);
        });

    });
</script>
@endsection