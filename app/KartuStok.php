<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    protected $table = 'kartu_stok';
    protected $guarded = [];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
