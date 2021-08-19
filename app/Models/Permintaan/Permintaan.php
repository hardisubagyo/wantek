<?php

namespace App\Models\Permintaan;

use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    protected $table = 'master_pemintaan';

    protected $fillable = [
        'id_pertamina','id_vendor','harga','status','id_permintaan'
    ];
}
