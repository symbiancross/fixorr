<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pesan extends Model
{
	public function user()
	{
        return $this->belongsTo('App\User', 'user_id');
    }

    public function tukang()
    {
        return $this->belongsTo('App\Tukang', 'tukang_id');
    }

    public function keahlian()
	{
        return $this->belongsTo('App\Keahlian', 'keahlian_id');
    }

    protected $primaryKey = 'pesan_id';

    protected $fillable = [
        'user_id', 'tukang_id', 'isComplete', 'total', 'alamat',
    ];

    
}
