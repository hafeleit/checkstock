@extends('layouts.appform')

@section('content')
    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .header-content {
            width: 100%;
            z-index: 9;
            text-align: center;
        }

        .header-logo {
            z-index: 9;
            width: 250px;
        }

        .warranty-bg {
            background-image: url('/img/bg_warranty.jpg');
            background-position: top;
        }

        .hidden-file-input {
            display: none;
        }

        .form-consent {
            display: flex;
            align-items: start;
        }

        .consent-msg-th {
            color: #000000;
        }

        .consent-msg-en {
            color: #666666;
            font-size: 12px;
        }

        .border-requierd {
            border: 0.5px solid red;
            border-radius: 5px;
            padding: 5px;
            margin-bottom: 8px;
        }

        #consentError {
            background-color: #faeded;
        }
    </style>

    <!-- End Navbar -->
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg warranty-bg">
            <div class="header-content">
                <img src="/img/hafele_logo_white.png" class="header-logo">
            </div>
            <span class="mask bg-primary opacity-6"></span>
        </div>
        <div class="container">
            <div class="row mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-5 col-lg-5 col-md-7 mx-auto">

                    <div class="card z-index-0">
                        <div class="text-center">
                            <a href="{{ route('check_warranty') }}"><button type="button"
                                    class="btn bg-gradient-success w-50 my-4 mb-2">Check Warranty</button></a>
                        </div>

                        <div class="card-header text-center pt-4">
                            <h3>Warranty registration</h3>
                        </div>
                        <hr class="horizontal dark mt-0">

                        <div class="card-body">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="registrationForm" role="form" action="{{ route('register-warranty.store') }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="text-sm">ชื่อ - สกุล (Name - Surname)<span
                                            class="text-danger">*</span></label>
                                    <input name="name" type="text" class="form-control"
                                        placeholder="กรุณากรอกชื่อ-นามสกุล (Please fill in)" value="{{ old('name') }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">ที่อยู่จัดส่งสินค้า (Delivery address)<span
                                            class="text-danger">*</span></label>
                                    <textarea name="addr" class="form-control" rows="3" placeholder="กรุณากรอกที่อยู่จัดส่งสินค้า (Please fill in)" required>
                                        {{ old('addr') }}
                                    </textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">เบอร์โทรศัพท์ที่ติดต่อได้ (Contact number)<span
                                            class="text-danger">*</span></label>
                                    <input name="tel" type="text" class="form-control"
                                        placeholder="กรุณากรอกเบอร์โทรศัพท์ (Please fill in)" value="{{ old('tel') }}"
                                        required id="contactTelInput">
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">Article no. (xxx.xx.xxx)<span
                                            class="text-danger">*</span></label>
                                    <input name="article_no" id="article_no" type="text" class="form-control"
                                        placeholder="กรุณากรอก Article no. (Please fill in)" value="{{ old('article_no') }}"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">Serial no. (16-20 หลัก)</label>
                                    <input name="serial_no" type="text" class="form-control"
                                        placeholder="“กรุณากรอก Serial no. (ถ้ามี)” (Please enter the serial number (if available)"
                                        value="{{ old('serial_no') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">ช่องทางการสั่งซื้อ (Order channel)<span
                                            class="text-danger">*</span></label>
                                    <select name="order_channel" id="order_channel" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือกช่องทางการสั่งซื้อ (Please select)</option>
                                        <option value="showroom" @if(old('order_channel') === 'showroom') selected @endif>
                                            โชว์รูม (Showroom)
                                        </option>
                                        <option value="shopee" @if(old('order_channel') === 'shopee') selected @endif>
                                            ช้อปปี้ (Shopee Mall)
                                        </option>
                                        <option value="lazada" @if(old('order_channel') === 'lazada') selected @endif>
                                            ลาซาด้า (Lazada Mall)
                                        </option>
                                        <option value="website-hafele-home" @if(old('order_channel') === 'website-hafele-home') selected @endif>
                                            เว็บไซต์บริษัท (Website: Hafele Home)
                                        </option>
                                        <option value="line-hafele-home" @if(old('order_channel') === 'line-hafele-home') selected @endif>
                                            LINE Official (LINE: Hafele Home)
                                        </option>
                                        <option value="modern-trade" @if(old('order_channel') === '"modern-trade') selected @endif>
                                            ห้างโมเดิร์นเทรด (Modern Trade)
                                        </option>
                                        <option value="dealer" @if(old('order_channel') === 'dealer') selected @endif>
                                            ร้านค้าวัสดุ / ร้านตัวแทนจำหน่าย (Dealer)
                                        </option>
                                        <option value="project-contractor" @if(old('order_channel') === 'project-contractor') selected @endif>
                                            เซลล์โครงการ / งานโครงการ (Project) / ผู้รับเหมา (Contractor)
                                        </option>
                                        <option value="other" @if(old('order_channel') === 'other') selected @endif>
                                            อื่นๆ (Other)
                                        </option>
                                    </select>
                                    <div id="otherChannelWrapper">
                                        <input type="text" name="other_channel" id="other_channel"
                                            class="form-control mt-3"
                                            placeholder="กรุณากรอกช่องทางการสั่งซื้ออื่นๆ (Please fill in)"
                                            value="{{ old('other_channel') }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">หมายเลขคำสั่งซื้อ (Order number)<span
                                            class="text-danger">*</span></label>
                                    <input name="order_number" type="text" class="form-control"
                                        placeholder="กรุณากรอกหมายเลขคำสั่งซื้อ (Please fill in)"
                                        value="{{ old('order_number') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-sm">อีเมล (Email)</label>
                                    <input name="email" type="email" class="form-control"
                                        placeholder="กรุณากรอกอีเมล (ถ้ามี)" value="{{ old('email') }}">
                                </div>
                                <div class="mb-3">
                                    <div class="row">
                                        <label class="text-sm">แนบรูปใบเสร็จ หรือ serial no. (Attach file)<span
                                                class="text-danger">*</span></label>
                                        <div class="col-8">
                                            <input accept=".jpg, .jpeg, .pdf" name="file" type="file"
                                                class="form-control" placeholder="Attach file" aria-label="Attach file"
                                                required>
                                            <input accept=".jpg, .jpeg, .pdf" name="file2" type="file"
                                                class="form-control files hidden-file-input" placeholder="Attach file"
                                                aria-label="Attach file">
                                            <input accept=".jpg, .jpeg, .pdf" name="file3" type="file"
                                                class="form-control files hidden-file-input" placeholder="Attach file"
                                                aria-label="Attach file">
                                            <input accept=".jpg, .jpeg, .pdf" name="file4" type="file"
                                                class="form-control files hidden-file-input" placeholder="Attach file"
                                                aria-label="Attach file">
                                            <input accept=".jpg, .jpeg, .pdf" name="file5" type="file"
                                                class="form-control files hidden-file-input" placeholder="Attach file"
                                                aria-label="Attach file">
                                        </div>
                                        <div class="col-4">
                                            <button class="btn btn-sm btn-outline-dark mb-0 add-more-btn"
                                                type="button">Add</button>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-danger text-sm">*แนบไฟลได้เฉพาะ ไฟล์ pdf และ jpg ไฟล์ขนาดสูงสุดไม่เกิน 5MB
                                    (Only pdf and jpg files with a maximum file size of 5MB.)</p>

                                <div id="consentError" class="alert d-none mt-3 text-xs text-danger font-weight-bold"
                                    role="alert">
                                    * กรุณาทำเครื่องหมายยอมรับนโยบายความเป็นส่วนตัวของบริษัท *
                                </div>

                                <div class="form-consent" id="consentPolicyForm">
                                    <input class="mt-1" type="checkbox" value="true" name="is_consent_policy"
                                        id="isConsentPolicyCheckbox" checked />
                                    <label class="form-check-label required">
                                        <span class="consent-msg-th">
                                            ข้าพเจ้าได้อ่านและยอมรับ
                                            <a class="font-weight-bold" target="_blank"
                                                href="https://www.hafelethailand.com/policy/">นโยบายความเป็นส่วนตัวของบริษัทฯ</a>
                                            และยินยอมให้เก็บ ใช้ และเปิดเผยข้อมูลส่วนบุคคลที่ให้ไว้
                                            เพื่อวัตถุประสงค์ในการรับประกันสินค้า
                                            บริการหลังการขาย การซ่อมบำรุง และการติดต่อประสานงานที่เกี่ยวข้อง
                                            พิสูจน์ยืนยันตัวตนและป้องกันการทุจริต
                                            โดยบริษัทจะจัดเก็บและใช้ข้อมูลดังกล่าวตามนโยบายความเป็นส่วนตัวของบริษัท
                                        </span>
                                        <span class="consent-msg-en">
                                            (I have read and agree to the
                                            <a class="font-weight-bold consent-msg-en" target="_blank"
                                                href="https://www.hafelethailand.com/policy/">Company's Privacy Policy and
                                                consent</a>
                                            to the collection, use, and disclosure
                                            of my personal data for the purpose of product warranty, after-sales service,
                                            and fraud prevention, as stipulated in the Policy.)
                                        </span>
                                    </label>
                                </div>

                                <div class="form-consent">
                                    <input class="mt-1" type="checkbox" value="true" name="is_consent_marketing"
                                        id="isConsentMarketingCheckbox" />
                                    <label class="form-check-label">
                                        <span class="consent-msg-th">
                                            ข้าพเจ้ายินยอมให้บริษัทฯ ใช้ข้อมูลส่วนบุคคลของข้าพเจ้าเพื่อส่งข่าวสาร โปรโมชั่น
                                            สิทธิพิเศษ และข้อเสนอทางการตลาดผ่านช่องทาง SMS, Email, โทรศัพท์, Line
                                            หรือช่องทางอื่น
                                        </span>
                                        <span class="consent-msg-en">
                                            (I consent to the Company using my personal data to send news,
                                            promotions, special offers, and marketing communications through SMS, Email,
                                            Phone,
                                            Line, or other channels.)
                                        </span>
                                    </label>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-danger w-100 mb-2">Register</button>
                                </div>

                                <div class="text-center">
                                    <a class="btn bg-gradient-secondary w-100 mb-0"
                                        href="https://www.hafelethailand.com/downloads-support/warranty-conditions/"
                                        target=”_blank”>อ่านเงื่อนไขการรับประกันสินค้า คลิก</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/jquery.mask.js') }}"></script>
    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        $('#article_no').mask('000.00.000');

        function add_more_upload() {
            $('.hidden-file-input').first().removeClass('hidden-file-input').removeClass('files');
        }
        document.querySelector('.add-more-btn').addEventListener('click', add_more_upload);

        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }

            return true;
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Tel - Only numeric
            const inputElement = document.getElementById('contactTelInput');
            if (inputElement) {
                inputElement.onkeypress = isNumberKey;

                inputElement.addEventListener('input', function() {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Other - Order Channel
            const orderChannelSelect = document.getElementById('order_channel');
            const otherChannelWrapper = document.getElementById('otherChannelWrapper');

            if (orderChannelSelect && otherChannelWrapper) {
                function toggleOtherChannelInput() {
                    const selectedValue = orderChannelSelect.value;

                    if (selectedValue === 'other') {
                        otherChannelWrapper.style.display = 'block';
                        otherChannelWrapper.querySelector('input').setAttribute('required', 'required');
                    } else {
                        otherChannelWrapper.style.display = 'none';
                        otherChannelWrapper.querySelector('input').removeAttribute('required');
                        otherChannelWrapper.querySelector('input').value = '';
                    }
                }

                orderChannelSelect.addEventListener('change', toggleOtherChannelInput);
                toggleOtherChannelInput();
            }

            // Checked - Policy consent
            const form = document.getElementById('registrationForm');
            const policyCheckbox = document.getElementById('isConsentPolicyCheckbox');
            const consentPolicyForm = document.getElementById('consentPolicyForm');
            const errorDisplay = document.getElementById('consentError');

            form.addEventListener('submit', function(event) {
                if (!policyCheckbox.checked) {
                    event.preventDefault();

                    errorDisplay.classList.remove('d-none');
                    consentPolicyForm.classList.add('border-requierd')

                    errorDisplay.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    return false;
                } else {
                    errorDisplay.classList.add('d-none');
                    consentPolicyForm.classList.remove('border-requierd')

                    return true;
                }
            });

            policyCheckbox.addEventListener('change', () => {
                if (policyCheckbox.checked) {
                    errorDisplay.classList.add('d-none');
                    consentPolicyForm.classList.remove('border-requierd')
                }
            });
        });
    </script>
@endsection
