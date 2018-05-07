<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationTokenTukang extends Model
{
    protected $fillable = ['token'];

	public function getRouteKeyName()
	{
		return 'token';
	}

	public function tukang()
	{
		return $this->belongsTo('App\Tukang', 'tukang_id', 'tukang_id');
	}
}
