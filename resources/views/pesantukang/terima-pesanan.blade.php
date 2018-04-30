@extends('layouts.app')

@section('content')
@if (count($pesans) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Current Tasks
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <thead>
                                <th>Pesanan</th>
                                <th>&nbsp;</th>
                            </thead>
                            <tbody>
                                @foreach ($pesans as $pesan)
                                @if ( $pesan->keahlian == Auth::guard('tukang')->user()->keahlian_id && $pesan->isComplete == 0)
                                    <tr>
                                        <td class="table-text"><div>{{ $pesan->user->nama }}</div></td>
                                        <td class="table-text"><div>{{ $pesan->keahlian }}</div></td>

                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ route('terima.pesanan', $pesan->pesan_id) }}" method="POST">
                                                {{ csrf_field() }}

                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-btn fa-trash"></i>Terima
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
</div>
@endsection