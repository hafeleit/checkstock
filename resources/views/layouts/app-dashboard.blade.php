<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'After Sales Dashboard')</title>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <link rel="icon" type="image/png" href="{{ env('APP_URL') }}/img/hafele_logo.png">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link href="{{ URL::to('/') }}/css/tailwind.min.css" rel="stylesheet" />

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ env('APP_URL') }}/assets/js/plugins/chartjs.min.js"></script>

    @stack('styles')
</head>

<body>
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
                    <h1 class="text-xl md:text-2xl font-bold">{{ date('F') }}</h1>
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
    </script>
</body>

</html>
