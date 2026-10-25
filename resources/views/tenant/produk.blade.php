@extends('layouts.tenant')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="font-judul text-2xl font-bold">Katalog Produk</h1>
    </div>

    @if(session('sukses')) <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('sukses') }}</div> @endif
    @if(session('error')) <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div> @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah Produk -->
        <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-sm border border-gray-100 h-fit">
            <h2 class="font-bold text-lg mb-4">Tambah Produk Baru</h2>
            <form method="POST" action="{{ route('tenant.produk.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Nama Produk</label>
                    <input type="text" name="nama" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="w-full border p-2 rounded" rows="2" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-semibold mb-1">Harga (Rp)</label>
                    <input type="number" name="harga" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-1">Link Foto Produk (Opsional)</label>
                    <input type="url" name="foto" class="w-full border p-2 rounded bg-gray-50 text-sm" placeholder="https://link-gambar.com/foto.jpg">
                </div>
                <button type="submit" class="w-full bg-emas text-tinta px-4 py-2 rounded font-bold hover:bg-yellow-500">Tambah Produk</button>
            </form>
        </div>

        <!-- Daftar Produk -->
        <div class="lg:col-span-2">
            @if($produks->isEmpty())
                <div class="bg-white p-8 rounded-xl shadow-sm text-center text-gray-500">
                    Kamu belum menambahkan produk apapun.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($produks as $p)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                            <div class="h-40 bg-gray-100 flex items-center justify-center overflow-hidden">
                                @if($p->foto)
                                    <img src="{{ $p->foto }}" alt="{{ $p->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex flex-col items-center text-gray-400">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-xs mt-1">Foto belum tersedia</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 flex-1 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-lg">{{ $p->nama }}</h3>
                                    <p class="text-sm text-gray-500 mb-2">{{ $p->deskripsi }}</p>
                                    <p class="font-bold text-emas">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
                                </div>
                                <form method="POST" action="{{ route('tenant.produk.destroy', $p->id_produk) }}" class="mt-4 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm hover:underline" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection