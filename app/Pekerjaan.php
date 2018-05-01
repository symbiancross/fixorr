<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pekerjaan extends Model
{
    protected $primaryKey = 'pekerjaan_id';

    protected $fillable = [
        'tukang_id', 'pekerjaan', 'harga', 'pesan_id',
    ];
}
