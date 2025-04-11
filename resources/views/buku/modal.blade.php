<div class="modal fade" id="modalBuku" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="jenis-form" action="{{ route('buku.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Buku</h5>
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
                        <input type="hidden" name="old_img" id="old_img">

                        <div class="row">
                            <div class="col-3">
                                <div class="text-center">
                                    <div id="icon-placeholder" class="rounded mt-2 bg-light d-flex justify-content-center align-items-center" style="height: 120px; cursor: pointer;">
                                        <i class="menu-icon tf-icons bx bx-book fs-1 text-primary"></i>
                                    </div>

                                    <img id="preview-gambar" class="rounded mt-4"
                                        style="max-width: 100px; max-height: 100px; object-fit: cover; cursor: pointer;">

                                    @error('gambar')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="col-12 mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input
                                        type="text"
                                        id="judul"
                                        class="form-control"
                                        placeholder="Judul"
                                        name="judul" />
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input
                                        type="text"
                                        id="penulis"
                                        class="form-control"
                                        placeholder="Penulis"
                                        name="penulis" />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input
                                    type="text"
                                    id="isbn"
                                    class="form-control"
                                    placeholder="ISBN"
                                    name="isbn" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="kategori" class="form-label">Kategori</label>
                                <select class="form-select" name="kategori_id" id="kategori_id">
                                    @foreach($kategori as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="penerbit" class="form-label">Penerbit</label>
                                <input
                                    type="text"
                                    id="penerbit"
                                    class="form-control"
                                    placeholder="Penerbit"
                                    name="penerbit" />
                            </div>
                            <div class="col-6 mb-3">
                                <label for="thn_terbit" class="form-label">Tahun Terbit</label>
                                <input
                                    type="number"
                                    id="thn_terbit"
                                    class="form-control"
                                    placeholder="Tahun Terbit"
                                    name="thn_terbit" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-4 mb-3">
                                <label for="harga" class="form-label">Harga Jual</label>
                                <input
                                    type="number"
                                    id="harga"
                                    class="form-control"
                                    placeholder="Harga Jual"
                                    name="harga" />
                            </div>

                            <div class="col-2">
                                <label for="pajak" class="form-label">Pajak</label>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="pajak" id="pajak" value="1">
                                </div>
                            </div>

                            <div class="col-6 mb-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input
                                    type="file"
                                    name="gambar"
                                    class="form-control"
                                    id="gambar">
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