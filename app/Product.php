<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Initialize
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'warna',
        'ukuran',
        'stok',
        'harga',
        'keterangan',
    ];
}