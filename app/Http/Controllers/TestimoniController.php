<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate;

class TestimoniController extends Controller
{
    public function showTestimoni()
    {
    	$rates = Rate::with('user')->orderBy('created_at', 'desc')->paginate(10);

    	return view('noauth.testimoni')->with('rates', $rates);
    }

    public function urutkan(Request $request)
    {
    	$selected=$request->urutkan; 
    	if($selected==1)
    	{
    		$rates = Rate::with('user')->orderBy('created_at', 'desc')->paginate(10);
    	}
    	else
    	{
    		$rates = Rate::with('user')->orderBy('rate_tukang', 'desc')->paginate(10);
    	}
    	
    	return view('noauth.testimoni')->with('rates', $rates)->with('selected', $selected);
    }
}
