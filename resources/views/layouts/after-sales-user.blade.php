<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-touch-icon.png" />
    <link rel="icon" type="image/png" href="/img/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/img/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/img/favicon/favicon.ico" />
    <link rel="manifest" href="/img/favicon/site.webmanifest" />
    <link href="/css/tailwind.min.css" rel="stylesheet">

    <title>Häfele Application (TH)</title>

    <script src="/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/js/plugins/chartjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        #loader-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(255, 255, 255);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 0.6s ease;
            opacity: 0.8;
        }

        .loader-spinner {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            opacity: 0.8;
        }

        @media (min-width: 768px) {
            .loader-spinner {
                width: 160px;
                height: 160px;
            }
        }

        .loader-hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen">
    <div id="loader-wrapper">
        <img src="{{ asset('img/icons/loader.gif') }}" alt="loading" class="loader-spinner">
    </div>

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
                    <h1 class="text-xl md:text-2xl font-bold">{{ date('F Y') }}</h1>
                </div>
                @yield('header-actions')
            </div>
        </div>
    </header>

    {{-- ── Content ── --}}
    <main class="p-4">
        @yield('content')
    </main>

    {{-- Preloader --}}
    <script type="text/javascript" nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        function hideLoader() {
            const loader = document.getElementById('loader-wrapper');
            loader.classList.add('loader-hidden');
            setTimeout(() => { loader.style.display = 'none'; }, 500);
        }

        window.addEventListener('load', hideLoader);

        // Hide preloader when page is restored (back/forward navigation)
        window.addEventListener('pageshow', function(e) {
            if (e.persisted) { hideLoader(); }
        });

        window.addEventListener('beforeunload', function() {
            if (typeof Swal !== 'undefined' && Swal.isVisible()) { 
                return; 
            }
            
            document.getElementById('loader-wrapper').classList.remove('loader-hidden');
            document.getElementById('loader-wrapper').style.display = 'flex';
        });
    </script>

    @stack('scripts')

</body>
</html>
