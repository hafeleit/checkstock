@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Page Manual FAQ'])

    <link rel="stylesheet" href="{{ asset('assets/css/page-manual-faq.css') }}">

    <div class="container-fluid py-4">
        <div class="row mt-4">
            <div class="px-0">

                <form action="{{ route('page-manual-faqs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card">

                        <div class="card-header border-bottom pb-3 pt-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                                <div class="mb-3 mb-md-0">
                                    <h5 class="mb-0"><i class="fas fa-question-circle me-2 text-primary"></i>Add FAQ Items</h5>
                                    <p class="text-sm text-muted mb-0 mt-1">Create new FAQ items for a page</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">

                            {{-- Page Identifier --}}
                            <div class="mb-4">
                                <label class="text-xs text-uppercase font-weight-bold text-secondary mb-1 d-block required">
                                    Page Identifier
                                </label>
                                <select name="page_identifier" class="form-control @error('page_identifier') is-invalid @enderror" required>
                                    <option value="product360" {{ old('page_identifier', 'product360') === 'product360' ? 'selected' : '' }}>Products 360°</option>
                                </select>
                                @error('page_identifier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FAQ Items section --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-xs text-uppercase font-weight-bold text-secondary">FAQ Items</span>
                            </div>

                            <div id="faq-container"></div>

                            <button type="button" id="add-faq-btn" class="add-question-btn">
                                <i class="fas fa-plus"></i> Add Question
                            </button>

                        </div>

                        <div class="px-4 pb-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('page-manual-faqs.index') }}" class="btn btn-light btn-sm mb-0">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm mb-0">
                                <i class="fas fa-save me-1"></i> Save
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    {{-- FAQ item template (not rendered) --}}
    <template id="faq-template">
        <div class="faq-item">
            <span class="drag-handle"><i class="fas fa-grip-vertical"></i></span>
            <span class="faq-number">1</span>
            <div class="faq-fields">
                <div class="mb-2">
                    <span class="field-label">Question <span class="text-danger">*</span></span>
                    <textarea name="faqs[__INDEX__][question]" rows="2" required
                              placeholder="Enter question...">{{ old('faqs.__INDEX__.question', '') }}</textarea>
                </div>
                <div class="mb-2">
                    <span class="field-label">Answer <span class="text-danger">*</span></span>
                    <textarea name="faqs[__INDEX__][answer]" rows="3" required
                              placeholder="Enter answer...">{{ old('faqs.__INDEX__.answer', '') }}</textarea>
                </div>
                <label class="faq-pdf-label">
                    <i class="fas fa-paperclip"></i>
                    <span>Attach PDF</span>
                    <span class="faq-pdf-filename"></span>
                    <input type="file" class="faq-pdf-input" name="faqs[__INDEX__][pdf]" accept=".pdf">
                </label>
            </div>
            <input type="hidden" class="faq-sequence" name="faqs[__INDEX__][sequence]" value="1">
            <button type="button" class="faq-remove-btn" title="Remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </template>

    <script src="{{ asset('js/jquery-ui.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        var counter = 0;

        function resequence() {
            document.querySelectorAll('#faq-container .faq-item').forEach(function(item, idx) {
                item.querySelector('.faq-sequence').value = idx + 1;
                item.querySelector('.faq-number').textContent = idx + 1;
            });
        }

        function addItem() {
            var tmpl = document.getElementById('faq-template');
            var clone = document.importNode(tmpl.content, true);
            var item = clone.querySelector('.faq-item');

            item.querySelectorAll('[name]').forEach(function(el) {
                el.name = el.name.replace(/__INDEX__/g, counter);
            });

            counter++;
            document.getElementById('faq-container').appendChild(clone);
            resequence();
        }

        document.getElementById('add-faq-btn').addEventListener('click', addItem);

        document.addEventListener('click', function(e) {
            var btn = e.target.closest('.faq-remove-btn');
            if (!btn) return;
            var items = document.querySelectorAll('#faq-container .faq-item');
            if (items.length > 1) {
                btn.closest('.faq-item').remove();
                resequence();
            }
        });

        document.addEventListener('change', function(e) {
            if (!e.target.matches('.faq-pdf-input')) return;
            var nameEl = e.target.closest('.faq-pdf-label').querySelector('.faq-pdf-filename');
            nameEl.textContent = e.target.files.length ? e.target.files[0].name : '';
        });

        $(function() {
            $('#faq-container').sortable({
                handle: '.drag-handle',
                axis: 'y',
                tolerance: 'pointer',
                stop: function() {
                    resequence();
                }
            });

            addItem();
        });
    </script>
@endsection
