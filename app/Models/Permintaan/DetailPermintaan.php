<?php

namespace App\Models\Permintaan;

use Illuminate\Database\Eloquent\Model;

class DetailPermintaan extends Model
{
    protected $table = 'detail_permintaan';

    protected $fillable = [
        'id_permintaan','id_barang','harga','qty'
    ];
}
