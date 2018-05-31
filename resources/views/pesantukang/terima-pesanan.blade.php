@extends('layouts.app')

@section('content')
@if (count($pesans) > 0)
    @if($cek_pesanan == 1)
        @if ($pesanan[0]->isComplete == 1 || $pesanan[0]->isComplete == 2)
            <center>
                @if($detail_user->foto==NULL)
                <center><img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
                @else
                    <center><img src="{{ asset('image/'.$detail_user->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
                @endif
                {{ $detail_user->nama }}<br>
                {{ $pesanan[0]->alamat }}<br>
                {{ $detail_user->no_telp }}<br>
                @if ($pesanan[0]->isComplete == 1)
                    <form action="{{ route('status', $pesanan[0]->pesan_id) }}" method="POST">
                            {{ csrf_field() }}

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-trash"></i>Sampai
                        </button>
                    </form>
                @elseif ($pesanan[0]->isComplete == 2)
                    <form action="{{ route('biaya') }}" method="GET">

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-trash"></i>Total
                        </button>
                    </form>
                @endif
                <br>
                @if(isset($map))
                    {!! $map['js'] !!}
                    {!! $map['html'] !!}
                @endif
            </center>
        @endif
    @else
        

        <div class="panel-body container">
            <table class="table table-striped task-table">
                <thead>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Nomer Telepon</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Expired Pemesanan</th>
                    <th>&nbsp;</th>
                </thead>
                <tbody>
                    <?php
                        $i = 0;
                    ?>
                    @foreach ($pesans as $pesan)
                        
                            <tr>
                                <td class="table-text"><div>{{ $pesan->user->nama }}</div></td>
                                <td class="table-text"><div>{{ $pesan->alamat }}</div></td>
                                <td class="table-text"><div>{{ $pesan->user->no_telp }}</div></td>
                                <td class="table-text"><div>{{ $pesan->created_at }}</div></td>
                                
                                <td class="table-text"><div>{{ $expireds[$i] }}</div></td>
                                <td>
                                    <form action="{{ route('status', $pesan->pesan_id) }}" method="POST">
                                        {{ csrf_field() }}

                                        <button type="submit" class="btn btn-success">
                                            <i class="fa fa-btn fa-trash"></i>Terima
                                        </button>
                                    </form>
                                </td>
                            </tr>
                       <?php $i++;  ?>
                    @endforeach            
                </tbody>
            </table>
        </div>
        </div>
    @endif
@endif
@endsection