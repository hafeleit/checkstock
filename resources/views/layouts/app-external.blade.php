<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/hafele_logo.png">
    <link rel="icon" type="image/png" href="/img/hafele_logo.png">

    <title>Product Information System</title>

    <script src="{{ asset('js/alpinejs.csp.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <link href="{{ URL::to('/') }}/css/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/external.css">
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="navbar bg-white shadow-sm border-b sticky top-0 z-50">
        <div class="flex items-center justify-between py-5">
            <a href="/customer/products" class="flex gap-4 items-center px-6 md:px-4">
                <img src="/img/hafele_logo.png" class="w-5 h-5">
                <h1 class="text-sm md:text-xl font-bold text-gray-800">Product Information System</h1>
            </a>

            <!-- User Dropdown -->
            <div class="hidden md:inline-block px-4" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                    <span class="text-sm font-bold">{{ auth()->user()->username }}</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open"
                    @click.away="open = false"
                    x-transition
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <a href="{{ route('customer.profile.show', auth()->user()->id) }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <a href="{{ route('customer.profile.change-password') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Change Password
                    </a>
                    <form method="POST" action="{{ route('customer.logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center w-full text-left px-4 py-2 text-sm text-primary-700 hover:bg-gray-100">
                            <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                            </svg>
                            <p>Sign out</p>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar: Moblie -->
            <div class="flex items-center md:hidden px-6">
                <button id="hamburger-button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div id="mobile-sidebar" class="fixed inset-y-0 left-0 w-64 py-5 flex flex-col justify-between bg-primary-700 text-white transform -translate-x-full transition-transform duration-300 ease-in-out shadow-lg">
                    <div>
                        <div class="flex items-center gap-2 border-b py-4 mx-4">
                            <h2 class="text-md font-semibold">{{ auth()->user()->username }}</h2>
                        </div>

                        <nav class="mt-4">
                            <div class="px-4 py-2">
                                <h3 class="text-xs font-ligth text-white uppercase tracking-wider">Main Menu</h3>
                            </div>
                            <a href="{{ route('customer.products.index') }}" class="block font-semibold px-4 py-2 hover:bg-red-800 flex items-center">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Products
                            </a>
                        </nav>
                    </div>
                    <nav class="mt-4">
                        <div class="px-4 py-2">
                            <h3 class="text-xs font-ligth text-white uppercase tracking-wider">Account</h3>
                        </div>
                        <a href="{{ route('customer.profile.show', auth()->user()->id) }}" class="block font-semibold px-4 py-2 hover:bg-red-800 flex items-center">
                            <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Profile
                        </a>
                        <a href="{{ route('customer.profile.change-password') }}" class="block font-semibold px-4 py-2 hover:bg-red-800 flex items-center">
                            <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                            </svg>

                            Change Password
                        </a>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full font-semibold px-4 py-2 hover:bg-red-800 flex items-center">
                                <svg class="w-4 h-4 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25" />
                                </svg>
                                <p>Sign out</p>
                            </button>
                        </form>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">
        @if (auth()->user()->type !== 'customer')
        <!-- Sidebar: Desktop -->
        <div class="hidden md:block w-64 bg-white shadow-lg">
            <nav class="mt-4 z-50">
                <div class="px-4 py-2">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Main Menu</h3>
                </div>

                <!-- Product Menu -->
                <a href="{{ route('customer.products.index') }}"
                    class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 {{ request()->routeIs('customer.products.*') ? 'bg-primary-50 text-primary-700 border-r-2 border-primary-700' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Products
                </a>
            </nav>
        </div>
        @endif

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-auto">
            <!-- Page Content -->
            <main class="flex-1 p-6">
                @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')

                @yield('scripts')
            </main>
        </div>
    </div>
</body>

</html>

<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    document.addEventListener('DOMContentLoaded', function() {
        const hamburgerBtn = document.getElementById('hamburger-button');
        const sidebar = document.getElementById('mobile-sidebar');

        hamburgerBtn.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
    });
</script>
