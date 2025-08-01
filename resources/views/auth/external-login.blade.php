@extends('layouts.guest')

@section('content')
<main class="main-content">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <!-- Header -->
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900">Welcome</h1>
                <p class="mt-2 text-sm text-gray-600">Sign in to your account to continue</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('external.login') }}" class="space-y-4">
                @csrf
                <div class="space-y-2">
                    <label for="email" class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email address
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter your email" class="w-full h-11 px-3 py-2 border border-gray-300 rounded-md shadow-sm @error('email') border-red-500 @enderror">
                    @error('email')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="space-y-2">
                    <label for="password" class="flex items-center gap-2 text-sm font-medium text-gray-700">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Password
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required placeholder="Enter your password" class="w-full h-11 px-3 py-2 pr-10 border border-gray-300 rounded-md shadow-sm @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword()" class="absolute right-0 top-0 h-full px-3 py-2 text-gray-400 hover:text-gray-600 focus:outline-none">
                            <svg id="eye-open" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg id="eye-closed" class="h-4 w-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }} class="h-4 w-4 text-blue-600  rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-600">
                            Remember me
                        </label>
                    </div>
                    <!-- <a href="#" class="text-sm text-blue-600 hover:text-blue-500 hover:underline">
                        Forgot password?
                    </a> -->
                </div>

                <button type="submit" class="w-full h-11 flex items-center justify-center gap-2 px-4 py-2 button-primary rounded-md disabled:cursor-not-allowed">
                    Sign in
                </button>
            </form>
        </div>
    </div>
</main>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eye-open');
        const eyeClosed = document.getElementById('eye-closed');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            passwordInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>

@endsection