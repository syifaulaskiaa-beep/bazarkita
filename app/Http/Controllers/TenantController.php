<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use App\Models\Produk;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class TenantController extends Controller
{
    public function edit()
    {
        $tenant = Tenant::where('id_user', Auth::id())->first();
        return view('tenant.profil', compact('tenant'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'jenis_produk' => 'required|in:kuliner,kriya,jasa',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        Tenant::updateOrCreate(
            ['id_user' => Auth::id()],
            [
                'nama_usaha' => $request->nama_usaha,
                'jenis_produk' => $request->jenis_produk,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ]
        );

        return redirect()->route('dashboard')->with('sukses', 'Profil usaha berhasil disimpan!');
    }

    // FUNGSI BARU UNTUK DASHBOARD YANG LEBIH KAYA
    public function dashboard()
    {
        $tenant = Tenant::where('id_user', Auth::id())->first();
        
        $totalProduk = 0;
        $totalPendaftaran = 0;
        $pendaftaranTerbaru = collect(); // default kosong

        if ($tenant) {
            $totalProduk = Produk::where('id_tenant', $tenant->id_tenant)->count();
            $totalPendaftaran = Pendaftaran::where('id_tenant', $tenant->id_tenant)->count();
            $pendaftaranTerbaru = Pendaftaran::with('event', 'booth')
                                    ->where('id_tenant', $tenant->id_tenant)
                                    ->latest()
                                    ->take(3)
                                    ->get();
        }

        return view('tenant.dashboard', compact(
            'tenant', 'totalProduk', 'totalPendaftaran', 'pendaftaranTerbaru'
        ));
    }
}