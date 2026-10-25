<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BazarKita - Satu tempat untuk bazar dan tenantnya</title>
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
<body class="font-isi bg-krem text-tinta">

    <!-- Navbar -->
    <nav class="bg-tinta text-white p-4 absolute top-0 w-full z-20">
        <div class="max-w-6xl mx-auto flex justify-between items-center">
            <h1 class="font-judul text-2xl font-bold tracking-wider">Bazar<span class="text-emas">Kita</span></h1>
            <div class="space-x-4">
                <a href="/" class="hover:text-emas">Beranda</a>
                <a href="/login" class="bg-emas text-tinta px-4 py-2 rounded font-bold hover:bg-yellow-500 transition">Masuk</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section dengan Gambar Tenda Bazar -->
    <header class="bg-tinta text-white pt-32 pb-24 text-center relative overflow-hidden">
        <!-- Gambar Background Tenda Bazar -->
        <div class="absolute inset-0 opacity-40 bg-[url('https://images.unsplash.com/photo-1531058020387-3be344556be6?q=80&w=1920&auto=format&fit=crop')] bg-cover bg-center"></div>

        <div class="max-w-4xl mx-auto px-4 relative z-10">
            <h2 class="font-judul text-5xl md:text-6xl font-bold leading-tight mb-6">
                Satu tempat untuk <br> <span class="text-emas">bazar dan tenantnya.</span>
            </h2>
            <p class="text-lg md:text-xl text-gray-200 mb-8 max-w-2xl mx-auto">
                BazarKita memudahkan pelaku UMKM mendaftar bazar, memilih booth, dan memantau status pendaftaran secara online.
            </p>
            <a href="/register" class="bg-emas text-tinta px-8 py-3 rounded-full font-bold text-lg hover:bg-yellow-500 transition shadow-lg inline-block">
                Daftar sebagai Tenant
            </a>
        </div>
        <!-- Efek lengkungan bawah -->
        <div class="absolute bottom-0 w-full overflow-hidden leading-none z-10">
            <svg class="relative block w-full h-12" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V95.8C59.71,118.08,130.83,120.87,196.09,109.55Z" fill="#FAF6F0"></path>
            </svg>
        </div>
    </header>

    <!-- Section Event -->
    <main class="max-w-6xl mx-auto px-4 py-16 relative z-10">
        <h3 class="font-judul text-3xl font-bold mb-8 text-center">Event Bazar Terdekat</h3>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Kartu Event 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="h-40 bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-emas uppercase tracking-wide">Kuliner</span>
                    <h4 class="font-judul text-xl font-bold mt-2">Bazar UMKM Aceh 2026</h4>
                    <p class="text-gray-600 mt-2 text-sm">Banda Aceh, 20 - 23 Nov 2026</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="font-bold text-tinta">Rp 150.000</span>
                        <a href="/login" class="text-emas font-semibold hover:underline">Daftar &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Event 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="h-40 bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1528698827591-e19ccd7bc23d?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-emas uppercase tracking-wide">Kriya</span>
                    <h4 class="font-judul text-xl font-bold mt-2">Pasar Kriya Gayo Festival</h4>
                    <p class="text-gray-600 mt-2 text-sm">Takengon, 15 - 18 Des 2026</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="font-bold text-tinta">Rp 100.000</span>
                        <a href="/login" class="text-emas font-semibold hover:underline">Daftar &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Kartu Event 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="h-40 bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=600&auto=format&fit=crop" class="w-full h-full object-cover">
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-emas uppercase tracking-wide">Umum</span>
                    <h4 class="font-judul text-xl font-bold mt-2">Festival Kuliner Rakyat</h4>
                    <p class="text-gray-600 mt-2 text-sm">Lhokseumawe, 10 - 12 Jan 2027</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="font-bold text-tinta">Gratis</span>
                        <a href="/login" class="text-emas font-semibold hover:underline">Daftar &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-tinta text-gray-400 py-8 text-center mt-12">
        <p>&copy; 2026 BazarKita. Sistem Informasi Pengelolaan Bazar dan Pendaftaran Tenant.</p>
    </footer>

</body>
</html>