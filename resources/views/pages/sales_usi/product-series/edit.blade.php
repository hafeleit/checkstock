@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Products 360°'])

    <link href="{{ URL::to('/') }}/assets/css/product-series.css" rel="stylesheet">

    <div class="container-fluid relative">

        <form id="createForm" action="{{ route('product-series.update', $productSeries->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            {{-- Step Indicator — edit mode always starts at step 2 --}}
            <div class="eu-card mb-3">
                <div class="step-bar">
                    <div class="step-item">
                        <div class="step-circle done">
                            <i class="fas fa-check step-check-icon"></i>
                        </div>
                        <span class="step-label done">Series Info</span>
                    </div>
                    <div class="step-connector done"></div>
                    <div class="step-item">
                        <div class="step-circle active">2</div>
                        <span class="step-label active">Add Items</span>
                    </div>
                </div>
            </div>

            {{-- Step 2: Add Items (shown immediately) --}}
            <div class="eu-card" id="step-2">
                <div class="eu-card-header">
                    <div>
                        <p class="eu-card-title mb-1">Add Items</p>

                        {{-- Series name: display mode --}}
                        <p class="form-label-eu form-label-eu-sm mb-1">Series Name</p>
                        <div class="series-name-display" id="series-name-display">
                            <span class="series-name-text" id="series_name_text">{{ old('series_name', $productSeries->series_name) }}</span>
                            <button type="button" class="btn-edit-name" id="btnEditName" title="Edit series name">
                                <i class="fas fa-pencil-alt fa-xs"></i>
                            </button>
                        </div>

                        {{-- Series name: edit mode --}}
                        <div class="series-name-edit" id="series-name-edit">
                            <div>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="series_name_edit_input"
                                    placeholder="e.g. SERIES A"
                                    autocomplete="off"
                                >
                                <div class="series-name-edit-error" id="series_name_edit_error">Series name is required.</div>
                            </div>
                            <button type="button" class="btn-name-confirm" id="btnNameConfirm" title="Confirm">
                                <i class="fas fa-check fa-sm"></i>
                            </button>
                            <button type="button" class="btn-name-cancel" id="btnNameCancel" title="Cancel">
                                <i class="fas fa-times fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-4">
                    <input type="hidden" name="series_name" id="series_name_hidden" value="{{ old('series_name', $productSeries->series_name) }}">

                    <label class="form-label-eu required">Item Code</label>
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
                            <div class="text-danger field-error mt-1 d-none" id="item_code_error"></div>
                        </div>
                        <button type="button" class="btn-eu-primary btn-add-item" id="btnAddItem">
                            <i class="fas fa-plus fa-xs"></i> Add
                        </button>
                    </div>

                    <div class="items-list-wrap">
                        <label class="form-label-eu mt-3">Items in Series</label>
                        <div id="items-list">
                            @php
                                $oldItems = old('items', []);
                                $oldBase = old('item_base', $seriesItems->firstWhere('item_base', true)?->item_code);
                                $rows = [];

                                if (! empty($oldItems)) {
                                    foreach ($oldItems as $code) {
                                        $rows[] = [
                                            'item_code' => $code,
                                            'item_base' => $oldBase === $code,
                                        ];
                                    }
                                } else {
                                    foreach ($seriesItems as $item) {
                                        $rows[] = [
                                            'item_code' => $item->item_code,
                                            'item_base' => $item->item_base,
                                        ];
                                    }
                                }
                            @endphp

                            @if (count($rows))
                                @foreach ($rows as $idx => $row)
                                    <div class="item-row {{ $row['item_base'] ? 'is-base' : '' }}" id="item-row-{{ $idx }}">
                                        <input type="hidden" name="items[]" class="item-code-value" value="{{ $row['item_code'] }}">
                                        <span class="item-code-text">{{ $row['item_code'] }}</span>
                                        <span class="badge-base {{ $row['item_base'] ? '' : 'd-none' }}" id="badge-{{ $idx }}">Base</span>
                                        <label class="base-radio-label ms-auto mb-0">
                                            <input
                                                type="radio"
                                                name="item_base"
                                                value="{{ $row['item_code'] }}"
                                                id="radio-{{ $idx }}"
                                                data-idx="{{ $idx }}"
                                                {{ $row['item_base'] ? 'checked' : '' }}
                                            >
                                            Item Base
                                        </label>
                                        <button type="button" class="btn-remove-item" title="Remove" data-idx="{{ $idx }}">
                                            <i class="fas fa-times fa-xs"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="items-empty" id="items-empty">
                                    <i class="fas fa-box-open mb-2 d-block"></i>
                                    No items added yet
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="submit-hint d-none" id="submit-hint">
                        <i class="fas fa-info-circle me-1"></i>
                        Select one item as <strong>Item Base</strong> before submitting
                    </div>

                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn-eu-primary" id="btnSubmit" disabled>
                            <i class="fas fa-save fa-xs me-1"></i> Update Series
                        </button>
                        <a href="{{ route('product-series.index') }}" class="btn btn-secondary btn-sm mb-0">Cancel</a>
                    </div>
                </div>
            </div>

        </form>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">

        (function () {
            let itemCounter = {{ count($rows) }};
            let acSelected = false;
            let acSettingValue = false;
            let acItems = [];

            // ── Inline series name edit ───────────────────────────────────
            function openNameEdit() {
                const current = document.getElementById('series_name_hidden').value;
                document.getElementById('series_name_edit_input').value = current;
                document.getElementById('series_name_edit_error').style.display = 'none';
                document.getElementById('series_name_edit_input').classList.remove('is-invalid');
                document.getElementById('series-name-display').style.display = 'none';
                document.getElementById('series-name-edit').classList.add('active');
                document.getElementById('series_name_edit_input').focus();
                document.getElementById('series_name_edit_input').select();
            }

            function confirmNameEdit() {
                const input = document.getElementById('series_name_edit_input');
                const name  = input.value.trim();
                if (!name) {
                    input.classList.add('is-invalid');
                    document.getElementById('series_name_edit_error').style.display = 'block';
                    input.focus();
                    return;
                }
                document.getElementById('series_name_hidden').value       = name;
                document.getElementById('series_name_text').textContent   = name;
                input.classList.remove('is-invalid');
                document.getElementById('series_name_edit_error').style.display = 'none';
                document.getElementById('series-name-edit').classList.remove('active');
                document.getElementById('series-name-display').style.display = '';
            }

            function cancelNameEdit() {
                document.getElementById('series_name_edit_input').classList.remove('is-invalid');
                document.getElementById('series_name_edit_error').style.display = 'none';
                document.getElementById('series-name-edit').classList.remove('active');
                document.getElementById('series-name-display').style.display = '';
            }

            document.getElementById('btnEditName').addEventListener('click', openNameEdit);
            document.getElementById('btnNameConfirm').addEventListener('click', confirmNameEdit);
            document.getElementById('btnNameCancel').addEventListener('click', cancelNameEdit);
            document.getElementById('series_name_edit_input').addEventListener('keydown', function (e) {
                if (e.key === 'Enter')  { e.preventDefault(); confirmNameEdit(); }
                if (e.key === 'Escape') { e.preventDefault(); cancelNameEdit(); }
            });

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
                acSelected = false;
                acItems = [];
                const itemsEmpty = document.getElementById('items-empty');
                if (itemsEmpty) {
                    itemsEmpty.classList.add('d-none');
                }

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
                acItems = [];
                input.focus();
                updateSubmitState();
            }

            function removeItem(idx) {
                const row = document.getElementById('item-row-' + idx);
                if (row) {
                    row.remove();
                }

                if (!document.querySelectorAll('.item-row').length) {
                    const itemsEmpty = document.getElementById('items-empty');
                    if (itemsEmpty) {
                        itemsEmpty.classList.remove('d-none');
                    }
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

            // ── Add item button / Enter key ───────────────────────────────
            document.getElementById('btnAddItem').addEventListener('click', addItem);
            document.getElementById('item_code_input').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { 
                    e.preventDefault(); 
                    addItem(); 
                }
            });

            updateSubmitState();
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
