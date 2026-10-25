<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model {
    protected $table = 'event';
    protected $primaryKey = 'id_event';
    protected $guarded = [];

    public function booth() { return $this->hasMany(Booth::class, 'id_event'); }
    public function pendaftaran() { return $this->hasMany(Pendaftaran::class, 'id_event'); }
}