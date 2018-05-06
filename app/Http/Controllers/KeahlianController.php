<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keahlian;
use Illuminate\Support\Facades\Validator;

class KeahlianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showSearchKeahlianForm()
    {        
        return view('pesantukang.cari-keahlian');
    }

    public function cariKeahlian(Request $request)
    { 
    	$validator = $request->validate([
            'keahlian' => 'required|max:255',
        ]);

        $keahlian = $request->keahlian;
        $hasils = Keahlian::where('nama_keahlian', 'LIKE', '%'.$keahlian.'%')->get();

        return view('pesantukang.cari-keahlian')->with('hasils', $hasils);
    }
}
