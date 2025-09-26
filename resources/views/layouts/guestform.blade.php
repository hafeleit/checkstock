<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Hafele E-Tax Invoice')</title>

    <link href="{{ URL::to('/') }}/css/tailwind.min.css" rel="stylesheet" />

    <style nonce="{{ request()->attributes->get('csp_style_nonce') }}">
        .bg-gradient {
            background: #EEAECA;
            background: radial-gradient(circle, rgba(238, 174, 202, 1) 0%, rgba(148, 187, 233, 1) 100%);
        }
    </style>
</head>

<body class="bg-gradient min-h-screen flex flex-col">

    <header class="text-center text-white py-6 border-b border-white">
        <h1 class="text-xl sm:text-3xl font-bold">Hafele E-Tax Invoice Form</h1>
    </header>

    <main class="container mx-auto flex-1 p-4 md:p-8">
        <div class="bg-white backdrop-blur-sm rounded-lg p-6 shadow-xl max-w-3xl mx-auto">
            @yield('content')
        </div>
    </main>

    <footer class="text-center py-4 text-sm text-white">
        &copy; {{ date('Y') }} Hafele. All Rights Reserved.
    </footer>

</body>

</html>
