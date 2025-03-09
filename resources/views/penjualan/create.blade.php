@extends('layout.header')
@section('title', 'Transaksi Buku')
@section('content')
<div class="row">

    <div class="col-lg-8 mb-4 order-0">

        <div class="col-12">
            <div class="card card-action mb-6">
                <div class="card-header">
                    <h5 class="card-action-title mb-0">Order</h5>
                    <div class="card-action-element">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="javascript:void(0);" class="card-collapsible"><i class="icon-base bx bx-chevron-down"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="collapse">
                    <div class="card-body pt-0">
                        <div class="table-responsive text-nowrap p-3">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="fw-bold">No</th>
                                        <th class="fw-bold">Judul</th>
                                        <th class="fw-bold">Harga</th>
                                        <th class="fw-bold">Jumlah</th>
                                        <th class="fw-bold">Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="orderList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                    <div class="table-responsive text-nowrap p-3">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <th class="fw-bold">No</th>
                                    <th class="fw-bold">ISBN</th>
                                    <th class="fw-bold">Judul</th>
                                    <th class="fw-bold">Penulis</th>
                                    <th class="fw-bold">Harga</th>
                                    <th class="fw-bold">Stok</th>
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
                                    <td>{{$data->harga}}</td>
                                    <td>{{$data->stok}}</td>
                                    <td>
                                        <button class="btn rounded-pill btn-outline-success btn-sm add-buku"
                                            data-id="{{$data->id}}"
                                            data-judul="{{$data->judul}}"
                                            data-harga="{{$data->harga}}">
                                            <i class="menu-icon tf-icons bx bx-plus m-0"></i>
                                        </button>
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

    <div class="col-lg-4 mb-4 order-0">
        <div class="card">
            <form id="formPenjualan" action="{{ route('penjualan.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <h5 class="pb-0 fw-bold">Transaksi</h5>
                    
                    <hr class="mx-n6" />
                    <h6>Order Details</h6>
                    <dl class="row mb-0 text-heading" id="itemList">
                    </dl>

                    <hr class="mx-n6" />
                    <div class="col-12">
                        <label for="member_id" class="form-label my-0">
                            <h6>Member</h6>
                        </label>
                        <div class="row">
                            <div class="col-8">
                                <select class="select2 form-select" id="member_id" name="member_id" data-allow-clear="true" aria-placeholder="Member">
                                    <option value="">Search Member</option>
                                    @foreach($member as $m)
                                    <option value="{{$m->id}}">{{$m->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-4">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalMember" type="button">
                                    <i class="icon-base bx bx-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr class="mx-n6" />
                    <div class="row">
                        <div class="col-8 col-xxl-8 col-xl-12">
                            <input type="text" class="form-control" placeholder="Enter Promo Code" aria-label="Enter Promo Code" />
                        </div>
                        <div class="col-4 col-xxl-4 col-xl-12">
                            <div class="d-grid">
                                <button type="button" class="btn btn-label-primary">Apply</button>
                            </div>
                        </div>
                    </div>

                    <hr class="mx-n6" />
                    <dl class="row mb-0">
                        <dt class="col-6 text-heading">Total</dt>
                        <dd id="total_bayar" class="col-6 fw-medium text-end text-heading mb-0">0</dd>
                    </dl>
                    <input type="number" id="total_bayar" name="total_bayar" hidden />
                    <input type="hidden" name="buku" id="bukuData">

                </div>
                <div class="d-grid card-footer">
                    <button type="submit" id="submit-btn" class="btn btn-primary btn-next">Place Order</button>
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

        // 📌 Klik tombol "Pilih" di modal
        $(".add-buku").click(function() {
            let id = $(this).data("id");
            let judul = $(this).data("judul");
            let harga = parseFloat($(this).data("harga"));
            let existing = selectedBuku.find(item => item.buku_id == id);

            if (existing) {
                existing.jumlah++;
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

        // 📌 Tambah / Kurangi jumlah 
        $(document).on("click", ".btn-qty", function() {
            let id = $(this).data("id");
            let action = $(this).data("action");
            let item = selectedBuku.find(b => b.buku_id == id);

            if (item) {
                if (action === "plus") item.jumlah++;
                else if (action === "minus" && item.jumlah > 1) item.jumlah--;

                item.subtotal = item.harga_jual * item.jumlah;
                updateTable();
            }
        });

        // 📌 Hapus item dari daftar
        $(document).on("click", ".btn-delete", function() {
            let id = $(this).data("id");
            selectedBuku = selectedBuku.filter(b => b.buku_id != id);
            updateTable();
        });

        // 📌 UPDATE TABEL + TOTAL BAYAR
        function updateTable() {
            let itemList = $("#itemList");
            let orderList = $("#orderList");

            itemList.empty();
            orderList.empty();
            let totalBayar = 0;

            $.each(selectedBuku, function(index, buku) {
                totalBayar += buku.subtotal; // 🔥 Hitung total bayar

                itemList.append(`
                <div class="row">
                            <dt class="col-12 fw-bold mb-1">${buku.judul}</dt>
                            <dd class="col-3">${buku.harga_jual.toLocaleString()}</dd>
                            <dd class="col-3 d-flex">x${buku.jumlah}</dd>
                            <dd class="col-6 text-end">${buku.subtotal.toLocaleString()}</dd>
                        </div>
                
                `);
                orderList.append(`
                <tr>
                                    <td>${index + 1}</td>
                                    <td>${buku.judul}</td>
                                    <td>${buku.harga_jual.toLocaleString()}</td>
                                    <td>
                                        <button class="btn btn-sm rounded-pill btn-label-primary btn-qty" data-id="${buku.buku_id}" data-action="minus">-</button>
                                        ${buku.jumlah}
                                        <button class="btn btn-sm rounded-pill btn-label-primary btn-qty" data-id="${buku.buku_id}" data-action="plus">+</button>
                                    </td>
                                    <td>${buku.subtotal.toLocaleString()}</td>
                                    <td>
                                        <button class="btn btn-sm rounded-pill btn-label-danger btn-delete" data-id="${buku.buku_id}"><i class="bx bx-trash text-danger"></i></button>
                                    </td>
                                </tr>
                
                `);
            });

            // 🔥 Update Total Bayar di Input
            $("#total_bayar").text(totalBayar.toLocaleString());
            $("#total_bayar").val(totalBayar);

            // 🔥 Simpan data ke input hidden buat dikirim ke server
            $("#bukuData").val(JSON.stringify(selectedBuku));
        }

    });
</script>
@endsection