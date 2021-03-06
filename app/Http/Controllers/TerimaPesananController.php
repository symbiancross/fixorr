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
use App\Rate;
use GeneaLabs\LaravelMaps\Facades\Map;

class TerimaPesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:tukang');
   	}

    public function showDaftarPesanan()
    {
        $pesans = Pesan::with('user')->orderBy('created_at', 'desc')
        ->where('keahlian_id', '=', Auth::user()->keahlian_id)
        ->where('isComplete', '=', 0)
        ->where('created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 2 DAY)'))
        ->paginate(10);

        $pesanan = DB::table('pesans')->where('tukang_id', '=', Auth::user()->tukang_id)->whereIn('isComplete', [1, 2, 3])->get();        

        $cek_pesanan = 0;
        $detail_user = new User;
        $pesanan_id = 0;
        
        if(count($pesanan)==1)
        {
            $cek_pesanan = 1;
            $detail_user = User::findOrFail($pesanan[0]->user_id);

            $images=json_decode($pesanan[0]->foto, true);

            $config = array();
            $config['center'] = $pesanan[0]->alamat;
            $config['map_height'] = '300px';
            $config['map_width'] = '300px';
            $config['places'] = TRUE;
            
            Map::initialize($config);

            $marker = array();
            $marker['position'] = $pesanan[0]->alamat;
            Map::add_marker($marker);

            $map = Map::create_map();

            return view('pesantukang.terima-pesanan')->with('pesans', $pesans)->with('cek_pesanan', $cek_pesanan)->with('detail_user', $detail_user)->with('pesanan', $pesanan)->with('map', $map)->with('images', $images);
        }

        $rates = DB::table('rates')->where('tukang_id', '=', Auth::user()->tukang_id)->get();
        $count = 0;
        $total = 0;
        if(count($rates)>0)
        {
            foreach ($rates as $rate) {
                $total = $total+$rate->rate_tukang;
                $count++;
            }

            $hasil = $total/$count;

            
            if ($hasil==4) 
            {
                $count=0;
                foreach ($pesans as $pesan) {
                    $time=strtotime($pesan->created_at);
                    $timestart=strtotime("+15 minute", $time);
                    $timenow=strtotime(now());
                    
                    if($timestart >= $timenow)
                    {
                        $pesans->forget($count);
                    }
                    $count++;
                }
            }
            elseif ($hasil==3) 
            {
                $count=0;
                foreach ($pesans as $pesan) {
                    $time=strtotime($pesan->created_at);
                    $timestart=strtotime("+20 minute", $time);
                    $timenow=strtotime(now());
                    
                    if($timestart >= $timenow)
                    {
                        $pesans->forget($count);
                    }
                    $count++;
                }
            }
            elseif ($hasil==2) 
            {
                $count=0;
                foreach ($pesans as $pesan) {
                    $time=strtotime($pesan->created_at);
                    $timestart=strtotime("+25 minute", $time);
                    $timenow=strtotime(now());
                    
                    if($timestart >= $timenow)
                    {
                        $pesans->forget($count);
                    }
                    $count++;
                }
            }
            elseif ($hasil==1) 
            {
                $count=0;
                foreach ($pesans as $pesan) {
                    $time=strtotime($pesan->created_at);
                    $timestart=strtotime("+30 minute", $time);
                    $timenow=strtotime(now());
                    
                    if($timestart >= $timenow)
                    {
                        $pesans->forget($count);
                    }
                    $count++;
                }
            }

        }

        $count = 0;
        $expireds = [];

        foreach ($pesans as $pesan ) {
            $expired=strtotime($pesan->created_at);
            $expired=strtotime("+2 day", $expired);
            $expired=date('Y-m-d H:i:s', $expired);
            $expireds[$count++]=$expired;
        }


        return view('pesantukang.terima-pesanan')->with('pesans', $pesans)->with('cek_pesanan', $cek_pesanan)->with('detail_user', $detail_user)->with('pesanan', $pesanan)->with('expireds', $expireds);
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
            $pesan->isComplete = 4;
            $pekerjaans = Pekerjaan::where('pesan_id', '=', $id)->get();
            if(count($pekerjaans)>0)
            {
                $total = $pesan->total;
                foreach ($pekerjaans as $pekerjaan)
                {
                    $total = $total+$pekerjaan->harga;
                }
                $pesan->total = $total;
            }

            $pesan->save();
            return redirect('tukang');
        }   
    }

    public function showTambahPembayaran()
    {
        $pesan = DB::table('pesans')->where('tukang_id', '=', Auth::user()->tukang_id)->whereIn('isComplete', [2, 3])->get();
        $kekurangans = new Pekerjaan;
        $pesan_id = 0;
        $cek_pesanan = 0;
        $isComplete = 0;
        if(count($pesan)==1)
        {
            $cek_pesanan = 1;            
            $pesan_id = $pesan[0]->pesan_id;
            $isComplete = $pesan[0]->isComplete;
            
            $kekurangans = DB::table('pekerjaans')
            ->where('tukang_id', '=', Auth::user()->tukang_id)
            ->where('pesan_id', '=', $pesan_id)
            ->get();
            
            return view('pesantukang.tambah-biaya')->with('kekurangans', $kekurangans)->with('cek_pesanan', $cek_pesanan)->with('pesan_id', $pesan_id)->with('isComplete', $isComplete);
        }
        else
        {
            return view('pesantukang.tambah-biaya')->with('kekurangans', $kekurangans)->with('cek_pesanan', $cek_pesanan)->with('pesan_id', $pesan_id)->with('isComplete', $isComplete);
        }
        
    }

    public function tambahKekurangan(Request $request)
    {
        $validator = $request->validate([
            'kekurangan' => 'required|max:255',
            'harga' => 'required|numeric|between:0.001,999999999',
        ]);

        $pesan = DB::table('pesans')->where('tukang_id', '=', Auth::user()->tukang_id)->whereIn('isComplete', [2, 3])->get();
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

    public function showDaftarPesananSelesai()
    {
        $pesanans = DB::table('pesans', 'users')
            ->select(
                'pesans.pesan_id',
                'pesans.user_id',
                'pesans.tukang_id',
                'pesans.isComplete',
                'pesans.keahlian_id',
                'pesans.created_at',
                'users.nama'
            )
            ->join(
                'users',
                'users.user_id','=','pesans.user_id'
            )
            ->where('tukang_id', '=', Auth::user()->tukang_id)
            ->where('isComplete', '=', 4)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            //dd($pesanans);

        return view('pesantukang.daftar-pesanan-selesai-tukang')->with('pesanans', $pesanans);
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
                'users.nama',
                'keahlians.nama_keahlian',
                'keahlians.biaya',
                'users.foto'
            )
            ->join(
                'users',
                'users.user_id','=','pesans.user_id'
            )->join(
                'keahlians',
                'keahlians.keahlian_id','=','pesans.keahlian_id'
            )
            ->where('pesans.pesan_id', '=', $id)
            ->get();

            $rate = Rate::where('pesan_id', '=', $id)->get();

            return view('pesantukang.detail-pesanan-tukang-selesai')->with('detail_pesanan', $detail_pesanan)->with('pesanan', $pesanan)->with('total', $total)->with('tambahans', $tambahans)->with('rate', $rate);
        
    }

    public function showDetailPesananAktif($id)
    {
        $detail=Pesan::with('user')->find($id);

        $images=json_decode($detail->foto, true);


        $config = array();
        $config['center'] = $detail->alamat;
        $config['map_height'] = '300px';
        $config['map_width'] = '300px';
        $config['places'] = TRUE;
       
        Map::initialize($config);

        $marker = array();
        $marker['position'] = $detail->alamat;
        Map::add_marker($marker);

        $map = Map::create_map();
        
        return view('pesantukang.detail-pesanan-tukang-aktif')->with('detail', $detail)->with('map', $map)->with('images', $images);
    }
}
