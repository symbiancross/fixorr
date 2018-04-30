<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keahlian extends Model
{
    protected $primaryKey = 'keahlian_id';

    protected $fillable = [
        'nama_keahlian', 'biaya',
    ];
}

