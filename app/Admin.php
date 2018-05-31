<?php

namespace App;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $admin;
    protected $email;

    protected $guard = 'admin';
	
    public function __construct() {
        $this->admin = config('admin.name');
        $this->email = config('admin.email');
    }

    protected $fillable = [
        'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];
}
