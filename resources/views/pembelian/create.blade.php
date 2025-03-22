@extends('layout.header')
@section('title', 'Pendataan Buku')
@php
$breadcrumbs = [
['label' => 'Transaksi', 'route' => 'pembelian.create'],
['label' => 'Pembelian', 'route' => 'pembelian.create'],
];
@endphp
@section('content')
<div class="row">
    <x-breadcrumb :breadcrumbs="$breadcrumbs" />
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <form id="formPembelian" action="{{ route('pembelian.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="pb-0 fw-bold">Pendataan Buku</h5>
                        <button type="submit" class="btn btn-primary" id="submit-btn">Simpan Transaksi</button>
                    </div>
                    <div class="row">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="pemasok_id" class="form-label">Pemasok</label>
                                <div class="row">
                                    <div class="col-8">
                                        <select class="select2 form-select" id="pemasok_id" name="pemasok_id" data-allow-clear="true">
                                            @foreach($pemasok as $p)
                                            <option value="{{$p->id}}">{{$p->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalPemasok" type="button">
                                            <i class="icon-base bx bx-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3 mb-3">
                                <label for="total" class="form-label">Total Bayar</label>
                                <input type="number" class="total_bayar form-control" placeholder="Total Bayar" readonly />
                                <input type="hidden" id="total" name="total" />
                            </div>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="buku" class="form-label">Buku</label>
                            <div class="row">
                                <div class="col-8">
                                    <select class="select2 form-select" id="buku" name="buku" data-allow-clear="true">
                                        @foreach($buku as $b)
                                        <option value="{{$b->id}}" data-cover="{{ $b->gambar }}" data-judul="{{ $b->judul }}" data-penulis="{{ $b->penulis }}" data-isbn="{{ $b->isbn }}" data-harga="{{ $b->harga }}">
                                            {{$b->judul}} by {{$b->penulis}} ({{$b->isbn}})
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalBuku">
                                        <span class="align-middle">Buku Baru</span>
                                    </button>
                                </div>
                            </div>
                            <div class="mt-5">
                                <table class="table">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="fw-bold text-center w-10">No</th>
                                            <th class="fw-bold text-center w-10">Cover</th>
                                            <th class="fw-bold w-50">Buku</th>
                                            <th class="fw-bold text-center w-20">Harga Jual</th>
                                            <th class="fw-bold text-center w-20">Harga Beli</th>
                                            <th class="fw-bold text-center w-10">Jumlah</th>
                                            <th class="fw-bold text-center w-20">Subtotal</th>
                                            <th class="fw-bold"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="buku-container">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="buku" id="bukuData">
            </form>
        </div>
    </div>

</div>

@include('pemasok.modal')
@include('buku.modal')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {
        $('#buku').change(function() {
            var selectedOption = $(this).find('option:selected');
            var cover = selectedOption.data('cover');
            var judul = selectedOption.data('judul');
            var penulis = selectedOption.data('penulis');
            var isbn = selectedOption.data('isbn');
            var harga = selectedOption.data('harga');

            // Create a new row
            var newRow = `
                <tr class="buku-item">
                    <td></td>
                    <td><img src="/gambar/${cover}" alt="Cover" style="width: 70px; height: auto;" /></td>
                    <td>
                        <strong>${judul}</strong><br>
                        ${penulis}<br>
                        (${isbn})
                    </td>
                    <td><input type="number" class="form-control harga-jual" value="${harga}" readonly/></td>
                    <td><input type="number" class="form-control harga" /></td>
                    <td><input type="number" class="form-control jumlah" /></td>
                    <td><input type="number" class="form-control subtotal" readonly/></td>
                    <td>
                        <input type="hidden" class="buku_id" name="buku[][buku_id]" value="${selectedOption.val()}" />
                        <button type="button" class="btn btn-label-danger remove-buku">
                            <i class="icon-base bx bx-x"></i>
                        </button>
                    </td>
                </tr>
                `;


            // Append the new row to the table body
            $('#buku-container').append(newRow);
            updateRowNumbers(); // Update row numbers after adding a new row
        });

        // Remove book item
        $('#buku-container').on("click", ".remove-buku", function() {
            $(this).closest("tr").remove();
            updateRowNumbers();
            updateTotal();
        });

        // Calculate subtotal
        $('#buku-container').on("input", ".harga, .jumlah", function() {
            let row = $(this).closest("tr");
            let harga = parseFloat(row.find(".harga").val()) || 0;
            let jumlah = parseInt(row.find(".jumlah").val()) || 0;
            let subtotal = harga * jumlah;
            row.find(".subtotal").val(subtotal);
            updateTotal();
        });

        // Update total bayar
        function updateTotal() {
            let total = 0;
            $(".subtotal").each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $(".total_bayar").val(total.toLocaleString());
            $("#total").val(total);
        }

        function updateRowNumbers() {
            $('#buku-container tr.buku-item').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }
        // Prepare data before submit
        $("#submit-btn").click(function(event) {
            event.preventDefault();

            let bukuArray = [];
            $(".buku-item").each(function() {
                let buku = {
                    buku_id: $(this).find(".buku_id").val(),
                    harga_beli: $(this).find(".harga").val(),
                    jumlah: $(this).find(".jumlah").val(),
                };
                bukuArray.push(buku);
            });

            $("#bukuData").val(JSON.stringify(bukuArray));
            $("#formPembelian").submit();
        });
    });
</script>
@endsection