<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $pesan->keahlian_id = $request->input('keahlian');
        $pesan->isComplete = 0;

        $pesan->save();

        return redirect('home');
    }

    public function showListPesanan()
    {
        $pesanans = DB::table('pesans')
            ->select(
                'pesans.pesan_id',
                'pesans.user_id',
                'pesans.tukang_id',
                'pesans.isComplete',
                'pesans.keahlian_id',
                'tukangs.nama',
                'keahlians.nama_keahlian'
            )
            ->leftjoin(
                'tukangs',
                'tukangs.tukang_id','=','pesans.tukang_id'
            )->join(
                'keahlians',
                'keahlians.keahlian_id','=','pesans.keahlian_id'
            )
            ->where('user_id', '=', Auth::user()->user_id)
            ->get();
            //dd($pesanans);

        return view('pesantukang.daftar-pesanan')->with('pesanans', $pesanans);
    }
}
