<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    public $incrementing = false;
    protected $table = 'pembelian';
    protected $guarded = [];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}
