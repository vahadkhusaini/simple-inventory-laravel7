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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function pesanan_detail()
    {
        return $this->hasMany(PesananDetail::class);
    }
}
