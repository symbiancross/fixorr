<?php

namespace App\Http\Controllers\TukangAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tukang;
use App\VerificationTokenTukang;
use Auth;
use App\Events\TukangRequestedVerificationEmail;

class VerificationTukangController extends Controller
{
    public function verify(VerificationTokenTukang $token)
    {
    	$token->tukang()->update([
			'verified' => true
		]);
	 
		$token->delete();
	 
	    // Uncomment the following lines if you want to login the user 
	    // directly upon email verification
		// Auth::login($token->user);
	    // return redirect('/home');
	 
		return redirect('/tukang/login')->with('emailVerifivationSuccess', 'Email verification succesful. Please login again');
    }
 
    public function resend(Request $request)
    {
    	$user = Tukang::byEmail($request->email)->firstOrFail();
 
	    if($user->hasVerifiedEmail()) {
	        return redirect('/tukang');
	    }
	 
	    event(new TukangRequestedVerificationEmail($user));
	 
	    return redirect('/tukang/login')->with('status', 'Verification email resent. Please check your inbox');
    }
}
