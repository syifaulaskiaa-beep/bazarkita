<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'id_tenant');
    }
}