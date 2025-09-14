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
        {{ $slot }}

        @livewireScripts
    </body>
</html>
