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
                timerDisplay.textContent = `Next Switch: ${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
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
