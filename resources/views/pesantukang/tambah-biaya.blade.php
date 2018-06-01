@extends('layouts.app')

@section('content')
@if($cek_pesanan==1)
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            @if(!$isComplete==3)
            <div class="panel panel-default">

                <div class="panel-heading">
                    Kekurangan
                </div>

                <div class="panel-body">
                    
                    <form action="{{ route('tambah.kekurangan') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="kekurangan" class="col-sm-3 control-label">Nama Kekurangan</label>

                            <div class="col-sm-6">
                                <input type="text" name="kekurangan" id="kekurangan" class="form-control{{ $errors->has('kekurangan') ? ' is-invalid' : '' }}" value="{{ old('kekurangan') }}" required autofocus>
                            </div>

                            <label for="harga" class="col-sm-3 control-label">Harga</label>

                            <div class="col-sm-6">
                                <input type="number" name="harga" id="harga" class="form-control{{ $errors->has('harga') ? ' is-invalid' : '' }}" value="{{ old('harga') }}" required autofocus>
                            </div>
                        </div>

                       
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endif

            <!-- Current Tasks -->
            @if (count($kekurangans) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Daftar Kekurangan
                    </div>

                    <div class="panel-body container">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Kekurangan biaya</th>
                                <th>Harga</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($kekurangans as $kekurangan)
                                    <tr>
                                        <td class="table-text"><div>{{ $kekurangan->pekerjaan }}</div></td>
                                        <td class="table-text"><div>Rp {{ number_format($kekurangan->harga,2,',','.') }}</div></td>
                                        <!-- Task Delete Button -->
                                        @if(!$isComplete==3)
                                        <td>
                                            <form action="{{ route('hapus.kekurangan', $kekurangan->pekerjaan_id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            @endif
            @if($isComplete==3)
            <form action="{{ route('status', $pesan_id) }}" method="POST">
            @csrf

            <button type="submit" class="btn btn-success">
                <i class="fa fa-btn fa-trash"></i>Selesai
            </button>
            </form>
            @endif
        </div>
</div>
@else
<center>belum dapat menambahkan kekurangan</center>
@endif
@endsection