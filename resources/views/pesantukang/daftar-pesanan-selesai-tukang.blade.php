@extends('layouts.app')

@section('content')
            <!-- Current Tasks -->
            @if (count($pesanans) > 0)
                <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                        <th>Pesanan</th>
                        <th>&nbsp;</th>
                    </thead>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Keahlian</th>
                                <th>Nama</th>
                                <th>Tanggal Pemesanan</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($pesanans as $pesanan)
                                    <tr>
                                                                              
                                            <td class="table-text"><div>{{ $pesanan->nama }}</div></td>     
                                            <td class="table-text"><div>{{ $pesanan->created_at }}</div></td>
                                            <td>
                                            <form action="{{ route('daftar.pesanan.selesai.detail', $pesanan->pesan_id) }}" method="GET">
                                                @csrf

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-trash"></i>Detil Pelayanan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
            </table>
            </div>
            @else
            <center>Belum ada pesanan selesai</center>
            <center>Silahkan mencari atau menyelesaikan pesanan di <a href="{{ route('daftar.pesanan') }}">{{ __('sini') }}</a><br></center>
            @endif
@endsection