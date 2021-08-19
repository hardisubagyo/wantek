<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';

    protected $fillable = [
        'nama','harga','stok','id_vendor'
    ];
}
