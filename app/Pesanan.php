<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $fillable = [
        'id',
        'supplier_id',
        'status'
    ];

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class);
    }
}
