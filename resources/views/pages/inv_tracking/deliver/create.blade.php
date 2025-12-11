@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Deliver Management'])
<style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
    .select2-container--default .select2-selection--single {
        height: 30px !important;
        border: 1px solid #d2d6da !important;
        border-radius: 8px !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        font-size: 12px !important;
    }

    .sweetalert-text-container {
        text-align: left;
        padding: 0 1rem;
    }
    #delivery_date {
        pointer-events: auto !important;
        background-color: #f9f9f9;
        cursor: pointer;
    }
    #duplicate_message {
        background-color: #feeef1;
        padding: 3px;
        border-radius: 5px;
    }
    #submit_button:disabled {
        color: #ffffff !important;
    }
</style>
<div class="container-fluid py-4">
    <div class="card">
        <div class="px-4 d-flex align-items-center justify-content-between mt-4">
            <h2 class="h5 mb-0">Create New Deliver</h2>
            <a href="/delivery-trackings" class="btn btn-secondary btn-sm d-flex align-items-center gap-2 mb-0">
                <i class="fa fa-arrow-left"></i>
                <span>Back</span>
            </a>
        </div>
        <div class="px-4">
            <p class="text-sm text-secondary">
                Fill in the details below to create a new delivery job.
            </p>
        </div>

        <div class="px-4">
            <form id="deliver-form" action="{{ route('delivery-trackings.delivers.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-6">
                        <label for="driver_or_sent_to" class="form-label required">Driver</label>
                        <select class="form-control form-control-sm" id="driver_or_sent_to" name="driver_or_sent_to" required>
                            <option value=""></option>
                            @foreach ($drivers as $driver)
                            <option value="{{ $driver->code }}">{{$driver->code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="delivery_date" class="form-label required">Delivery Date</label>
                        <input type="datetime-local" class="form-control form-control-sm bg-white" id="delivery_date" name="delivery_date" value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="erp_documents" class="form-label required">Outbound No.</label>
                    <textarea class="form-control" id="erp_documents" name="erp_documents" rows="10" placeholder="#000000001&#10;#000000002&#10;#000000003" required></textarea>

                    <p id="duplicate_message" class="text-danger fw-bold text-xs mt-2 d-none"></p>
                    <p class="form-text text-xs mt-1">
                        Enter each outbound number on a separate line. Each document will create a separate job record.
                    </p>
                </div>
                <div class="mb-3">
                    <p id="line-counter" class="form-text text-sm mt-1 text-gray-500 text-right fw-bold">Count: </p>
                </div>
                <div class="mb-3">
                    <label for="remark" class="form-label">Remark</label>
                    <input type="text" class="form-control form-control-sm" id="remark" name="remark">
                </div>

                <div class="d-grid">
                    <button type="submit" id="submit_button" class="btn btn-primary uppercase d-flex align-items-center justify-content-center gap-2">
                        <i class="fa fa-plus-circle"></i>
                        <span>GENERATE DELIVERY DOCUMENT</span>
                    </button>
                </div>
            </form>
        </div>


    </div>
</div>

<link href="{{ asset('css/sweetalert2.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
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

    // --- Select2 Initialization ---
    $(document).ready(function() {
        flatpickr("#delivery_date", {
            enableTime: true,
            dateFormat: "d-m-Y H:i",
            defaultDate: "{{ \Carbon\Carbon::now()->format('d-m-Y H:i') }}",
        });
        $('#driver_or_sent_to').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: 'Search for a driver or add a new one',
            createTag: function(params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        });
    });

    // --- Input Sanitation ---
    document.getElementById('erp_documents').addEventListener('input', function(event) {
        let value = event.target.value;
        event.target.value = value.replace(/[^a-zA-Z0-9\n]/g, '');
    });

    // --- Form Submission Handler ---
    document.getElementById('deliver-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const form = this;
        const driver_or_sent_to = form.querySelector('#driver_or_sent_to').value;
        const delivery_date = form.querySelector('#delivery_date').value;
        const erpDocuments = form.querySelector('#erp_documents').value;
        const remark = form.querySelector('#remark').value;
        const erpDocumentsArray = erpDocuments.split('\n').filter(line => line.trim() !== '');

        if (erpDocumentsArray.length === 0) {
            Swal.fire({
                title: 'Warning!',
                text: 'Please enter at least one erp document.',
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
                <p class="mb-0 text-sm"><strong>Driver:</strong> ${driver_or_sent_to ?? ''}</p>
                <p class="mb-0 text-sm"><strong>Created by:</strong> {{ $user->username }}</p>
                <p class="mb-0 text-sm"><strong>Delivery date:</strong> ${delivery_date}</p>
                <p class="mb-0 text-sm"><strong>Remark:</strong> ${remark ?? ''}</p>
                <p class="mb-0 text-sm"><strong>Outbound:</strong></p>
                <ol class="list-group list-group-numbered">
                    ${previewList}
                </ol>
            </div>
        `;

        Swal.fire({
            title: "Confirm data save",
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
                    driver_or_sent_to: driver_or_sent_to,
                    delivery_date: delivery_date,
                    erp_documents: erpDocumentsArray,
                    remark: form.querySelector('#remark').value,
                };

                Swal.fire({
                    title: 'Creating...',
                    text: 'Please wait, your delivery document is being generated.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                console.log(finalData)
                fetch(form.action, {
                        method: 'post',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify(finalData)
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                    })
                    .then(data => {
                        Swal.fire('Success', 'Data saved successfully!', 'success')
                            .then(() => {
                                window.location.href = '/delivery-trackings';
                            });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred while saving the data. Please check the console for more details.', 'error');
                    });
            }
        });
    });

    // --- Check Duplicate Outbound No. ---
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('erp_documents');
        const messageElement = document.getElementById('duplicate_message');
        const submitButton = document.getElementById('submit_button');

        if (!textarea || !messageElement || !submitButton) {
            console.error("One or more required elements not found.");
            return;
        }

        textarea.addEventListener('blur', function() {
            const input = this.value;
            const numbers = input.split('\n').map(line => line.trim()).filter(line => line.length > 0);
            const seenNumbers = {};
            const duplicates = [];

            numbers.forEach(number => {
                if (seenNumbers[number] && !duplicates.includes(number)) {
                    duplicates.push(number);
                } else {
                    seenNumbers[number] = true; 
                }
            });
            
            if (duplicates.length > 0) {
                const duplicateList = duplicates.join(', ');
                const alertMessage = `⚠️ Duplicate data found: ${duplicateList}. Please remove the duplicates to proceed.`;
                
                messageElement.textContent = alertMessage;
                messageElement.classList.remove('d-none');
                submitButton.disabled = true;
            } else {
                messageElement.classList.add('d-none');
                submitButton.disabled = false;
            }
        });
    });
</script>
@endsection