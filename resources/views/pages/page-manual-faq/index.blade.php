@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Page Manual FAQ'])

    <link rel="stylesheet" href="{{ asset('assets/css/page-manual-faq.css') }}">

    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="col-12 px-0">
                <div class="card">
                
                    <div class="card-header border-bottom pb-3 pt-4">
                        <div class="mt-n4">
                            @include('components.alert')
                        </div>
                        
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="mb-3 mb-md-0">
                                <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-primary"></i>Page Manual FAQ</h5>
                                <p class="text-sm text-muted mb-0 mt-1">Manage FAQ items for each page in the system</p>
                            </div>
                            @can('faq create')
                            <div class="d-flex align-items-center gap-2">
                                <a href="{{ route('page-manual-faqs.create') }}" class="btn btn-primary btn-sm mb-0 shadow-sm">
                                    <i class="fas fa-plus me-1"></i> Add New
                                </a>
                            </div>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            <table class="table w-100">
                                <thead class="bg-gray-100 rounded text-xs">
                                    <tr>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7">#</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2 w-70">Page</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Updated By</th>
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 ps-2">Updated At</th>
                                        @canany(['faq edit', 'faq delete'])
                                        <th class="text-uppercase text-secondary font-weight-bolder opacity-7 text-center">Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($faqs as $faq)
                                        <tr>
                                            <td><p class="text-sm font-weight-bold mb-0 ps-2">{{ $faqs->firstItem() + $loop->index }}</p></td>
                                            <td><p class="text-sm font-weight-bold mb-0">{{ $pageLabels[$faq->page_identifier] ?? $faq->page_identifier }}</p></td>
                                            <td><p class="text-sm text-secondary mb-0">{{ $faq->updatedBy->username }}</p></td>
                                            <td><p class="text-sm text-secondary mb-0">{{ $faq->updated_at->format('d/m/Y H:i') }}</p></td>
                                            @canany(['faq edit', 'faq delete'])
                                            <td class="text-center align-middle">
                                                @can('faq edit')
                                                <a href="{{ route('page-manual-faqs.edit', $faq->id) }}" class="action-btn edit text-secondary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @endcan
                                                @can('faq delete')
                                                <button type="button" class="action-btn delete text-secondary ms-1 border-0 bg-transparent"
                                                    title="Delete" data-faq-id="{{ $faq->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <form id="delete-form-{{ $faq->id }}" action="{{ route('page-manual-faqs.destroy', $faq->id) }}" method="POST" class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                @endcan
                                            </td>
                                            @endcanany
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="{{ auth()->user()->canany(['faq edit', 'faq delete']) ? 5 : 4 }}" class="text-center py-4 text-secondary text-sm">No FAQ items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if ($faqs->hasPages())
                            <div class="px-4 py-3">
                                {!! $faqs->links('pagination::bootstrap-4') !!}
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('[data-faq-id]').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var id = this.dataset.faqId;
                    Swal.fire({
                        title: 'Confirm Delete?',
                        text: 'This FAQ item will be permanently deleted.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ea0606',
                        cancelButtonColor: '#8392ab',
                        confirmButtonText: 'Delete',
                        cancelButtonText: 'Cancel'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            var loader = document.getElementById('loader-wrapper');
                            loader.classList.remove('loader-hidden');
                            loader.style.display = 'flex';
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
