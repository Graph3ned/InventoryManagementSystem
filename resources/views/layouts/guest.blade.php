<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Mini Store') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
                        .store-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%239C92AC' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                background-attachment: fixed;
            }
            
            .admin-theme {
                background: linear-gradient(135deg, #1a1a1a 0%, #2d3748 100%);
            }
            

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .store-icon {
                filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            }

            @media (max-width: 640px) {
                .glass-effect {
                    margin: 0 1rem;
                    padding: 1.5rem !important;
                }
            }

            @media (max-height: 700px) {
                .min-h-screen {
                    padding: 2rem 0;
                }
            }
            
            .staff-theme {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .store-icon {
                filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        @php
            $role = session('loginRole', 'staff');
        @endphp

        @if($role === 'admin')
            <!-- Admin Theme -->
            <div class="min-h-screen flex flex-col items-center justify-center store-pattern admin-theme px-4 py-6 sm:px-6 lg:px-8">
                <!-- Admin Logo -->
                <div class="mb-6 sm:mb-8">
                    <a href="/" wire:navigate class="flex flex-col items-center transform hover:scale-105 transition-transform duration-200">
                        <div class="relative">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 store-icon text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <div class="absolute -top-2 -right-2 w-5 h-5 sm:w-6 sm:h-6 bg-red-500 rounded-full flex items-center justify-center transform hover:scale-110 transition-transform duration-200">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                        </div>
                        <span class="mt-3 sm:mt-4 text-xl sm:text-2xl font-bold text-white tracking-tight">Admin Console</span>
                        <span class="text-red-400 text-xs sm:text-sm font-medium">Secure Management Portal</span>
                    </a>
                </div>

                <!-- Admin Login Form Container -->
                <div class="w-full max-w-[90vw] sm:max-w-md">
                    <div class="glass-effect rounded-lg shadow-2xl p-6 sm:p-8 text-white border border-red-500/20">
                        <div class="text-center mb-4 sm:mb-6">
                            <h2 class="text-xl sm:text-2xl font-bold text-red-400">Administrator Login</h2>
                            <p class="text-xs sm:text-sm text-gray-300 mt-1">Access the management dashboard</p>
                        </div>
                        
                        {{ $slot }}

                        <div class="mt-4 sm:mt-6 pt-4 border-t border-white/10">
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-white/60">Secure connection</span>
                                <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <!-- Staff Theme -->
                <div class="min-h-screen flex flex-col items-center justify-center store-pattern staff-theme px-4 py-6 sm:px-6 lg:px-8">
                    <!-- Staff Logo -->
                    <div class="mb-6 sm:mb-8">
                        <a href="/" wire:navigate class="flex flex-col items-center transform hover:scale-105 transition-transform duration-200">
                            <div class="relative">
                                <svg class="w-16 h-16 sm:w-20 sm:h-20 store-icon text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <div class="absolute -top-2 -right-2 w-5 h-5 sm:w-6 sm:h-6 bg-blue-400 rounded-full flex items-center justify-center transform hover:scale-110 transition-transform duration-200">
                                    <svg class="w-3 h-3 sm:w-4 sm:h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <span class="mt-3 sm:mt-4 text-xl sm:text-2xl font-bold text-white tracking-tight">Staff Portal</span>
                            <span class="text-blue-200 text-xs sm:text-sm font-medium">Store Management System</span>
                        </a>
                    </div>

                    <!-- Staff Login Form Container -->
                    <div class="w-full max-w-[90vw] sm:max-w-md">
                        <div class="glass-effect rounded-lg shadow-2xl p-6 sm:p-8 text-white border border-blue-400/20">
                            <div class="text-center mb-4 sm:mb-6">
                                <h2 class="text-xl sm:text-2xl font-bold text-blue-200">Staff Login</h2>
                                <p class="text-xs sm:text-sm text-gray-300 mt-1">Access your store account</p>
                            </div>

                            {{ $slot }}

                            <div class="mt-4 sm:mt-6 pt-4 border-t border-white/10">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-white/60">Store access</span>
                                    <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

            <!-- Back to Selection -->
            <div class="text-center mt-4 sm:mt-6">
                <a href="/" wire:navigate class="text-white/80 hover:text-white text-xs sm:text-sm inline-flex items-center justify-center gap-2 transition-all duration-200 hover:gap-3">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to role selection</span>
                </a>
            </div>

            <!-- Footer -->
            <footer class="mt-6 sm:mt-8 text-center text-white/60 text-xs sm:text-sm">
                <p>&copy; {{ date('Y') }} Mini Store. All rights reserved.</p>
            </footer>
        </div>

        @livewireScripts
    </body>
</html>
