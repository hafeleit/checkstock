<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/hafele_logo.png">
    <link rel="icon" type="image/png" href="/img/hafele_logo.png">
    <title>
        HAFELE APPLICATION
    </title>

    <link href="{{ asset('css/fonts.googleapis.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.all.min.css') }}" rel="stylesheet">
    <!-- Nucleo Icons -->
    <link href="{{ URL::to('/') }}/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ URL::to('/') }}/assets/css/nucleo-svg.css" rel="stylesheet" />

    <link href="{{ URL::to('/') }}/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ URL::to('/') }}/assets/css/argon-dashboard.css" rel="stylesheet" />

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/buttons.github.js') }}"></script>
</head>

<body class="{{ $class ?? '' }} g-sidenav-hidden">

    @guest
    @yield('content')
    @endguest

    @auth
    @if (in_array(request()->route()->getName(), ['sign-in-static', 'sign-up-static', 'login', 'register','change-password', 'recover-password', 'rtl', 'virtual-reality']))
    @yield('content')
    @else
    @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
    <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('/img/bg-hafele.jpg'); background-position-y: 30%; background-position-x: 30%;">
        <span class="mask bg-gradient-faded-dark-vertical opacity-3"></span>
    </div>
    @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
    <div class="position-absolute w-100 min-height-300 top-0" style="background-image: url('/img/bg-hafele.jpg'); background-position-y: 32%; background-position-x: 30%;">
        <span class="mask bg-gradient-faded-dark-vertical opacity-3"></span>
    </div>
    @endif
    @include('layouts.navbars.auth.sidenav')
    <main class="main-content border-radius-lg">
        @yield('content')
    </main>
    @include('components.fixed-plugin')
    @endif
    @endauth

    <!--   Core JS Files   -->
    <script src="{{ URL::to('/') }}/assets/js/core/popper.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="{{ URL::to('/') }}/assets/js/plugins/flatpickr.min.js"></script>

    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script src="{{ URL::to('/') }}/assets/js/argon-dashboard.js"></script>
    @stack('js')
</body>

</html>
