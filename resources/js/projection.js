// --- Select2 Initialization ---
$(document).ready(function () {
    $('.select2-projection').select2({
        placeholder: 'Search station...',
        allowClear: true,
        width: '100%',
    });

    // Auto-submit filter on station change
    $('.select2-projection').on('change', function () {
        $('#filterForm').submit();
    });

    // --- Drag & Drop Dropzone ---
    const dropzone    = document.getElementById('projDropzone');
    const fileInput   = document.getElementById('importFile');
    const fileNameBox = document.getElementById('projFileName');

    if (dropzone && fileInput) {
        dropzone.addEventListener('dragover', function (e) {
            e.preventDefault();
            dropzone.classList.add('drag-over');
        });

        dropzone.addEventListener('dragleave', function () {
            dropzone.classList.remove('drag-over');
        });

        dropzone.addEventListener('drop', function (e) {
            e.preventDefault();
            dropzone.classList.remove('drag-over');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                showFileName(files[0].name);
            }
        });

        fileInput.addEventListener('change', function () {
            if (this.files.length > 0) {
                showFileName(this.files[0].name);
            }
        });

        function showFileName(name) {
            fileNameBox.textContent = '📄 ' + name;
            fileNameBox.style.display = 'block';
        }
    }

    // --- Delete Confirmation ---
    $(document).on('click', '.btn-delete-projection', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');
        if (confirm('Apakah Anda yakin ingin menghapus data projection ini?')) {
            form.submit();
        }
    });

    // ==========================================================
    // --- Import Projection (button di luar <form>, trigger via JS) ---
    // ==========================================================
    const $importForm   = $('#importProjectionForm');
    const $importBtn    = $('#importSubmitBtn');
    const $importFile   = $('#importFile');
    const $fileNameBox  = $('#projFileName');
    const $modal        = $('#importProjectionModal');

    if ($importForm.length && $importBtn.length) {

        // Klik tombol submit di footer modal -> validasi -> trigger submit form
        $importBtn.on('click', function (e) {
            e.preventDefault();

            const fileEl = $importFile.get(0);

            if (!fileEl.files.length) {
                fileEl.reportValidity(); // munculkan native "please select a file"
                return;
            }

            const allowedExt = ['xlsx', 'csv'];
            const fileName   = fileEl.files[0].name;
            const ext        = fileName.split('.').pop().toLowerCase();

            if (!allowedExt.includes(ext)) {
                showImportAlert('danger', 'File harus berformat .xlsx atau .csv.');
                return;
            }

            submitImportForm();
        });

        function submitImportForm() {
            const formData = new FormData($importForm.get(0));
            const originalBtnHtml = $importBtn.html();

            $importBtn.prop('disabled', true)
                      .html('<i class="fas fa-spinner fa-spin"></i> Importing...');

            clearImportAlert();

            $.ajax({
                url: $importForm.attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    || $importForm.find('input[name="_token"]').val(),
                },
            })
            .done(function (data) {
                const hasFailed = data.failed_count > 0;

                showImportAlert(
                    hasFailed ? 'warning' : 'success',
                    `Import selesai. ${data.imported_count} baris berhasil, ${data.failed_count} baris gagal.`
                );

                if (hasFailed && data.errors && data.errors.length) {
                    renderImportErrors(data.errors);
                }

                // Reset form & preview
                $importForm.get(0).reset();
                $fileNameBox.hide().text('');

                // Reload table setelah beberapa saat supaya user sempat baca pesan
                setTimeout(function () {
                    window.location.reload();
                }, hasFailed ? 2000 : 1200);
            })
            .fail(function (xhr) {
                const message = xhr.responseJSON?.message
                    || 'Terjadi kesalahan saat memproses file.';
                showImportAlert('danger', message);

                // Kalau error dari FormRequest validation (422), tampilkan detail per-field
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    showImportAlert('danger', errors.join('<br>'));
                }
            })
            .always(function () {
                $importBtn.prop('disabled', false).html(originalBtnHtml);
            });
        }

        function showImportAlert(type, message) {
            clearImportAlert();
            const $alert = $(`
                <div class="alert alert-${type} proj-import-alert" role="alert">
                    ${message}
                </div>
            `);
            $importForm.prepend($alert);
        }

        function clearImportAlert() {
            $importForm.find('.proj-import-alert').remove();
            $importForm.find('.proj-import-errors').remove();
        }

        function renderImportErrors(errors) {
            const rows = errors.map(err =>
                `<tr><td>${err.row}</td><td>${err.reason}</td></tr>`
            ).join('');

            const $table = $(`
                <div class="proj-import-errors" style="margin-top: 12px; max-height: 200px; overflow-y: auto;">
                    <table class="table table-sm table-bordered mb-0">
                        <thead>
                            <tr><th>Baris</th><th>Alasan Gagal</th></tr>
                        </thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
            `);
            $importForm.append($table);
        }

        // Reset state form & alert setiap kali modal ditutup
        $modal.on('hidden.bs.modal', function () {
            $importForm.get(0).reset();
            $fileNameBox.hide().text('');
            clearImportAlert();
        });
    }

});
