<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Booth extends Model {
    protected $table = 'booth';
    protected $primaryKey = 'id_booth';
    protected $guarded = [];

    public function event() { return $this->belongsTo(Event::class, 'id_event'); }
    public function pendaftaran() { return $this->hasOne(Pendaftaran::class, 'id_booth'); }
}