<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Event;
use App\Models\Booth;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function create(Event $event)
    {
        $tenant = Tenant::where('id_user', Auth::id())->first();
        if (!$tenant) return redirect()->route('tenant.profil')->with('error', 'Lengkapi profil usaha terlebih dahulu!');
        if ($event->kategori !== 'umum' && $tenant->jenis_produk !== $event->kategori) return redirect()->route('tenant.event')->with('error', 'Jenis produk tidak sesuai.');
        
        $sudahDaftar = Pendaftaran::where('id_tenant', $tenant->id_tenant)->where('id_event', $event->id_event)->exists();
        if ($sudahDaftar) return redirect()->route('tenant.status')->with('error', 'Kamu sudah mendaftar di event ini.');

        $booths = Booth::where('id_event', $event->id_event)->where('status', 'tersedia')->orderBy('kode_booth')->get();
        return view('tenant.daftar', compact('event', 'booths', 'tenant'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'deskripsi_produk' => 'required|string',
            'id_booth' => 'required|exists:booth,id_booth',
            'setuju_syarat' => 'accepted',
        ]);

        $tenant = Tenant::where('id_user', Auth::id())->first();
        $booth = Booth::findOrFail($request->id_booth);
        if ($booth->status !== 'tersedia') return back()->with('error', 'Maaf, booth sudah diambil.');

        Pendaftaran::create([
            'id_tenant' => $tenant->id_tenant,
            'id_event' => $event->id_event,
            'id_booth' => $request->id_booth,
            'deskripsi_produk' => $request->deskripsi_produk,
            'setuju_syarat' => true,
            'status' => 'menunggu',
        ]);

        $booth->update(['status' => 'terisi']);
        return redirect()->route('tenant.status')->with('sukses', 'Pendaftaran berhasil! Menunggu persetujuan Admin.');
    }

    public function index()
    {
        $tenant = Tenant::where('id_user', Auth::id())->first();
        $pendaftarans = Pendaftaran::with(['event', 'booth', 'pembayaran', 'tiket'])
                        ->where('id_tenant', $tenant->id_tenant)
                        ->latest()
                        ->get();
        return view('tenant.status', compact('pendaftarans'));
    }

    // UPLOAD ALTERNATIF: Menggunakan Link URL
    public function bayar(Request $request, $id)
    {
        $request->validate([
            'bukti' => 'required|url' // Wajib berupa link
        ]);

        try {
            $pendaftaran = Pendaftaran::findOrFail($id);
            
            $pendaftaran->pembayaran->update([
                'bukti' => $request->bukti, // Simpan link ke database
                'status' => 'menunggu_verifikasi',
                'tgl_bayar' => now(),
            ]);

            return back()->with('sukses', 'Link bukti pembayaran berhasil disimpan!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Sistem Error: ' . $e->getMessage());
        }
    }
}