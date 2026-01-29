<div class="card border p-4 mt-3">
    <div class="d-flex align-items-center justify-between">
        <label class="fw-bold text-lg">Information</label>
        <button type="button" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#changeInfoModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
            </svg>
            <div>Update info</div>
        </button>
    </div>

    <div class="modal fade" id="changeInfoModal" tabindex="-1" aria-labelledby="changeInfoModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 m-0" id="changeInfoModalLabel">Update information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black"
                            class="bi bi-x" viewBox="0 0 16 16">
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateInfoForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="project-item" class="form-label">Project item</label>
                                <input class="form-control" type="text" id="project-item" name="project_item" value="{{ $product->project_item }}">
                            </div>
                            <div class="col-md-6">
                                <label for="superseded" class="form-label">Superseded</label>
                                <input class="form-control" type="text" id="superseded" name="superseded" value="{{ $product->superseded }}">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveInfoBtn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Project item</label>
            <input class="form-control" type="text" value="{{ $product->project_item }}" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Superseded</label>
            <input class="form-control" type="text" value="{{ $product->superseded }}" readonly>
        </div>
    </div>
</div>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    $('#project-item').mask('000.00.000');
    $('#superseded').mask('000.00.000');
    $('#item-code-input').mask('000.00.000');

    // Submit form
    document.addEventListener('DOMContentLoaded', () => {
        const saveInfoBtn = document.getElementById('saveInfoBtn');
        const updateInfoForm = document.getElementById('updateInfoForm');
        const modalElement = document.getElementById('changeInfoModal');

        saveInfoBtn.addEventListener('click', async () => {
            Swal.fire({
                title: 'Uploading...',
                text: 'Please wait while we process your file.',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const formData = new FormData(updateInfoForm);
            formData.append('_method', 'PUT');

            axios.post(`/product-infos/${item_code}`, formData)
                .then(resonse => {
                     Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Data has been saved successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        document.getElementById('updateInfoForm').reset();
                        $('#changeInfoModal').modal('hide');
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
</script>
