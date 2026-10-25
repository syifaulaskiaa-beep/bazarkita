<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    public function index()
    {
        $tenant = Tenant::where('id_user', Auth::id())->first();
        if (!$tenant) return redirect()->route('tenant.profil')->with('error', 'Lengkapi profil dulu.');
        
        $produks = Produk::where('id_tenant', $tenant->id_tenant)->latest()->get();
        return view('tenant.produk', compact('produks'));
    }

    public function store(Request $request)
    {
        // Validasi (Link foto boleh kosong, tapi kalau diisi harus berupa URL)
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'foto' => 'nullable|url', 
        ]);

        try {
            $tenant = Tenant::where('id_user', Auth::id())->first();
            
            Produk::create([
                'id_tenant' => $tenant->id_tenant,
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'foto' => $request->foto, // Simpan URL
            ]);

            return back()->with('sukses', 'Produk berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah produk: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return back()->with('sukses', 'Produk berhasil dihapus!');
    }
}