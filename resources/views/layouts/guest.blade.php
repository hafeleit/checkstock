<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/hafele_logo.png">
    <link rel="icon" type="image/png" href="/img/hafele_logo.png">

    <title>
        EXTERNAL SYSTEM
    </title>

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <link href="{{ URL::to('/') }}/css/tailwind.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="/assets/css/external.css">
</head>

<body class="font-sans text-gray-900 antialiased">
    @yield('content')
</body>

</html>
