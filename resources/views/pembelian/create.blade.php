@extends('layout.header')
@section('title', 'Pendataan Buku')
@section('content')
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <form id="formPembelian" action="{{ route('pembelian.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="pb-0 fw-bold">Transaksi</h5>
                        <button type="submit" class="btn btn-primary" id="submit-btn">Bayar</button>
                    </div>
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

                        <div class="col-12 mb-3">
                            <label for="buku" class="form-label">Buku</label>
                            <br>
                            <div id="buku-container"></div>
                            <div class="mb-0">
                                <div class="d-flex">
                                    <button type="button" class="btn btn-primary me-2" id="add-buku">
                                        <i class="icon-base bx bx-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalBuku">
                                        <span class="align-middle">Buku Baru</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 mb-3">
                            <label for="total" class="form-label">Total Bayar</label>
                            <input type="number" id="total" class="form-control" placeholder="Total Bayar" name="total" readonly />
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
        let bukuContainer = $("#buku-container");

        function getBukuItem() {
            return `
            <div class="buku-item row">
                <div class="mb-6 col-lg-6 col-xl-4 col-12 mb-0">
                    <label class="form-label">Judul Buku</label>
                    <select class="select2 form-select buku_id" data-allow-clear="true">
                        @foreach($buku as $b)
                        <option value="{{$b->id}}">{{$b->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                    <label class="form-label">Harga</label>
                    <input type="number" class="form-control harga" />
                </div>
                <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control jumlah" />
                </div>
                <div class="mb-6 col-lg-6 col-xl-2 col-12 mb-0">
                    <label class="form-label">Subtotal</label>
                    <input type="number" class="form-control subtotal" readonly />
                </div>
                <div class="mb-6 col-lg-6 col-xl-2 col-12 d-flex align-items-end mb-0">
                    <button type="button" class="btn btn-label-danger remove-buku">
                        <i class="icon-base bx bx-x"></i>
                    </button>
                </div>
                <hr />
            </div>`;
        }

        // Add new book item
        $("#add-buku").click(function() {
            bukuContainer.append(getBukuItem());
            $(".select2").select2(); // Reinitialize select2
        });

        // Remove book item
        bukuContainer.on("click", ".remove-buku", function() {
            $(this).closest(".buku-item").remove();
            updateTotal();
        });

        // Calculate subtotal
        bukuContainer.on("input", ".harga, .jumlah", function() {
            let row = $(this).closest(".buku-item");
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
            $("#total").val(total);
        }

        // Prepare data before submit
        $("#submit-btn").click(function(event) {
            event.preventDefault(); // Prevent form from submitting normally

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
            $("#formPembelian").submit(); // Submit form
        });
    });
</script>
@endsection