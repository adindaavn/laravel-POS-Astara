<div class="modal fade" id="modalAbsensi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="jenis-form" action="{{ route('absensi.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Absensi Karyawan</h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="row">

                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="id" id="id">

                        <div class="col-12 mb-3">
                            <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                            <input
                                type="text"
                                id="nama_karyawan"
                                class="form-control"
                                placeholder="Nama Karyawan"
                                name="nama_karyawan" />
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="tgl_masuk" class="form-label">Tanggal Masuk</label>
                                <input class="form-control" type="date" id="tgl_masuk" name="tgl_masuk" value="{{ now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" class="form-select" data-allow-clear="true" name="status">
                                    <option value="masuk">Masuk</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="cuti">Cuti</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="jam_masuk" class="form-label">Jam Masuk</label>
                                <input class="form-control" type="time" id="jam_masuk" name="jam_masuk" value="{{ now()->format('H:i') }}">
                            </div>
                            <div class="col-6 mb-3 input-selesai">
                                <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                <input class="form-control" type="time" id="jam_selesai" name="jam_selesai">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit-btn">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>