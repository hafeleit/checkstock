@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Products 360°'])

    <link href="{{ URL::to('/') }}/assets/css/product-series.css" rel="stylesheet">

    <div class="container-fluid relative">

        <form id="createForm" action="{{ route('product-series.store') }}" method="POST" novalidate>
            @csrf

            {{-- Step Indicator --}}
            <div class="eu-card mb-3">
                <div class="step-bar">
                    <div class="step-item">
                        <div class="step-circle active" id="circle-1">1</div>
                        <span class="step-label active" id="label-1">Series Info</span>
                    </div>
                    <div class="step-connector" id="connector-1"></div>
                    <div class="step-item">
                        <div class="step-circle" id="circle-2">2</div>
                        <span class="step-label" id="label-2">Add Items</span>
                    </div>
                </div>
            </div>

            {{-- Step 1: Series Name --}}
            <div class="eu-card" id="step-1">
                <div class="eu-card-header">
                    <p class="eu-card-title">Series Info</p>
                </div>
                <div class="px-4 py-4">
                    <div class="row">
                        <div>
                            <label class="form-label-eu required" for="series_name_input">
                                Series Name
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="series_name_input"
                                placeholder="e.g. FF-93513000-2026-01"
                                value="{{ old('series_name') }}"
                                autocomplete="off"
                            >
                            <div class="text-danger field-error mt-1 d-none" id="series_name_error"></div>
                        </div>
                    </div>
                    <div class="mt-4 px-3 d-flex gap-2 justify-content-end">
                        <button type="button" class="btn-eu-primary" id="btnNext">
                            Next <i class="fas fa-arrow-right fa-xs ms-1"></i>
                        </button>
                        <a href="{{ route('product-series.index') }}" class="btn btn-secondary btn-sm mb-0">Cancel</a>
                    </div>
                </div>
            </div>

            {{-- Step 2: Add Items --}}
            <div class="eu-card d-none" id="step-2">
                <div class="eu-card-header">
                    <div>
                        <p class="eu-card-title">Add Items</p>
                        <p class="series-subtitle mb-0">
                            Series name: <strong class="series-name-val" id="series_name_display">—</strong>
                        </p>
                    </div>
                    <div class="eu-card-actions">
                        <button type="button" class="btn btn-secondary btn-sm mb-0" id="btnBack">
                            <i class="fas fa-arrow-left fa-xs me-1"></i> Back
                        </button>
                    </div>
                </div>

                <div class="px-4 py-4">
                    <input type="hidden" name="series_name" id="series_name_hidden">

                    <label class="form-label-eu required">
                        Item Code
                    </label>
                    <div class="add-item-wrap">
                        <div class="add-item-input ac-wrap">
                            <input
                                type="text"
                                class="form-control"
                                id="item_code_input"
                                placeholder="Search item code..."
                                autocomplete="off"
                            >
                            <div id="item_code_dropdown" class="ac-dropdown d-none"></div>
                        </div>
                        <button type="button" class="btn-eu-primary btn-add-item" id="btnAddItem">
                            <i class="fas fa-plus fa-xs"></i> Add
                        </button>
                    </div>
                    <div class="text-danger field-error mt-1 d-none" id="item_code_error"></div>

                    <div class="items-list-wrap">
                        <label class="form-label-eu mt-3">Items in Series</label>
                        <div id="items-list">
                            <div class="items-empty" id="items-empty">
                                <i class="fas fa-box-open mb-2 d-block"></i>
                                No items added yet
                            </div>
                        </div>
                    </div>

                    <div class="submit-hint d-none" id="submit-hint">
                        <i class="fas fa-info-circle me-1"></i>
                        Select one item as <strong>Item Base</strong> before submitting
                    </div>

                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn-eu-primary" id="btnSubmit" disabled>
                            <i class="fas fa-save fa-xs me-1"></i> Create Series
                        </button>
                        <a href="{{ route('product-series.index') }}" class="btn btn-secondary btn-sm mb-0">Cancel</a>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">

        (function () {
            let itemCounter = 0;
            let acSelected = false;
            let acItems = [];

            // ── Stepper helpers ──────────────────────────────────────────
            function goToStep2() {
                const nameInput = document.getElementById('series_name_input');
                const errorEl  = document.getElementById('series_name_error');
                const name     = nameInput.value.trim();

                if (!name) {
                    errorEl.textContent = 'Series name is required.';
                    errorEl.classList.remove('d-none');
                    nameInput.classList.add('is-invalid');
                    nameInput.focus();
                    return;
                }

                if (!/^[A-Z]+-\d{8}-\d{4}-\d{2}$/.test(name)) {
                    errorEl.textContent = 'Invalid format. Expected: ProductCat-ZZZZZZZZ-YYYY-XX (e.g. FF-93513000-2026-01)';
                    errorEl.classList.remove('d-none');
                    nameInput.classList.add('is-invalid');
                    nameInput.focus();
                    return;
                }

                errorEl.classList.add('d-none');
                nameInput.classList.remove('is-invalid');

                document.getElementById('series_name_hidden').value        = name;
                document.getElementById('series_name_display').textContent = name;

                document.getElementById('step-1').classList.add('d-none');
                document.getElementById('step-2').classList.remove('d-none');

                document.getElementById('circle-1').className    = 'step-circle done';
                document.getElementById('label-1').className     = 'step-label done';
                document.getElementById('connector-1').className = 'step-connector done';
                document.getElementById('circle-2').className    = 'step-circle active';
                document.getElementById('label-2').className     = 'step-label active';

                document.getElementById('item_code_input').focus();
            }

            function goToStep1() {
                document.getElementById('step-2').classList.add('d-none');
                document.getElementById('step-1').classList.remove('d-none');

                document.getElementById('circle-1').className    = 'step-circle active';
                document.getElementById('label-1').className     = 'step-label active';
                document.getElementById('connector-1').className = 'step-connector';
                document.getElementById('circle-2').className    = 'step-circle';
                document.getElementById('label-2').className     = 'step-label';

                document.getElementById('series_name_input').focus();
            }

            // ── Input mask ───────────────────────────────────────────────
            $('#item_code_input').mask('000.00.000');

            // ── Autocomplete ─────────────────────────────────────────────
            (function () {
                const acInput    = document.getElementById('item_code_input');
                const acDropdown = document.getElementById('item_code_dropdown');
                let acTimer = null;
                let acRequest = null;
                let acActiveIdx = -1;

                function closeDropdown() {
                    acDropdown.classList.add('d-none');
                    acDropdown.innerHTML = '';
                    acActiveIdx = -1;
                    if (!acSelected) {
                        acItems = [];
                    }
                }

                function setActive(idx) {
                    acActiveIdx = idx;
                    acDropdown.querySelectorAll('.ac-item').forEach(function (el, i) {
                        el.classList.toggle('ac-active', i === idx);
                    });
                }

                function renderDropdown(items) {
                    acItems = items;
                    acActiveIdx = -1;
                    acDropdown.innerHTML = '';
                    if (!items.length) {
                        acDropdown.innerHTML = '<div class="ac-loading">No results found</div>';
                        acDropdown.classList.remove('d-none');
                        return;
                    }
                    items.forEach(function (item) {
                        const div = document.createElement('div');
                        div.className = 'ac-item';
                        div.textContent = item;
                        div.addEventListener('mousedown', function (e) {
                            e.preventDefault();
                            acSelected = true;
                            $('#item_code_input').val(item);
                            closeDropdown();
                        });
                        acDropdown.appendChild(div);
                    });
                    acDropdown.classList.remove('d-none');
                }

                acInput.addEventListener('input', function () {
                    acSelected = false;
                    clearTimeout(acTimer);
                    if (acRequest) {
                        acRequest.abort();
                        acRequest = null;
                    }
                    closeDropdown();

                    const digits = this.value.replace(/\D/g, '');
                    if (digits.length < 3) {
                        return;
                    }

                    const q = this.value.trim();
                    acTimer = setTimeout(function () {
                        acDropdown.innerHTML = '<div class="ac-loading"><i class="fas fa-spinner fa-spin me-1"></i>Loading...</div>';
                        acDropdown.classList.remove('d-none');
                        acRequest = $.ajax({
                            url: '{{ route("product-series.material-search") }}',
                            data: { q: q },
                            dataType: 'json',
                            success: function (data) {
                                if (acInput.value.trim() !== q) {
                                    return;
                                }
                                renderDropdown(data);
                            },
                            error: function () {
                                closeDropdown();
                            },
                            complete: function () {
                                acRequest = null;
                            }
                        });
                    }, 250);
                });

                acInput.addEventListener('keydown', function (e) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        if (acActiveIdx < acItems.length - 1) {
                            setActive(acActiveIdx + 1);
                        }
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        if (acActiveIdx > 0) {
                            setActive(acActiveIdx - 1);
                        }
                    } else if (e.key === 'Enter' && acActiveIdx >= 0 && acItems[acActiveIdx]) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        acSelected = true;
                        $('#item_code_input').val(acItems[acActiveIdx]);
                        closeDropdown();
                    } else if (e.key === 'Escape') {
                        closeDropdown();
                    }
                });

                acInput.addEventListener('blur', function () {
                    setTimeout(closeDropdown, 150);
                });
            })();

            // ── Item management ──────────────────────────────────────────
            function addItem() {
                const input   = document.getElementById('item_code_input');
                const errorEl = document.getElementById('item_code_error');
                const code    = input.value.trim();
                
                if (!(acSelected || (acItems && acItems.length && acItems.includes(code)))) {
                    errorEl.textContent = 'Please select a valid item from the suggestions.';
                    errorEl.classList.remove('d-none');
                    input.classList.add('is-invalid');
                    input.focus();
                    return;
                }

                if (!code) {
                    errorEl.textContent = 'Please enter an item code.';
                    errorEl.classList.remove('d-none');
                    input.classList.add('is-invalid');
                    input.focus();
                    return;
                }

                const existing = document.querySelectorAll('.item-code-value');
                for (const el of existing) {
                    if (el.value === code) {
                        errorEl.textContent = '"' + code + '" is already added.';
                        errorEl.classList.remove('d-none');
                        input.classList.add('is-invalid');
                        input.focus();
                        return;
                    }
                }

                errorEl.classList.add('d-none');
                input.classList.remove('is-invalid');
                document.getElementById('items-empty').classList.add('d-none');

                const idx = itemCounter++;
                const row = document.createElement('div');
                row.className = 'item-row';
                row.id = 'item-row-' + idx;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'items[]';
                hiddenInput.className = 'item-code-value';
                hiddenInput.value = code;

                const codeSpan = document.createElement('span');
                codeSpan.className = 'item-code-text';
                codeSpan.textContent = code;

                const baseBadge = document.createElement('span');
                baseBadge.className = 'badge-base d-none';
                baseBadge.id = 'badge-' + idx;
                baseBadge.textContent = 'Base';

                const radioLabel = document.createElement('label');
                radioLabel.className = 'base-radio-label ms-auto mb-0';

                const radio = document.createElement('input');
                radio.type = 'radio';
                radio.name = 'item_base';
                radio.value = code;
                radio.id = 'radio-' + idx;
                radio.dataset.idx = idx;

                radioLabel.appendChild(radio);
                radioLabel.appendChild(document.createTextNode(' Item Base'));

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'btn-remove-item';
                removeBtn.title = 'Remove';
                removeBtn.dataset.idx = idx;
                removeBtn.innerHTML = '<i class="fas fa-times fa-xs"></i>';

                row.appendChild(hiddenInput);
                row.appendChild(codeSpan);
                row.appendChild(baseBadge);
                row.appendChild(radioLabel);
                row.appendChild(removeBtn);

                document.getElementById('items-list').appendChild(row);
                input.value = '';
                input.focus();
                updateSubmitState();
            }

            function removeItem(idx) {
                const row = document.getElementById('item-row-' + idx);
                if (row) {
                    row.remove();
                }
                if (!document.querySelectorAll('.item-row').length) {
                    document.getElementById('items-empty').classList.remove('d-none');
                }
                updateSubmitState();
            }

            function onBaseChange(idx) {
                document.querySelectorAll('.item-row').forEach(r => r.classList.remove('is-base'));
                document.querySelectorAll('.badge-base').forEach(b => b.classList.add('d-none'));
                document.getElementById('item-row-' + idx).classList.add('is-base');
                document.getElementById('badge-' + idx).classList.remove('d-none');
                updateSubmitState();
            }

            function updateSubmitState() {
                const hasItems = !!document.querySelectorAll('.item-row').length;
                const hasBase  = !!document.querySelector('input[name="item_base"]:checked');
                document.getElementById('btnSubmit').disabled = !(hasItems && hasBase);
                document.getElementById('submit-hint').classList.toggle('d-none', !(hasItems && !hasBase));
            }

            // ── Event delegation for dynamic items ───────────────────────
            document.getElementById('items-list').addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-remove-item');
                if (btn) {
                    removeItem(btn.dataset.idx);
                }
            });

            document.getElementById('items-list').addEventListener('change', function (e) {
                const radio = e.target.closest('input[type="radio"][name="item_base"]');
                if (radio) {
                    onBaseChange(radio.dataset.idx);
                }
            });

            // ── Static button listeners ───────────────────────────────────
            document.getElementById('btnNext').addEventListener('click', goToStep2);
            document.getElementById('btnBack').addEventListener('click', goToStep1);
            document.getElementById('btnAddItem').addEventListener('click', addItem);

            document.getElementById('series_name_input').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { 
                    e.preventDefault(); 
                    goToStep2(); 
                }
            });

            document.getElementById('item_code_input').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { 
                    e.preventDefault(); 
                    addItem(); 
                }
            });
        })();
    </script>

    @if ($errors->any())
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        Swal.fire({
            icon: 'error',
            title: 'Validation Error',
            html: {!! json_encode(implode('<br>', $errors->all())) !!},
            confirmButtonColor: '#f5365c',
        });
    </script>
    @endif
@endsection
