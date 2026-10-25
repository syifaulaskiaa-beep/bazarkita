<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model {
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    protected $guarded = [];
    protected $casts = ['foto_produk' => 'array'];

    public function tenant() { return $this->belongsTo(Tenant::class, 'id_tenant'); }
    public function event() { return $this->belongsTo(Event::class, 'id_event'); }
    public function booth() { return $this->belongsTo(Booth::class, 'id_booth'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class, 'id_pendaftaran'); }
    public function tiket() { return $this->hasOne(Tiket::class, 'id_pendaftaran'); }
}