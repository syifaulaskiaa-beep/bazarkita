@extends('layouts.admin')

@section('content')
    <h1 class="font-judul text-2xl font-bold mb-6">Log Aktivitas</h1>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="p-4 font-semibold text-sm">Waktu</th>
                    <th class="p-4 font-semibold text-sm">Admin</th>
                    <th class="p-4 font-semibold text-sm">Aksi</th>
                    <th class="p-4 font-semibold text-sm">Deskripsi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($logs as $log)
                <tr>
                    <td class="p-4 text-sm text-gray-500">{{ $log->created_at->format('d M Y, H:i') }}</td>
                    <td class="p-4">{{ $log->user->name ?? '-' }}</td>
                    <td class="p-4">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $log->aksi }}</span>
                    </td>
                    <td class="p-4 text-sm">{{ $log->deskripsi }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">Belum ada aktivitas yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection