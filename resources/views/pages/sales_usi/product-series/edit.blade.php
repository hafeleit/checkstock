@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Products 360°'])

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .step-bar {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .step-circle {
            width: 2rem;
            height: 2rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 700;
            flex-shrink: 0;
            border: 2px solid #dee2e6;
            color: #adb5bd;
            background: #fff;
            transition: all 0.2s;
        }

        .step-circle.active {
            border-color: #5e72e4;
            color: #5e72e4;
            background: #eef0fd;
        }

        .step-circle.done {
            border-color: #2dce89;
            background: #2dce89;
            color: #fff;
        }

        .step-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #adb5bd;
            transition: color 0.2s;
        }

        .step-label.active,
        .step-label.done {
            color: #344767;
        }

        .step-connector {
            flex: 1;
            height: 2px;
            background: #dee2e6;
            margin: 0 1rem;
            transition: background 0.3s;
        }

        .step-connector.done {
            background: #2dce89;
        }

        .form-label-eu {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            color: #344767;
            margin-bottom: 0.35rem;
            display: block;
        }

        .add-item-wrap {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .add-item-input {
            flex: 1;
        }

        .btn-add-item {
            white-space: nowrap;
        }

        .items-list-wrap {
            margin-top: 0.75rem;
        }

        .item-row {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            background: #f8f9fa;
            margin-bottom: 0.5rem;
            border: 1px solid #e9ecef;
            transition: background 0.15s, border-color 0.15s;
        }

        .item-row.is-base {
            background: #f0faf5;
            border-color: #2dce89;
        }

        .item-code-text {
            font-size: 0.82rem;
            font-weight: 600;
            color: #344767;
            font-family: monospace;
            flex: 1;
        }

        .badge-base {
            font-size: 0.68rem;
            background: #d3f4e7;
            color: #1aae6f;
            padding: 2px 8px;
            border-radius: 20px;
            font-weight: 700;
            white-space: nowrap;
        }

        .base-radio-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #8392ab;
            cursor: pointer;
            white-space: nowrap;
            user-select: none;
        }

        .base-radio-label input[type="radio"] {
            accent-color: #2dce89;
            width: 14px;
            height: 14px;
            cursor: pointer;
        }

        .btn-remove-item {
            background: none;
            border: none;
            color: #f5365c;
            padding: 0.2rem 0.45rem;
            border-radius: 6px;
            cursor: pointer;
            line-height: 1;
            transition: background 0.15s;
            flex-shrink: 0;
        }

        .btn-remove-item:hover {
            background: #fde8ec;
        }

        .items-empty {
            text-align: center;
            padding: 2rem 0;
            color: #adb5bd;
            font-size: 0.82rem;
        }

        .items-empty i {
            font-size: 1.5rem;
        }

        .submit-hint {
            font-size: 0.78rem;
            color: #8392ab;
            margin-top: 0.5rem;
        }

        .field-error {
            font-size: 0.8rem;
        }

        .series-subtitle {
            font-size: 0.8rem;
            color: #8392ab;
        }

        .series-name-val {
            color: #344767;
        }

        .btn-eu-primary:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            pointer-events: auto;
        }
    </style>

    <div class="container-fluid relative">


        <form id="createForm" action="{{ route('product-series.update', $productSeries->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

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
                            <label class="form-label-eu required" for="series_name_input">Series Name</label>
                            <input type="text" class="form-control" id="series_name_input" name="series_name" placeholder="e.g. ELITEBOOK 840 G5" value="{{ old('series_name', $productSeries->series_name) }}" autocomplete="off">
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
                            Series name: <strong class="series-name-val" id="series_name_display">{{ old('series_name', $productSeries->series_name) }}</strong>
                        </p>
                    </div>
                    <div class="eu-card-actions">
                        <button type="button" class="btn btn-secondary btn-sm mb-0" id="btnBack">
                            <i class="fas fa-arrow-left fa-xs me-1"></i> Back
                        </button>
                    </div>
                </div>

                <div class="px-4 py-4">
                    <input type="hidden" name="series_name" id="series_name_hidden" value="{{ old('series_name', $productSeries->series_name) }}">

                    <label class="form-label-eu required">Item Code</label>
                    <div class="add-item-wrap">
                        <div class="add-item-input">
                            <input
                                type="text"
                                class="form-control"
                                id="item_code_input"
                                placeholder="000.00.000"
                                autocomplete="off"
                            >
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

            // ── Item management ──────────────────────────────────────────
            const ITEM_CODE_RE = /^\d{3}\.\d{2}\.\d{3}$/;

            function addItem() {
                const input   = document.getElementById('item_code_input');
                const errorEl = document.getElementById('item_code_error');
                const code    = input.value.trim();

                if (!code) {
                    errorEl.textContent = 'Please enter an item code.';
                    errorEl.classList.remove('d-none');
                    input.classList.add('is-invalid');
                    input.focus();
                    return;
                }

                if (!ITEM_CODE_RE.test(code)) {
                    errorEl.textContent = 'Item code must be in format 000.00.000';
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
                const itemsEmpty = document.getElementById('items-empty');
                if (itemsEmpty) itemsEmpty.classList.add('d-none');

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
                if (row) row.remove();
                if (!document.querySelectorAll('.item-row').length) {
                    const itemsEmpty = document.getElementById('items-empty');
                    if (itemsEmpty) itemsEmpty.classList.remove('d-none');
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
                if (btn) removeItem(btn.dataset.idx);
            });

            document.getElementById('items-list').addEventListener('change', function (e) {
                const radio = e.target.closest('input[type="radio"][name="item_base"]');
                if (radio) onBaseChange(radio.dataset.idx);
            });

            // ── Static button listeners ───────────────────────────────────
            document.getElementById('btnNext').addEventListener('click', goToStep2);
            document.getElementById('btnBack').addEventListener('click', goToStep1);
            document.getElementById('btnAddItem').addEventListener('click', addItem);

            document.getElementById('series_name_input').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); goToStep2(); }
            });

            document.getElementById('item_code_input').addEventListener('keydown', function (e) {
                if (e.key === 'Enter') { e.preventDefault(); addItem(); }
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
