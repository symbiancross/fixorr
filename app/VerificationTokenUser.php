<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationTokenUser extends Model
{
    protected $fillable = ['token'];

	public function getRouteKeyName()
	{
		return 'token';
	}

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'user_id');
	}
}
