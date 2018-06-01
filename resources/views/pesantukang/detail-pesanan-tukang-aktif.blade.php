@extends('layouts.app')

@section('content')
<center>
    @if($detail->user->foto==NULL)
        <center><img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
    @else
        <center><img src="{{ asset('image/'.$detail->user->foto)  }}" id="showgambar" style="max-width:200px;max-height:200px;" class="form-control"></center>
    @endif
    <br>
    <form action="{{ route('daftar.pesanan') }}" method="GET" style="display: inline;">
    {{ csrf_field() }}
        <button type="submit" class="btn btn-danger">
            <i class="fa fa-btn fa-trash"></i>Kembali
        </button>
    </form>
    <form action="{{ route('status', $detail->pesan_id) }}" method="POST" style="display: inline;">
    {{ csrf_field() }}
        <button type="submit" class="btn btn-success">
            <i class="fa fa-btn fa-trash"></i>Terima
        </button>
    </form>
</center><br> 
    <div class="panel-body container">
        <table class="table table-striped task-table">
            <tr>
                <td class="table-text">Nama</div></td>
                <td class="table-text"><div>{{ $detail->user->nama }}</div></td>
            </tr>
            <tr>
                <td class="table-text">Alamat</div></td>
                <td class="table-text">{{ $detail->alamat }}<br></td>
            </tr>
            <tr>
                <td class="table-text">No. Telepon</div></td>
                <td class="table-text">{{ $detail->user->no_telp }}<br></td>
            </tr>   
            <tr>
                <td class="table-text">Deskripsi Kerusakan</div></td>
                <td class="table-text">{{ $detail->deskripsi }}<br></td>
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
    <center>
    {!! $map['js'] !!}
    {!! $map['html'] !!}
    </center>         
   
@endsection