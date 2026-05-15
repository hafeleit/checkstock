<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'After-Sales Overview')</title>

    <link rel="icon" type="image/png" href="/img/hafele_logo.png">
    <link href="/css/tailwind.min.css" rel="stylesheet">

    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>

    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- ── Navbar ── --}}
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-md">
        <div class="px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="/img/hafele_logo.png" class="w-8 h-8" alt="Hafele">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800 leading-none">After-Sales Overview</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex items-center justify-center gap-2 px-3 py-1 border border-gray-400 rounded-xl w-full md:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-calendar-event" viewBox="0 0 16 16">
                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                    </svg>
                    <h1 class="text-xl md:text-2xl font-bold">{{ date('F') }}</h1>
                </div>
                @yield('header-actions')
            </div>
        </div>
    </header>

    {{-- ── Content ── --}}
    <main class="p-4">
        @yield('content')
    </main>

    @stack('scripts')

</body>
</html>
