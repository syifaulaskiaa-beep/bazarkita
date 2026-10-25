<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use App\Models\Booth;
use App\Models\Pembayaran;
use App\Models\Tiket;
use App\Models\Event;
use App\Models\Tenant;
use App\Models\Notifikasi;
use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalEvent = Event::count();
        $menungguVerifikasi = Pembayaran::where('status', 'menunggu_verifikasi')->count();
        $disetujui = Pendaftaran::where('status', 'disetujui')->count();
        $lunas = Pembayaran::where('status', 'lunas')->count();

        // Data untuk grafik
        $events = Event::withCount('pendaftaran')->get();
        $chartLabels = $events->pluck('nama_event');
        $chartData = $events->pluck('pendaftaran_count');

        return view('admin.dashboard', compact('totalEvent', 'menungguVerifikasi', 'disetujui', 'lunas', 'chartLabels', 'chartData'));
    }

    public function pendaftaran()
    {
        $pendaftarans = Pendaftaran::with(['tenant', 'event', 'booth'])->latest()->get();
        return view('admin.pendaftaran', compact('pendaftarans'));
    }

    public function setujui(Request $request, $id)
    {
        $request->validate(['id_booth' => 'required|exists:booth,id_booth']);

        DB::transaction(function () use ($request, $id) {
            $pendaftaran = Pendaftaran::findOrFail($id);
            if ($pendaftaran->status !== 'menunggu') return;

            $pendaftaran->update([
                'status' => 'disetujui',
                'id_booth' => $request->id_booth,
                'tgl_keputusan' => now(),
            ]);

            Booth::where('id_booth', $request->id_booth)->update(['status' => 'terisi']);

            Pembayaran::create([
                'id_pendaftaran' => $pendaftaran->id_pendaftaran,
                'jumlah' => $pendaftaran->event->biaya_booth,
                'batas_bayar' => now()->addDays(3),
                'status' => 'belum_bayar',
            ]);

            Notifikasi::create([
                'id_user' => $pendaftaran->tenant->id_user,
                'judul' => 'Pendaftaran Disetujui',
                'isi' => 'Pendaftaran kamu di event ' . $pendaftaran->event->nama_event . ' telah disetujui. Silakan lakukan pembayaran.',
            ]);

            LogAktivitas::create([
                'id_user' => Auth::id(),
                'aksi' => 'Setujui Pendaftaran',
                'deskripsi' => 'Menyetujui pendaftaran ' . $pendaftaran->tenant->nama_usaha . ' di event ' . $pendaftaran->event->nama_event,
            ]);
        });

        return back()->with('sukses', 'Pendaftaran disetujui! Booth dikunci dan tagihan dibuat.');
    }

    public function pembayaran()
    {
        $pembayarans = Pembayaran::with(['pendaftaran.tenant', 'pendaftaran.event'])
                        ->whereIn('status', ['menunggu_verifikasi', 'lunas'])
                        ->latest()
                        ->get();
        return view('admin.pembayaran', compact('pembayarans'));
    }

    public function verifikasi($id)
    {
        DB::transaction(function () use ($id) {
            $pembayaran = Pembayaran::findOrFail($id);
            
            $pembayaran->update([
                'status' => 'lunas',
                'tgl_verifikasi' => now(),
            ]);

            Tiket::firstOrCreate(
                ['id_pendaftaran' => $pembayaran->id_pendaftaran],
                ['kode_tiket' => 'BK-' . strtoupper(\Str::random(8))]
            );

            Notifikasi::create([
                'id_user' => $pembayaran->pendaftaran->tenant->id_user,
                'judul' => 'Pembayaran Lunas',
                'isi' => 'Pembayaran kamu telah diverifikasi. Tiket QR sudah terbit di dashboard.',
            ]);

            LogAktivitas::create([
                'id_user' => Auth::id(),
                'aksi' => 'Verifikasi Pembayaran',
                'deskripsi' => 'Memverifikasi pembayaran ' . $pembayaran->pendaftaran->tenant->nama_usaha . ' sebesar Rp ' . number_format($pembayaran->jumlah, 0, ',', '.'),
            ]);
        });

        return back()->with('sukses', 'Pembayaran diverifikasi! Tiket QR telah diterbitkan.');
    }

    public function denahBooth()
    {
        $event = Event::first();
        if (!$event) return redirect()->route('dashboard')->with('error', 'Belum ada event.');
        
        $booths = Booth::where('id_event', $event->id_event)->orderBy('kode_booth')->get();
        return view('admin.denah-booth', compact('event', 'booths'));
    }

    public function event()
    {
        $events = Event::latest()->get();
        return view('admin.event', compact('events'));
    }

    public function eventStore(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'kategori' => 'required|in:umum,kuliner,kriya',
            'deskripsi' => 'required',
            'lokasi' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'tanggal_tutup' => 'required|date',
            'biaya_booth' => 'required|numeric',
        ]);

        DB::transaction(function () use ($request) {
            $event = Event::create([
                'nama_event' => $request->nama_event,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'syarat' => $request->syarat ?? '-',
                'jadwal' => $request->jadwal ?? '08.00 - 22.00',
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tanggal_tutup' => $request->tanggal_tutup,
                'lokasi' => $request->lokasi,
                'kuota' => 24,
                'biaya_booth' => $request->biaya_booth,
                'status' => 'dibuka',
            ]);

            foreach (['A', 'B', 'C'] as $zona) {
                for ($i = 1; $i <= 8; $i++) {
                    Booth::create([
                        'id_event' => $event->id_event,
                        'kode_booth' => $zona . '-' . $i,
                        'zona' => $zona,
                        'status' => 'tersedia',
                    ]);
                }
            }
        });

        return back()->with('sukses', 'Event berhasil dibuat beserta 24 booth-nya!');
    }

    public function dataTenant()
    {
        $tenants = Tenant::with('user')->latest()->get();
        return view('admin.tenant', compact('tenants'));
    }

    public function laporan()
    {
        $pendaftarans = Pendaftaran::with(['tenant', 'event', 'booth', 'pembayaran'])->get();
        return view('admin.laporan', compact('pendaftarans'));
    }

    public function laporanCsv()
    {
        $pendaftarans = Pendaftaran::with(['tenant', 'event', 'booth', 'pembayaran'])->get();
        
        $filename = "laporan_bazarkita_" . date('Y-m-d') . ".csv";
        $handle = fopen('php://output', 'w');
        
        fputcsv($handle, ['Nama Usaha', 'Event', 'Booth', 'Status Pendaftaran', 'Total Bayar', 'Status Bayar']);
        
        foreach ($pendaftarans as $p) {
            fputcsv($handle, [
                $p->tenant->nama_usaha ?? '-',
                $p->event->nama_event ?? '-',
                $p->booth->kode_booth ?? '-',
                $p->status,
                $p->pembayaran->jumlah ?? 0,
                $p->pembayaran->status ?? '-'
            ]);
        }
        
        fclose($handle);
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        return response()->stream(function() use ($pendaftarans) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Usaha', 'Event', 'Booth', 'Status Pendaftaran', 'Total Bayar', 'Status Bayar']);
            foreach ($pendaftarans as $p) {
                fputcsv($handle, [
                    $p->tenant->nama_usaha ?? '-',
                    $p->event->nama_event ?? '-',
                    $p->booth->kode_booth ?? '-',
                    $p->status,
                    $p->pembayaran->jumlah ?? 0,
                    $p->pembayaran->status ?? '-'
                ]);
            }
            fclose($handle);
        }, 200, $headers);
    }

    public function logAktivitas()
    {
        $logs = LogAktivitas::with('user')->latest()->get();
        return view('admin.log', compact('logs'));
    }
}