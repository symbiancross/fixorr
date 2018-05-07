<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\VerificationTokenUser;
use Auth;
use App\Events\UserRequestedVerificationEmail;

class VerificationUserController extends Controller
{
    public function verify(VerificationTokenUser $token)
    {
    	$token->user()->update([
			'verified' => true
		]);
	 
		$token->delete();
	 
	    // Uncomment the following lines if you want to login the user 
	    // directly upon email verification
		// Auth::login($token->user);
	    // return redirect('/home');
	 
		return redirect('/login')->with('emailVerifivationSuccess', 'Email verification succesful. Please login again');
    }
 
    public function resend(Request $request)
    {
    	$user = User::byEmail($request->email)->firstOrFail();
 
	    if($user->hasVerifiedEmail()) {
	        return redirect('/home');
	    }
	 
	    event(new UserRequestedVerificationEmail($user));
	 
	    return redirect('/login')->withInfo('Verification email resent. Please check your inbox');
    }
}
