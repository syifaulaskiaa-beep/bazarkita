@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="font-judul text-3xl font-bold text-tinta">Data Tenant</h1>
            <p class="text-gray-500 mt-1">Daftar seluruh pelaku usaha yang terdaftar di BazarKita.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="p-5 font-semibold text-sm text-gray-600">Nama Usaha</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Pemilik</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Kategori</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Kontak</th>
                        <th class="p-5 font-semibold text-sm text-gray-600">Alamat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tenants as $t)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="p-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-emas/20 text-emas flex items-center justify-center font-bold mr-3">
                                    {{ substr($t->nama_usaha, 0, 1) }}
                                </div>
                                <div class="font-bold text-tinta">{{ $t->nama_usaha }}</div>
                            </div>
                        </td>
                        <td class="p-5 text-sm text-gray-700">{{ $t->user->name ?? '-' }}</td>
                        <td class="p-5">
                            <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                {{ $t->jenis_produk }}
                            </span>
                        </td>
                        <td class="p-5 text-sm text-gray-700">{{ $t->no_hp }}</td>
                        <td class="p-5 text-sm text-gray-500 max-w-xs truncate">{{ $t->alamat }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-500">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Belum ada data tenant.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection