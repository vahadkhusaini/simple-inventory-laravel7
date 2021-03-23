<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'barang_id', 
        'barcode',
        'nama_barang',
        'harga_jual',
        'harga_beli',
        'supplier_id'];
}
