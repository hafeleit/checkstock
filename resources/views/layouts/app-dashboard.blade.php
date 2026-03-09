<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <link rel="icon" type="../image/png" href="{{ env('APP_URL') }}/img/hafele_logo.png">

    <title>@yield('title', 'After Sales Dashboard')</title>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <link href="{{ URL::to('/') }}/css/tailwind.min.css" rel="stylesheet" />

    <script src="{{ env('APP_URL') }}/assets/js/plugins/chartjs.min.js"></script>

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }

        .dashboard-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="dashboard-container">
        <nav class="bg-white shadow-sm px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">
                @yield('header', 'After Sales Service')
            </h1>
            <div id="timer-display" class="text-sm font-mono text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                Next Switch: 05:00
            </div>
        </nav>

        <main class="flex-grow p-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>

</html>
