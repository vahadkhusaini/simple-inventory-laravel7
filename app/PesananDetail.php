<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesananDetail extends Model
{
    protected $table = 'pesanan';
    protected $fillable = [
        'pesanan_id',
        'barang_id',
        'harga_beli',
        'satuan_beli'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
