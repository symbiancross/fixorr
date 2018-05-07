<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\UserResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama', 'alamat', 'email', 'no_telp', 'password', 'foto', 'verified'
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
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function pesan(){
        return $this->hasMany('App\Pesan' ,'pesan_id');
    }

    public function verificationToken()
    {
        return $this->hasOne(VerificationTokenUser::class, 'user_id', 'user_id');
    }

    public function hasVerifiedEmail()
    {
        return $this->verified;
    }
    public static function byEmail($email)
    {
        return static::where('email', $email);
    }
}
