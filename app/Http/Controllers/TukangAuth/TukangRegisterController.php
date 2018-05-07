<?php

namespace App\Http\Controllers\TukangAuth;

use App\Tukang;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Auth;

class TukangRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('tukang.auth.register');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/tukang';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:tukang');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return Tukang::create([
            'nama' => $data['name'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'no_telp' => $data['telephone'],
            'foto' => "dddddd",
            'keahlian_id' => "1",
            'password' => Hash::make($data['password']),
            'verified' => false
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
     
        return redirect('/tukang/login')->with('success', 'Please verify your email');
    }

    protected function guard()
    {
        return Auth::guard('tukang');
    }
}
