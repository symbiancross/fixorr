@extends('layouts.app')

@section('content')
@if (count($pesans) == 0 && $cek_pesanan==1)
        @if ($pesanan[0]->isComplete == 1 || $pesanan[0]->isComplete == 2  || $pesanan[0]->isComplete == 3)
            <center>
                @if($detail_user->foto==NULL)
                <center><img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
                @else
                    <center><img src="{{ asset('image/'.$detail_user->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
                @endif
                <br>
                @if ($pesanan[0]->isComplete == 1)
                    <form action="{{ route('status', $pesanan[0]->pesan_id) }}" method="POST">
                            {{ csrf_field() }}

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-trash"></i>Sampai
                        </button>
                    </form>
                @elseif ($pesanan[0]->isComplete == 2  || $pesanan[0]->isComplete == 3)
                    <form action="{{ route('biaya') }}" method="GET">

                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-btn fa-trash"></i>Total
                        </button>
                    </form>
                @endif
                <br>
                    <div class="panel-body container">
                        <table class="table table-striped task-table">
                            <tr>
                                <td class="table-text">Nama</div></td>
                                <td class="table-text"><div>{{ $detail_user->nama }}</div></td>
                            </tr>
                            <tr>
                                <td class="table-text">Alamat</div></td>
                                <td class="table-text">{{ $pesanan[0]->alamat }}<br></td>
                            </tr>
                            <tr>
                                <td class="table-text">No. Telepon</div></td>
                                <td class="table-text">{{ $detail_user->no_telp }}<br></td>
                            </tr>   
                            <tr>
                                <td class="table-text">Deskripsi Kerusakan</div></td>
                                <td class="table-text">{{ $pesanan[0]->deskripsi }}<br></td>
                            </tr> 
                            <tr>
                                <td class="table-text">Foto Kerusakan</div></td>
                                <td class="table-text">
                                    @foreach($images as $image)
                                    <a target="_blank" href="{{ asset('files/'.$image)  }}">
                                    <img src="{{ asset('files/'.$image)  }}"  style="float: left; width: 10%; margin-right: 1%; margin-bottom: 0.5em;" class="img-responsive thumb" alt="--"></a>
                                    @endforeach
                                </td>
                            </tr>   
                        </table>
                    </div>
                
                <br>
                @if(isset($map))
                    {!! $map['js'] !!}
                    {!! $map['html'] !!}
                @endif
            </center>
        @endif
@elseif(count($pesans) > 0)
        
    <div class="panel-body container">
        <table class="table table-striped task-table">
            <thead>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Nomer Telepon</th>
                 <th>Tanggal Pemesanan</th>
                <th>Expired Pemesanan</th>
                    <th>&nbsp;</th>
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
                        <form action="{{ route('daftar.pesanan.aktif.detail', $pesan->pesan_id) }}" method="GET">
                        {{ csrf_field() }}

                            <button type="submit" class="btn btn-success">
                                <i class="fa fa-btn fa-trash"></i>Detail
                            </button>
                        </form>
                    </td>
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
@else
    <center><strong>Belum ada pesanan</strong></center>
@endif
@endsection