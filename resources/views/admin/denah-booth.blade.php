@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="font-judul text-2xl font-bold">Denah Booth</h1>
            <p class="text-gray-500 text-sm">{{ $event->nama_event }}</p>
        </div>
        <div class="flex space-x-4 text-sm">
            <div class="flex items-center"><span class="w-4 h-4 bg-green-500 rounded mr-2"></span> Tersedia</div>
            <div class="flex items-center"><span class="w-4 h-4 bg-red-500 rounded mr-2"></span> Terisi</div>
        </div>
    </div>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            @foreach(['A', 'B', 'C'] as $zona)
                <div>
                    <h3 class="font-bold text-lg mb-4 text-center border-b pb-2">Zona {{ $zona }}</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($booths->where('zona', $zona) as $booth)
                            <div class="p-4 rounded-lg text-center font-bold text-white shadow-sm 
                                {{ $booth->status == 'tersedia' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ $booth->kode_booth }}
                                <div class="text-xs font-normal mt-1 opacity-80">
                                    {{ $booth->status == 'tersedia' ? 'Kosong' : 'Terisi' }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection