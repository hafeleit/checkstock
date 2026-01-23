<div class="card border p-4 mt-3">
    <div class="d-flex align-items-center justify-between">
        <label class="fw-bold text-lg">Manuals</label>
        <button type="button" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#changeManualModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
            </svg>
            <div>Import new version</div>
        </button>
    </div>

    <div class="modal fade" id="changeManualModal" tabindex="-1" aria-labelledby="changeManualModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 m-0" id="changeManualModalLabel">Import new manuals</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="uploadManualForm">
                        @csrf
                        <div class="mb-3">
                            <label for="manual-files-input" class="form-label">Choose manuals</label>
                            <input class="form-control" type="file" id="manual-files-input" accept="application/pdf" multiple>
                            <div id="manual-file-list" class="text-xs mt-1 text-muted"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveManualBtn" class="btn btn-primary">Import</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-dark text-sm">
                <tr>
                    <th class="px-2">File name</th>
                    <th class="px-2"></th>
                </tr>
            </thead>
            <tbody>
                @if (!$manuals->isEmpty())
                    @foreach ($manuals as $manual)
                        <tr>
                            <td>
                                <a href="{{ $manual->path }}" target="_blank" class="d-flex align-items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z"/>
                                    </svg>
                                    <div>{{ $manual->file_name }}</div>
                                </a>
                            </td>
                            <td class="text-end">
                                <a class="delete-manual-btn cursor-pointer" data-filename="{{ $manual->file_name }}" data-id="{{ $manual->id }}" data-item-code="{{ $manual->item_code }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="text-center text-sm text-muted italic">No manuals found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    document.addEventListener('DOMContentLoaded', () => {
        const manualInput = document.getElementById('manual-files-input');
        const saveBtn = document.getElementById('saveManualBtn');

        // Save import
        saveBtn.addEventListener('click', async () => {
            const files = manualInput.files;

            if (files.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select files',
                    text: 'You need to choose at least one pdf file.'
                });
                return;
            }

            Swal.fire({
                title: 'Uploading...',
                text: 'Please wait while we process your file.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('type', 'manual');
            for (let i = 0; i < files.length; i++) {
                formData.append('file[]', files[i]);
            }

            axios.post(`/product-infos/${item_code}/upload-files`, formData)
                .then(response => {
                    const result = response.data;
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: 'Manual has been updated.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('uploadManualForm').reset();
                        document.getElementById('manual-file-list').innerHTML = '';
                        
                        $('#changeManualModal').modal('hide');
                        window.location.reload();
                    });
                })
                .catch(error => {
                    const errorMessage = error.response?.data?.message || 'Something went wrong, please try again.';
                    Swal.fire({
                        icon: 'error',
                        title: 'error',
                        text: errorMessage
                    });
                    console.error('Upload Error:', error);
                })
        });
    });

    // Delete button
    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-manual-btn');

        if (deleteBtn) {
            e.preventDefault();
            const fileName = deleteBtn.getAttribute('data-filename');
            const fileId = deleteBtn.getAttribute('data-id');
            const itemCode = deleteBtn.getAttribute('data-item-code');

            console.log(fileName, fileId)

            Swal.fire({
                title: 'Are you sure?',
                text: `Do you want to delete ${fileName}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                reverseButtons: true
            }).then(async (result) => {
                if (result.isConfirmed) {
                    axios.delete(`/product-infos/pdf-files/${fileId}`)
                        .then(response => {
                            Swal.fire(
                                'Deleted!',
                                'Manual file has been deleted.',
                                'success'
                            ).then(() => {
                                window.location.reload();
                            });
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire(
                                'Error!',
                                'Could not delete the file. please try again.',
                                'error'
                            );
                        })
                }
            });
        }
    });

    // Display files
    const updateManualFileList = (input, listElementId) => {
        const listElement = document.getElementById(listElementId);
        listElement.innerHTML = '';
        
        if (input.files.length > 0) {
            const ol = document.createElement('ol');
            ol.className = 'mb-0';
            
            Array.from(input.files).forEach(file => {
                const li = document.createElement('li');
                li.innerHTML = `<i class="bi bi-file-earmark-pdf text-danger"></i> ${file.name} <span class="text-muted">(${(file.size / 1024).toFixed(1)} KB)</span>`;
                ol.appendChild(li);
            });
            
            listElement.appendChild(ol);
        }
    };
    document.getElementById('manual-files-input').addEventListener('change', function() {
        updateManualFileList(this, 'manual-file-list');
    });
</script>
