<button type="button" class="btn btn-primary m-0 d-flex align-items-center" data-bs-toggle="modal"
    data-bs-target="#AddNewProductInfoModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus"
        viewBox="0 0 16 16">
        <path
            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
    </svg>
    <div>Add new product</div>
</button>

<div class="modal fade" id="AddNewProductInfoModal" tabindex="-1" aria-labelledby="AddNewProductInfoModalLabel"
    aria-hidden="true">
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
                            <label for="super-ceed-input" class="form-label required">Super ceed</label>
                            <input class="form-control" type="text" id="super-ceed-input" name="super_ceed" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div>
                            <label for="image-input" class="form-label">Choose image</label>
                            <div class="mt-2">
                                <img id="image-preview" src="#" alt="preview"
                                    class="img-fluid d-none border rounded" width="250">
                            </div>
                            <input class="form-control" type="file" id="image-input" accept="image/*">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="catalog-input" class="form-label">Choose catalog</label>
                        <input class="form-control" type="file" id="catalog-input" accept="application/pdf">
                    </div>
                    <div class="mt-3">
                        <label for="manual-input" class="form-label">Choose manual</label>
                        <input class="form-control" type="file" id="manual-input" accept="application/pdf">
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
            const superCeed = document.getElementById('super-ceed-input').value.trim();

            if (!projectItem || !superCeed) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Required fields missing',
                    text: 'Please enter project item and super ceed.'
                });
                return;
            }

            Swal.fire({
                title: 'Uploading data...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'New product has been added.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                productForm.reset();
                imagePreview.classList.add('d-none');
                $('#AddNewProductInfoModal').modal('hide');
            });
            
            // try {
            //     const formData = new FormData(productForm);
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
</script>
