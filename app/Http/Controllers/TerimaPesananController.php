<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Tukang;
use App\Pesan;

class TerimaPesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tukang');
   	}

    public function showDaftarPesanan()
    {
        $pesans = Pesan::with('user')->get();

        return view('pesantukang.terima-pesanan')->with('pesans', $pesans);
    }

    public function terimaPesanan(Request $request, $id)
    {
        $pesan = Pesan::findOrFail($id);

        $pesan->tukang_id = Auth::user()->tukang_id;
        $pesan->isComplete = 1;

        $pesan->save();
        return redirect('tukang');
    }
}
