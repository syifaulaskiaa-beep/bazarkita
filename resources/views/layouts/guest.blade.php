<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BazarKita') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,700&family=Instrument+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Scripts (Tailwind CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tinta: '#0F2B46',
                        emas: '#D89B3C',
                        krem: '#FAF6F0',
                    },
                    fontFamily: {
                        judul: ['"Bricolage Grotesque"', 'sans-serif'],
                        isi: ['"Instrument Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-isi text-tinta antialiased bg-krem">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-tinta to-[#1a4a6e]">
        
        <!-- Logo BazarKita -->
        <div class="mb-8">
            <a href="/" class="font-judul text-4xl font-bold text-white tracking-wider">
                Bazar<span class="text-emas">Kita</span>
            </a>
        </div>

        <!-- Kotak Form Login/Register -->
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>

        <!-- Footer -->
        <div class="mt-8 text-sm text-gray-300">
            &copy; 2026 BazarKita. Sistem Informasi Bazar.
        </div>
    </div>
</body>
</html>