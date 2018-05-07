<?php

namespace App\Http\Controllers\TukangAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Password;
use Illuminate\Http\Request;

class TukangResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
    
    protected function guard()
    {
        return Auth::guard('tukang');
    }
    
    protected function broker()
    {
        return Password::broker('tukangs');
    }   

    public function showResetForm(Request $request, $token = null)
    {
        return view('tukang.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function sendResetResponse($response)
    {
        if(!$this->guard()->user()->hasVerifiedEmail()) {
            $this->guard()->logout();
            return redirect('/tukang/login')->with('status', 'Password changed successfully. Please verify your email');
        }
        return redirect($this->redirectPath())
                            ->with('status', trans($response));
    }
}
