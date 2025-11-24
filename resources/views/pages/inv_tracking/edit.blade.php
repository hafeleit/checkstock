@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Deliver Management'])
<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .sweetalert-text-container {
        text-align: left;
        padding: 0 1rem;
    }
</style>

<div class="container-fluid py-4">
    <div class="card">
        <div class="px-4 d-flex align-items-center justify-content-between mt-4">
            <h2 class="h5 mb-0">Edit Deliver/Return #{{ $invTracking['logi_track_id'] }}</h2>
            <a href="/delivery-trackings" class="btn btn-secondary btn-sm d-flex align-items-center gap-2 mb-0">
                <i class="fa fa-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
        <div class="px-4">
            <p class="text-sm text-secondary">
                Fill in the details below to update data.
            </p>
        </div>

        <div class="px-4">
            <form id="edit-form" action="{{ route('delivery-trackings.update', $invTracking['logi_track_id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 {{ $invTracking['type'] === 'deliver' ? 'col-6' : 'col-12'}}">
                        <label for="driver_or_sent_to" class="form-label required">{{ $invTracking['type'] === 'deliver' ? 'Driver' : 'Sent to' }}</label>
                        <input type="text" class="form-control form-control-sm" id="driver_or_sent_to" name="driver_or_sent_to" value="{{ $invTracking['driver_or_sent_to'] }}" disabled>
                    </div>
                    @if ($invTracking['type'] ==='deliver')
                    <div class="mb-3 col-6">
                        <label for="delivery_date" class="form-label required">Delivery Date</label>
                        <input type="date" class="form-control form-control-sm" id="delivery_date" name="delivery_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" disabled>
                    </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="erp_documents" class="form-label required">Outbound</label>
                    <textarea class="form-control" id="erp_documents" name="erp_documents" rows="10" placeholder="#000000001&#10;#000000002&#10;#000000003" required>{{ implode("\n", $erpDocuments) }}</textarea>
                    <p class="form-text text-xs mt-1">
                        Enter each outbound number on a separate line. Each document will create a separate job record.
                    </p>
                </div>
                <div class="mb-3">
                    <p id="line-counter" class="form-text text-sm mt-1 text-gray-500 text-right fw-bold">Count: </p>
                </div>
                <div class="mb-3">
                    <label for="remark" class="form-label">Remark</label>
                    <input type="text" class="form-control form-control-sm" id="remark" name="remark" value="{{ $invTracking['remark'] }}">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary uppercase d-flex align-items-center justify-content-center gap-2">
                        <span>UPDATE DOCUMENT</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    // --- Line Counter Logic ---
    const erp_documents = document.getElementById('erp_documents');
    const counter = document.getElementById('line-counter');
    const updateLineCount = () => {
        const text = erp_documents.value;
        const lines = text.split('\n').filter(line => line.trim() !== '');
        counter.textContent = `Count: ${lines.length}`;
    };
    erp_documents.addEventListener('input', updateLineCount);
    updateLineCount();

    // --- Input Sanitation ---
    document.getElementById('erp_documents').addEventListener('input', function(event) {
        let value = event.target.value;
        event.target.value = value.replace(/[^a-zA-Z0-9\n]/g, '');
    });

    // --- Form Submission Handler ---
    document.getElementById('edit-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const form = this;
        const driver_or_sent_to = form.querySelector('#driver_or_sent_to').value;
        const erpDocuments = form.querySelector('#erp_documents').value;
        const remark = form.querySelector('#remark').value;
        const erpDocumentsArray = erpDocuments.split('\n').filter(line => line.trim() !== '');

        if (erpDocumentsArray.length === 0) {
            Swal.fire({
                title: 'warning!',
                text: 'please enter at least one erp document.',
                icon: 'warning',
            });
            return;
        }

        const previewList = erpDocumentsArray.map(erp => {
            return `
                <li class="d-flex gap-2">
                    <p class="mb-0 text-sm">${erp}</p>
                </li>
            `;
        }).join('');

        const htmlContent = `
            <p class="text-sm">Do you want to save this delivery data? Please review the details below before confirming.</p>
            <div class="text-sm sweetalert-text-container">
                <p class="mb-0 text-sm"><strong>Driver/Sent to:</strong> ${driver_or_sent_to ?? ''}</p>
                <p class="mb-0 text-sm"><strong>Created by:</strong> {{ $user->username }}</p>
                <p class="mb-0 text-sm"><strong>Remark:</strong> ${remark ?? ''}</p>
                <p class="mb-0 text-sm"><strong>Outbound:</strong></p>
                <ol class="list-group list-group-numbered">
                    ${previewList}
                </ol>
            </div>
        `;

        Swal.fire({
            title: "Confirm data update",
            html: htmlContent,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
                actions: 'd-flex gap-2 justify-content-center'
            },
            buttonsStyling: false,
        }).then((result) => {
            if (result.isConfirmed) {
                const finalData = {
                    remark: form.querySelector('#remark').value,
                    erp_documents: erpDocumentsArray,
                };

                Swal.fire({
                    title: 'Updating...',
                    text: 'Please wait, your data document is being generated.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(form.action, {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json',
                            'x-csrf-token': form.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({
                            finalData,
                            _method: 'PUT'
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server returned an unexpected response. Check the console for details.');
                        }
                    })
                    .then(data => {
                        Swal.close(); 
                        Swal.fire('Success', 'Data saved successfully!', 'success');
                        window.location.href = '/delivery-trackings';
                    })
                    .catch(error => {
                        swal.fire('Error', 'An error occurred while saving the data.', 'error');
                        console.error('error:', error);
                    });
            }
        });
    });

    async function fetchInvoices(erpDocuments) {
        for (const erp of erpDocuments) {
            const inputField = document.querySelector(`input[data-erp="${erp}"]`);
            try {
                const response = await fetch(`/ajax/api/map-erp-to-invoice?erp=${erp}`);
                if (!response.ok) {
                    throw new Error('network response was not ok');
                }
                const data = await response.json();

                if (data.invoice_id) {
                    inputField.value = data.invoice_id;
                } else {
                    inputField.placeholder = 'enter invoice manually';
                    inputField.style.borderColor = '#ff4d4d';
                }
            } catch (error) {
                console.error('failed to fetch invoice id for erp:', erp, error);
                inputField.placeholder = 'enter invoice manually';
                inputField.style.borderColor = '#ff4d4d';
            } finally {
                inputField.disabled = false;
            }
        }
    }
</script>
@endsection