<button type="button" class="btn btn-primary m-0 d-flex align-items-center" data-bs-toggle="modal"
    data-bs-target="#AddNewProductInfoModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus"
        viewBox="0 0 16 16">
        <path
            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
    </svg>
    <div>Add new product</div>
</button>

<div class="modal fade" id="AddNewProductInfoModal" tabindex="-1" aria-labelledby="AddNewProductInfoModalLabel">
    <div class="modal-dialog modal-lg z-index-1">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 m-0" id="AddNewProductInfoModalLabel">Add new product information</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x"
                        viewBox="0 0 16 16">
                        <path
                            d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <form id="productInfoForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="project-item-input" class="form-label required">Project item</label>
                            <input class="form-control" type="text" id="project-item-input" name="project_item"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="superseded-input" class="form-label required">Superseded</label>
                            <input class="form-control" type="text" id="superseded-input" name="super_ceed" required>
                        </div>
                        
                    </div>
                    {{-- <div class="mt-3">
                        <label for="spare-part-input" class="form-label">Spare part</label>
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
                    </div> --}}
                    <div class="mt-3">
                        <div>
                            <label for="image-input" class="form-label">Choose image</label>
                            <div class="mb-2">
                                <img id="image-preview" src="#" alt="preview"
                                    class="img-fluid d-none border rounded" width="250">
                            </div>
                            <input class="form-control" type="file" id="image-input" accept="image/*">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="catalog-input" class="form-label">Choose catalog</label>
                        <input class="form-control" type="file" id="catalog-input" accept="application/pdf" multiple>
                        <div id="catalog-file-list" class="text-xs mt-1 text-muted"></div>
                    </div>
                    <div class="mt-3">
                        <label for="manual-input" class="form-label">Choose manual</label>
                        <input class="form-control" type="file" id="manual-input" accept="application/pdf" multiple>
                        <div id="manual-file-list" class="text-xs mt-1 text-muted"></div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="saveNewBtn" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    $('#item-code-input').mask('000.00.000');
    $('#project-item-input').mask('000.00.000');
    $('#superseded-input').mask('000.00.000');

    // Submit Form
    document.addEventListener('DOMContentLoaded', () => {
        const productForm = document.getElementById('productInfoForm');
        const imageInput = document.getElementById('image-input');
        const imagePreview = document.getElementById('image-preview');
        const saveBtn = document.getElementById('saveNewBtn');

        // Preview image
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.addEventListener('load', function() {
                    imagePreview.setAttribute('src', this.result);
                    imagePreview.classList.remove('d-none');
                });
                reader.readAsDataURL(file);
            } else {
                imagePreview.classList.add('d-none');
                imagePreview.setAttribute('src', '#');
            }
        });

        // Save form
        saveBtn.addEventListener('click', async () => {
            const projectItem = document.getElementById('project-item-input').value.trim();
            const superCeed = document.getElementById('superseded-input').value.trim();

            if (!projectItem || !superCeed) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required fields missing',
                    text: 'Please fill in all required fields.'
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'New product has been added.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                productForm.reset();

                const tableBody = document.querySelector('#spare-parts-table tbody');
                tableBody.innerHTML = ''; 
                
                // document.getElementById('spare-parts-container').classList.add('d-none');

                document.getElementById('catalog-file-list').innerHTML = '';
                document.getElementById('manual-file-list').innerHTML = '';

                imagePreview.classList.add('d-none');
                imagePreview.setAttribute('src', '#');
                
                $('#AddNewProductInfoModal').modal('hide');
            });
            
            // try {
            // const formData = new FormData(productForm);

            // // handle multiple catalog files
            // const catalogInput = document.getElementById('catalog-input');
            // if (catalogInput.files.length > 0) {
            //     for (let i = 0; i < catalogInput.files.length; i++) {
            //         formData.append('catalog_files[]', catalogInput.files[i]);
            //     }
            // }

            // // handle multiple manual files
            // const manualInput = document.getElementById('manual-input');
            // if (manualInput.files.length > 0) {
            //     for (let i = 0; i < manualInput.files.length; i++) {
            //         formData.append('manual_files[]', manualInput.files[i]);
            //     }
            // }

            //     if (imageInput.files[0]) {
            //         formData.append('product_image', imageInput.files[0])
            //     };
            //     if (document.getElementById('catalog-input').files[0]) {
            //         formData.append('catalog_file', document.getElementById('catalog-input').files[0]);
            //     }
            //     if (document.getElementById('manual-input').files[0]) {
            //         formData.append('manual_file', document.getElementById('manual-input').files[0]);
            //     }

            //     const response = await fetch('/api/products/add', {
            //         method: 'POST',
            //         body: formData,
            //         headers: {
            //             'X-CSRF-TOKEN': productForm.querySelector('input[name="_token"]').value
            //         }
            //     });

            //     if (response.ok) {
            //         await Swal.fire({
            //             icon: 'success',
            //             title: 'Success!',
            //             text: 'New product has been added.',
            //             timer: 2000,
            //             showConfirmButton: false
            //         }).then(() => {
            //             productForm.reset();
            //             imagePreview.classList.add('d-none');
            //             $('#AddNewProductInfoModalLabel').modal('hide');
            //         });
            //     } else {
            //         throw new Error('upload failed');
            //     }
            // } catch (error) {
            //     Swal.fire({
            //         icon: 'error',
            //         title: 'error',
            //         text: 'failed to save data, please try again.'
            //     });
            // }
        });
    });

    // Add spare part items
    // document.getElementById('add-item-btn').addEventListener('click', function() {
    //     const codeInput = document.getElementById('item-code-input');
    //     const descInput = document.getElementById('desc-input');
    //     const tableBody = document.querySelector('#spare-parts-table tbody');
    //     const container = document.getElementById('spare-parts-container');

    //     if (codeInput.value.trim() === '' || descInput.value.trim() === '') {
    //         alert('please fill both fields');
    //         return;
    //     }

    //     const row = document.createElement('tr');
    //     row.innerHTML = `
    //         <td>${codeInput.value} <input type="hidden" name="item_codes[]" value="${codeInput.value}"></td>
    //         <td>${descInput.value} <input type="hidden" name="descriptions[]" value="${descInput.value}"></td>
    //         <td class="text-center">
    //             <a type="button" class="remove-btn cursor-pointer">
    //                 <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
    //                     <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
    //                     <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
    //                 </svg>
    //             </a>
    //         </td>
    //     `;

    //     tableBody.appendChild(row);
    //     container.classList.remove('d-none');

    //     codeInput.value = '';
    //     descInput.value = '';
    //     codeInput.focus();
    // });

    // Display spare part items
    // document.querySelector('#spare-parts-table').addEventListener('click', function(e) {
    //     const removeBtn = e.target.closest('.remove-btn');
    //     if (removeBtn) {
    //         removeBtn.closest('tr').remove();
            
    //         const tableBody = document.querySelector('#spare-parts-table tbody');
    //         if (tableBody.children.length === 0) {
    //             document.getElementById('spare-parts-container').classList.add('d-none');
    //         }
    //     }
    // });

    // Display file name
    const updateFileList = (input, listElementId) => {
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
    document.getElementById('catalog-input').addEventListener('change', function() {
        updateFileList(this, 'catalog-file-list');
    });
    document.getElementById('manual-input').addEventListener('change', function() {
        updateFileList(this, 'manual-file-list');
    });
</script>
