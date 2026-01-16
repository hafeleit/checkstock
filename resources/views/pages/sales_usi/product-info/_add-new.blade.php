<button type="button" class="btn btn-primary m-0 d-flex align-items-center" data-bs-toggle="modal"
    data-bs-target="#AddNewProductInfoModal">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
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
                    <div>
                         <label for="image-input" class="form-label required">Item code</label>
                         <input type="text" name="item_code" id="item-code-input" class="form-control" required>
                    </div>
                    <div class="mt-3">
                        <div>
                            <label for="image-input" class="form-label">Choose image</label>
                            <div>
                                <img id="image-preview" src="#" alt="preview" class="img-fluid d-none border rounded mb-2" width="250">
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
    $('#itemC-code-input').mask('000.00.000');

    // Submit Form
    document.addEventListener('DOMContentLoaded', () => {
        const productForm = document.getElementById('productInfoForm');
        const itemCodeInput = document.getElementById('item-code-input');
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

            if (!itemCodeInput.value.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing data',
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
                
                document.getElementById('catalog-file-list').innerHTML = '';
                document.getElementById('manual-file-list').innerHTML = '';

                imagePreview.classList.add('d-none');
                imagePreview.setAttribute('src', '#');
                
                $('#AddNewProductInfoModal').modal('hide');
            });
        });
    });

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
