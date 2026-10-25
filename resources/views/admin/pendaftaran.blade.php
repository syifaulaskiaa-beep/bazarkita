@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="font-judul text-3xl font-bold text-tinta">Periksa Pendaftaran</h1>
            <p class="text-gray-500 mt-1">Kelola dan tinjau pendaftaran tenant untuk setiap event.</p>
        </div>
    </div>

    @if(session('sukses')) <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 shadow-sm">{{ session('sukses') }}</div> @endif
    @if(session('error')) <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded mb-6 shadow-sm">{{ session('error') }}</div> @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-5 font-semibold text-sm text-gray-600">Nama Usaha</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Event</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Booth</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Status</th>
                        <th class="p-5 font-semibold text-sm text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pendaftarans as $p)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-5">
                            <div class="font-bold text-tinta">{{ $p->tenant->nama_usaha ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $p->tenant->user->name ?? '-' }}</div>
                        </td>
                        <td class="p-5 text-sm text-gray-700">{{ $p->event->nama_event ?? '-' }}</td>
                        <td class="p-5 text-sm font-semibold text-gray-700">{{ $p->booth->kode_booth ?? '-' }}</td>
                        <td class="p-5">
                            @if($p->status == 'menunggu')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                    <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span> Menunggu
                                </span>
                            @elseif($p->status == 'disetujui')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Disetujui
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                    <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            @if($p->status == 'menunggu')
                            <form method="POST" action="{{ route('admin.setujui', $p->id_pendaftaran) }}" class="flex items-center justify-end space-x-2">
                                @csrf
                                <select name="id_booth" class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-emas focus:border-emas" required>
                                    <option value="">Pilih Booth</option>
                                    @foreach($p->event->booth as $booth)
                                        @if($booth->status == 'tersedia')
                                            <option value="{{ $booth->id_booth }}">{{ $booth->kode_booth }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button class="bg-tinta text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-gray-800 transition shadow-sm">Setujui</button>
                            </form>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Belum ada data pendaftaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection