<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TukangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tukang');
   	}

	public function index()
	{
        return view('tukanghome');
    }
}
