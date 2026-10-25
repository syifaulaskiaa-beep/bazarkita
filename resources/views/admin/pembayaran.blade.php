@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="font-judul text-3xl font-bold text-tinta">Verifikasi Pembayaran</h1>
            <p class="text-gray-500 mt-1">Periksa bukti transfer dan terbitkan tiket QR.</p>
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
                        <th class="p-5 font-semibold text-sm text-gray-600">Jumlah</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Bukti</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Status</th>
                        <th class="p-5 font-semibold text-sm text-gray-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pembayarans as $p)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-5">
                            <div class="font-bold text-tinta">{{ $p->pendaftaran->tenant->nama_usaha ?? '-' }}</div>
                            <div class="text-xs text-gray-500 mt-1">Booth: {{ $p->pendaftaran->booth->kode_booth ?? '-' }}</div>
                        </td>
                        <td class="p-5 font-semibold text-gray-700">Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                        <td class="p-5">
                            @if($p->bukti)
                                <a href="{{ $p->bukti }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    Lihat Bukti
                                </a>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="p-5">
                            @if($p->status == 'menunggu_verifikasi')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span> Menunggu
                                </span>
                            @elseif($p->status == 'lunas')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                    <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Lunas
                                </span>
                            @endif
                        </td>
                        <td class="p-5 text-right">
                            @if($p->status == 'menunggu_verifikasi')
                            <form method="POST" action="{{ route('admin.verifikasi', $p->id_bayar) }}">
                                @csrf
                                <button class="bg-emas text-tinta px-4 py-2 rounded-lg text-sm font-bold hover:bg-yellow-500 transition shadow-sm">
                                    Verifikasi & Terbitkan Tiket
                                </button>
                            </form>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            Belum ada data pembayaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection