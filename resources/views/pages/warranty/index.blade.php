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
                        <a href="{{route('check_warranty')}}"><button type="button" class="btn bg-gradient-success w-50 my-4 mb-2">Check Warranty</button></a>
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
                        <form role="form" action="{{route('register-warranty.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="text-sm">ชื่อ - สกุล (Name - Surname)<span class="text-danger">*</span></label>
                                <input name="name" type="text" class="form-control" placeholder="กรุณากรอกชื่อ-นามสกุล (Please fill in)" value="{{ old('name') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">ที่อยู่จัดส่งสินค้า (Delivery address)<span class="text-danger">*</span></label>
                                <textarea name="addr" class="form-control" rows="3" placeholder="กรุณากรอกที่อยู่จัดส่งสินค้า (Please fill in)" value="{{ old('addr') }}" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">เบอร์โทรศัพท์ที่ติดต่อได้ (Contact number)<span class="text-danger">*</span></label>
                                <input name="tel" type="text" class="form-control" placeholder="กรุณากรอกเบอร์โทรศัพท์ (Please fill in)" value="{{ old('tel') }}" required id="contactTelInput">
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">Article no. (xxx.xx.xxx)<span class="text-danger">*</span></label>
                                <input name="article_no" id="article_no" type="text" class="form-control" placeholder="กรุณากรอก Article no. (Please fill in)" value="{{ old('article_no') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">Serial no. (16-20 หลัก)</label>
                                <input name="serial_no" type="text" class="form-control" placeholder="“กรุณากรอก Serial no. (ถ้ามี)” (Please enter the serial number (if available)" value="{{ old('serial_no') }}">
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">ช่องทางการสั่งซื้อ (Order channel)<span class="text-danger">*</span></label>
                                <select name="order_channel" id="order_channel" class="form-control">
                                    <option value="" selected disabled>กรุณาเลือกช่องทางการสั่งซื้อ (Please select)</option>
                                    <option value="โชว์รูม (Showroom)">โชว์รูม (Showroom)</option>
                                    <option value="ช้อปปี้ (Shopee Mall)">ช้อปปี้ (Shopee Mall)</option>
                                    <option value="ลาซาด้า (Lazada Mall)">ลาซาด้า (Lazada Mall)</option>
                                    <option value="เว็บไซต์บริษัท (Website: Hafele Home)">เว็บไซต์บริษัท (Website: Hafele Home)</option>
                                    <option value="LINE Official (LINE: Hafele Home)">LINE Official (LINE: Hafele Home)</option>
                                    <option value="ห้างโมเดิร์นเทรด (Modern Trade)">ห้างโมเดิร์นเทรด (Modern Trade)</option>
                                    <option value="ร้านค้าวัสดุ / ร้านตัวแทนจำหน่าย (Dealer)">ร้านค้าวัสดุ / ร้านตัวแทนจำหน่าย (Dealer)</option>
                                    <option value="เซลล์โครงการ / งานโครงการ (Project) / ผู้รับเหมา (Contractor)">เซลล์โครงการ / งานโครงการ (Project) / ผู้รับเหมา (Contractor)</option>
                                    <option value="อื่นๆ (Other)">อื่นๆ (Other)</option>
                                </select>
                                <div id="otherChannelWrapper">
                                    <input type="text" name="other_channel" id="other_channel" class="form-control mt-3" placeholder="กรุณากรอกช่องทางการสั่งซื้ออื่นๆ (Please fill in)">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">หมายเลขคำสั่งซื้อ (Order number)<span class="text-danger">*</span></label>
                                <input name="order_number" type="text" class="form-control" placeholder="กรุณากรอกหมายเลขคำสั่งซื้อ (Please fill in)" value="{{ old('order_number') }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="text-sm">อีเมล (Email)</label>
                                <input name="email" type="email" class="form-control" placeholder="กรุณากรอกอีเมล (ถ้ามี)" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <label class="text-sm">แนบรูปใบเสร็จ หรือ serial no. (Attach file)<span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <input accept=".jpg, .jpeg, .pdf" name="file" type="file" class="form-control" placeholder="Attach file" aria-label="Attach file" required>
                                        <input accept=".jpg, .jpeg, .pdf" name="file2" type="file" class="form-control files hidden-file-input" placeholder="Attach file" aria-label="Attach file">
                                        <input accept=".jpg, .jpeg, .pdf" name="file3" type="file" class="form-control files hidden-file-input" placeholder="Attach file" aria-label="Attach file">
                                        <input accept=".jpg, .jpeg, .pdf" name="file4" type="file" class="form-control files hidden-file-input" placeholder="Attach file" aria-label="Attach file">
                                        <input accept=".jpg, .jpeg, .pdf" name="file5" type="file" class="form-control files hidden-file-input" placeholder="Attach file" aria-label="Attach file">
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-sm btn-outline-dark mb-0 add-more-btn" type="button">Add</button>
                                    </div>
                                </div>
                            </div>
                            <p class="text-danger text-sm">*แนบไฟลได้เฉพาะ ไฟล์ pdf และ jpg ไฟล์ขนาดสูงสุดไม่เกิน 5MB (Only pdf and jpg files with a maximum file size of 5MB.)</p>
                        
                            <p class="text-sm">บริษัท เฮเฟเล่ (ประเทศไทย) จำกัด ("เฮเฟเล่") จะเก็บ รวบรวม ใช้ เปิดเผยข้อมูลส่วนบุคคลของท่านเพื่อติดต่อ นำเสนอ และประชาสัมพันธ์ผลิตภัณฑ์และบริการที่ท่านสนใจโปรดศึกษารายละเอียดและสิทธิใน <a target="_blank" href="https://www.hafelethailand.com/policy/">นโยบายคุ้มครองข้อมูลส่วนบุคคล (Privacy Policy) ของเฮเฟเล่</a></p>
                            <p class="text-sm">* In order to reach out to you, offer, and promote goods and services you might find interesting, Häfele (Thailand) Co., Ltd. gathers, uses, and discloses your personal information. Please review the
                                <a target="_blank" href="https://www.hafelethailand.com/policy/">privacy protection policy's details and rights.</a>
                            </p>

                            <div>
                                <input type="checkbox" name="is_consent" id="isConsentCheckbox" value="true" required>
                                <label class="form-check-label text-sm" for="isConsentCheckbox">
                                   <span class="text-danger">*</span> ข้าพเจ้ายินยอมให้บริษัทฯ เก็บ รวบรวม ใช้ เปิดเผยข้อมูลส่วนบุคคล 
                                </label>
                                <p class="text-xs text-muted mb-0">
                                    I consent to the Company collecting, using, and disclosing my personal data.
                                </p>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn bg-gradient-danger w-100 my-4 mb-2" id="registerButton">Register</button>
                            </div>

                            <div class="text-center">
                                <a class="btn bg-gradient-secondary w-100 mb-0" href="https://www.hafelethailand.com/downloads-support/warranty-conditions/" target=”_blank”>อ่านเงื่อนไขการรับประกันสินค้า คลิก</a>
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

        // Disabled registerButton
        const consentCheckbox = document.getElementById('isConsentCheckbox');
        const registerButton = document.getElementById('registerButton');
        
        if (consentCheckbox && registerButton) {
            function toggleRegisterButton() {
                registerButton.disabled = !consentCheckbox.checked;
            }
            consentCheckbox.addEventListener('change', toggleRegisterButton);
            toggleRegisterButton();
        }
    });
    

</script>
@endsection