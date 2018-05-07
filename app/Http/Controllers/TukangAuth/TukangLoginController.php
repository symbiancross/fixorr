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
                ?: redirect('/tukang');
    }

    protected function authenticated(Request $request, $user)
    {
        if(!$user->hasVerifiedEmail()) {
            $this->guard()->logout();
     
            return redirect('/tukang/login')
                ->with('verify', 'Please activate your account. <a href="' . route('tukang.auth.verify.resend') . '?email=' . $user->email .'">Resend?</a>');
        }
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
