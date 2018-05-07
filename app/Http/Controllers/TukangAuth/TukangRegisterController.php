<?php

namespace App\Http\Controllers\TukangAuth;

use App\Tukang;
use App\Keahlian;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

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
        $keahlians = Keahlian::all();

        return view('tukang.auth.register')->with('keahlians', $keahlians);
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
            'email' => 'required|string|email|max:255|unique:tukangs',
            'telephone' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:500|dimensions:min_width=100,min_height=100,max_width=200,max_height=200',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        if($request->keahlian==0 && $request->keahlian_baru==NULL)
        {
            $keahlians = Keahlian::all();

            return redirect('/tukang/register')->with('status', 'tolong isi keahlian baru')->with('keahlians', $keahlians);
        }

        if($request->keahlian==0 && !$request->keahlian_baru==NULL)
        {
            $keahlians = Keahlian::where('nama_keahlian', '=', $request->keahlian_baru)->get();
            if(count($keahlians)>0)
            {
                $keahlians = Keahlian::all();

                return redirect('/tukang/register')->with('status', 'sudah ada keahlian yang sama, silahkan memilih dari daftar yang ada')->with('keahlians', $keahlians);
            }
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected function create(array $data)
    {
        $file = $data['foto'];
        $fileName = $file->getClientOriginalName();
        $data['foto']->move("image/", $fileName);
        $keahliantukang = $data['keahlian'];

        if($data['keahlian']==0)
        {
            $keahlian = new Keahlian;
            $keahlian->nama_keahlian = $data['keahlian_baru'];
            $keahlian->save(); 
            
            $keahlian = Keahlian::where('nama_keahlian', '=', $data['keahlian_baru'])->get();
            $keahliantukang = $keahlian[0]->keahlian_id; 
        }

        return Tukang::create([
            'nama' => $data['name'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'no_telp' => $data['telephone'],
            'foto' => $fileName,
            'keahlian_id' =>  $keahliantukang,
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
