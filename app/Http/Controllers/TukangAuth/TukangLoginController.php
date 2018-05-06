<?php

namespace App\Http\Controllers\TukangAuth;

use App\Tukang;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

class TukangLoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest:tukang')->except('logout');;
    }

    public function showLoginForm()
    {
        return view('tukang.auth.login');
    }    

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/tukang';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended('/tukang');
    }

    public function logout()
    {
        Auth::guard('tukang')->logout();

        return redirect('/');
    }

    protected function guard()
    {
        return Auth::guard('tukang');
    }
}
