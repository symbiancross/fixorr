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
                                        <td class="table-text"><div>{{ $pesanan->nama_keahlian }}</div></td>
                                                                              
                                            <td class="table-text"><div>{{ $pesanan->nama }}</div></td>     
                                            <td class="table-text"><div>{{ $pesanan->created_at }}</div></td>
                                            <td>
                                            <form action="{{ route('list.pesanan.selesai.detail', $pesanan->pesan_id) }}" method="GET">
                                                @csrf

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-trash"></i>Detil Pesanan
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
            @endif
@endsection