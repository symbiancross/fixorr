<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Tukang;
use App\Pesan;
use App\User;
use App\Pekerjaan;

class TerimaPesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tukang');
   	}

    public function showDaftarPesanan()
    {
        $pesans = Pesan::with('user')->get();

        $pesanan = DB::table('pesans')->where('tukang_id', '=', Auth::user()->tukang_id)->whereIn('isComplete', [1, 2])->get();

        $cek_pesanan = 0;
        $detail_user = new User;
        $pesanan_id = 0;
        
        if(count($pesanan)==1)
        {
            $cek_pesanan = 1;
            $detail_user = User::findOrFail($pesanan[0]->user_id);
        }

        return view('pesantukang.terima-pesanan')->with('pesans', $pesans)->with('cek_pesanan', $cek_pesanan)->with('detail_user', $detail_user)->with('pesanan', $pesanan);
    }

    public function status($id)
    {
        $pesan = Pesan::findOrFail($id);
        if($pesan->isComplete==0)
        {
            $pesan->tukang_id = Auth::user()->tukang_id;
            $pesan->isComplete = 1;
            $pesan->save();
            return redirect()->route('daftar.pesanan');
        }
        else if($pesan->isComplete==1)
        {
            $pesan->isComplete = 2;
            $pesan->save();
            return redirect()->route('daftar.pesanan');
        }
        else
        {
            $pesan->isComplete = 3;
            $pesan->save();
            return redirect('tukang');
        }   
    }

    public function showTambahPembayaran()
    {
        $pesan = DB::table('pesans')->where('tukang_id', '=', Auth::user()->tukang_id)->where('isComplete', '=', 2)->get();
        $kekurangans = new Pekerjaan;
        $pesan_id = 0;
        $cek_pesanan = 0;
        if(count($pesan)==1)
        {
            $cek_pesanan = 1;            
            $pesan_id = $pesan[0]->pesan_id;
            
            $kekurangans = DB::table('pekerjaans')
            ->where('tukang_id', '=', Auth::user()->tukang_id)
            ->where('pesan_id', '=', $pesan_id)
            ->get();
            
            return view('pesantukang.tambah-biaya')->with('kekurangans', $kekurangans)->with('cek_pesanan', $cek_pesanan)->with('pesan_id', $pesan_id);
        }
        else
        {
            return view('pesantukang.tambah-biaya')->with('kekurangans', $kekurangans)->with('cek_pesanan', $cek_pesanan)->with('pesan_id', $pesan_id);
        }
        
    }

    public function tambahKekurangan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kekurangan' => 'required|max:255',
            'harga' => 'required|numeric|between:0.001,999999999',
        ]);

        $pesan = DB::table('pesans')->where('tukang_id', '=', Auth::user()->tukang_id)->where('isComplete', '=', 2)->get();
        $pesan_id = $pesan[0]->pesan_id;

        $pekerjaan =  new Pekerjaan;
        $pekerjaan->tukang_id = Auth::user()->tukang_id;
        $pekerjaan->pekerjaan = $request->kekurangan;
        $pekerjaan->harga = $request->harga;
        $pekerjaan->pesan_id = $pesan_id;

        $pekerjaan->save();

        return redirect()->route('biaya');
    }

    public function hapusKekurangan($id)
    {
        $pekerjaan = Pekerjaan::findOrFail($id);
        $pekerjaan->delete();

        return redirect()->route('biaya');
    }
}
