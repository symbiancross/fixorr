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
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($pesanans as $pesanan)
                                    <tr>
                                        <td class="table-text"><div>{{ $pesanan->nama_keahlian }}</div></td>
                                        @if($pesanan->isComplete==0)
                                            <td class="table-text"><div>sedang mencari tukang</div></td>                                      
                                        @else                                        
                                            <td class="table-text"><div>{{ $pesanan->nama }}</div></td>                                      
                                        @endif                                        
                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button type="submit" class="btn btn-danger">
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