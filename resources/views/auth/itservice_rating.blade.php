@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
      <style media="screen">

      @media (min-width: 992px) {
          .rate_cus {
              transform: translate(-15%, -16%) !important;
          }
      }

      .rate_cus {
          transform: translate(-18%, -16%);
      }


      .rate {
          height: 80px;
          padding: 0 10px;
      }
      .rate:not(:checked) > input {
          position:absolute;
          bottom: -226px;
          left: -1105px;
      }
      .rate:not(:checked) > label {
          float:right;
          width:1em;
          overflow:hidden;
          white-space:nowrap;
          cursor:pointer;
          font-size:40px;
          color:#ccc;
      }
      .rate:not(:checked) > label:before {
          content: '★ ';
      }
      .rate > input:checked ~ label {
          color: #ffc700;
      }
      .rate:not(:checked) > label:hover,
      .rate:not(:checked) > label:hover ~ label {
          color: #deb217;
      }
      .rate > input:checked + label:hover,
      .rate > input:checked + label:hover ~ label,
      .rate > input:checked ~ label:hover,
      .rate > input:checked ~ label:hover ~ label,
      .rate > label:hover ~ input:checked ~ label {
          color: #c59b08;
      }

      /* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */


    </style>
    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-cover.jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Welcome!</h1>
                        <p class="text-lead text-white">IT Service Rating</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-header text-center pt-4">
                            <h5>ให้คะแนน IT Service</h5>
                            <h6 >Service Name: <label class="text-danger text-lg">{{$data['task_name']}}</label></h6>
                        </div>
                        <form method="POST" action="{{ route('save-itservice-rating',$data['task_id']) }}">
                          @csrf
                          <input type="hidden" name="task_assign_id" value="{{$data['task_assign_id']}}">
                        <div class="">

                          <div class="rate rate_cus" style="">
                              <input type="radio" id="star5" name="rating" value="5" checked />
                              <label for="star5" title="text">5 stars</label>
                              <input type="radio" id="star4" name="rating" value="4" />
                              <label for="star4" title="text">4 stars</label>
                              <input type="radio" id="star3" name="rating" value="3" />
                              <label for="star3" title="text">3 stars</label>
                              <input type="radio" id="star2" name="rating" value="2" />
                              <label for="star2" title="text">2 stars</label>
                              <input type="radio" id="star1" name="rating" value="1" />
                              <label for="star1" title="text">1 star</label>
                            </div>

                            <div class="mt-2 position-relative text-center">
                                <p
                                    class="text-sm font-weight-bold mb-2 text-secondary text-border d-inline z-index-2 bg-white px-3">
                                    Comment
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                          <div class="flex flex-col mb-3">
                              <textarea class="form-control" id="comment_text" name="comment_text" rows="3"></textarea>
                          </div>

                          <div class="text-center">
                              <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Send</button>
                          </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection
