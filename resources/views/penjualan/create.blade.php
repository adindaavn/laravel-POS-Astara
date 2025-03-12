@extends('layout.header')
@section('title', 'Transaksi Buku')
@section('content')
<div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="col-lg-8 mb-4 order-0">
        <div class="col-12">
            <div class="card card-action mb-6">
                <div class="card-header">
                    <h5 class="card-action-title mb-0">Buku</h5>
                    <div class="card-action-element">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" class="card-expand"><i class="icon-base bx bx-fullscreen"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tableTransaksi" class="table-responsive text-nowrap">
                        <div class="d-flex justify-content-between align-items-center row gap-6 gap-md-0 g-md-6 mb-3">
                            <div class="col-md-4 product_category">
                                <select id="kategori_id" name="kategori_id" class="select2 form-select text-capitalize" data-allow-clear="true" aria-placeholder="Pilih Kategori">
                                    @foreach($kategori as $k)
                                    <option value="{{ $k->nama }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table id="tableBuku" class="table table-striped table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th></th>
                                    <th class="fw-bold">ISBN</th>
                                    <th class="fw-bold">Judul</th>
                                    <th class="fw-bold">Penulis</th>
                                    <th class="fw-bold">Harga</th>
                                    <th class="fw-bold">Kategori</th>
                                    <th class="fw-bold">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stok as $data)
                                <tr>
                                    <td>
                                        <button class="btn rounded-pill btn-outline-success btn-sm add-buku"
                                            data-id="{{$data->id}}"
                                            data-judul="{{$data->judul}}"
                                            data-harga="{{$data->harga}}">
                                            <i class="menu-icon tf-icons bx bx-plus m-0"></i>
                                        </button>
                                    </td>
                                    <td>{{$data->isbn}}</td>
                                    <td>{{$data->judul}}</td>
                                    <td>{{$data->penulis}}</td>
                                    <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                                    <td>{{$data->kategori}}</td>
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

    <div class="col-lg-4 mb-4 order-0">
        <div class="card">
            <form id="formPenjualan" action="{{ route('penjualan.store') }}" method="post">
                @csrf
                <div class="card-body pb-0">
                    <h5 class="pb-0 fw-bold">Transaksi</h5>
                    <hr class="mx-n6" />
                    <div class="row">
                        <div class="col-1 d-flex align-items-center">
                            <span><i class="icon-base bx bxs-user-badge"></i></span>
                        </div>
                        <div class="col-8">
                            <select class="select2 form-select" id="member_id" name="member_id" data-allow-clear="true" aria-placeholder="Pilih Member">
                                <option value="">Search Member</option>
                                @foreach($member as $m)
                                <option value="{{$m->id}}">{{$m->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalMember" type="button">
                                <i class="icon-base bx bx-plus"></i>
                            </button>
                        </div>
                    </div>

                    <hr class="px-2" />
                    <h6>Order Details</h6>
                    <dl class="col-12 mb-0 text-heading" id="itemList">
                    </dl>

                    <hr class="px-2" />
                    <div class="row">
                        <div class="col-8 col-xxl-8 col-xl-12">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text" id="voucher"><i class="icon-base bx bxs-discount"></i></span>
                                <input type="text" class="form-control" placeholder="Enter Promo Code" aria-label="Enter Promo Code" aria-describedby="voucher" />
                            </div>
                        </div>
                        <div class="col-4 col-xxl-4 col-xl-12">
                            <div class="d-grid">
                                <button type="button" class="btn btn-label-primary">Apply</button>
                            </div>
                        </div>
                    </div>

                    <hr class="px-2" />
                    <dl class="row mb-0">
                        <dt class="col-6">Subtotal</dt>
                        <dd id="subtotal" class="col-6 fw-medium text-end mb-1">0</dd>
                        <dt class="col-6">Pajak</dt>
                        <dd id="pajak" class="col-6 fw-medium text-end mb-1">0</dd>
                        <dt class="col-6 text-heading">Total</dt>
                        <dd id="total" class="col-6 fw-medium text-end text-heading mb-1">0</dd>
                    </dl>
                    <input type="number" id="total_bayar" name="total_bayar" step="0.01" hidden />
                    <input type="hidden" name="buku" id="bukuData">
                </div>
                <div class="d-grid card-footer">
                    <hr />
                    <div class="row">
                        <div class="col-md mb-3">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="cash">
                                    <span class="custom-option-body">
                                        <i class="icon-base bx bx-wallet"></i>
                                        <span class="custom-option-title">Cash</span>
                                    </span>
                                    <input hidden name="metode_bayar" class="form-check-input" type="radio" value="cash" id="cash" checked />
                                </label>
                            </div>
                        </div>
                        <div class="col-md mb-3">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="kartu">
                                    <span class="custom-option-body">
                                        <i class="icon-base bx bx-credit-card"></i>
                                        <span class="custom-option-title">Kartu</span>
                                    </span>
                                    <input hidden name="metode_bayar" class="form-check-input" type="radio" value="kartu" id="kartu" />
                                </label>
                            </div>
                        </div>
                        <div class="col-md mb-3">
                            <div class="form-check custom-option custom-option-icon">
                                <label class="form-check-label custom-option-content" for="qris">
                                    <span class="custom-option-body">
                                        <i class="icon-base bx bx-qr-scan"></i>
                                        <span class="custom-option-title">QRIS</span>
                                    </span>
                                    <input hidden name="metode_bayar" class="form-check-input" type="radio" value="qris" id="qris" />
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit-btn" class="btn btn-primary btn-next">Bayar</button>
                </div>
            </form>
        </div>
    </div>

</div>
@include('member.modal')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {
        let selectedBuku = [];

        $(".add-buku").click(function() {
            let id = $(this).data("id");
            let judul = $(this).data("judul");
            let harga = parseFloat($(this).data("harga"));
            let existing = selectedBuku.find(item => item.buku_id == id);

            if (existing) {
                existing.jumlah++;
                existing.subtotal = existing.jumlah * existing.harga_jual;
            } else {
                selectedBuku.push({
                    buku_id: id,
                    judul: judul,
                    harga_jual: harga,
                    jumlah: 1,
                    subtotal: harga
                });
            }

            updateTable();
        });

        $(document).on("input", ".input-jumlah", function() {
            let id = $(this).data("id");
            let newJumlah = parseInt($(this).val());
            let item = selectedBuku.find(b => b.buku_id == id);

            if (item) {
                if (newJumlah <= 0) {
                    selectedBuku = selectedBuku.filter(b => b.buku_id != id); // Hapus jika 0
                } else {
                    item.jumlah = newJumlah;
                    item.subtotal = item.harga_jual * item.jumlah;
                }
            }

            updateTable();
        });

        $(document).on("click", ".btn-delete", function() {
            let id = $(this).data("id");
            selectedBuku = selectedBuku.filter(b => b.buku_id != id);
            updateTable();
        });

        function updateTable() {
            let itemList = $("#itemList");

            itemList.empty();
            let subtotal = 0;
            let pajak = 0;
            let total = 0;

            $.each(selectedBuku, function(index, buku) {
                subtotal += buku.subtotal;

                itemList.append(`
            <div class="row mb-1">
                <dt class="col-2 d-flex align-items-center">
                    <input type="number" class="form-control input-jumlah" data-id="${buku.buku_id}" value="${buku.jumlah}" min="0" style="width: 60px;">
                </dt>
                <div class="col-10">
                    <div class="fw-bold">${buku.judul}</div>
                    <div class="d-flex justify-content-between">
                        <span>${buku.harga_jual.toLocaleString()}</span>
                        <span class="text-end">${buku.subtotal.toLocaleString()}</span>
                    </div>
                </div>
            </div>
            `);

            });

            pajak = (subtotal * 11 / 100);
            total = subtotal + pajak;

            $("#subtotal").text(subtotal.toLocaleString());
            $("#pajak").text(pajak.toLocaleString());
            $("#total").text(total.toLocaleString());
            $("#total_bayar").val(total);

            $("#bukuData").val(JSON.stringify(selectedBuku));
        }
    });
</script>
@endsection