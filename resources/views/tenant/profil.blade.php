@extends('layouts.tenant')

@section('content')
    <div class="max-w-3xl mx-auto">
        <!-- Header Kartu Profil -->
        <div class="bg-gradient-to-r from-tinta to-[#1a4a6e] rounded-t-2xl p-8 text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 opacity-10 transform translate-x-4 -translate-y-4">
                <svg class="w-48 h-48" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
            </div>
            
            <div class="flex items-center space-x-5 relative z-10">
                <div class="w-20 h-20 bg-emas rounded-full flex items-center justify-center text-tinta text-3xl font-bold shadow-lg border-4 border-white/20">
                    {{ substr($tenant->nama_usaha ?? auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h1 class="font-judul text-3xl font-bold">{{ $tenant->nama_usaha ?? 'Nama Usaha Belum Diisi' }}</h1>
                    <div class="flex items-center mt-2 space-x-3">
                        <span class="bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold uppercase tracking-wider">
                            {{ $tenant->jenis_produk ?? 'Kategori' }}
                        </span>
                        <span class="text-sm text-gray-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            {{ $tenant->alamat ?? 'Alamat belum diisi' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Profil -->
        <div class="bg-white rounded-b-2xl shadow-lg border-x border-b border-gray-100 p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-judul text-xl font-bold text-tinta">Edit Informasi Usaha</h2>
                <span class="text-xs text-gray-400">Terakhir diperbarui: {{ $tenant ? $tenant->updated_at->format('d M Y') : '-' }}</span>
            </div>

            @if(session('sukses'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('sukses') }}
                </div>
            @endif

            <form method="POST" action="{{ route('tenant.profil.update') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Nama Usaha -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Usaha</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <input type="text" name="nama_usaha" value="{{ $tenant->nama_usaha ?? '' }}" 
                                   class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required placeholder="Contoh: Kopi Gayo Asli">
                        </div>
                    </div>

                    <!-- Jenis Produk -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Produk</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            </div>
                            <select name="jenis_produk" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50 appearance-none" required>
                                <option value="kuliner" {{ ($tenant->jenis_produk ?? '') == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                                <option value="kriya" {{ ($tenant->jenis_produk ?? '') == 'kriya' ? 'selected' : '' }}>Kriya</option>
                                <option value="jasa" {{ ($tenant->jenis_produk ?? '') == 'jasa' ? 'selected' : '' }}>Jasa</option>
                            </select>
                        </div>
                    </div>

                    <!-- No HP -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">No. HP / WhatsApp</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <input type="text" name="no_hp" value="{{ $tenant->no_hp ?? '' }}" 
                                   class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required placeholder="08xxxxxxxxxx">
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap Usaha</label>
                        <div class="relative">
                            <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <textarea name="alamat" rows="3" class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-3 border bg-gray-50" required placeholder="Tuliskan alamat lengkap...">{{ $tenant->alamat ?? '' }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-100">
                    <button type="submit" class="bg-emas text-tinta px-8 py-3 rounded-lg font-bold hover:bg-yellow-500 transition shadow-md flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Profil Usaha
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection