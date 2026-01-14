<div class="card border p-4 mt-3">
    <div class="d-flex align-items-center justify-between">
        <label class="fw-bold text-lg">Project information</label>
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="project-item" class="form-label required">Project item</label>
                                <input class="form-control" type="text" id="project-item" name="project_item" value="000.00.000" required>
                            </div>
                            <div class="col-md-6">
                                <label for="superseded" class="form-label required">Superseded</label>
                                <input class="form-control" type="text" id="superseded" name="superseded" value="000.00.000" required>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="spare-part" class="form-label">Spare parts</label>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <input type="text" id="item-code-input" class="form-control" placeholder="Item code">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" id="desc-input" class="form-control" placeholder="Description">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary w-100 m-0">ADD</button>
                                    </div>
                                </div>
                                <div class="table-responsive d-none" id="spare-parts-container">
                                    <table class="table text-xs" id="spare-parts-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="w-20 px-2">Item code</th>
                                                <th class="px-2">Description</th>
                                                <th class="w-10 px-2">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
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
            <input class="form-control" type="text" value="000.00.000" readonly>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Superseded</label>
            <input class="form-control" type="text" value="000.00.000" readonly>
        </div>
        <div class="col-md-12 mb-3">
            <label class="form-label">Spare parts</label>
            <div class="table-responsive">
                <table class="table text-xs">
                    <thead class="table-light">
                        <tr>
                            <th class="w-20 px-2">Item code</th>
                            <th class="px-2">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>100.00.101</td>
                            <td>Lorem ipsum dolor sit amet</td>
                        </tr>
                        <tr>
                            <td>100.00.102</td>
                            <td>Lorem ipsum dolor sit amet</td>
                        </tr>
                        <tr>
                            <td>100.00.103</td>
                            <td>Lorem ipsum dolor sit amet</td>
                        </tr>
                        <tr>
                            <td>100.00.104</td>
                            <td>Lorem ipsum dolor sit amet</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
            const projectItem = updateInfoForm.querySelector('#project-item').value.trim();
            const superCeed = updateInfoForm.querySelector('#superseded').value.trim();
            // const sparePart = updateInfoForm.querySelector('#spare-part').value.trim();

            if (!projectItem || !superCeed) {
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

    // Add spare part items
    document.getElementById('add-item-btn').addEventListener('click', function() {
        const codeInput = document.getElementById('item-code-input');
        const descInput = document.getElementById('desc-input');
        const tableBody = document.querySelector('#spare-parts-table tbody');
        const container = document.getElementById('spare-parts-container');

        if (codeInput.value.trim() === '' || descInput.value.trim() === '') {
            alert('please fill both fields');
            return;
        }

        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${codeInput.value} <input type="hidden" name="item_codes[]" value="${codeInput.value}"></td>
            <td>${descInput.value} <input type="hidden" name="descriptions[]" value="${descInput.value}"></td>
            <td class="text-center">
                <a type="button" class="remove-btn cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                    </svg>
                </a>
            </td>
        `;

        tableBody.appendChild(row);
        container.classList.remove('d-none');

        codeInput.value = '';
        descInput.value = '';
        codeInput.focus();
    });

    // Display spare part items
    document.querySelector('#spare-parts-table').addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.remove-btn');
        if (removeBtn) {
            removeBtn.closest('tr').remove();
            
            const tableBody = document.querySelector('#spare-parts-table tbody');
            if (tableBody.children.length === 0) {
                document.getElementById('spare-parts-container').classList.add('d-none');
            }
        }
    });

    // Mock data in modal
    const loadMockSpareParts = () => {
        const tableBody = document.querySelector('#spare-parts-table tbody');
        const container = document.getElementById('spare-parts-container');
        const mockData = [
            { code: '100.00.101', desc: 'Lorem ipsum dolor sit amet' },
            { code: '100.00.102', desc: 'Lorem ipsum dolor sit amet' },
            { code: '100.00.103', desc: 'Lorem ipsum dolor sit amet' },
            { code: '100.00.104', desc: 'Lorem ipsum dolor sit amet' },
        ];

        tableBody.innerHTML = '';
        mockData.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.code} <input type="hidden" name="item_codes[]" value="${item.code}"></td>
                <td>${item.desc} <input type="hidden" name="descriptions[]" value="${item.desc}"></td>
                <td class="text-center">
                    <a type="button" class="remove-btn cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                        </svg>
                    </a>
                </td>
            `;
            tableBody.appendChild(row);
        });

        container.classList.remove('d-none');
    };
    document.getElementById('changeInfoModal').addEventListener('show.bs.modal', function () {
        loadMockSpareParts();
    });
</script>
