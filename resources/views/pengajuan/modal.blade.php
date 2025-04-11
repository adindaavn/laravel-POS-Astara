<div class="modal fade" id="modalPengajuan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="jenis-form" action="{{ route('pengajuan.store') }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Pengajuan Buku</h5>
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
                            <label for="member_id" class="form-label">Member</label>
                            <select class="form-select" name="member_id" id="member_id">
                                <option value="">-- Pilih Member --</option>
                                @foreach($member as $m)
                                <option value="{{ $m->id }}">{{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="nama_pengaju" class="form-label">Nama Pengaju</label>
                                <input
                                    type="text"
                                    id="nama_pengaju"
                                    class="form-control"
                                    placeholder="Nama Pengaju"
                                    name="nama_pengaju" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="no_telp" class="form-label">No. Telepon</label>
                                <input
                                    type="text"
                                    id="no_telp"
                                    class="form-control"
                                    placeholder="No. Telepon"
                                    name="no_telp" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="judul" class="form-label">Judul</label>
                                <input
                                    type="text"
                                    id="judul"
                                    class="form-control"
                                    placeholder="Judul"
                                    name="judul" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input
                                    type="text"
                                    id="penulis"
                                    class="form-control"
                                    placeholder="Penulis"
                                    name="penulis" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3 mb-3">
                                <label for="qty" class="form-label">Qty</label>
                                <input
                                    type="number"
                                    id="qty"
                                    class="form-control"
                                    placeholder="Qty"
                                    name="qty" />
                            </div>
                            <div class="col-9 mb-3">
                                <label for="catatan" class="form-label">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control"></textarea>
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