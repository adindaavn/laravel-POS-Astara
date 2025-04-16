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
                    <input type="text" class="barcode-input form-control form-control-md mb-2 w-25" placeholder="Scan Barcode ISBN" autofocus/>
                    <div id="tableTransaksi" class="table-responsive text-nowrap">
                        <div id="tableContainer">
                            <table id="tableBuku" class="table table-striped table-bordered">
                                <thead>
                                    <tr class="table-primary">
                                        <th></th>
                                        <th class="fw-bold">ID</th>
                                        <th class="fw-bold">ISBN</th>
                                        <th class="fw-bold">Judul</th>
                                        <th class="fw-bold">Penulis</th>
                                        <th class="fw-bold">Harga</th>
                                        <th class="fw-bold">Kategori</th>
                                        <th class="fw-bold">Stok</th>
                                        <th class="fw-bold">Cover</th>
                                        <th class="fw-bold">Barcode</th>
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
                                        <td>{{$data->id}}</td>
                                        <td>{{$data->isbn}}</td>
                                        <td>{{$data->judul}}</td>
                                        <td>{{$data->penulis}}</td>
                                        <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                                        <td>{{$data->kategori}}</td>
                                        <td>{{$data->stok}}</td>
                                        <td>{{$data->gambar}}</td>
                                        <td><img src="data:image/png;base64,{{ $data->barcode }}" alt="Barcode ISBN" width="150"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Container untuk Card -->
                        <div id="cardContainer" class="row mt-3"></div>

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
                                <option value="{{$m->id}}" data-point="{{$m->point}}">
                                    {{$m->nama}} (XP {{$m->point}})
                                </option>
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
                    <dl class="col-12 mb-0 text-heading itemList">
                    </dl>
                    <!-- 
                    <hr class="px-2" />
                    <div class="row">
                        <div class="col-1 d-flex align-items-center">
                            <span><i class="icon-base bx bxs-discount"></i></span>
                        </div>
                        <div class="col-7">
                            <select class="select2 form-select" id="voucher_id" name="voucher_id" data-allow-clear="true" aria-placeholder="Pilih Voucher">
                                <option value="">Search Voucher</option>
                                @foreach($voucher as $v)
                                <option value="{{$v->id}}">{{$v->kode}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <div class="d-grid">
                                <button type="button" class="btn btn-label-primary">Apply</button>
                            </div>
                        </div>
                    </div> -->

                    <hr class="px-2" />
                    <dl class="row mb-0">
                        <dt class="col-8">Subtotal</dt>
                        <dd class="subtotal col-4 fw-medium text-end mb-1">0</dd>
                        <dt class="col-8 diskon-text">Diskon</dt>
                        <dd class="diskon col-4 fw-medium text-end mb-1">0</dd>
                        <dt class="col-8 text-heading fs-5">Total</dt>
                        <dd class="total col-4 fw-medium text-end text-heading mb-1 fs-5">0</dd>
                    </dl>
                    <input type="hidden" id="total_bersih" name="total_bersih" step="0.01" />
                    <input type="hidden" id="total_bayar" name="total_bayar" step="0.01" />
                    <input type="hidden" id="kembali" name="kembali">
                    <input type="hidden" id="bayar" name="bayar">
                    <input type="hidden" id="diskon" name="diskon">
                    <input type="hidden" id="minus_point" name="minus_point">
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
                    <button type="submit" id="submit-btn" class="btn btn-primary btn-next" hidden>Bayar</button>
                    <button type="button"
                        id="btn-bayar"
                        class="btn btn-primary"
                        data-total_bayar=""
                        data-bs-target="#modalCash"
                        data-bs-toggle="modal"
                        data-bs-dismiss="modal">
                        Bayar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('member.modal')
@include('penjualan.modal')
@include('penjualan.fraktur')

<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {

        let selectedBuku = [];

        let semuaBuku = [];

        $(".add-buku").each(function() {
            let $btn = $(this);
            let tr = $btn.closest("tr");

            semuaBuku.push({
                buku_id: $btn.data("id"),
                isbn: tr.find("td").eq(2).text().trim(),
                judul: $btn.data("judul"),
                harga_jual: parseFloat($btn.data("harga")),
                stok: parseInt(tr.find("td").eq(7).text().trim()) || 0
            });
        });

        $(".barcode-input").on("keypress", function(e) {
            if (e.which === 13) {
                e.preventDefault();
                let barcode = $(this).val().trim();
                if (!barcode) return;

                let buku = semuaBuku.find(item => item.isbn == barcode);
                if (!buku) {
                    alert("Buku dengan barcode tersebut tidak ditemukan!");
                    $(this).val("").focus();
                    return;
                }

                let existing = selectedBuku.find(item => item.buku_id == buku.buku_id);
                if (existing) {
                    if (existing.jumlah < buku.stok) {
                        existing.jumlah++;
                        existing.subtotal = existing.jumlah * existing.harga_jual;

                        // ✅ Update input value-nya juga
                        let input = $(`.input-jumlah[data-id='${existing.buku_id}']`);
                        if (input.length) {
                            input.val(existing.jumlah);
                        }
                    }
                } else {
                    selectedBuku.push({
                        buku_id: buku.buku_id,
                        judul: buku.judul,
                        harga_jual: buku.harga_jual,
                        jumlah: 1,
                        subtotal: buku.harga_jual,
                        stok: buku.stok
                    });

                    // 🔁 Replace tombol add-buku dengan input jumlah
                    let $btn = $(`.add-buku[data-id='${buku.buku_id}']`);
                    let jumlahInput = `
                        <div class="d-flex align-items-center justify-content-center gap-1 jumlah-input" style="font-size: 0.85rem;">
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-2 btn-minus" data-id="${buku.buku_id}" style="min-width: 30px;">-</button>
                            <input type="number" class="form-control text-center form-control-sm input-jumlah" data-id="${buku.buku_id}" value="1" min="1" max="${buku.stok}" 
                                style="width: 50px; border-radius: 50px;">
                            <button class="btn btn-outline-success btn-sm rounded-pill px-2 btn-plus" data-id="${buku.buku_id}" style="min-width: 30px;">+</button>
                        </div>
                    `;
                                    $btn.replaceWith(jumlahInput);
                                }

                updateTable();
                $(this).val("").focus();
            }
        });

        $(document).on("click", ".add-buku", function() {
            let id = $(this).data("id");
            let judul = $(this).data("judul");
            let harga = $(this).data("harga");
            let stok = $(this).data("stok");

            // Cek apakah harga valid
            if (!harga) {
                console.error("Harga tidak ditemukan!", this);
                return;
            }

            // Bersihkan format harga dan ubah ke angka
            harga = parseFloat(harga.toString().replace("Rp. ", "").replace(/\./g, ""));

            let existing = selectedBuku.find(item => item.buku_id == id);

            if (existing) {
                if (existing.jumlah < stok) {
                    existing.jumlah++;
                    existing.subtotal = existing.jumlah * existing.harga_jual;
                }
            } else {
                selectedBuku.push({
                    buku_id: id,
                    judul: judul,
                    harga_jual: harga,
                    jumlah: 1,
                    subtotal: harga,
                    stok: stok
                });
            }

            let jumlahInput = `
            <div class="d-flex align-items-center justify-content-center gap-1 jumlah-input" style="font-size: 0.85rem;">
                <button class="btn btn-outline-danger btn-sm rounded-pill px-2 btn-minus" data-id="${id}" style="min-width: 30px;">-</button>
                <input type="number" class="form-control text-center form-control-sm input-jumlah" data-id="${id}" value="1" min="1" max="${stok}" 
                    style="width: 50px; border-radius: 50px;">
                <button class="btn btn-outline-success btn-sm rounded-pill px-2 btn-plus" data-id="${id}" style="min-width: 30px;">+</button>
            </div>
        `;
            $(this).replaceWith(jumlahInput);
            updateTable();
        });

        $(document).on("input", ".input-jumlah", function() {
            let id = $(this).data("id");
            let newJumlah = parseInt($(this).val());
            let item = selectedBuku.find(b => b.buku_id == id);
            let stok = item ? item.stok : 0;

            if (item) {
                if (newJumlah <= 0) {
                    selectedBuku = selectedBuku.filter(b => b.buku_id != id);
                } else if (newJumlah > stok) {
                    item.jumlah = stok;
                    $(this).val(stok);
                } else {
                    item.jumlah = newJumlah;
                }
                item.subtotal = item.harga_jual * item.jumlah;
            }
            updateTable();
        });

        $(document).on("click", ".btn-plus", function() {
            let id = $(this).data("id");
            let input = $(`.input-jumlah[data-id='${id}']`);
            let item = selectedBuku.find(b => b.buku_id == id);

            if (item && item.jumlah < item.stok) {
                item.jumlah++;
                item.subtotal = item.harga_jual * item.jumlah;
                input.val(item.jumlah);
            }
            updateTable();
        });

        $(document).on("click", ".btn-minus", function() {
            let id = $(this).data("id");
            let input = $(`.input-jumlah[data-id='${id}']`);
            let item = selectedBuku.find(b => b.buku_id == id);

            if (item) {
                if (item.jumlah > 1) {
                    item.jumlah--;
                    item.subtotal = item.harga_jual * item.jumlah;
                    input.val(item.jumlah);
                } else {
                    selectedBuku = selectedBuku.filter(b => b.buku_id != id);
                    let tombolTambah = `<button class="btn rounded-pill btn-primary btn-outline-primary btn-sm add-buku mt-1"
                data-id="${id}" data-judul="${item.judul}" data-harga="${item.harga_jual}" data-stok="${item.stok}">
                <i class="bx bx-plus"></i> Tambah
            </button>`;
                    input.closest(".jumlah-input").replaceWith(tombolTambah);
                }
            }
            updateTable();
        });

        $("#member_id").on("change", function() {
            updateTable();
        });

        function updateTable() {
            let itemList = $(".itemList");

            itemList.empty();
            let subtotal = 0;
            let diskon = 0;
            let total = 0;

            $.each(selectedBuku, function(index, buku) {
                subtotal += buku.subtotal;

                itemList.append(`
                    <div class="row mb-1">
                        <dt class="col-12 fw-bold mb-1">${buku.judul}</dt>
                        <dd class="col-3">${buku.harga_jual.toLocaleString()}</dd>
                        <dd class="col-3 d-flex">x${buku.jumlah}</dd>
                        <dd class="col-6 text-end">${buku.subtotal.toLocaleString()}</dd>
                    </div>
                `);

            });

            let selectedMember = $('#member_id').find(':selected');
            let point = parseInt(selectedMember.data('point')) || 0;

            let persentaseDiskon = 0;
            let minusPoint = 0;
            if (point >= 400) {
                persentaseDiskon = 20;
                minusPoint = 400;
            } else if (point >= 300) {
                persentaseDiskon = 15;
                minusPoint = 300;
            } else if (point >= 200) {
                persentaseDiskon = 10;
                minusPoint = 200;
            } else if (point >= 100) {
                persentaseDiskon = 5;
                minusPoint = 100;
            }

            diskon = subtotal * (persentaseDiskon / 100);
            total = subtotal - diskon;

            persentaseDiskon == 0 ?
                $(".diskon-text").text('Diskon') :
                $(".diskon-text").text("Diskon " + persentaseDiskon + "% (-" + minusPoint + " point member)");

            $(".subtotal").text(subtotal.toLocaleString());
            $(".diskon").text(diskon.toLocaleString());
            $(".total").text(total.toLocaleString());

            $("#minus_point").val(minus_point);
            $("#diskon").val(diskon);
            $("#total_bayar").val(total);
            $("#total_bersih").val(subtotal);

            $("#bukuData").val(JSON.stringify(selectedBuku));
            $("#btn-bayar").attr('data-total_bayar', total);
            $("#btn-bayar").attr('data-total_format', total.toLocaleString());

            console.log("Data dikirim:", JSON.stringify(selectedBuku));
            console.log($("#formPenjualan").serializeArray());
        }
    });
</script>
<script>
    $(document).ready(function() {
        // Ubah target modal sesuai metode bayar yang dipilih
        $('input[name="metode_bayar"]').change(function() {
            const metode = $('input[name="metode_bayar"]:checked').val();
            const targetModal = metode === 'qris' ? '#modalQris' : '#modalCash';
            $('#btn-bayar').attr('data-bs-target', targetModal);
        });

        // Modal Cash muncul
        $('#modalCash').on('show.bs.modal', function() {
            const total = $("#btn-bayar").data('total_bayar');
            const format = $("#btn-bayar").data('total_format');
            $("#bayar_cash").text("Rp. " + format);
            $("#cash").val(total);
        });

        // Fokus input nominal saat modal cash dibuka
        $('#modalCash').on('shown.bs.modal', function() {
            $('#nominal_bayar').trigger('focus');
        });

        // Hitung kembalian saat input nominal berubah
        $("#nominal_bayar").on("input", function() {
            const total = parseFloat($("#cash").val()) || 0;
            const bayar = parseFloat($(this).val()) || 0;
            const kembali = bayar - total;

            $("#kembalian").text(kembali >= 0 ? "Rp. " + kembali.toLocaleString() : "Nominal kurang");
            $("#kembali").val(kembali);
            $("#bayar").val(bayar);
        });

        // Modal QRIS muncul
        $('#modalQris').on('show.bs.modal', function() {
            const total = $("#btn-bayar").data('total_bayar');
            const format = $("#btn-bayar").data('total_format');

            $("#qris-total").text("Rp. " + format);
            $("#bayar").val(total);
            $("#kembali").val(0);
        });

        // Submit QRIS langsung via tombol
        $("#btn-qris-paid").on("click", function() {
            $("input[name='metode_bayar']").val("qris");
            submitWithPrint();
        });

        // Submit form cash
        $('#formBayarCash').on('submit', function(e) {
            e.preventDefault();
            $("input[name='metode_bayar']").val("cash");
            submitWithPrint();
        });

        // Fungsi submit dan cetak
        function submitWithPrint() {
            $("#formPenjualan").submit(); // tanpa ?print=true
        }
    });
</script>
@endsection