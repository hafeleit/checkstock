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
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link href="{{ URL::to('/') }}/css/tailwind.min.css" rel="stylesheet" />

    <title>Häfele Application (TH)</title>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}" nonce="{{ request()->attributes->get('csp_script_nonce') }}"></script>

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

<body>
    <div id="loader-wrapper">
        <img src="{{ asset('img/icons/loader.gif') }}" alt="loading" class="loader-spinner">
    </div>
    
    <div class="dashboard-container">
        <nav class="sticky top-0 z-50 bg-white shadow-sm px-3 md:px-5 py-1.5 md:py-2 flex flex-col md:flex-row justify-between items-start md:items-center gap-2 md:gap-0">
            <div class="w-full md:w-auto">
                <div class="flex flex-row items-center gap-2 md:gap-3">
                    <h1 class="text-base md:text-lg font-bold text-gray-800">
                        @yield('header', 'Aftersale Service Overview')
                    </h1>
                    <div id="timer-display" class="text-xs font-mono text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full whitespace-nowrap">
                        Next Switch: 05:00
                    </div>
                    <button id="btn-next-page" class="text-xs font-semibold text-white bg-blue-500 hover:bg-blue-600 border-0 px-2 py-0.5 rounded-full whitespace-nowrap cursor-pointer">
                        Next Page →
                    </button>
                </div>
            </div>

            <div class="w-full md:w-auto">
                <div class="flex items-center justify-center gap-2 px-3 py-1 border border-gray-400 rounded-xl w-full md:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="red" class="bi bi-calendar-event" viewBox="0 0 16 16">
                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                    </svg>
                    <h1 class="text-xl md:text-2xl font-bold">{{ date('F Y') }}</h1>
                </div>
            </div>
        </nav>

        <main class="flex-1 min-h-0 p-2.5 bg-gray-200 overflow-hidden">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    <script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
        document.addEventListener('DOMContentLoaded', function() {
            const storageKey = 'active_dashboard_id';
            const timerDisplay = document.getElementById('timer-display');
            let activeId = localStorage.getItem(storageKey) || 'dashboard-1';

            const activeView = document.getElementById(activeId);
            if (activeView) {
                activeView.classList.add('active');
            } else {
                document.getElementById('dashboard-1').classList.add('active');
                activeId = 'dashboard-1';
            }

            function switchPage() {
                const nextId = (activeId === 'dashboard-1') ? 'dashboard-2' : 'dashboard-1';
                localStorage.setItem(storageKey, nextId);
                window.location.reload();
            }

            let timeLeft = 5 * 60;
            const countdown = setInterval(function() {
                timeLeft--;
                const mins = Math.floor(timeLeft / 60);
                const secs = timeLeft % 60;
                timerDisplay.textContent = `Next Switch: ${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                if (timeLeft <= 0) {
                    clearInterval(countdown);
                    switchPage();
                }
            }, 1000);

            document.getElementById('btn-next-page').addEventListener('click', function() {
                clearInterval(countdown);
                switchPage();
            });
        });

        // Preloader
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
</body>

</html>
