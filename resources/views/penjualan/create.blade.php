@extends('layout.header')
@section('title', 'Transaksi Buku')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-header">

                <h5 class="pb-0 fw-bold">Transaksi</h5>
            </div>
            <form id="formPenjualan" action="{{ route('penjualan.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">

                        <div class="col-8 mb-3">

                            <label for="member_id" class="form-label">Member</label>
                            <div class="input-group">
                                <select class="form-select" id="inputGroupSelect04">
                                    <option selected>Choose...</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                                <button class="btn btn-outline-primary" type="button">Button</button>
                            </div>
                            <select class="form-select" id="member_id" name="member_id">
                                @foreach($member as $m)
                                <option value="{{$m->id}}">{{$m->nama}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-3">
                            <label for="buku" class="form-label">Buku</label>
                            <br>
                            <button type="button" class="btn btn-primary btn-add"
                                data-bs-toggle="modal"
                                data-bs-target="#modalBuku">
                                <div class="d-flex align-content-center py-1">
                                    <i class="menu-icon tf-icons bx bx-plus"></i>
                                    <h5 class="text-white m-0">Tambah</h5>
                                </div>
                            </button>

                            <div class="table-responsive text-nowrap p-3">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="fw-bold">No</th>
                                            <th class="fw-bold">Nama</th>
                                            <th class="fw-bold">Harga</th>
                                            <th class="fw-bold">Jumlah</th>
                                            <th class="fw-bold">Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="bukuList">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="total_bayar" class="form-label">Total Bayar</label>
                            <input
                                type="number"
                                id="total_bayar"
                                class="form-control"
                                placeholder="Total Bayar"
                                name="total_bayar" readonly />
                        </div>

                    </div>
                </div>
                <input type="hidden" name="buku" id="bukuData">
                <div class="card-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Bayar</button>
            </form>

        </div>
    </div>

</div>
<div class="modal fade" id="modalBuku" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="table-responsive text-nowrap p-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th class="fw-bold">No</th>
                            <th class="fw-bold">Kode</th>
                            <th class="fw-bold">Judul</th>
                            <th class="fw-bold">Penulis</th>
                            <th class="fw-bold">ISBN</th>
                            <th class="fw-bold">Harga</th>
                            <th class="fw-bold">Stok</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buku as $data)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$data->kode}}</td>
                            <td>{{$data->judul}}</td>
                            <td>{{$data->penulis}}</td>
                            <td>{{$data->isbn}}</td>
                            <td>{{$data->harga}}</td>
                            <td>{{$data->stok}}</td>
                            <td>
                                <button class="btn btn-success btn-sm add-buku"
                                    data-id="{{$data->id}}"
                                    data-judul="{{$data->judul}}"
                                    data-harga="{{$data->harga}}">
                                    Pilih
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
            $("#modalBuku").modal("hide");
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
            let tbody = $("#bukuList");
            tbody.empty();

            let totalBayar = 0; // 🔥 Inisialisasi total bayar

            $.each(selectedBuku, function(index, buku) {
                totalBayar += buku.subtotal; // 🔥 Hitung total bayar

                tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${buku.judul}</td>
                <td>${buku.harga_jual.toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-secondary btn-qty" data-id="${buku.buku_id}" data-action="minus">-</button>
                    ${buku.jumlah}
                    <button class="btn btn-sm btn-secondary btn-qty" data-id="${buku.buku_id}" data-action="plus">+</button>
                </td>
                <td>${buku.subtotal.toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-danger btn-delete" data-id="${buku.buku_id}">Hapus</button>
                </td>
            </tr>
        `);
            });

            // 🔥 Update Total Bayar di Input
            $("#total_bayar").val(totalBayar);

            // 🔥 Simpan data ke input hidden buat dikirim ke server
            $("#bukuData").val(JSON.stringify(selectedBuku));
        }

    });
</script>
@endsection