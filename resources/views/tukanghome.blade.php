@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard Tukang</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                    Hello {{Auth::guard('tukang')->user()->nama}}
                    <a href="{{ route('daftar.pesanan') }}">{{ __('Daftar Pesanan') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
