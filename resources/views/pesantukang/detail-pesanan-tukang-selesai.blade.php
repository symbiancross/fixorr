@extends('layouts.app')

@section('content')

<center>
    @if($detail_pesanan[0]->foto==NULL)
        <center><img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
    @else
        <center><img src="{{ asset('image/'.$detail_pesanan[0]->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
    @endif
    {{ $detail_pesanan[0]->nama }}<br>
</center> 

@if(count($rate)>0)
<div class="wrapper">
        @if($rate[0]->foto_testimoni==NULL)
            <center><img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center> 
        @else
            <center><img src="{{ asset('image/'.$rate[0]->foto_testimoni)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
        @endif
        
        <center>
            @for ($i = 0; $i < $rate[0]->rate_tukang; $i++)
            <img src="{{ asset('images/star-on-big.png') }}">
            @endfor
            @for ($i = 0; $i < 5-$rate[0]->rate_tukang; $i++)
            <img src="{{ asset('images/star-off-big.png') }}">
            @endfor</center> 
        <br>
        
        @if (!$rate[0]->testimoni==NULL)
            <center>{{ $rate[0]->testimoni }}</center>
        @endif 
</div>
@endif


<div class="panel-body">
    <table class="table table-striped task-table">
        <thead>
            <th>Jenis Tukang</th>
            <th>Biaya</th>
        </thead>
        <tbody>
            <tr>
                <td class="table-text"><div>{{ $detail_pesanan[0]->nama_keahlian }}</div></td>
                <td class="table-text"><div>Rp {{ number_format($detail_pesanan[0]->biaya,2,',','.') }}</div></td>
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
                        <td class="table-text"><div>Rp {{ number_format($tambahan->harga->biaya,2,',','.') }}</div></td>
                    </tr>
                @endforeach
            </tbody>
        @endif
    </table>
</div>            
@endsection