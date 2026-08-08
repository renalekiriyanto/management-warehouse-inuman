{{-- =============================================================
     IMPORT MODAL PARTIAL
     Include ke: inbounds/projection/index.blade.php
     ============================================================= --}}

<div
    class="modal fade proj-modal"
    id="importProjectionModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="importProjectionModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 560px;">
        <div class="modal-content">

            {{-- ===== MODAL HEADER ===== --}}
            <div class="modal-header">
                <h5 class="modal-title" id="importProjectionModalLabel">
                    <i class="fas fa-file-import mr-2"></i>
                    Import Projection
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            {{-- ===== MODAL BODY ===== --}}
            <div class="modal-body">
                <form
                    id="importProjectionForm"
                    action="{{ route('inbound.projection.import') }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf

                    {{-- Drag & Drop Dropzone --}}
                    <div class="proj-dropzone" id="projDropzone">

                        {{-- Hidden File Input --}}
                        <input
                            type="file"
                            id="importFile"
                            name="file"
                            accept=".xlsx,.csv"
                            required
                        >

                        {{-- Dropzone UI --}}
                        <div class="dropzone-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>

                        <p class="dropzone-title">Drag & Drop file ke sini</p>
                        <p class="dropzone-sub">atau klik area ini untuk memilih file</p>

                        <button
                            type="button"
                            class="btn-proj btn-proj-outline btn-proj-sm"
                            onclick="document.getElementById('importFile').click(); event.stopPropagation();"
                            style="position: relative; z-index: 2;"
                        >
                            <i class="fas fa-folder-open"></i>
                            Choose Excel File
                        </button>

                        <div class="dropzone-accepted">
                            <span class="file-type-badge">.xlsx</span>
                            <span class="file-type-badge">.csv</span>
                        </div>

                    </div>

                    {{-- Selected File Name --}}
                    <div class="proj-file-name" id="projFileName"></div>

                    {{-- Template Info --}}
                    <div class="template-info">
                        <div class="template-info-header">
                            <i class="fas fa-info-circle"></i>
                            Format Template
                        </div>
                        <div class="template-info-body">
                            <table class="template-table">
                                <thead>
                                    <tr>
                                        <th>date</th>
                                        <th>projection_inbound</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>2026-08-01</td>
                                        <td>5200</td>
                                    </tr>
                                    <tr>
                                        <td>2026-08-02</td>
                                        <td>4700</td>
                                    </tr>
                                    <tr>
                                        <td>2026-08-03</td>
                                        <td>6100</td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="template-note">
                                <i class="fas fa-exclamation-triangle"></i>
                                <span>
                                    Pastikan format file mengikuti template agar proses import berhasil.
                                </span>
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            {{-- ===== MODAL FOOTER ===== --}}
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn-proj btn-proj-outline"
                    data-dismiss="modal"
                >
                    <i class="fas fa-times"></i>
                    Cancel
                </button>

                <button
                    type="submit"
                    form="importProjectionForm"
                    class="btn-proj btn-proj-yellow"
                    id="importSubmitBtn"
                >
                    <i class="fas fa-file-import"></i>
                    Import
                </button>
            </div>

        </div>
    </div>
</div>
