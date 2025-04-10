<div class="modal fade" id="modalCash" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-6">
                    <h4 class="mb-2">Bayar Cash</h4>
                    <p>Masukkan nominal bayar untuk menyelesaikan transaksi</p>
                </div>
                <form id="addNewCCForm" class="row g-6" onsubmit="return false">
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="bayar_cash">Total</label>
                        <p id="bayar_cash" class="form-control"></p>
                        <input type="number" id="cash" hidden />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label" for="nominal_bayar">Nominal Bayar</label>
                        <input type="number" id="nominal_bayar" class="form-control" autofocus />
                    </div>
                    <div class="col-6 col-md-6">
                        <label class="form-label" for="kembalian">Kembalian</label>
                        <p id="kembalian"></p>
                    </div>

                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1">Bayar</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>