<div class="card border p-4 mt-3">
    <div class="d-flex align-items-center justify-between">
        <label class="fw-bold text-lg">Catalogs</label>
        <button type="button" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#changeCatalogModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload"
                viewBox="0 0 16 16">
                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
            </svg>
            <div>Import new version</div>
        </button>
    </div>

    <div class="modal fade" id="changeCatalogModal" tabindex="-1" aria-labelledby="changeCatalogModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 m-0" id="changeCatalogModalLabel">Import new catalog</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="uploadCatalogForm">
                        @csrf
                        <div class="mb-3">
                            <label for="catalogInput" class="form-label">Choose catalog</label>
                            <input class="form-control" type="file" id="catalogInput" accept="application/pdf">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveCatalogBtn" class="btn btn-primary">Import</button>
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
                <tr>
                    <td>sample_catelog_version_03.pdf</td>
                    <td class="text-end">
                        <a class="delete-btn cursor-pointer" data-filename="sample_catelog_version_03.pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>sample_catelog_version_02.pdf</td>
                    <td class="text-end">
                        <a class="delete-btn cursor-pointer" data-filename="sample_catelog_version_02.pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>sample_catelog_version_01.pdf</td>
                    <td class="text-end">
                        <a class="delete-btn cursor-pointer" data-filename="sample_catelog_version_01.pdf">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                            </svg>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .swal2-styled.swal2-confirm {
        border-radius: .25em;
    }
</style>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    document.addEventListener('DOMContentLoaded', () => {
        const catalogInput = document.getElementById('catalogInput');
        const saveBtn = document.getElementById('saveCatalogBtn');

        // Save import
        saveBtn.addEventListener('click', async () => {
            const file = catalogInput.files[0];
            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a file',
                    text: 'You need to choose an file first.'
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'success',
                text: 'Catalog file has been updated.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                document.getElementById('uploadCatalogForm').reset();

                imagePreview.classList.add('d-none');
                imagePreview.setAttribute('src', '#');

                $('#changeCatalogModal').modal('hide');

            });

            // const formData = new FormData();
            // formData.append('catalog_file', file);
            // try {
            //     const response = await fetch('/api/upload-endpoint', {
            //         method: 'POST',
            //         body: formData
            //     });

            //     if (response.ok) {
            //         Swal.fire({
            //             icon: 'success',
            //             title: 'success',
            //             text: 'Catalog file has been updated.',
            //             timer: 2000,
            //             showConfirmButton: false
            //         }).then(() => {
            //             document.getElementById('uploadCatalogForm').reset();

            //             imagePreview.classList.add('d-none');
            //             imagePreview.setAttribute('src', '#');

            //             $('#changeCatalogModal').modal('hide');
            //         });
            //     } else {
            //         throw new Error('upload failed');
            //     }
            // } catch (error) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'error',
            //         text: 'something went wrong, please try again.'
            //     });
            // }
        });
    });

    document.addEventListener('click', function(e) {
        const deleteBtn = e.target.closest('.delete-btn');

        if (deleteBtn) {
            e.preventDefault();
            const fileName = deleteBtn.getAttribute('data-filename');

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
                    Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
                        .then(() => {
                            deleteBtn.closest('tr').remove();
                        });
                    // try {
                    //     const response = await fetch(`/api/delete/${fileName}`, { method: 'DELETE' });

                    //     if (response.ok) {
                    //         Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
                    //             .then(() => {
                    //                 deleteBtn.closest('tr').remove();
                    //             });
                    //     } else {
                    //         throw new Error();
                    //     }
                    // } catch (error) {
                    //     Swal.fire('error', 'could not delete the file.', 'error');
                    // }
                }
            });
        }
    });
</script>
