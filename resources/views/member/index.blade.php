@extends('layout.header')
@section('title', 'Member')
@section('content')
<div class="row">
    <div class="mb-4 order-0">
        <button type="button" class="btn btn-primary btn-add"
            data-bs-toggle="modal"
            data-bs-target="#modalMember">
            <div class="d-flex align-content-center py-1">
                <i class="menu-icon tf-icons bx bx-plus"></i>
                <h5 class="text-white m-0">Tambah</h5>
            </div>
        </button>
    </div>

    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <h5 class="card-header pb-0 fw-bold">Data Member</h5>
            <div class="table-responsive text-nowrap p-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Nama</th>
                            <th class="fw-bold">Point</th>
                            <th class="fw-bold">No. Telepon</th>
                            <th class="fw-bold">Email</th>
                            <th class="fw-bold">Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($member as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->nama}}</td>
                            <td>{{$data->point}}</td>
                            <td>{{$data->alamat}}</td>
                            <td>{{$data->telp}}</td>
                            <td>{{$data->email}}</td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button"
                                        class="btn btn-edit"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalMember"
                                        data-id="{{$data->id}}"
                                        data-point="{{$data->point}}"
                                        data-nama="{{$data->nama}}"
                                        data-alamat="{{$data->alamat}}"
                                        data-telp="{{$data->telp}}"
                                        data-email="{{$data->email}}">
                                        <span class="badge rounded-pill bg-label-info"><i class="bx bx-edit-alt text-dark"></i></span>
                                    </button>
                                    <form action="{{ route('member.destroy', $data->id) }}" method="post">
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
@include('member.modal')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        $('.btn-add').click(function() {
            $('.modal-title').text('Tambah Member');
            $('#jenis-form').attr('action', "{{ route('member.store') }}");
            $('#form-method').val('POST');
            $('#nama').val('');
            $('#alamat').val('');
            $('#telp').val('');
            $('#email').val('');
            $('#submit-btn').text('Tambah');
        });

        $('.btn-edit').click(function() {
            let id = $(this).data('id');
            let point = $(this).data('point');
            let nama = $(this).data('nama');
            let alamat = $(this).data('alamat');
            let telp = $(this).data('telp');
            let email = $(this).data('email');

            $('.modal-title').text('Edit Member');
            $('#jenis-form').attr('action', `/member/${id}`);
            $('#form-method').val('PUT');
            $('#submit-btn').text('Edit');
            $('#id').val(id);
            $('#point').val(point);
            $('#nama').val(nama);
            $('#alamat').val(alamat);
            $('#telp').val(telp);
            $('#email').val(email);
            $('#submit-btn').text('Edit');
        });

    });
</script>
@endsection