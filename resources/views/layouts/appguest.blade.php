<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <link rel="icon" type="../image/png" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <title>
        HAFELE APPLICATION
    </title>
    <!--     Fonts and icons-->

    <!-- Nucleo Icons -->
    <link href="{{ env('APP_URL') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ env('APP_URL') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->

    <link href="{{ env('APP_URL') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ env('APP_URL') }}/assets/css/argon-dashboard.css" rel="stylesheet" />

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
</head>

<body class="{{ $class ?? '' }} g-sidenav-hidden">
    @guest
        @if (in_array(request()->route()->getName(), ['products.index','so-status.index','so-status.show','sales-usi.index']))
        <div class="position-absolute w-100 top-0" style="background-image: url('/img/bg-hafele2.jpg'); background-position-y: 12%; background-position-x: 30%; height:100%">
            <span class="bg-primary opacity-2"></span>
        </div>
        @else
          @if (in_array(request()->route()->getName(), ['clr_dashboard']))
          <div class="min-height-600 bg-success position-absolute w-100"></div>
          @endif
        @endif

        @yield('content')
    @endguest

    @auth
        @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register', 'recover-password', 'rtl', 'virtual-reality']))
            @yield('content')
        @else
            @if (!in_array(request()->route()->getName(), ['profile', 'profile-static','products.index']))
                <div class="min-height-300 bg-success position-absolute w-100"></div>
            @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile','products.index']))
                <div class="position-absolute w-100 min-height-300 top-0">
                    <span class="bg-primary opacity-6"></span>
                </div>
            @endif

                <main class="main-content border-radius-lg">
                    @yield('content')
                </main>

        @endif
    @endauth

    <!--   Core JS Files   -->
    <script src="{{ env('APP_URL') }}/assets/js/core/popper.min.js"></script>
    <script src="{{ env('APP_URL') }}/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ env('APP_URL') }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ env('APP_URL') }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ env('APP_URL') }}/assets/js/argon-dashboard.js"></script>
    @stack('js');
</body>

</html>
