<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = [
        'supplier_id',
        'nama_supplier',
        'telepon',
        'alamat'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class);
    }
}
