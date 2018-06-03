<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keahlian extends Model
{
    protected $primaryKey = 'keahlian_id';

    protected $fillable = [
        'nama_keahlian', 'biaya',
    ];

    public function pesan(){
        return $this->hasMany('App\Pesan' ,'pesan_id');
    }

    public function tukang(){
        return $this->hasMany('App\Tukang' ,'tukang_id');
    }
}

