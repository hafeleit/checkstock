<div class="d-flex gap-2">
    {{-- Update project item --}}
    <div>
        <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#updateProjectItemModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-upload mx-1" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
            </svg>
            Update project item
        </button>
    </div>
    <div class="modal fade" id="updateProjectItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateProjectItemModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateProjectItemModalLabel">Update project item</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <p class="text-secondary small mb-2">
                            You can download the template to prepare your data for importing into the system from the link below.
                        </p>
                        <a href="{{ route('product-infos.download-template', 'project-item') }}" class="btn btn-sm btn-outline-secondary m-0">
                            Download template (.xlsx)
                        </a>
                    </div>

                    <hr class="text-secondary opacity-25">

                    <form action="" method="post" id="projectItemForm">
                        @csrf
                        <div>
                            <label class="form-label fw-bold">Select file to import</label>
                            <input class="form-control" type="file" id="import-project-item-file"
                                accept=".xlsx, .xls">
                            <div class="form-text text-xs">Only .xlsx, or .xls files are supported.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="uploadProjectItemBtn" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Update superseded --}}
    <div>
        <button type="button" class="btn btn-sm btn-outline-dark" data-bs-toggle="modal" data-bs-target="#updateSupersededModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-upload mx-1" viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
            </svg>
            Update superseded
        </button>
    </div>
    <div class="modal fade" id="updateSupersededModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="updateSupersededModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateSupersededModalLabel">Update superseded</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <p class="text-secondary small mb-2">
                            You can download the template to prepare your data for importing into the system from the link below.
                        </p>
                        <a href="{{ route('product-infos.download-template', 'superseded') }}" class="btn btn-sm btn-outline-secondary m-0">
                            Download template (.xlsx)
                        </a>
                    </div>

                    <hr class="text-secondary opacity-25">

                    <form method="POST" id="supersededForm">
                        @csrf
                        <div>
                            <label class="form-label fw-bold">Select file to import</label>
                            <input class="form-control" type="file" id="import-superseded-file" accept=".xlsx, .xls">
                            <div class="form-text text-xs">Only .xlsx, or .xls files are supported.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="uploadSupersededBtn" class="btn btn-primary">Upload</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    document.addEventListener('DOMContentLoaded', () => {
        const uploadProjectItemBtn = document.getElementById('uploadProjectItemBtn');
        const uploadSupersededBtn = document.getElementById('uploadSupersededBtn');
        const projectItemFileInput = document.getElementById('import-project-item-file');
        const supersededFileInput = document.getElementById('import-superseded-file');

        // Update Project Item
        uploadProjectItemBtn.addEventListener('click', async () => {
            const files = projectItemFileInput.files;

            if (files.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select files',
                    text: 'You need to choose at least one excel file.'
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
            formData.append('file', files[0]);
            formData.append('type', 'project-item');

            axios.post('/product-infos/import-info', formData)
                .then(res => {
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: 'Project item file has been updated.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('projectItemForm').reset();
                        $('#updateProjectItemModal').modal('hide');
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
        })

        // Update Superseded
        uploadSupersededBtn.addEventListener('click', async () => {
            const files = supersededFileInput.files;

            if (files.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select files',
                    text: 'You need to choose at least one excel file.'
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
            formData.append('file', files[0]);
            formData.append('type', 'superseded');

            axios.post('/product-infos/import-info', formData)
                .then(res => {
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: 'Superseded file has been updated.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('supersededForm').reset();
                        $('#updateSupersededModal').modal('hide');
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
        })
    })
</script>
