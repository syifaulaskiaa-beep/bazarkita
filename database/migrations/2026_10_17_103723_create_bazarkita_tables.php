<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $t) {
            $t->enum('role', ['admin','tenant'])->default('tenant')->after('email');
        });

        Schema::create('tenant', function (Blueprint $t) {
            $t->id('id_tenant');
            $t->foreignId('id_user')->unique()->constrained('users')->cascadeOnDelete();
            $t->string('nama_usaha');
            $t->enum('jenis_produk', ['kuliner','kriya','jasa']);
            $t->string('no_hp');
            $t->text('alamat');
            $t->string('nib')->nullable();
            $t->string('logo')->nullable();
            $t->timestamps();
        });

        Schema::create('produk', function (Blueprint $t) {
            $t->id('id_produk');
            $t->foreignId('id_tenant')->constrained('tenant','id_tenant')->cascadeOnDelete();
            $t->string('nama');
            $t->text('deskripsi');
            $t->decimal('harga', 12, 2);
            $t->string('foto')->nullable();
            $t->timestamps();
        });

        Schema::create('event', function (Blueprint $t) {
            $t->id('id_event');
            $t->string('nama_event');
            $t->enum('kategori', ['umum','kuliner','kriya']);
            $t->text('deskripsi');
            $t->text('syarat');
            $t->text('jadwal');
            $t->string('gambar')->nullable();
            $t->date('tanggal_mulai');
            $t->date('tanggal_selesai');
            $t->date('tanggal_tutup');
            $t->string('lokasi');
            $t->integer('kuota')->default(24);
            $t->string('ukuran_booth')->nullable();
            $t->decimal('biaya_booth', 12, 2);
            $t->enum('status', ['draf','dibuka','segera','ditutup'])->default('draf');
            $t->timestamps();
        });

        Schema::create('booth', function (Blueprint $t) {
            $t->id('id_booth');
            $t->foreignId('id_event')->constrained('event','id_event')->cascadeOnDelete();
            $t->string('kode_booth');
            $t->enum('zona', ['A','B','C']);
            $t->enum('status', ['tersedia','terisi'])->default('tersedia');
            $t->timestamps();
            $t->unique(['id_event','kode_booth']);
        });

        Schema::create('pendaftaran', function (Blueprint $t) {
            $t->id('id_pendaftaran');
            $t->foreignId('id_tenant')->constrained('tenant','id_tenant')->cascadeOnDelete();
            $t->foreignId('id_event')->constrained('event','id_event')->cascadeOnDelete();
            $t->foreignId('id_booth')->nullable()->unique()->constrained('booth','id_booth');
            $t->string('booth_preferensi')->nullable();
            $t->text('deskripsi_produk');
            $t->json('foto_produk')->nullable();
            $t->boolean('setuju_syarat')->default(false);
            $t->enum('status', ['menunggu','disetujui','ditolak','dibatalkan'])->default('menunggu');
            $t->text('alasan_tolak')->nullable();
            $t->timestamp('tgl_daftar')->useCurrent();
            $t->timestamp('tgl_keputusan')->nullable();
            $t->timestamps();
            $t->unique(['id_tenant','id_event']);
        });

        Schema::create('pembayaran', function (Blueprint $t) {
            $t->id('id_bayar');
            $t->foreignId('id_pendaftaran')->unique()->constrained('pendaftaran','id_pendaftaran')->cascadeOnDelete();
            $t->decimal('jumlah', 12, 2);
            $t->date('batas_bayar');
            $t->string('bukti')->nullable();
            $t->enum('status', ['belum_bayar','menunggu_verifikasi','lunas','ditolak'])->default('belum_bayar');
            $t->text('alasan_tolak')->nullable();
            $t->timestamp('tgl_bayar')->nullable();
            $t->timestamp('tgl_verifikasi')->nullable();
            $t->timestamps();
        });

        Schema::create('tiket', function (Blueprint $t) {
            $t->id('id_tiket');
            $t->foreignId('id_pendaftaran')->unique()->constrained('pendaftaran','id_pendaftaran')->cascadeOnDelete();
            $t->string('kode_tiket')->unique();
            $t->timestamp('terbit_pada')->useCurrent();
            $t->timestamps();
        });

        Schema::create('notifikasi', function (Blueprint $t) {
            $t->id('id_notif');
            $t->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $t->string('judul');
            $t->text('isi');
            $t->boolean('dibaca')->default(false);
            $t->timestamps();
        });

        Schema::create('log_aktivitas', function (Blueprint $t) {
            $t->id('id_log');
            $t->foreignId('id_user')->constrained('users')->cascadeOnDelete();
            $t->string('aksi');
            $t->text('deskripsi')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('log_aktivitas');
        Schema::dropIfExists('notifikasi');
        Schema::dropIfExists('tiket');
        Schema::dropIfExists('pembayaran');
        Schema::dropIfExists('pendaftaran');
        Schema::dropIfExists('booth');
        Schema::dropIfExists('event');
        Schema::dropIfExists('produk');
        Schema::dropIfExists('tenant');
        Schema::table('users', function (Blueprint $t) { $t->dropColumn('role'); });
    }
};