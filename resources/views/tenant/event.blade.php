@extends('layouts.tenant')

@section('content')
    <h1 class="font-judul text-2xl font-bold mb-6">Event Bazar Tersedia</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
    @endif

    @if($events->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow-sm text-center text-gray-500">
            Belum ada event bazar yang dibuka saat ini.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100 hover:shadow-md transition">
                    <div class="h-40 bg-gray-200 flex items-center justify-center text-gray-400 overflow-hidden">
                        @if($event->kategori == 'kuliner')
                            <img src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Kuliner" class="w-full h-full object-cover">
                        @elseif($event->kategori == 'kriya')
                            <img src="https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?q=80&w=600&auto=format&fit=crop" alt="Kriya" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.pexels.com/photos/1190297/pexels-photo-1190297.jpeg?auto=compress&cs=tinysrgb&w=600" alt="Umum" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="p-5">
                        <span class="text-xs font-bold text-emas uppercase tracking-wide">{{ $event->kategori }}</span>
                        <h3 class="font-judul text-lg font-bold mt-1">{{ $event->nama_event }}</h3>
                        <p class="text-sm text-gray-500 mt-2">📍 {{ $event->lokasi }}</p>
                        <p class="text-sm text-gray-500">📅 {{ \Carbon\Carbon::parse($event->tanggal_mulai)->format('d M Y') }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="font-bold text-tinta">Rp {{ number_format($event->biaya_booth, 0, ',', '.') }}</span>
                            <a href="{{ route('tenant.daftar', $event->id_event) }}" class="bg-tinta text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800">Daftar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection