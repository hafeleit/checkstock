@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Products 360°'])

    <div class="container-fluid relative">
        <div class="eu-card">
            <div class="eu-card-header">
                <p class="eu-card-title">Product Series</p>
                <div class="eu-card-actions">
                    <button type="button" class="btn-eu-dark" data-bs-toggle="modal" data-bs-target="#importProductSeriesModal">
                        <i class="fa-solid fa-upload fa-xs"></i> Import
                    </button>
                    <div class="eu-card-actions">
                        <a href="{{ route('product-series.create') }}" class="btn-eu-primary">
                            <i class="fas fa-plus fa-xs"></i> Add New
                        </a>
                    </div>
                </div>
            </div>

            {{-- Search --}}
            <div class="search-wrap">
                <div class="search-input-wrap">
                    <input type="search" class="search-input" id="search" value="{{ $params['search'] ?? '' }}" placeholder="Series name or item code">
                </div>
                <button type="button" class="btn-search" id="searchButton">
                    <i class="fas fa-search fa-xs"></i> Search
                </button>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="um-table">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Series Name</th>
                            <th>Base Item Code</th>
                            <th>Item Codes</th>
                            <th>Updated By</th>
                            <th>Updated At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productSeries as $series)
                            <tr>
                                <td class="muted">{{ $productSeries->firstItem() + $loop->index }}</td>
                                <td>{{ $series->series_name }}</td>
                                <td>{{ $series->item_code }}</td>
                                <td>
                                    @foreach ($series->seriesItems as $child)
                                        <span class="badge bg-secondary fw-normal">{{ $child->item_code }}</span>
                                    @endforeach
                                </td>
                                <td class="muted">{{ $series->updatedBy?->username ?? '—' }}</td>
                                <td class="muted">{{ $series->updated_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 flex-nowrap justify-content-center">
                                        <a href="{{ route('product-series.edit', $series->id) }}" class="btn-action btn-action-edit">
                                            <i class="fas fa-pen fa-xs"></i> Edit
                                        </a>
                                        <form id="delete-form-{{ $series->id }}" action="{{ route('product-series.destroy', $series->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-action btn-action-delete py-2 confirm-delete-btn"
                                                data-form-id="delete-form-{{ $series->id }}"
                                                data-series-name="{{ $series->series_name }}">
                                                <i class="fas fa-trash fa-xs"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center muted py-5">No product series found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-4 py-3">
                {{ $productSeries->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>

        {{-- Import Product Series Modal --}}
        <div class="modal fade" id="importProductSeriesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="importProductSeriesModalLabel">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 mt-0" id="importProductSeriesModalLabel">Import Product Series</h1>
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
                            <button class="export-template-btn btn btn-sm btn-outline-secondary m-0" data-url="product-series/export-template" data-filename="Product_Series_Template.xlsx">
                                <i class="fas fa-print"></i> <span>Download template (.xlsx)</span>
                            </button>
                        </div>

                        <hr class="text-secondary opacity-25">

                        <form method="post" id="productSeriesForm">
                            @csrf
                            <div>
                                <label class="form-label fw-bold required">Select file to import</label>
                                <input class="form-control" type="file" id="import-product-series-file" accept=".xlsx, .xls">
                                <div class="form-text text-xs">Only .xlsx, or .xls files are supported.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mb-0" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="uploadProductSeriesBtn" class="btn btn-primary mb-0">Upload</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const handleSearch = () => {
            const search = document.getElementById('search').value.trim();
            const params = new URLSearchParams();
            if (search) {
                params.set('search', search);
            }
            window.location.href = `/product-series${params.toString() ? '?' + params.toString() : ''}`;
        };

        document.getElementById('searchButton').addEventListener('click', handleSearch);
        document.getElementById('search').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleSearch();
            }
        });

        document.querySelectorAll('.confirm-delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const formId = this.dataset.formId;
                const seriesName = this.dataset.seriesName;
                Swal.fire({
                    title: 'Delete Series?',
                    text: `"${seriesName}" will be permanently deleted.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#f5365c',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                }).then(result => {
                    if (result.isConfirmed) {
                        const loader = document.getElementById('loader-wrapper');
                        loader.classList.remove('loader-hidden');
                        loader.style.display = 'flex';
                        document.getElementById(formId).submit();
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const uploadButton = document.getElementById('uploadProductSeriesBtn');

            uploadButton.addEventListener('click', function() {
                const fileInput = document.getElementById('import-product-series-file');
                const file = fileInput.files[0];

                if (!file) {
                    Swal.fire('No file selected', 'Please choose a file to upload.', 'warning');
                    return;
                }

                const formData = new FormData();
                formData.append('file', file);

                Swal.fire({
                    title: 'Uploading...',
                    text: 'Please wait while the file is being uploaded.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                axios.post('/product-series/import', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        Swal.fire('Success', response.data.message || 'File uploaded successfully.', 'success')
                            .then(() => {
                                window.location.reload();
                            });
                    })
                    .catch(error => {
                        console.log(error);
                        const msg = error.response?.data?.message || 'Something went wrong';
                        Swal.fire('Error', msg, 'error');
                    });
            });
        });
    </script>

    @if (session('status'))
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: {!! json_encode(session('status')) !!},
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        </script>
    @endif

    @if ($errors->any())
        <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: {!! json_encode(implode('<br>', $errors->all())) !!},
                confirmButtonColor: '#f5365c',
            });
        </script>
    @endif
@endsection
