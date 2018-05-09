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