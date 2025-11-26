<x-guest-layout>
    <div class="min-h-screen bg-bg-secondary flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Header Section -->
            <div class="text-center">
                <x-application-logo class="mx-auto h-16 w-auto" />
                <h2 class="mt-6 text-3xl font-bold text-text-primary">
                    Welcome back
                </h2>
                <p class="mt-2 text-sm text-text-secondary">
                    Sign in to your PayerReady account
                </p>
            </div>

            <!-- Login Card -->
            <div class="bg-white rounded-xl shadow-lg border border-border p-8">
                <!-- Success Message -->
                @session('status')
                    <div class="mb-6 bg-success-50 border border-success-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-success-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-success-800 text-sm">{{ $value }}</p>
                        </div>
                    </div>
                @endsession

                <!-- Error Message -->
                @session('error')
                    <div class="mb-6 bg-error-50 border border-error-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-error-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-error-800 text-sm">{{ $value }}</p>
                        </div>
                    </div>
                @endsession

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 bg-error-50 border border-error-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-error-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div>
                                <h3 class="text-error-800 font-medium text-sm">Please correct the following errors:</h3>
                                <ul class="mt-1 text-error-700 text-sm list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Field -->
                    <div>
                        <x-ui.label for="email">Email Address</x-ui.label>
                        <x-ui.input
                            id="email"
                            type="email"
                            name="email"
                            :value="old('email')"
                            placeholder="Enter your email address"
                            :invalid="$errors->has('email')"
                            required
                            autofocus
                            autocomplete="username"
                        />
                        <x-ui.error name="email" />
                    </div>

                    <!-- Password Field -->
                    <div>
                        <x-ui.label for="password">Password</x-ui.label>
                        <x-ui.input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Enter your password"
                            :invalid="$errors->has('password')"
                            required
                            autocomplete="current-password"
                            revealable
                        />
                        <x-ui.error name="password" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="flex items-center">
                            <input
                                id="remember_me"
                                name="remember"
                                type="checkbox"
                                class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                            >
                            <span class="ml-2 text-sm text-text-secondary">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors"
                            >
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <x-ui.button type="submit" color="teal" class="w-full justify-center">
                            <span wire:loading.remove wire:target="login">Sign In</span>
                            <span wire:loading wire:target="login" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Signing in...   
                            </span>
                        </x-ui.button>
                    </div>
                </form>

                <!-- Sign Up Link -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-text-secondary mb-3">
                        Don't have an account?
                    </p>
                    <x-ui.button as="a" href="{{ route('register') }}" wire:navigate color="teal" class="w-full justify-center text-green">
                        Sign up for free
                    </x-ui.button>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="text-center">
                <p class="text-xs text-text-tertiary">
                    By signing in, you agree to our
                    <a href="#" class="text-primary-600 hover:text-primary-700 transition-colors">Terms of Service</a>
                    and
                    <a href="#" class="text-primary-600 hover:text-primary-700 transition-colors">Privacy Policy</a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
