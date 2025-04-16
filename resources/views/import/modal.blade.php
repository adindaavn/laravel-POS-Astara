<div class="modal fade" id="modalImport" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form id="importForm" action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Import Data Excel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="tipe" id="importTipe">
                <div class="mb-3">
                    <label for="fileExcel" class="form-label">File Excel</label>
                    <input class="form-control" type="file" id="fileExcel" name="file" required accept=".xlsx,.xls">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
            </div>
        </form>
    </div>
</div>