@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {!! session('success') !!}
                    </div>
            @endif
            <div class="card">
                <div class="card-header">Dashboard Pengguna</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br>
                    <a href="{{ route('user.edit') }}">{{ __('Edit profil pengguna') }}</a><br>
                    <a href="{{ route('welcome') }}">{{ __('Pesan Tukang') }}</a><br>
                    <a href="{{ route('list.pesanan.aktif') }}">{{ __('Daftar Pesanan Aktif') }}</a><br>
                    <a href="{{ route('list.pesanan.selesai') }}">{{ __('Riwayat Pemesanan') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
