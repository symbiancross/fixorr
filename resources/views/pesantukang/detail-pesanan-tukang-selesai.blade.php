@extends('layouts.app')

@section('content')

<center>
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