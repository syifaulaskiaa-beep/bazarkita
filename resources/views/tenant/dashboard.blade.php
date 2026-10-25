@extends('layouts.tenant')

@section('content')
    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mb-6">
        <h1 class="font-judul text-3xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}! 👋</h1>
        
        @if($tenant)
            <p class="text-gray-600 mb-4">Profil usaha kamu (<strong>{{ $tenant->nama_usaha }}</strong>) sudah lengkap dan siap digunakan.</p>
            
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                <p class="text-sm text-green-800 font-semibold">Profil usaha sudah aktif!</p>
                <p class="text-sm text-green-700 mt-1">Kamu sekarang bisa mendaftar ke event bazar yang tersedia.</p>
            </div>
        @else
            <p class="text-gray-600 mb-4">Silakan lengkapi profil usaha kamu terlebih dahulu.</p>
            <div class="bg-yellow-50 border-l-4 border-emas p-4 mb-6">
                <p class="text-sm text-yellow-800 font-semibold">Profil usaha kamu belum lengkap!</p>
            </div>
            <a href="{{ route('tenant.profil') }}" class="inline-block bg-emas text-tinta px-6 py-3 rounded-lg font-bold hover:bg-yellow-500 transition">
                Lengkapi Profil Usaha
            </a>
        @endif
    </div>

    @if($tenant)
    <!-- KOTAK STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-tinta flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Produk</p>
                <h3 class="text-3xl font-bold mt-1">{{ $totalProduk }}</h3>
            </div>
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-tinta">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-emas flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Pendaftaran Event</p>
                <h3 class="text-3xl font-bold mt-1">{{ $totalPendaftaran }}</h3>
            </div>
            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-emas">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            </div>
        </div>
    </div>

    <!-- PENDAFTARAN TERBARU -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-6">
        <h3 class="font-bold text-lg mb-4">Pendaftaran Terbaru</h3>
        @if($pendaftaranTerbaru->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada pendaftaran.</p>
        @else
            <div class="space-y-3">
                @foreach($pendaftaranTerbaru as $p)
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100">
                        <div>
                            <p class="font-semibold">{{ $p->event->nama_event }}</p>
                            <p class="text-xs text-gray-500">Booth: {{ $p->booth->kode_booth ?? '-' }}</p>
                        </div>
                        <span class="text-xs font-bold px-2 py-1 rounded {{ $p->status == 'disetujui' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
        <div class="mt-4">
            <a href="{{ route('tenant.event') }}" class="inline-block bg-tinta text-white px-6 py-2 rounded-lg font-bold hover:bg-gray-800 transition">
                Lihat Event Bazar Tersedia
            </a>
        </div>
    </div>
    @endif
@endsection