<div class="card border p-4 mt-3">
    <div class="d-flex align-items-center justify-between">
        <label class="fw-bold text-lg">Image</label>
        <button type="button" class="btn btn-sm btn-outline-dark d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#changeImgProductModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-image" viewBox="0 0 16 16">
                <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                <path d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1z" />
            </svg>
            <div>change new image</div>
        </button>
    </div>

    <div class="modal fade" id="changeImgProductModal" tabindex="-1" aria-labelledby="changeImgProductModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 m-0" id="changeImgProductModalLabel">Change new image</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="black" class="bi bi-x" viewBox="0 0 16 16">
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="uploadImgForm">
                        @csrf
                        <div class="mb-3">
                            <label for="image-product-Input" class="form-label">choose image</label>
                            <input class="form-control" type="file" id="image-product-Input" name="image-product-Input" accept="image/jpeg">
                        </div>
                        <div class="text-center">
                            <img id="imagePreview" src="#" alt="preview" class="img-fluid d-none border rounded">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveImageBtn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @if ($imageProduct)
        <img id="item_preview" src="{{ $imageProduct }}" class="img-thumbnail" width="250">
    @else
        <div class="d-flex align-items-center gap-2 img-thumbnail border-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1z"/>
            </svg>
            <p class="mb-0 text-secondary">No image</p>
        </div>
    @endif
</div>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    const item_code = "{{ request()->item_code }}";

    document.addEventListener('DOMContentLoaded', () => {
        const imageInput = document.getElementById('image-product-Input');
        const imagePreview = document.getElementById('imagePreview');
        const saveBtn = document.getElementById('saveImageBtn');

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

        // Save change image
        saveBtn.addEventListener('click', async () => {
            const file = imageInput.files[0];
            
            if (!file) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please select a file',
                    text: 'You need to choose an image first.'
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
            formData.append('file', file);
            formData.append('type', 'product');

            axios.post(`/product-infos/${item_code}/upload-files`, formData)
                .then(response => {
                    const result = response.data;
                    Swal.fire({
                        icon: 'success',
                        title: 'success',
                        text: 'Image has been updated.',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        const mainPreview = document.getElementById('item_preview');
                        if (mainPreview) {
                            mainPreview.src = result.data[0]; 
                        }

                        document.getElementById('uploadImgForm').reset();
                        imagePreview.classList.add('d-none');
                        $('#changeImgProductModal').modal('hide');
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
