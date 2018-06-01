@extends('layouts.app')

@section('content')
@if($pesanan->isComplete==0)
      <center>masih mencari tukang</center>      
@else 
<center>
                <center><img src="{{ asset('image/'.$detail_pesanan[0]->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
                {{ $detail_pesanan[0]->nama }}<br>
                {{ $detail_pesanan[0]->no_telp }}<br>
                @if($pesanan->isComplete==1)
                status: dalam perjalanan<br>
                @elseif($pesanan->isComplete==2)
                status: sudah sampai<br>
                @endif
                Total : {{ $total }}
                
                @if($pesanan->isComplete==2)
                <form action="{{ route('selesai', $detail_pesanan[0]->pesan_id) }}" method="POST">
                @csrf

                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-btn fa-trash"></i>Selesai
                    </button>
                </form>
                @endif<br>
                <div class="panel-body container">
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
                
                
            </center> 
            @endif     
@endsection