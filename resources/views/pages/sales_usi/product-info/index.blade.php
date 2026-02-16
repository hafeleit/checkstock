@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Products 360°'])

    <style media="screen" nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .icon-search {
            position: absolute;
            top: 7%;
            right: 1%;
        }

        .relative {
            position: relative;
        }

        .swal2-styled.swal2-confirm {
            background-color: #2152ff !important;
            border-radius: .25em !important;
        }

        .dropdown-file-lists {
            max-height: 250px;
            overflow-y: auto;
        }

        .dropdown-item-lists:hover {
            text-decoration: underline;
            color: red;
        }

        .table-responsive {
            overflow-x: auto;
            overflow-y: hidden;
        }

        .dropdown-menu {
            margin: 0;
            transform: none !important; 
        }

        .swal2-html-container {
            line-height: 1.6 !important;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-md-flex align-items-center justify-between">
                            <h6 class="mb-0 h3">Product Information</h6>
                            <div>
                                @include('pages.sales_usi.product-info._update-info')
                            </div>
                            {{-- <div class="d-flex gap-2">
                                @include('pages.sales_usi.product-info._import')
                                @include('pages.sales_usi.product-info._export')
                                @include('pages.sales_usi.product-info._add-new')
                            </div> --}}
                        </div>
                        @php
                            $yesterday = date('d/m/Y', strtotime('-1 day'));
                        @endphp
                        <p class="text-uppercase text-secondary text-xxs font-weight-bolder">LAST UPDATE: {{ $yesterday }} 20:00</p>
                    </div>

                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group relative">
                                    <form id="searchProductForm" action="" method="GET">
                                        <input type="text" class="form-control form-control-sm search-field" id="item_code" name="item_code" value="{{ $params['item_code'] ?? '' }}" placeholder="Item code">
                                        <a href="#" id="searchButton" type="submit">
                                            <img src="/img/icons/search.png" alt="country flag" width="25px" class="icon-search">
                                        </a>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover text-sm">
                                <thead>
                                    <tr class="table-secondary ">
                                        <th class="px-2">Item Code</th>
                                        <th class="px-2">Image</th>
                                        <th class="px-2">Project Item</th>
                                        <th class="px-2">Superseded</th>
                                        <th class="px-2">Catalogue</th>
                                        <th class="px-2">Manual</th>
                                        <th class="px-2">Spec Sheet</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$productInformations->isEmpty())
                                        @foreach ($productInformations as $product)
                                        <tr>
                                            <td>{{ $product->item_code }}</td>
                                            <td>
                                                @php
                                                    $imagePath = public_path('storage/img/products/' . $product->item_code . '.jpg');
                                                    $imageUrl = asset('storage/img/products/' . $product->item_code . '.jpg');
                                                @endphp

                                                @if(file_exists($imagePath))
                                                    <img src="{{ asset('/storage/img/products/' . $product->item_code . '.jpg') }}" class="img-thumbnail" width="50">
                                                @else
                                                    <span class="text-muted italic small">- No image -</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->project_item)
                                                    <span class="text-dark">{{ $product->project_item }}</span>
                                                @else
                                                    <span class="text-secondary italic small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($product->superseded)
                                                    <span class="text-dark">{{ $product->superseded }}</span>
                                                @else
                                                    <span class="text-muted italic small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->catalogueFiles && $product->catalogueFiles->isNotEmpty())
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-dark btn-sm d-flex align-content-center dropdown-toggle fw-normal gap-2 m-0 px-3 text-xs" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                                            PDF Files ({{ count($product->catalogueFiles) }})
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-file-lists dropdown-menu-end shadow">
                                                            @foreach($product->catalogueFiles as $file)
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ asset($file->path) }}" target="_blank">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                                        </svg>
                                                                        <span class="text-truncate dropdown-item-lists">{{ $file->file_name }}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->manualFiles && $product->manualFiles->isNotEmpty())
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-dark btn-sm d-flex align-content-center dropdown-toggle fw-normal gap-2 m-0 px-3 text-xs" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                                            PDF Files ({{ count($product->manualFiles) }})
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-file-lists dropdown-menu-end shadow">
                                                            @foreach($product->manualFiles as $file)
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ asset($file->path) }}" target="_blank">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                                        </svg>
                                                                        <span class="text-truncate dropdown-item-lists">{{ $file->file_name }}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($product->specsheetFiles && $product->specsheetFiles->isNotEmpty())
                                                    <div class="dropdown">
                                                        <button class="btn btn-outline-dark btn-sm d-flex align-content-center dropdown-toggle fw-normal gap-2 m-0 px-3 text-xs" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                                            PDF Files ({{ count($product->specsheetFiles) }})
                                                        </button>
                                                        <ul class="dropdown-menu dropdown-file-lists dropdown-menu-end shadow">
                                                            @foreach($product->specsheetFiles as $file)
                                                                <li>
                                                                    <a class="dropdown-item d-flex align-items-center gap-2" href="{{ asset($file->path) }}" target="_blank">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5zM1.6 11.85H0v3.999h.791v-1.342h.803q.43 0 .732-.173.305-.175.463-.474a1.4 1.4 0 0 0 .161-.677q0-.375-.158-.677a1.2 1.2 0 0 0-.46-.477q-.3-.18-.732-.179m.545 1.333a.8.8 0 0 1-.085.38.57.57 0 0 1-.238.241.8.8 0 0 1-.375.082H.788V12.48h.66q.327 0 .512.181.185.183.185.522m1.217-1.333v3.999h1.46q.602 0 .998-.237a1.45 1.45 0 0 0 .595-.689q.196-.45.196-1.084 0-.63-.196-1.075a1.43 1.43 0 0 0-.589-.68q-.396-.234-1.005-.234zm.791.645h.563q.371 0 .609.152a.9.9 0 0 1 .354.454q.118.302.118.753a2.3 2.3 0 0 1-.068.592 1.1 1.1 0 0 1-.196.422.8.8 0 0 1-.334.252 1.3 1.3 0 0 1-.483.082h-.563zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638z" />
                                                                        </svg>
                                                                        <span class="text-truncate dropdown-item-lists">{{ $file->file_name }}</span>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @can('salesusi productinfo edit')
                                                <a href="{{ route('product-infos.edit', $product->item_code) }}" class="px-2" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </a>
                                                @endcan
                                                @can('salesusi productinfo delete')
                                                <a href="#" class="delete-item-btn px-2" data-item-code="{{ $product->item_code }}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="red" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center text-muted italic">No product information found.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-4">
                            {{ $productInformations->withQueryString()->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        const handleSearch = () => {
            const searchItemCode = document.getElementById('item_code').value;

            const data = {
                item_code: searchItemCode,
            };

            const filteredData = {};
            for (const key in data) {
                if (data[key]) {
                    filteredData[key] = data[key];
                }
            }

            const params = new URLSearchParams(filteredData).toString();
            const url = `/product-infos${params ? '?' + params : ''}`;

            window.location.href = url;
        };

        const searchForm = document.getElementById('searchProductForm');
        if (searchButton) {
            searchButton.addEventListener('click', handleSearch);
        }

        document.querySelectorAll('.search-field').forEach(field => {
            field.addEventListener('change', handleSearch);
            if (field.type === 'search' || field.type === 'text') {
                field.addEventListener('blur', handleSearch); 
            }
        });
        
        document.addEventListener('click', function(e) {
            const deleteItemBtn = e.target.closest('.delete-item-btn');
            
            if (deleteItemBtn) {
                e.preventDefault();
                const itemCode = deleteItemBtn.getAttribute('data-item-code');

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete ${itemCode}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    reverseButtons: true,
                    showLoaderOnConfirm: true,
                    preConfirm: async () => {
                        try {
                            await axios.delete(`/product-infos/${itemCode}`);
                        } catch (error) {
                            console.log(error)
                            const msg = error.response?.data?.message || 'Something went wrong';
                            Swal.showValidationMessage(`Request failed: ${msg}`);
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Deleted!', 'Item has been deleted.', 'success')
                            .then(() => {
                                window.location.reload();
                            });
                    }
                });
            }
        });
    </script>
@endsection
