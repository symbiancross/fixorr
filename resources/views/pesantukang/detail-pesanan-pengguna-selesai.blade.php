@extends('layouts.app')

@section('content')

<center>
    <center><img src="{{ asset('image/'.$detail_pesanan[0]->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
    {{ $detail_pesanan[0]->nama }}<br>
    {{ $detail_pesanan[0]->no_telp }}<br>
                
           
    
    Total : {{ $total }}
</center> 

<div class="wrapper">
    <form action="{{ route('rate', $detail_pesanan[0]->tukang_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    

                            
                        
    @if(count($rate)>0)

        @if($rate[0]->foto_testimoni==NULL)
            <center><img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
        @else
            <center><img src="{{ asset('image/'.$rate[0]->foto_testimoni)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
        @endif
        
        <input type="file" id="inputgambar" name="foto" class="form-control">
        @if ($errors->has('foto'))
            <span class="help-block">
                <strong>{{ $errors->first('foto') }}</strong>
            </span>
        @endif
        
        <span class="rating">
            <input id="rating5" type="radio" name="rating" value="5" @if(isset($rate) && $rate[0]->rate_tukang=="5") checked @endif>
            <label for="rating5">5</label>
            <input id="rating4" type="radio" name="rating" value="4" @if(isset($rate) && $rate[0]->rate_tukang=="4") checked @endif>
            <label for="rating4">4</label>
            <input id="rating3" type="radio" name="rating" value="3" @if(isset($rate) && $rate[0]->rate_tukang=="3") checked @endif>
            <label for="rating3">3</label>
            <input id="rating2" type="radio" name="rating" value="2" @if(isset($rate) && $rate[0]->rate_tukang=="2") checked @endif>
            <label for="rating2">2</label>
            <input id="rating1" type="radio" name="rating" value="1" @if(isset($rate) && $rate[0]->rate_tukang=="1") checked @endif>
            <label for="rating1">1</label>
        </span><br>
        <center>
        @if (!$rate[0]->testimoni==NULL)
            <textarea id="testimoni" name="testimoni" class="pb-cmnt-textarea" placeholder="Tuliskan testimoni anda disini!">{{ $rate[0]->testimoni }}</textarea>
        @else
            <textarea id="testimoni" name="testimoni" class="pb-cmnt-textarea" placeholder="Tuliskan testimoni anda disini!"></textarea>
        @endif   
        <input type="hidden" id="pesan_id" name="pesan_id" value="{{ $detail_pesanan[0]->pesan_id }}">
        <input type="hidden" id="rate_id" name="rate_id" value="{{ $rate[0]->rate_id }}">
        <center> 
            <button type="submit" class="btn btn-success">
                <i class="fa fa-btn fa-trash"></i>Update Rating
            </button>
        </center>
            
        @else
        <center><img src="{{ asset('image/'.$rate->foto_testimoni)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
                
        <input type="file" id="inputgambar" name="foto" class="form-control">
        @if ($errors->has('foto'))
            <span class="help-block">
                <strong>{{ $errors->first('foto') }}</strong>
            </span>
        @endif
            
        <span class="rating">
            <input id="rating5" type="radio" name="rating" value="5">
            <label for="rating5">5</label>
            <input id="rating4" type="radio" name="rating" value="4">
            <label for="rating4">4</label>
            <input id="rating3" type="radio" name="rating" value="3">
            <label for="rating3">3</label>
            <input id="rating2" type="radio" name="rating" value="2" checked>
            <label for="rating2">2</label>
            <input id="rating1" type="radio" name="rating" value="1">
            <label for="rating1">1</label>
        </span>
        <center>
        <textarea id="testimoni" name="testimoni" placeholder="Tuliskan komentar anda disini!" class="pb-cmnt-textarea"></textarea>
        
        <input type="hidden" id="pesan_id" name="pesan_id" value="{{ $detail_pesanan[0]->pesan_id }}">
         <button type="submit" class="btn btn-success">
        <i class="fa fa-btn fa-trash"></i>Rate
        </button></center>
    @endif
    </form>
</div>
<div class="panel-body">
    <table class="table table-striped task-table">
        <thead>
            <th>Jenis Tukang</th>
            <th>Biaya</th>
        </thead>
        <tbody>
            <tr>
                <td class="table-text"><div>{{ $detail_pesanan[0]->nama_keahlian }}</div></td>
                <td class="table-text"><div>{{ $detail_pesanan[0]->biaya }}</div></td>
            </tr>
        </tbody>
        @if(count($tambahans)>0)
            <thead>
                <th>Kekurangan</th>
                <th>Harga</th>
            </thead>
            <tbody>
                @foreach($tambahans as $tambahan)
                    <tr>
                        <td class="table-text"><div>{{ $tambahan->pekerjaan }}</div></td>
                        <td class="table-text"><div>{{ $tambahan->harga }}</div></td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
</div>            
@endsection