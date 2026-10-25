@extends('layouts.admin')

@section('content')
    <!-- Header Halaman -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="font-judul text-3xl font-bold text-tinta">Ikhtisar BazarKita</h1>
            <p class="text-gray-500 mt-1">Pantau aktivitas event, pendaftaran, dan pembayaran secara real-time.</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Hari ini</p>
            <p class="font-bold text-tinta">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
    </div>

    <!-- Kotak Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Event -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-500 text-sm font-semibold mb-1">Total Event</p>
                <h3 class="text-4xl font-bold text-tinta">{{ $totalEvent }}</h3>
            </div>
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-500 text-sm font-semibold mb-1">Menunggu Verifikasi</p>
                <h3 class="text-4xl font-bold text-tinta">{{ $menungguVerifikasi }}</h3>
            </div>
            <div class="w-14 h-14 bg-orange-50 rounded-2xl flex items-center justify-center text-orange-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-500 text-sm font-semibold mb-1">Disetujui</p>
                <h3 class="text-4xl font-bold text-tinta">{{ $disetujui }}</h3>
            </div>
            <div class="w-14 h-14 bg-green-50 rounded-2xl flex items-center justify-center text-green-500">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Pembayaran Lunas -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition">
            <div>
                <p class="text-gray-500 text-sm font-semibold mb-1">Pembayaran Lunas</p>
                <h3 class="text-4xl font-bold text-tinta">{{ $lunas }}</h3>
            </div>
            <div class="w-14 h-14 bg-emas/10 rounded-2xl flex items-center justify-center text-emas">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Area Grafik Chart.js -->
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="font-bold text-xl text-tinta">Aktivitas Pendaftaran per Event</h3>
                <p class="text-sm text-gray-500 mt-1">Jumlah tenant yang mendaftar di setiap event bazar.</p>
            </div>
            <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-semibold">Real-time Data</span>
        </div>
        <div class="h-80 w-full">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <!-- Panggil Library Chart.js via CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('myChart').getContext('2d');
            
            // Gradient warna emas untuk grafik
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, '#D89B3C'); // Emas terang
            gradient.addColorStop(1, '#B87A22'); // Emas gelap

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Jumlah Pendaftar',
                        data: @json($chartData),
                        backgroundColor: gradient,
                        borderColor: '#0F2B46',
                        borderWidth: 1,
                        borderRadius: 8, // Sudut grafik melengkung
                        barThickness: 50, // Ketebalan batang grafik
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                font: { family: 'Instrument Sans', size: 12 }
                            },
                            grid: {
                                display: true,
                                color: '#f3f4f6'
                            }
                        },
                        x: {
                            ticks: {
                                font: { family: 'Instrument Sans', size: 12 }
                            },
                            grid: { display: false }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
@endsection