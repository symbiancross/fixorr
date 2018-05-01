@extends('layouts.app')

@section('content')
@if($cek_pesanan==1)
    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Kekurangan
                </div>

                <div class="panel-body">
                    <!-- Display Validation Errors -->

                    <!-- New Task Form -->
                    <form action="{{ route('tambah.kekurangan') }}" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Task Name -->
                        <div class="form-group">
                            <label for="kekurangan" class="col-sm-3 control-label">Nama Kekurangan</label>

                            <div class="col-sm-6">
                                <input type="text" name="kekurangan" id="kekurangan" class="form-control">
                            </div>

                            <label for="harga" class="col-sm-3 control-label">Harga</label>

                            <div class="col-sm-6">
                                <input type="number" name="harga" id="harga" class="form-control">
                            </div>
                        </div>

                        <!-- Add Task Button -->
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

            <!-- Current Tasks -->
            @if (count($kekurangans) > 0)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Daftar Kekurangan
                    </div>

                    <div class="panel-body">
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
                                        <td class="table-text"><div>{{ $kekurangan->harga }}</div></td>
                                        <!-- Task Delete Button -->
                                        <td>
                                            <form action="{{ route('hapus.kekurangan', $kekurangan->pekerjaan_id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf

                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i>Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
</div>
@else
belum dapat menambahkan kekurangan
@endif
@endsection