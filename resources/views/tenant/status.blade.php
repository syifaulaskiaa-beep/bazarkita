@extends('layouts.tenant')

@section('content')
    <h1 class="font-judul text-2xl font-bold mb-6">Pendaftaran Saya</h1>

    @if(session('sukses')) <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('sukses') }}</div> @endif
    @if(session('error')) <div class="bg-red-100 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div> @endif
    @if ($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    @if($pendaftarans->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow-sm text-center text-gray-500">Kamu belum mendaftar ke event manapun.</div>
    @else
        <div class="space-y-4">
            @foreach($pendaftarans as $p)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                    <div class="w-2/3">
                        <h3 class="font-bold text-lg">{{ $p->event->nama_event }}</h3>
                        <p class="text-sm text-gray-500 mb-3">Booth: {{ $p->booth->kode_booth ?? 'Belum ditentukan' }}</p>
                        
                        @if($p->status == 'disetujui' && $p->pembayaran)
                            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-sm font-semibold">Total Tagihan: Rp {{ number_format($p->pembayaran->jumlah, 0, ',', '.') }}</p>
                                <p class="text-xs text-red-500 mb-3">Batas Bayar: {{ \Carbon\Carbon::parse($p->pembayaran->batas_bayar)->format('d M Y') }}</p>
                                
                                @if($p->pembayaran->status == 'belum_bayar')
                                    <form method="POST" action="{{ route('tenant.bayar', $p->id_pendaftaran) }}" class="mt-2">
                                        @csrf
                                        <label class="block text-xs font-semibold mb-1">Paste Link Bukti Transfer (Google Drive / Imgur / dll)</label>
                                        <input type="url" name="bukti" required class="text-sm mb-2 block w-full border p-2 rounded bg-white" placeholder="https://link-gambar-kamu.com/bukti.jpg">
                                        <button type="submit" class="bg-emas text-tinta px-4 py-2 rounded text-sm font-bold hover:bg-yellow-500">Simpan Link Bukti</button>
                                    </form>
                                @elseif($p->pembayaran->status == 'menunggu_verifikasi')
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded text-sm font-semibold">Bukti sedang diperiksa Admin</span>
                                @elseif($p->pembayaran->status == 'lunas')
                                    <div class="bg-green-50 p-4 border border-green-200 rounded-lg mt-2">
                                        <p class="text-green-800 font-bold mb-2">Pembayaran Lunas!</p>
                                        @if($p->tiket)
                                            <div class="bg-white p-4 rounded border inline-block text-center">
                                                <p class="text-xs text-gray-500 mb-2">Tunjukkan QR ini ke Panitia</p>
                                                {!! QrCode::size(150)->generate($p->tiket->kode_tiket) !!}
                                                <p class="font-mono font-bold text-lg mt-2">{{ $p->tiket->kode_tiket }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div>
                        @if($p->status == 'menunggu') <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">Menunggu</span>
                        @elseif($p->status == 'disetujui') <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">Disetujui</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection