@extends('layouts.tenant')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="font-judul text-2xl font-bold text-tinta">Notifikasi</h1>
                <p class="text-gray-500 text-sm mt-1">Pesan dan informasi terbaru untuk Anda.</p>
            </div>
            <!-- Tombol Tandai Semua Dibaca (Opsional, jika nanti mau ditambahkan fungsinya) -->
            <button class="text-sm text-emas font-semibold hover:underline">Tandai semua dibaca</button>
        </div>

        @if($notifikasis->isEmpty())
            <!-- TAMPILAN JIKA KOSONG -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center flex flex-col items-center justify-center">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Notifikasi</h3>
                <p class="text-gray-500">Semua informasi penting akan muncul di sini.</p>
            </div>
        @else
            <!-- DAFTAR NOTIFIKASI -->
            <div class="space-y-4">
                @foreach($notifikasis as $n)
                    <div class="bg-white rounded-xl shadow-sm border transition hover:shadow-md relative overflow-hidden
                        {{ $n->dibaca ? 'border-gray-100' : 'border-emas bg-yellow-50/30' }}">
                        
                        <!-- Garis Kuning di Kiri (Jika Belum Dibaca) -->
                        @if(!$n->dibaca)
                            <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emas"></div>
                        @endif

                        <div class="p-5 flex items-start">
                            <!-- Ikon Berdasarkan Jenis (Opsional) -->
                            <div class="flex-shrink-0 mr-4 mt-1">
                                @if(str_contains(strtolower($n->judul), 'pembayaran'))
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                @elseif(str_contains(strtolower($n->judul), 'pendaftaran'))
                                    <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-gray-100 text-gray-600 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Isi Notifikasi -->
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="font-bold text-base {{ $n->dibaca ? 'text-gray-700' : 'text-tinta' }}">
                                        {{ $n->judul }}
                                    </h3>
                                    <span class="text-xs text-gray-400 whitespace-nowrap ml-4">{{ $n->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $n->isi }}</p>
                                
                                <!-- Tanda Jika Belum Dibaca -->
                                @if(!$n->dibaca)
                                    <div class="mt-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emas text-tinta">
                                            Baru
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection