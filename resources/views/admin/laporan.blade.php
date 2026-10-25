@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-judul text-2xl font-bold">Laporan</h1>
        <a href="{{ route('admin.laporan.csv') }}" class="bg-emas text-tinta px-4 py-2 rounded-lg font-bold hover:bg-yellow-500 transition">
            Download Laporan (CSV)
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 font-semibold text-sm">Nama Usaha</th>
                    <th class="p-4 font-semibold text-sm">Event</th>
                    <th class="p-4 font-semibold text-sm">Booth</th>
                    <th class="p-4 font-semibold text-sm">Status Pendaftaran</th>
                    <th class="p-4 font-semibold text-sm">Status Bayar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendaftarans as $p)
                <tr>
                    <td class="p-4">{{ $p->tenant->nama_usaha ?? '-' }}</td>
                    <td class="p-4">{{ $p->event->nama_event ?? '-' }}</td>
                    <td class="p-4">{{ $p->booth->kode_booth ?? '-' }}</td>
                    <td class="p-4">{{ $p->status }}</td>
                    <td class="p-4">{{ $p->pembayaran->status ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-gray-500">Belum ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection