<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tukang;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
   	}

	public function index()
	{
		$tukangs = Tukang::where('verified', 0)->paginate(5);
        return view('adminhome')->with('tukangs', $tukangs);
    }

    public function aktifkanTukang($id)
    {
    	$tukang = Tukang::findOrFail($id);
    	$tukang->verified = 1;
    	$tukang->save();

    	return redirect()->route('admin.home');
    }
}
