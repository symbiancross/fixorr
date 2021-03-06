@extends('layouts.app')

@section('content')
            <!-- Current Tasks -->
            @if (count($pesanans) > 0 || count($pesanans2)>0)
                <div class="panel-body container">
                <table class="table table-striped task-table">
                    <thead>
                        <th>Pesanan</th>
                        <th>&nbsp;</th>
                    </thead>

                    <div class="panel-body container">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Keahlian</th>
                                <th>Nama</th>
                                <th>Tanggal Pemesanan</th>
                                <th>Expired Pemesanan</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                ?>
                                @if (count($pesanans2) > 0)
                                @foreach ($pesanans2 as $pesanan2)
                                
                                    <tr>
                                        <td class="table-text"><div>{{ $pesanan2->nama_keahlian }}</div></td>
                                                                                
                                        <td class="table-text"><div>{{ $pesanan2->nama }}</div></td>    
                                        <td class="table-text"><div>{{ $pesanan2->created_at }}</div></td>

                                        <td class="table-text"><div>Pesanan Sudah diterima</div></td>                       
                                        <td>
                                            <form action="{{ route('list.pesanan.aktif.detail', $pesanan2->pesan_id) }}" method="GET">
                                                @csrf

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-trash"></i>Detil Pesanan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                                @if (count($pesanans) > 0)
                                @foreach ($pesanans as $pesanan)
                                
                                    <tr>
                                        <td class="table-text"><div>{{ $pesanan->nama_keahlian }}</div></td>
                                        @if($pesanan->isComplete==0)
                                            <td class="table-text"><div>sedang mencari tukang</div></td>                                     
                                        @endif 
                                        <td class="table-text"><div>{{ $pesanan->created_at }}</div></td>

                                        <td class="table-text"><div>{{ $expireds[$i] }}</div></td>                       
                                        <td>
                                            <form action="{{ route('list.pesanan.aktif.detail', $pesanan->pesan_id) }}" method="GET">
                                                @csrf

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-trash"></i>Detil Pesanan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $i++;  ?>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                
            </table>
            </div>
            @endif
@endsection