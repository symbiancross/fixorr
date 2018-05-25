<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Http\Request;
use Auth;
use GeneaLabs\LaravelMaps\Facades\Map;

class RegisterController extends Controller
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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $config = array();
        $config['center'] = 'Wisma tengger';
        $config['map_height'] = '0px';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'alamat';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'createMarker_map({ map: map, position:event.latLng });';
        Map::initialize($config);

        $map = Map::create_map();
        return view('auth.register')->with('map', $map);
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
        return User::create([
            'nama' => $data['name'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'no_telp' => $data['telephone'],
            'password' => Hash::make($data['password']),
            'verified' => false
        ]);
    }

    protected function registered(Request $request, $user)
    {
        $this->guard()->logout();
     
        return redirect('/login')->with('success', 'Tolong verifikasi email anda');
    }
}
