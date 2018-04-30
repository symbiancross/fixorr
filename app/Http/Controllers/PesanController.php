<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Keahlian;
use App\Pesan;


class PesanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showKonfirmasiForm($id)
    {
        $user = Auth::user();
        $keahlian = Keahlian::find($id);
        
        return view('pesantukang.pesan')->with('user', $user)->with('keahlian', $keahlian);
    }

    public function pesan(Request $request)
    {
        $pesan = new Pesan;
        $pesan->user_id = Auth::user()->user_id;
        $pesan->total = $request->input('total');
        $pesan->alamat = $request->input('alamat');
        $pesan->keahlian = $request->input('keahlian');
        $pesan->isComplete = 0;

        $pesan->save();

        return redirect('home');
    }
}
