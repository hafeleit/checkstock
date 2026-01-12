<div class="card border p-4 mt-3">
    <div class="d-flex align-items-center justify-between">
        <label class="fw-bold text-lg">Project item / Super ceed</label>
        <button type="button" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#changeInfoModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
            </svg>
            <div>Update info</div>
        </button>
    </div>

    <div class="modal fade" id="changeInfoModal" tabindex="-1" aria-labelledby="changeInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 m-0" id="changeInfoModalLabel">Update product information</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black"
                            class="bi bi-x" viewBox="0 0 16 16">
                            <path
                                d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateInfoForm">
                        @csrf
                        <div class="mb-3">
                            <label for="project-item" class="form-label required">Project item</label>
                            <input class="form-control" type="text" id="project-item" name="project_item" required>
                        </div>
                        <div class="mb-3">
                            <label for="super-ceed" class="form-label required">Super ceed</label>
                            <input class="form-control" type="text" id="super-ceed" name="super_ceed" required>
                        </div>
                        <div class="mb-3">
                            <label for="spare-part" class="form-label required">Spare part</label>
                            <input class="form-control" type="text" id="spare-part" name="spare_part" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveInfoBtn" class="btn btn-primary">Import</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label class="form-label">Project item</label>
            <input class="form-control" type="text" value="Lorem ipsum dolor sit amet" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Super ceed</label>
            <input class="form-control" type="text" value="Lorem ipsum dolor sit amet" readonly>
        </div>
        <div class="col-md-4 mb-3">
            <label class="form-label">Spare part</label>
            <input class="form-control" type="text" value="Lorem ipsum dolor sit amet" readonly>
        </div>
    </div>
</div>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    document.addEventListener('DOMContentLoaded', () => {
        const saveInfoBtn = document.getElementById('saveInfoBtn');
        const updateInfoForm = document.getElementById('updateInfoForm');
        const modalElement = document.getElementById('changeInfoModal');

        saveInfoBtn.addEventListener('click', async () => {
            const projectItem = updateInfoForm.querySelector('#project-item').value.trim();
            const superCeed = updateInfoForm.querySelector('#super-ceed').value.trim();
            const sparePart = updateInfoForm.querySelector('#spare-part').value.trim();

            if (!projectItem || !superCeed || !sparePart) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing data',
                    text: 'Please fill in all required fields.'
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Data has been saved successfully.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                document.getElementById('updateInfoForm').reset();
                $('#changeInfoModal').modal('hide');
            });

            // try {
            //     const formData = new FormData(updateInfoForm);
            //     const response = await fetch('/your-import-url', {
            //         method: 'POST',
            //         body: formData,
            //         headers: {
            //             'X-CSRF-TOKEN': updateInfoForm.querySelector('input[name="_token"]')
            //                 .value
            //         }
            //     });

            //     if (response.ok) {
            //         Swal.fire({
            //             icon: 'success',
            //             title: 'Success',
            //             text: 'Data has been saved successfully.',
            //             timer: 2000,
            //             showConfirmButton: false
            //         }).then(() => {
            //             document.getElementById('updateInfoForm').reset();
            //             $('#changeInfoModal').modal('hide');
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
</script>
