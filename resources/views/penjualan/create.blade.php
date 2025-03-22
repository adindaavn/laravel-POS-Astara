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
                        <dt class="col-6">Subtotal</dt>
                        <dd class="subtotal col-6 fw-medium text-end mb-1">0</dd>
                        <dt class="col-6">Pajak</dt>
                        <dd class="pajak col-6 fw-medium text-end mb-1">0</dd>
                        <dt class="col-6 text-heading">Total</dt>
                        <dd class="total col-6 fw-medium text-end text-heading mb-1">0</dd>
                    </dl>
                    <input type="hidden" id="total_bersih" name="total_bersih" step="0.01" />
                    <input type="hidden" id="total_bayar" name="total_bayar" step="0.01" />
                    <input type="hidden" id="no_rekening" name="no_rekening">
                    <input type="hidden" id="kembali" name="kembali">
                    <input type="hidden" id="bayar" name="bayar">
                    <input type="hidden" id="pajak" name="pajak">
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
                                <label class="form-check-label custom-option-content" for="transfer">
                                    <span class="custom-option-body">
                                        <i class="icon-base bx bx-qr-scan"></i>
                                        <span class="custom-option-title">Transfer</span>
                                    </span>
                                    <input hidden name="metode_bayar" class="form-check-input" type="radio" value="transfer" id="transfer" />
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

        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get("print") === "true") {
            const fraktur = document.getElementById("fraktur");
            if (fraktur) {
                const originalContents = document.body.innerHTML;
                document.body.innerHTML = fraktur.outerHTML;
                window.print();
                document.body.innerHTML = originalContents;

                // Hapus "print=true" dari URL tanpa refresh
                const newUrl = window.location.pathname;
                history.replaceState(null, "", newUrl);
            }
        }

        let selectedBuku = [];
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
        <div class="d-flex justify-content-center align-items-center gap-2">
            <button class="btn btn-label-danger btn-sm btn-minus" data-id="${id}">-</button>
            <input type="number" class="form-control text-center input-jumlah" data-id="${id}" value="1" min="1" max="${stok}" style="width: 60px;">
            <button class="btn btn-label-success btn-sm btn-plus" data-id="${id}">+</button>
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
                    let tombolTambah = `<button class="btn btn-outline-success btn-sm add-buku"
                data-id="${id}" data-judul="${item.judul}" data-harga="${item.harga_jual}" data-stok="${item.stok}">
                <i class="bx bx-plus"></i> Tambah
            </button>`;
                    input.closest(".d-flex").replaceWith(tombolTambah);
                }
            }
            updateTable();
        });


        function updateTable() {
            let itemList = $(".itemList");

            itemList.empty();
            let subtotal = 0;
            let pajak = 0;
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

            pajak = (subtotal * 11 / 100);
            total = subtotal + pajak;

            $(".subtotal").text(subtotal.toLocaleString());
            $(".pajak").text(pajak.toLocaleString());
            $(".total").text(total.toLocaleString());

            $("#pajak").val(pajak);
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
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get("print") === "true") {
            setTimeout(() => {
                const fraktur = document.getElementById("fraktur");
                if (fraktur) {
                    const originalContents = document.body.innerHTML;
                    document.body.innerHTML = fraktur.outerHTML;
                    window.print();
                    document.body.innerHTML = originalContents;

                    history.replaceState(null, "", window.location.pathname);
                }
            }, 500);
        }

        $('#modalCash').on('show.bs.modal', function(event) {
            $("#nominal_bayar").focus();
            let totalBayar = $("#btn-bayar").attr('data-total_bayar');
            let totalFormat = $("#btn-bayar").attr('data-total_format');
            $("#bayar_cash").text(totalFormat);
            $("#cash").val(totalBayar);
        });

        $("#nominal_bayar").on("input", function() {
            let totalBayar = parseFloat($("#cash").val()) || 0;
            let nominalBayar = parseFloat($(this).val()) || 0;
            let kembalian = nominalBayar - totalBayar;

            $("#kembalian").text(kembalian >= 0 ? kembalian.toLocaleString() : "Nominal kurang");
            $("#kembali").val(kembalian);
            $("#bayar").val(nominalBayar);
        });

        $('input[name="metode_bayar"]').change(function() {
            let metodeBayar = $('input[name="metode_bayar"]:checked').val();
            let targetModal = '';

            switch (metodeBayar) {
                case 'cash':
                    targetModal = '#modalCash';
                    break;
                case 'kartu':
                    targetModal = '#modalKartu';
                    break;
                case 'transfer':
                    targetModal = '#modalTransfer';
                    break;
            }

            $('#btn-bayar').attr('data-bs-target', targetModal);
        });

        $(".card-credit-mask").each(function() {
            new Cleave(this, {
                creditCard: true
            });
        });

        $("#modalKartu .btn-primary").on("click", function() {
            var noRekening = $("#noRekCC").val();

            $("#no_rekening").val(String(noRekening));

            submitWithPrint();
        });

        $("#modalCash .btn-primary").on("click", function() {
            $("input[name='metode_bayar']").val("cash");

            submitWithPrint();
        });

        $("#modalTransfer .btn-primary").on("click", function() {
            var noRekening = $("#noRekTf").val();
            var noHp = $("#noRekHp").val();

            if (noRekening != null) {
                $("#no_rekening").val(String(noRekening));
            } else {
                $("#no_rekening").val(String(noHp));
            }

            submitWithPrint();
        });

        function submitWithPrint() {
            const form = $("#formPenjualan");
            form.attr("action", form.attr("action") + "?print=true"); // Tambah param print
            form.submit();
        }
    });
</script>
@endsection