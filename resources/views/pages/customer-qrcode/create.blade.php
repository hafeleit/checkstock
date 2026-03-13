@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'QR Code Customer'])
    
    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .qr-preview-container {
            min-height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 2px dashed #e9ecef;
            border-radius: 15px;
            background-color: #ffffff;
        }
        .qr-placeholder-icon {
            font-size: 3rem;
            color: #dee2e6;
        }
        .btn-back {
            color: #344767;
            text-decoration: none;
        }
        .btn-primary.disabled {
            color: #ffffff;
        }
        .btn-gen-qr {
            background: #e9ecef;
        }
        .icon-back:hover {
            background: #e9e9e9;
            border-radius: .5rem;
            color: #344767;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card shadow-sm">
                    <div class="card-header pb-0">
                        <div class="d-md-flex align-items-center gap-3">
                            <a href="/qr-code-customers" class="btn-back">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short icon-back" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                                </svg>
                            </a>
                            <div>
                                <h4 class="mb-0 h4">Add QR Code Customer</h4>
                                <p class="text-secondary text-xs m-0">Fill in the customer details and generate a QR code</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row mt-3">
                            {{-- Form --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border p-4 shadow-none">
                                    <h6 class="text-uppercase text-muted text-xxs font-weight-bolder opacity-7 mb-4">Customer Information</h6>
                                    <form method="POST" action="{{ route('qr-code-customers.generate') }}" id="qr-form">
                                        @csrf

                                        <div class="form-group mt-3">
                                            <div class="d-flex justify-content-between">
                                                <label for="customer_code" class="form-control-label text-sm required">Customer Code <span class="text-muted">(REF1)</span></label>
                                                <span class="text-xs text-muted" id="code_count">0/9</span>
                                            </div>
                                            <input type="text" class="form-control" name="customer_code" id="customer_code" placeholder="Enter customer code" value="{{ $customer_code ?? '' }}" maxlength="9" required>
                                            <small id="code_error_msg" class="form-text text-danger text-xs fst-italic">Customer code must be exactly 9 characters.</small>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between">
                                                <label for="customer_name" class="form-control-label text-sm required">Customer Name </label>
                                            </div>
                                            <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Enter customer name" value="{{ $customer_name ?? '' }}" required>
                                            <small class="form-text text-muted text-xs fst-italic">Recommended to use English characters.</small>
                                        </div>

                                        <button type="submit" class="btn btn-gen-qr w-100 mt-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-qr-code" viewBox="0 0 16 16">
                                                    <path d="M2 2h2v2H2z"/>
                                                    <path d="M6 0v6H0V0zM5 1H1v4h4zM4 12H2v2h2z"/>
                                                    <path d="M6 10v6H0v-6zm-5 1v4h4v-4zm11-9h2v2h-2z"/>
                                                    <path d="M10 0v6h6V0zm5 1v4h-4V1zM8 1V0h1v2H8v2H7V1zm0 5V4h1v2zM6 8V7h1V6h1v2h1V7h5v1h-4v1H7V8zm0 0v1H2V8H1v1H0V7h3v1zm10 1h-1V7h1zm-1 0h-1v2h2v-1h-1zm-4 0h2v1h-1v1h-1zm2 3v-1h-1v1h-1v1H9v1h3v-2zm0 0h3v1h-2v1h-1zm-4-1v1h1v-2H7v1z"/>
                                                    <path d="M7 12h1v3h4v1H7zm9 2v2h-3v-1h2v-1z"/>
                                            </svg> 
                                            <span class="px-2">Generate QR Code</span>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- QR Code Preview --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 border p-4 shadow-none text-center">
                                    <h6 class="text-start text-uppercase text-muted text-xxs font-weight-bolder opacity-7 mb-4">QR Code Preview</h6>
                                    
                                    <div class="qr-preview-container">
                                        
                                        @if(isset($qrCode))
                                            <div class="p-3">
                                                <div class="mb-4 d-flex justify-content-center">
                                                    {!! $qrCode !!}
                                                </div>

                                                <input type="hidden" id="generated_payload" value="{{ $payload ?? '' }}">
                                                
                                                <div class="bg-gray-100 p-3 rounded-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-secondary text-xs">REF1:</span>
                                                        <span class="text-dark fw-bold text-xs">{{ $customer_code }}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-center mb-1">
                                                    <span class="text-dark fw-bold text-lg">{{ $customer_name }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="text-secondary">
                                                <div class="qr-placeholder-icon mb-2">
                                                    <i class="ni ni-qr-common"></i>
                                                </div>
                                                <p class="mb-0 font-weight-bold">No QR Code Generated</p>
                                                <p class="text-xs">Fill in the form and click Generate</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer border-top d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary mb-0" id="btn-cancel">Cancel</button>
                        <button type="button" class="btn btn-primary mb-0 {{ isset($qrCode) ? '' : 'disabled' }}" id="btn-confirm">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                let errorList = '';
                @foreach ($errors->all() as $error)
                    errorList += '{{ $error }}\n';
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorList,
                    confirmButtonColor: '#344767'
                });
            @endif

            const btnGenerate = document.querySelector('.btn-gen-qr');
            const btnCancel = document.getElementById('btn-cancel');
            const btnConfirm = document.getElementById('btn-confirm');
            const codeErrorMsg = document.getElementById('code_error_msg');
            const customerNameInput = document.getElementById('customer_name');
            const customerCodeInput = document.getElementById('customer_code');
            const payloadInput = document.getElementById('generated_payload');

            if (btnCancel) {
                btnCancel.addEventListener('click', function() {
                    window.location.href = '/qr-code-customers';
                });
            }

            if (btnConfirm && !btnConfirm.classList.contains('disabled')) {
                btnConfirm.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Uploading...',
                        text: 'Please wait while we process your data.',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    axios.post('/qr-code-customers', {
                        customer_name: customerNameInput.value,
                        customer_code: customerCodeInput.value,
                        payload: payloadInput.value
                    })
                    .then(resonse => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'QR code has been saved successfully.',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/qr-code-customers';
                        });
                    })
                    .catch(error => {
                        const errorMessage = error.response?.data?.message || 'Something went wrong, please try again.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                        console.error('Upload Error:', error);
                    })
                });
            }

            // validate generate qr code
            const updateValidation = () => {
                const codeLength = customerCode.value.length;
                
                if (codeLength > 0 && codeLength < 9) {
                    codeErrorMsg.classList.remove('d-none');
                    btnGenerate.disabled = true;
                    btnGenerate.style.opacity = '0.6';
                } else if (codeLength === 9) {
                    codeErrorMsg.classList.add('d-none');
                    btnGenerate.disabled = false;
                    btnGenerate.style.opacity = '1';
                } else {
                    codeErrorMsg.classList.add('d-none');
                    btnGenerate.disabled = true;
                }
            };
            
            // Count: customer code/customer name
            const updateCount = (inputEl, countEl, max) => {
                const currentLength = inputEl.value.length;
                countEl.textContent = `${currentLength}/${max}`;
                
                if (currentLength >= max) {
                    countEl.classList.remove('text-muted');
                    countEl.classList.add('text-danger');
                } else {
                    countEl.classList.remove('text-danger');
                }
            };

            const customerCode = document.getElementById('customer_code');
            const codeCount = document.getElementById('code_count');

            customerCode.addEventListener('input', () => {
                updateCount(customerCode, codeCount, 9);
                updateValidation();
            });

            updateCount(customerCode, codeCount, 9);
            updateValidation();
        });
    </script>
@endsection