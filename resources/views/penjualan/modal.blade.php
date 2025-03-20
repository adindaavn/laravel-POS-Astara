<div class="modal fade" id="modalKartu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-6">
                    <h4 class="mb-2">Bayar Kartu Kredit</h4>
                    <p>Masukkan nominal bayar untuk menyelesaikan transaksi</p>
                </div>
                <div id="addNewCCForm" class="row g-6" onsubmit="return false">
                    <div class="col-12 form-control-validation">
                        <label class="form-label w-100" for="no_rekening">No. Kartu</label>
                        <div class="input-group input-group-merge">
                            <input id="noRekCC" name="no_rekening" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" aria-describedby="no_rekening" />
                            <span class="input-group-text cursor-pointer" id="noRekCC"><span class="card-type me-n2"></span></span>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label class="form-label" for="nama_rek">Nama</label>
                        <input type="text" id="nama_rek" class="form-control" placeholder="John Doe" />
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="tgl_exp">Tgl. Exp</label>
                        <input type="text" id="tgl_exp" class="form-control expiry-date-mask" placeholder="MM/YY" />
                    </div>
                    <div class="col-6 col-md-3">
                        <label class="form-label" for="kode_cvv">Kode CVV</label>
                        <div class="input-group input-group-merge">
                            <input type="text" id="kode_cvv" class="form-control cvv-code-mask" maxlength="3" placeholder="654" />
                            <span class="input-group-text cursor-pointer ps-0" id="kode_cvv2"><i class="icon-base bx bx-help-circle text-body-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Card Verification Value"></i></span>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1">Bayar</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTransfer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-6">
                    <h4 class="mb-2">Bayar via Transfer</h4>
                    <p>Pilih transaksi transfer</p>
                </div>
                <div class="nav-align-top">
                    <ul class="nav nav-pills mb-4" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#bank"
                                aria-controls="bank"
                                aria-selected="true">
                                Transfer Bank
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#e-wallet"
                                aria-controls="e-wallet"
                                aria-selected="false">
                                E-Wallet
                            </button>
                        </li>
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#qris"
                                aria-controls="qris"
                                aria-selected="false">
                                QRIS
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content px-0 border-0 shadow-none">
                        <div class="tab-pane fade show active" id="bank" role="tabpanel">
                            <div class="col-12 form-control-validation">
                                <label class="form-label w-100" for="no_rekening">No. Rekening</label>
                                <div class="input-group input-group-merge">
                                    <input id="noRekTf" name="no_rekening" class="form-control credit-card-mask" type="text" placeholder="1356 3215 6548 7898" aria-describedby="no_rekening" />
                                    <span class="input-group-text cursor-pointer" id="noRekTf"><span class="card-type me-n2"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="e-wallet" role="tabpanel">
                            <div class="col-12 form-control-validation">
                                <label class="form-label w-100" for="no_hp">No. HP</label>
                                <div class="input-group input-group-merge">
                                    <input id="noRekHp" name="no_rekening" class="form-control phone-mask" type="text" placeholder="1356 3215 6548 7898" aria-describedby="no_rekening" />
                                    <span class="input-group-text cursor-pointer" id="noRekHp"><span class="card-type me-n2"></span></span>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="qris" role="tabpanel">
                            <div class="col-12 form-control-validation">
                                <label class="form-label w-100" for="qris">QRIS</label>
                                <div class="input-group input-group-merge">
                                    <input id="no_rekening" name="no_rekening" class="form-control qris-mask" type="text" placeholder="12345 67890 12345 67890" />
                                    <span class="input-group-text cursor-pointer"" id=" no_rekening"><span class="card-type me-n2"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-primary me-sm-3 me-1">Bayar</button>
                        <button type="reset" class="btn btn-label-secondary btn-reset" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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