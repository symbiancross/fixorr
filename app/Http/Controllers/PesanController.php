<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Keahlian;
use App\Pesan;
use App\Pekerjaan;
use App\Rate;


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

    public function showListPesananAktif()
    {
        $pesanans = DB::table('pesans')
            ->select(
                'pesans.pesan_id',
                'pesans.user_id',
                'pesans.tukang_id',
                'pesans.isComplete',
                'pesans.keahlian_id',
                'pesans.created_at',
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
            ->whereIn('isComplete', [0, 1, 2])
            ->get();

            $pesanans = $pesanans->sortBy('pesan_id');
            //dd($pesanans);

        return view('pesantukang.daftar-pesanan-aktif')->with('pesanans', $pesanans);
    }

    public function showDetailPesananAktif($id)
    {
        $pesanan = Pesan::findOrFail($id);
        $detail_pesanan = 0;
        $total = 0;
        $tambahans = 0;
        if($pesanan->isComplete==0)
        {
            return view('pesantukang.detail-pesanan-pengguna-aktif')->with('detail_pesanan', $detail_pesanan)->with('pesanan', $pesanan)->with('total', $total)->with('tambahans', $tambahans);
        }
        else
        {
            $total = $pesanan->total;
            $tambahans = Pekerjaan::where('pesan_id', '=', $id)->get();
            if(count($tambahans) > 0)
            {
                foreach ($tambahans as $tambahan) {
                    $total = $total + $tambahan->harga;
                }
            }
            $detail_pesanan = DB::table('pesans')
            ->select(
                'tukangs.nama',
                'tukangs.no_telp',
                'tukangs.foto',
                'keahlians.nama_keahlian',
                'keahlians.biaya'
            )
            ->join(
                'tukangs',
                'tukangs.tukang_id','=','pesans.tukang_id'
            )->join(
                'keahlians',
                'keahlians.keahlian_id','=','pesans.keahlian_id'
            )
            ->where('pesans.pesan_id', '=', $id)
            ->get();

            return view('pesantukang.detail-pesanan-pengguna-aktif')->with('detail_pesanan', $detail_pesanan)->with('pesanan', $pesanan)->with('total', $total)->with('tambahans', $tambahans);
        }
    }

    public function showListPesananSelesai()
    {
        $pesanans = DB::table('pesans')
            ->select(
                'pesans.pesan_id',
                'pesans.user_id',
                'pesans.tukang_id',
                'pesans.isComplete',
                'pesans.keahlian_id',
                'pesans.created_at',
                'tukangs.nama',
                'keahlians.nama_keahlian'
            )
            ->join(
                'tukangs',
                'tukangs.tukang_id','=','pesans.tukang_id'
            )->join(
                'keahlians',
                'keahlians.keahlian_id','=','pesans.keahlian_id'
            )
            ->where('user_id', '=', Auth::user()->user_id)
            ->where('isComplete', '=', 3)
            ->get();
            //dd($pesanans);

        return view('pesantukang.daftar-pesanan-selesai')->with('pesanans', $pesanans);
    }

    public function showDetailPesananSelesai($id)
    {
        $pesanan = Pesan::findOrFail($id);
        $detail_pesanan = 0;
        $total = 0;
        $tambahans = 0;
        
            $total = $pesanan->total;
            $tambahans = Pekerjaan::where('pesan_id', '=', $id)->get();
            if(count($tambahans) > 0)
            {
                foreach ($tambahans as $tambahan) {
                    $total = $total + $tambahan->harga;
                }
            }
            $detail_pesanan = DB::table('pesans')
            ->select(
                'pesans.pesan_id',
                'tukangs.tukang_id',
                'tukangs.foto',
                'tukangs.nama',
                'tukangs.no_telp',
                'keahlians.nama_keahlian',
                'keahlians.biaya'
            )
            ->join(
                'tukangs',
                'tukangs.tukang_id','=','pesans.tukang_id'
            )->join(
                'keahlians',
                'keahlians.keahlian_id','=','pesans.keahlian_id'
            )
            ->where('pesans.pesan_id', '=', $id)
            ->get();

            $rate = Rate::where('pesan_id', '=', $id)->get();

            return view('pesantukang.detail-pesanan-pengguna-selesai')->with('detail_pesanan', $detail_pesanan)->with('pesanan', $pesanan)->with('total', $total)->with('tambahans', $tambahans)->with('rate', $rate);
        
    }

    public function rate(Request $request, $id)
    {
        $chk_rate = Rate::where('pesan_id', '=', $request->pesan_id)->get();
        
        if(count($chk_rate)>0)
        {
            $rate = Rate::findOrFail($request->rate_id);
            if($request->rating==NULL)
            {
                $request->rating = 0;
            }

            if(!$request->foto==NULL)
            {
                $file = $request->file('foto');
                $fileName = $file->getClientOriginalName();
                $request->file('foto')->move("image/", $fileName);
                $rate->foto_testimoni = $fileName;
            }

            $rate->testimoni = $request->testimoni;
            $rate->rate_tukang = $request->rating;
            $rate->save();

        }
        else
        {
            $rate = new Rate;
            $rate->user_id = Auth::user()->user_id;
            $rate->tukang_id = $id;
            $rate->pesan_id = $request->pesan_id;
            if($request->rating==NULL)
            {
                $request->rating = 0;
            }

            if(!$request->foto==NULL)
            {
                $file = $request->file('foto');
                $fileName = $file->getClientOriginalName();
                $request->file('foto')->move("image/", $fileName);
                $rate->foto_testimoni = $fileName;
            }
            
            $rate->testimoni = $request->testimoni;
            $rate->rate_tukang = $request->rating;
            $rate->save();
        }
        return redirect('/home');
    }
}
