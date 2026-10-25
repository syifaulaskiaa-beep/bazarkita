@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="font-judul text-3xl font-bold text-tinta">Kelola Event</h1>
            <p class="text-gray-500 mt-1">Buat dan pantau semua event bazar yang terdaftar.</p>
        </div>
    </div>

    @if(session('sukses'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 flex items-center shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('sukses') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Form Tambah Event -->
        <div class="lg:col-span-1 bg-white p-6 rounded-2xl shadow-sm border border-gray-100 h-fit">
            <h2 class="font-bold text-xl text-tinta mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-emas" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Buat Event Baru
            </h2>
            
            <form method="POST" action="{{ route('admin.event.store') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Event</label>
                    <input type="text" name="nama_event" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required placeholder="Contoh: Bazar UMKM Aceh 2026">
                </div>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                    <select name="kategori" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required>
                        <option value="umum">Umum</option>
                        <option value="kuliner">Kuliner</option>
                        <option value="kriya">Kriya</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi</label>
                    <input type="text" name="lokasi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required placeholder="Contoh: Banda Aceh">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" rows="2" required placeholder="Tuliskan deskripsi singkat..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Biaya Booth (Rp)</label>
                    <input type="number" name="biaya_booth" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required placeholder="150000">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Batas Pendaftaran</label>
                    <input type="date" name="tanggal_tutup" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required>
                </div>

                <button type="submit" class="w-full bg-emas text-tinta px-6 py-3 rounded-lg font-bold hover:bg-yellow-500 transition shadow-md">
                    Simpan Event & Buat Booth
                </button>
            </form>
        </div>

        <!-- Tabel Daftar Event -->
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                <h2 class="font-bold text-xl text-tinta mb-6">Daftar Event Terdaftar</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="p-4 font-semibold text-sm text-gray-600">Nama Event</th>
                                <th class="p-4 font-semibold text-sm text-gray-600">Kategori</th>
                                <th class="p-4 font-semibold text-sm text-gray-600">Tanggal</th>
                                <th class="p-4 font-semibold text-sm text-gray-600">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($events as $e)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <div class="font-bold text-tinta">{{ $e->nama_event }}</div>
                                    <div class="text-xs text-gray-500 mt-1 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $e->lokasi }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider">
                                        {{ $e->kategori }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    {{ \Carbon\Carbon::parse($e->tanggal_mulai)->format('d M Y') }} <br>
                                    <span class="text-xs text-gray-400">s/d {{ \Carbon\Carbon::parse($e->tanggal_selesai)->format('d M Y') }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold 
                                        {{ $e->status == 'dibuka' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        <span class="w-2 h-2 rounded-full mr-2 {{ $e->status == 'dibuka' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        {{ ucfirst($e->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-gray-500">Belum ada event yang dibuat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection