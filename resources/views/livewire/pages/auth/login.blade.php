<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        // Get the expected role from session
        $expectedRole = session('loginRole', 'staff');
        $user = Auth::user();
        $userRole = $user->role;

        // Check if the user's role matches the expected role for this login page
        if ($userRole !== $expectedRole) {
            Auth::logout();
            
            if ($expectedRole === 'admin') {
                $this->addError('form.email', 'Access denied. This login is for administrators only.');
            } else {
                $this->addError('form.email', 'Access denied. This login is for staff members only.');
            }
            return;
        }

        // Check if the user account is active
        if ($user->status !== 'active') {
            Auth::logout();
            $this->addError('form.email', 'Your account has been deactivated. Please contact your administrator for assistance.');
            return;
        }

        Session::regenerate();

        // Redirect based on user role
        $redirectRoute = $userRole === 'staff' 
            ? route('Sales', absolute: false) 
            : route('dashboard', absolute: false);

        $this->redirectIntended(default: $redirectRoute, navigate: true);
    }
}; ?>

<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div class="text-center">
            <div class="flex justify-center">
                <div class="bg-red-600 p-3 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                </div>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">
                @if(session('loginRole') === 'admin')
                    Administrator Login
                @else
                    Staff Login
                @endif
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                @if(session('loginRole') === 'admin')
                    Access the management dashboard
                @else
                    Access your store account
                @endif
            </p>
        </div>

        <!-- Login Form -->
        <div class="bg-white py-8 px-6 shadow rounded-lg">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4 text-red-600" :status="session('status')" />

            <form wire:submit="login" class="space-y-6">
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input wire:model="form.email" id="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" type="email" name="email" required autofocus autocomplete="username" placeholder="Enter your email address" />
                    <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-red-600" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700" />
                    <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" />
                    <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded" name="remember">
                    <label for="remember" class="ml-2 block text-sm text-gray-900">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                        {{ __('Log in') }}
                    </button>
                </div>

                <!-- Back to Role Selection -->
                <div class="text-center">
                    <a href="{{ route('welcome') }}" class="text-sm text-gray-600 hover:text-gray-500 transition-colors duration-200">
                        ← Back to role selection
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
