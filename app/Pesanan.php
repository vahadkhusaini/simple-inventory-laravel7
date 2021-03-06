<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    public $incrementing = false;
    protected $table = 'pesanan';
    protected $fillable = [
        'id',
        'tanggal',
        'supplier_id',
        'status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class);
    }
}
