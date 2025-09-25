@extends('layouts.app-external')

@section('content')
<div class="mx-auto">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Change Password</h1>
        </div>

        <form method="POST" action="{{ route('customer.profile.update-password', auth()->user()->id) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <input type="text" 
                name="username" 
                autocomplete="username" 
                value="{{ auth()->user()->username }}" 
                hidden>

            <!-- Current Password -->
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                    Current Password
                </label>
                <div class="relative">
                    <input type="password"
                        id="current_password"
                        name="current_password"
                        autocomplete="current-password"
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('current_password') border-red-500 @enderror"
                        placeholder="Enter your current password"
                        required>
                    <button type="button"
                        data-target="current_password"
                        class="toggle-password-btn absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none">
                        <svg id="eye-open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed" class="w-5 h-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    </button>
                </div>
                @error('current_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    New Password
                </label>
                <div class="relative">
                    <input type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                        placeholder="Enter your new password"
                        required>
                    <button type="button"
                        data-target="password"
                        class="toggle-password-btn absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none">
                        <svg id="eye-open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed" class="w-5 h-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    </button>
                    
                </div>
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Password Requirement -->
                <div id="password-requirements" class="mt-2 text-sm text-gray-500 space-y-1">
                    <p class="mb-1">Password must meet the following criteria:</p>
                    <p id="req-length" class="text-red-500">
                        <span class="inline-block w-4 h-4 mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="icon-length" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                        at least 15 characters
                    </p>
                    <p id="req-lowercase" class="text-red-500">
                        <span class="inline-block w-4 h-4 mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="icon-lowercase" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                        at least one lowercase letter
                    </p>
                    <p id="req-uppercase" class="text-red-500">
                        <span class="inline-block w-4 h-4 mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="icon-uppercase" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                        at least one uppercase letter
                    </p>
                    <p id="req-number" class="text-red-500">
                        <span class="inline-block w-4 h-4 mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="icon-number" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                        at least one number
                    </p>
                    <p id="req-special" class="text-red-500">
                        <span class="inline-block w-4 h-4 mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path id="icon-special" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </span>
                        at least one special character (!@#$%, etc.)
                    </p>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirm New Password
                </label>
                <div class="relative">
                    <input type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                        class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        placeholder="Confirm your new password"
                        required>
                    <button type="button"
                        data-target="password_confirmation"
                        class="toggle-password-btn absolute inset-y-0 right-0 pr-3 flex items-center focus:outline-none">
                        <svg id="eye-open" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="eye-closed" class="w-5 h-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    </button>
                </div>
                <p id="password-match-error" class="mt-1 text-sm text-red-600 hidden">Passwords do not match</p>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('customer.profile.show',auth()->user()->id ) }}"
                    class="px-4 py-2 text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancel
                </a>
                <button type="submit"
                    class="px-4 py-2 button-primary">
                    Change Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script nonce="{{ request()->attributes->get('csp_script_nonce') }}">
    const togglePasswordBtns = document.querySelectorAll('.toggle-password-btn');
    if (togglePasswordBtns) {
        togglePasswordBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                togglePassword(targetId, this); // Pass the button element
            });
        });
    }

    // Toggle password visibility
    function togglePassword(fieldId, button) {
        const field = document.getElementById(fieldId);
        const eyeOpen = button.querySelector('#eye-open');
        const eyeClosed = button.querySelector('#eye-closed');

        if (field.type === 'password') {
            field.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            field.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }

    // Real-time validation feedback
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('password_confirmation');
        const requirements = {
            length: document.getElementById('req-length'),
            lowercase: document.getElementById('req-lowercase'),
            uppercase: document.getElementById('req-uppercase'),
            number: document.getElementById('req-number'),
            special: document.getElementById('req-special'),
        };
        const icons = {
            length: document.getElementById('icon-length'),
            lowercase: document.getElementById('icon-lowercase'),
            uppercase: document.getElementById('icon-uppercase'),
            number: document.getElementById('icon-number'),
            special: document.getElementById('icon-special'),
        };
        const mismatchError = document.getElementById('password-match-error');

        const successIconPath = "M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z";
        const errorIconPath = "M6 18L18 6M6 6l12 12";

        function updatePasswordRequirements() {
            const value = passwordField.value;

            // At least 15 characters
            const isLengthValid = value.length >= 15;
            requirements.length.classList.toggle('text-green-500', isLengthValid);
            requirements.length.classList.toggle('text-red-500', !isLengthValid);
            icons.length.setAttribute('d', isLengthValid ? successIconPath : errorIconPath);

            // At least one lowercase letter
            const hasLowercase = /[a-z]/.test(value);
            requirements.lowercase.classList.toggle('text-green-500', hasLowercase);
            requirements.lowercase.classList.toggle('text-red-500', !hasLowercase);
            icons.lowercase.setAttribute('d', hasLowercase ? successIconPath : errorIconPath);

            // At least one uppercase letter
            const hasUppercase = /[A-Z]/.test(value);
            requirements.uppercase.classList.toggle('text-green-500', hasUppercase);
            requirements.uppercase.classList.toggle('text-red-500', !hasUppercase);
            icons.uppercase.setAttribute('d', hasUppercase ? successIconPath : errorIconPath);

            // At least one number
            const hasNumber = /[0-9]/.test(value);
            requirements.number.classList.toggle('text-green-500', hasNumber);
            requirements.number.classList.toggle('text-red-500', !hasNumber);
            icons.number.setAttribute('d', hasNumber ? successIconPath : errorIconPath);

            // At least one special character
            const hasSpecial = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(value);
            requirements.special.classList.toggle('text-green-500', hasSpecial);
            requirements.special.classList.toggle('text-red-500', !hasSpecial);
            icons.special.setAttribute('d', hasSpecial ? successIconPath : errorIconPath);
        }

        function checkPasswordMatch() {
            if (confirmField.value !== passwordField.value) {
                mismatchError.classList.remove('hidden');
                confirmField.classList.remove('border-green-500');
                confirmField.classList.add('border-red-500');
            } else {
                mismatchError.classList.add('hidden');
                confirmField.classList.remove('border-red-500');
                if (confirmField.value.length > 0) {
                    confirmField.classList.add('border-green-500');
                } else {
                    confirmField.classList.remove('border-green-500');
                }
            }
        }

        passwordField.addEventListener('input', () => {
            updatePasswordRequirements();
            checkPasswordMatch();
        });

        confirmField.addEventListener('input', checkPasswordMatch);

        // Initial check on page load
        updatePasswordRequirements();
    });
</script>
@endsection