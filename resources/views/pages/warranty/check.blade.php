@extends('layouts.appform')

@section('content')
<!-- End Navbar -->
<style media="screen">
  #fullpage {
    display: none;
    position: absolute;
    z-index: 9999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    max-height: 100%;
    background-size: contain;
    background-repeat: no-repeat no-repeat;
    background-position: center center;
    background-color: black;
  }
</style>

<main class="main-content  mt-0">
  <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('/img/bg_warranty.jpg'); background-position: top;">
    <div style="width: 100%;z-index: 9;text-align: center;">
      <img src="/img/hafele_logo_white.png" style="z-index: 9;width: 250px;">
    </div>
    <span class="mask bg-primary opacity-6"></span>
  </div>
  <div class="container">
    <div class="row mt-lg-n12 mt-md-n11 mt-n10 justify-content-center">
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
                <label class="img text-sm">Search serial no or phone number<span class="text-danger"></span></label>
                <input id="search" name="search" type="text" class="form-control" placeholder="serial no or phone number">
              </div>
              <div class="card-body p-0 pb-0" id="get_warranty">
              </div>
              <div class="text-center">
                <button id="btn_search" type="button" class="btn bg-gradient-success w-100 my-4 mb-2">Search</button>
              </div>

            </form>
          </div>
        </div>
        <div id="fullpage" onclick="this.style.display='none';"></div>
      </div>
    </div>
  </div>
</main>
<script type="text/javascript">
  $(function() {

    $("#btn_search").on("click", function() {
      let search = $('#search').val();
      $.ajax({
        method: "GET",
        url: "{{ route('warranty.search_warranty') }}",
        data: {
          _token: '{{csrf_token()}}',
          search: search,
        }
      }).done(function(msg) {
        //console.log(msg);
        $('#get_warranty').html(msg);

        $(".img").click(function() {
          window.scrollTo(0, 0);
          let img_src = $(this).attr('src');
          $("#fullpage").css("background-image", "url(" + img_src + ")");
          $("#fullpage").css("display", "block");
        });

      });

    });



  });

  /*function getPics() {} //just for this demo
    const imgs = document.querySelectorAll('.gallery img');
    const fullPage = document.querySelector('#fullpage');

    imgs.forEach(img => {
      img.addEventListener('click', function() {
        fullPage.style.backgroundImage = 'url(' + img.src + ')';
        fullPage.style.display = 'block';
      });
  });*/
</script>
@endsection