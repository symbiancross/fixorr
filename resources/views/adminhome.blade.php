@extends('layouts.app')

@section('content')
@if (count($tukangs) > 0)
                <div class="panel-body container">
                <table class="table table-striped task-table">
                    <thead>
                        <th>Tukang</th>
                        <th>&nbsp;</th>
                    </thead>

                    
                        <table class="table table-hover">
                            <thead>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($tukangs as $tukang)
                                
                                    <tr>
                                        <td class="table-text"><div>{{ $tukang->nama }}</div></td>
                                        
                                        <td class="table-text"><div>{{ $tukang->email }}</div></td>

                                                              
                                        <td>
                                            <form action="{{ route('admin.aktifkan', $tukang->tukang_id)}}" method="POST">
                                                @csrf

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-trash"></i>Aktifkan
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $tukangs->links() }}
                    
                
            </table>
            </div>
            @endif
@endsection
