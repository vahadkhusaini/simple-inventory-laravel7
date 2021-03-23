<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $fillable = [
        'pelanggan_id',
        'nama_pelanggan',
        'telepon',
        'alamat'
    ];
}
