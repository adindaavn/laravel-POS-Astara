<div class="modal fade" id="modalCash" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="fw-bold mb-3">Cash</h4>
                    <p class="mb-2">Masukkan nominal bayar untuk menyelesaikan transaksi</p>
                </div>
                <form id="formBayarCash" class="row g-6 mt-2">
                    <!-- <div class="col-12 col-md-6">
                        <label class="form-label" for="bayar_cash">Total</label>
                        <p id="bayar_cash" class="form-control"></p>
                    </div> -->
                    <input type="hidden" id="cash" />
                    <input type="hidden" name="metode_bayar" value="cash" />
                    <div class="col-12 col-md-12">
                        <input type="number" id="nominal_bayar" class="form-control form-control-lg" placeholder="Nominal Bayar" />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label" for="bayar_cash">Total</label>
                        <p id="bayar_cash" class="fs-5"></p>
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label" for="kembalian">Kembalian</label>
                        <p id="kembalian" class="fs-5">Rp.</p>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Bayar</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalQris" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <h4 class="fw-bold mb-3">Pembayaran QRIS</h4>
                <p class="mb-2">Scan QR berikut untuk menyelesaikan pembayaran</p>

                <!-- Placeholder untuk QR Code -->
                <div id="qris-qr-code" class="mb-3">
                    <img src="{{ asset('assets') }}/img/elements/qris.svg" alt="QRIS" class="img-fluid rounded" />
                </div>

                <p class="fs-5 fw-bold">Total: <span id="qris-total">Rp 0</span></p>

                <button type="button" class="btn btn-primary" id="btn-qris-paid">Sudah Bayar</button>
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>