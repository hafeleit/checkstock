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
        <nav class="sticky top-0 z-50 bg-white shadow-sm px-4 md:px-6 py-3 md:py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
            <div class="w-full md:w-auto">
                <h1 class="text-lg md:text-xl font-bold text-gray-800">
                    @yield('header', 'Aftersale Service Overview')
                </h1>
                <div class="flex flex-col md:flex-row items-start md:items-center gap-2 md:gap-3 mt-2 md:mt-0">
                    <small class="text-gray-500 text-xs md:text-sm">Monitor key performance indicators and customer satisfaction.</small>
                    <div id="timer-display" class="text-xs font-mono text-blue-600 bg-blue-50 px-3 py-1 rounded-full whitespace-nowrap">
                        Next Switch: 05:00
                    </div>
                </div>
            </div>

            <div class="w-full md:w-auto">
                <div class="flex items-center justify-center gap-2 md:gap-3 px-4 md:px-6 py-2 border border-gray-400 rounded-xl w-full md:w-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" md:width="20" md:height="20" fill="red" class="bi bi-calendar-event" viewBox="0 0 16 16">
                        <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
                    </svg>
                    <h1 class="text-2xl md:text-3xl font-bold">{{ date('F') }}</h1>
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
            const totalTime = 5 * 60;
            let timeLeft = totalTime;
            const storageKey = 'active_dashboard_id';
            const timerDisplay = document.getElementById('timer-display');

            // ตรวจสอบสถานะจากครั้งก่อน
            let activeId = localStorage.getItem(storageKey) || 'dashboard-1';

            // แสดง Dashboard
            const activeView = document.getElementById(activeId);
            if (activeView) {
                activeView.classList.add('active');
            } else {
                document.getElementById('dashboard-1').classList.add('active');
                activeId = 'dashboard-1';
            }

            // ฟังก์ชันอัปเดตตัวเลขหน้าจอ
            function updateDisplay(seconds) {
                const mins = Math.floor(seconds / 60);
                const secs = seconds % 60;
                timerDisplay.textContent =
                    `Next Switch: ${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
            }

            // เริ่มนับถอยหลัง
            const countdown = setInterval(function() {
                timeLeft--;
                updateDisplay(timeLeft);

                if (timeLeft <= 0) {
                    clearInterval(countdown);

                    const nextId = (activeId === 'dashboard-1') ? 'dashboard-2' : 'dashboard-1';
                    localStorage.setItem(storageKey, nextId);

                    window.location.reload();
                }
            }, 1000);

            updateDisplay(timeLeft);
        });
    </script>
</body>

</html>
