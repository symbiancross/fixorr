<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\TukangResetPasswordNotification;

class Tukang extends Authenticatable
{
    use Notifiable;

    public function pesan(){
        return $this->hasMany('App\Pesan' ,'pesan_id');
    }

    protected $guard = 'tukang';

    protected $primaryKey = 'tukang_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'alamat', 'email', 'no_telp', 'password', 'foto', 'keahlian_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new TukangResetPasswordNotification($token));
    }
}
