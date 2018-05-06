@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Cari Keahlian
                </div>

                <div class="panel-body">
                    
                    <form action="{{ route('cari.keahlian.get') }}" method="GET" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="form-group">

                            <div class="col-sm-6">
                                <input type="text" name="keahlian" id="keahlian" class="form-control{{ $errors->has('keahlian') ? ' is-invalid' : '' }}" value="{{ old('keahlian') }}" required autofocus>
                            </div>

                        </div>

                       
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-btn fa-plus"></i>Cari Keahlian
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (isset($hasils))
                @if (count($hasils)>0)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Hasl Pencarian
                        </div>

                        <div class="panel-body">
                            <table class="table table-striped task-table">
                                
                                <tbody>
                                    @foreach ($hasils as $hasil)
                                        <tr>
                                            <td class="table-text"><div>{{ $hasil->nama_keahlian }}</div></td>
                                            <td>
                                                <form action="{{ route('pesan.tukang', $hasil->keahlian_id) }}" method="GET">
                                                    @csrf

                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fa fa-btn fa-trash"></i>Pilih
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                @else
                Pencarian tidak ditemukan
                @endif
            @endif
        </div>
</div>

@endsection