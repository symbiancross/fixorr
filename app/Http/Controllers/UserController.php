<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function showEditUserForm()
    {
        $user = Auth::user();
        
        return view('auth.edit-user')->with('user', $user);
    }

    public function update(User $user)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required', Rule::unique('users')->ignore($user->id, 'user_id'),
            'telephone' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->nama = request('name');
        $user->alamat = request('alamat');
        $user->email = request('email');
        $user->no_telp = request('telephone');
        $user->password = bcrypt(request('password'));

        $user->save();

        return redirect('home');
    }
}