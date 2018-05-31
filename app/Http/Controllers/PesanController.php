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
use GeneaLabs\LaravelMaps\Facades\Map;


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
        $config = array();
        $config['center'] = 'Wisma tengger';
        $config['map_height'] = '0px';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'alamat';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'createMarker_map({ map: map, position:event.latLng });';
        Map::initialize($config);

        $map = Map::create_map();

        return view('pesantukang.pesan')->with('user', $user)->with('keahlian', $keahlian)->with('map', $map);
    }

    public function pesan(Request $request)
    {
        $created_at=DB::table('pesans')
                ->where('user_id', '=', Auth::user()->user_id)
                ->latest()
                ->first();
        $latest=strtotime($created_at->created_at);
        $latest=strtotime("+2 hours", $latest);
        $now=strtotime(now());
        
        if($latest>$now)
        {
            return redirect('home')->with('tunggu', 'harap menunggu 2 jam untuk memesan kembali');
        }

        $cekkesamaan=DB::table('pesans')
                ->where('user_id', '=', Auth::user()->user_id)
                ->where('keahlian_id', '=', $request->keahlian)
                ->where('pesans.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 2 DAY)'))
                ->whereIn('isComplete', [0, 1, 2])->get();
        
        if($cekkesamaan>0)
        {
            return redirect('home')->with('sama', 'maaf anda tidak bisa memesan tukang dengan keahlian yang sama, harap tunggu 2 hari atau sampai pesanan dengan keahlian yang sama selesai');
        }

        $this->validate($request, [
            'deskripsi' => 'required',
            
            'photos' => 'required',

            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if($request->hasfile('photos'))
        {

            foreach($request->file('photos') as $file)

            {

                $name=$file->getClientOriginalName();

                $file->move(public_path().'/files/', $name);  

                $data[] = $name;  

            }

         }
       
        $pesan = new Pesan;
        $pesan->user_id = Auth::user()->user_id;
        $pesan->total = $request->input('total');
        $pesan->alamat = $request->input('alamat');
        $pesan->keahlian_id = $request->input('keahlian');
        $pesan->deskripsi = $request->input('deskripsi');
        $pesan->foto = json_encode($data);
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
            ->where('pesans.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 2 DAY)'))
            ->whereIn('isComplete', [0])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $pesanans2 = DB::table('pesans')
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
            ->whereIn('isComplete', [1,2])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $count = 0;
        $expireds= [];

        foreach ($pesanans as $pesanan ) {
            $expired=strtotime($pesanan->created_at);
            $expired=strtotime("+2 day", $expired);
            $expired=date('Y-m-d H:i:s', $expired);
            $expireds[$count++]=$expired;
        }
            
            //dd($pesanans);

        return view('pesantukang.daftar-pesanan-aktif')->with('pesanans', $pesanans)->with('expireds', $expireds)->with('pesanans2', $pesanans2);
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
            ->orderBy('created_at', 'desc')
            ->paginate(10);
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
        
        return redirect('/home');
    }
}
