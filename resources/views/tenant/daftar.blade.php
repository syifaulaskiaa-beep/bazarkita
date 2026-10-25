@extends('layouts.tenant')

@section('content')
    <div class="max-w-2xl bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <h1 class="font-judul text-2xl font-bold mb-1">Daftar Event</h1>
        <p class="text-gray-500 mb-6">{{ $event->nama_event }}</p>

        {{-- BLOK PESAN ERROR & SUKSES --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('tenant.daftar.store', $event->id_event) }}">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Deskripsi Produk yang akan Dijual</label>
                <textarea name="deskripsi_produk" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-emas focus:ring-emas p-2 border" required placeholder="Contoh: Menjual aneka kopi gayo dan kue tradisional...">{{ old('deskripsi_produk') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold mb-2">Pilih Booth Tersedia</label>
                <select name="id_booth" class="w-full border-gray-300 rounded-lg shadow-sm p-2 border" required>
                    <option value="">-- Pilih Booth --</option>
                    @foreach($booths as $booth)
                        <option value="{{ $booth->id_booth }}" {{ old('id_booth') == $booth->id_booth ? 'selected' : '' }}>
                            {{ $booth->kode_booth }} (Zona {{ $booth->zona }})
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">*Booth yang sudah dipilih tidak akan muncul lagi.</p>
            </div>

            <div class="mb-6">
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="setuju_syarat" value="1" class="rounded text-emas focus:ring-emas" required>
                    <span class="text-sm">Saya menyetujui syarat dan ketentuan event ini.</span>
                </label>
            </div>

            <button type="submit" class="bg-emas text-tinta px-6 py-2 rounded-lg font-bold hover:bg-yellow-500 transition w-full">
                Kirim Pendaftaran
            </button>
        </form>
    </div>
@endsection