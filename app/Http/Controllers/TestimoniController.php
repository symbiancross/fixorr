<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rate;
use App\Tukang;

class TestimoniController extends Controller
{
    public function showTestimoni()
    {
    	$tukangs = Rate::with('tukang')->select('tukang_id')->distinct()->get();

        foreach ($tukangs as $tukang) {
            $total=0;
            $rates = Rate::select('rate_tukang')->where('tukang_id', $tukang->tukang_id)->get();
            $keahlian = Tukang::where('tukang_id', $tukang->tukang_id)->first();
            foreach ($rates as $rate) {
                $total=$total+$rate->rate_tukang;
            }
            $count=count($rates);
            $avg_rate=$total/$count;
            $tukang['average']=$avg_rate;
            $tukang['keahlian']=$keahlian->keahlian->nama_keahlian;
        }

        $sortedtukangs=$tukangs->sortByDesc('average');

    	return view('noauth.testimoni')->with('sortedtukangs', $sortedtukangs);
    }

    public function urutkan(Request $request)
    {
    	$selected=$request->urutkan; 

        $tukangs = Rate::with('tukang')->select('tukang_id')->distinct()->get();

        foreach ($tukangs as $tukang) {
            $total=0;
            $rates = Rate::select('rate_tukang')->where('tukang_id', $tukang->tukang_id)->get();
            
            foreach ($rates as $rate) {
                $total=$total+$rate->rate_tukang;
            }
            
            $count=count($rates);
            $avg_rate=$total/$count;
            $tukang['average']=$avg_rate;
        }

    	if($selected==1)
    	{
    		$sortedtukangs= $tukangs->sortByDesc('average');
    	}
    	else
    	{
    		$sortedtukangs= $tukangs->sortBy('average');
    	}
    	
    	return view('noauth.testimoni')->with('sortedtukangs', $sortedtukangs)->with('selected', $selected);
    }
}
