<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tenant;
use App\Models\Produk;

class DataDummySeeder extends Seeder
{
    public function run(): void
    {
        $produkKuliner = [
            ['nama' => 'Kopi Gayo Premium', 'deskripsi' => 'Biji kopi arabika asli dataran tinggi Gayo', 'harga' => 50000],
            ['nama' => 'Kue Tradisional Aceh', 'deskripsi' => 'Aneka kue kering khas Aceh', 'harga' => 35000],
            ['nama' => 'Bakso Sapi Jumbo', 'deskripsi' => 'Bakso sapi asli tanpa pengawet', 'harga' => 25000],
            ['nama' => 'Mie Aceh Spesial', 'deskripsi' => 'Mie Aceh dengan bumbu rempah melimpah', 'harga' => 30000],
            ['nama' => 'Sate Matang', 'deskripsi' => 'Sate kambing khas Matang', 'harga' => 40000],
            ['nama' => 'Nasi Biryani', 'deskripsi' => 'Nasi biryani dengan daging empuk', 'harga' => 45000],
            ['nama' => 'Roti Cane', 'deskripsi' => 'Roti canai khas Aceh dengan kuah kari', 'harga' => 20000],
            ['nama' => 'Es Timun Serut', 'deskripsi' => 'Minuman segar es timun serut', 'harga' => 15000],
            ['nama' => 'Martabak Telur', 'deskripsi' => 'Martabak telur isi daging dan daun bawang', 'harga' => 35000],
            ['nama' => 'Pisang Goreng Keju', 'deskripsi' => 'Pisang goreng crispy dengan topping keju', 'harga' => 25000],
        ];

        $produkKriya = [
            ['nama' => 'Kerajinan Rotan', 'deskripsi' => 'Tas dan dompet anyaman rotan', 'harga' => 120000],
            ['nama' => 'Batik Aceh', 'deskripsi' => 'Kain batik motif pintu Aceh', 'harga' => 250000],
            ['nama' => 'Ukiran Kayu', 'deskripsi' => 'Ukiran kayu khas Gayo', 'harga' => 350000],
            ['nama' => 'Gelang Manik-Manik', 'deskripsi' => 'Gelang dari manik-manik warna-warni', 'harga' => 45000],
            ['nama' => 'Songket Aceh', 'deskripsi' => 'Kain songket tenun tangan', 'harga' => 500000],
            ['nama' => 'Tas Kulit', 'deskripsi' => 'Tas kulit asli buatan tangan', 'harga' => 280000],
            ['nama' => 'Anyaman Pandan', 'deskripsi' => 'Tempat tisu dari anyaman pandan', 'harga' => 35000],
            ['nama' => 'Topi Bambu', 'deskripsi' => 'Topi bambu untuk bertani', 'harga' => 25000],
            ['nama' => 'Piring Keramik', 'deskripsi' => 'Piring keramik hias', 'harga' => 75000],
            ['nama' => 'Lampu Hias', 'deskripsi' => 'Lampu hias dari batok kelapa', 'harga' => 90000],
        ];

        $produkJasa = [
            ['nama' => 'Jasa Desain Grafis', 'deskripsi' => 'Desain logo dan banner', 'harga' => 150000],
            ['nama' => 'Jasa Fotografi', 'deskripsi' => 'Foto produk dan acara', 'harga' => 300000],
            ['nama' => 'Jasa Cuci Sepatu', 'deskripsi' => 'Cuci sepatu kiloan', 'harga' => 25000],
            ['nama' => 'Jasa Servis AC', 'deskripsi' => 'Servis dan cuci AC', 'harga' => 100000],
            ['nama' => 'Jasa Les Privat', 'deskripsi' => 'Les privat matematika dan IPA', 'harga' => 50000],
            ['nama' => 'Jasa Katering', 'deskripsi' => 'Katering harian dan acara', 'harga' => 75000],
            ['nama' => 'Jasa Rias Pengantin', 'deskripsi' => 'Makeup dan rias pengantin', 'harga' => 500000],
            ['nama' => 'Jasa Sedot WC', 'deskripsi' => 'Sedot WC mampet', 'harga' => 300000],
            ['nama' => 'Jasa Pindahan', 'deskripsi' => 'Pindahan rumah dan kantor', 'harga' => 250000],
            ['nama' => 'Jasa Servis Motor', 'deskripsi' => 'Servis motor panggilan', 'harga' => 60000],
        ];

        $tenants = Tenant::all();
        
        foreach ($tenants as $tenant) {
            if ($tenant->jenis_produk == 'kuliner') {
                $daftarProduk = $produkKuliner;
            } elseif ($tenant->jenis_produk == 'kriya') {
                $daftarProduk = $produkKriya;
            } else {
                $daftarProduk = $produkJasa;
            }

            Produk::where('id_tenant', $tenant->id_tenant)->delete();

            foreach ($daftarProduk as $p) {
                Produk::create([
                    'id_tenant' => $tenant->id_tenant,
                    'nama' => $p['nama'],
                    'deskripsi' => $p['deskripsi'],
                    'harga' => $p['harga'],
                    'foto' => null, // KOSONGKAN FOTO
                ]);
            }
        }
    }
}