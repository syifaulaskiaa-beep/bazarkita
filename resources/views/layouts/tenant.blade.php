<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant - BazarKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;12..96,700&family=Instrument+Sans:wght@400;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { tinta: '#0F2B46', emas: '#D89B3C', krem: '#FAF6F0' },
                    fontFamily: { judul: ['"Bricolage Grotesque"', 'sans-serif'], isi: ['"Instrument Sans"', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="font-isi bg-gray-50 text-tinta flex h-screen overflow-hidden">

    <!-- SIDEBAR TENANT -->
    <aside id="sidebar" class="w-64 bg-tinta text-white flex-col absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out z-30 flex">
        <div class="h-16 flex items-center justify-center border-b border-gray-700">
            <h1 class="font-judul text-2xl font-bold tracking-wider">Bazar<span class="text-emas">Kita</span></h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-emas text-tinta font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('tenant.event') }}" class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('tenant.event') || request()->routeIs('tenant.daftar') ? 'bg-emas text-tinta font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Event Tersedia
            </a>
            <a href="{{ route('tenant.status') }}" class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('tenant.status') ? 'bg-emas text-tinta font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                Pendaftaran Saya
            </a>
            <a href="{{ route('tenant.produk') }}" class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('tenant.produk') ? 'bg-emas text-tinta font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Katalog Produk
            </a>
            <a href="{{ route('tenant.notifikasi') }}" class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('tenant.notifikasi') ? 'bg-emas text-tinta font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                Notifikasi
            </a>
            <a href="{{ route('tenant.profil') }}" class="flex items-center px-4 py-2 rounded-lg transition {{ request()->routeIs('tenant.profil') ? 'bg-emas text-tinta font-semibold' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profil Usaha
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <form method="POST" action="/logout">
                @csrf
                <button class="w-full text-left px-4 py-2 text-red-300 hover:bg-gray-700 rounded-lg transition flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div id="overlay" class="fixed inset-0 bg-black opacity-50 z-20 hidden md:hidden" onclick="toggleSidebar()"></div>

    <div class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 md:px-8">
            <div class="flex items-center space-x-4">
                <button onclick="toggleSidebar()" class="text-tinta md:hidden focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h2 class="font-bold text-lg">Dashboard Tenant</h2>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-sm font-semibold hidden sm:block">{{ auth()->user()->name }}</span>
                <div class="w-10 h-10 bg-emas rounded-full flex items-center justify-center text-white font-bold">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>
        <main class="p-4 md:p-8">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('overlay').classList.toggle('hidden');
        }
    </script>
</body>
</html>