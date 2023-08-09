@extends('layouts.appform')

@section('content')
<!-- End Navbar -->
<main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
      <div style="width: 100%;z-index: 9;text-align: center;">
        <img src="https://www.hafelethailand.com/wp-content/uploads/2022/10/cropped-Hafele-Logo-white.png" style="z-index: 9;width: 250px;">
      </div>
      <span class="mask bg-primary opacity-6" style=""></span>
    </div>
    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-7 mx-auto">

                <div class="card z-index-0">
                  <div class="text-center">
                      <a href="{{route('register-warranty.index')}}"><button type="button" class="btn bg-gradient-danger w-50 my-4 mb-2">Register Warranty</button></a>

                  </div>

                    <div class="card-header text-center pt-4">
                        <h3>Check Warranty</h3>
                    </div>
                    <hr class="horizontal dark mt-0">
                    <div class="card-body">
                        <form role="form">
                            <div class="mb-3">
                                <label class="text-sm">Search Order number<span class="text-danger"></span></label>
                                <input type="text" class="form-control" placeholder="ex SO_WEB2300011496">
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn bg-gradient-success w-100 my-4 mb-2">Search</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
