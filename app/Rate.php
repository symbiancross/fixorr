<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $primaryKey = 'rate_id';

    protected $fillable = [
        'user_id', 'tukang_id','foto_testimoni','rate_tukang','rate_pengguna','testimoni',
    ];

    public function user()
	{
        return $this->belongsTo('App\User', 'user_id');
    }
}
