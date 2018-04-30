@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Konfirmasi Pemesanan</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('pesan.tukang.submit') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ $user->alamat }}" required autofocus>

                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="biaya" class="col-md-4 col-form-label text-md-right">{{ __('Biaya') }}</label>

                            <div class="col-md-6 col-form-label">
                                <input type="hidden" id="total" name="total" value="{{ $keahlian->biaya }}">
                                <input type="hidden" id="keahlian" name="keahlian" value="{{ $keahlian->keahlian_id }}">
                                <strong>{{ $keahlian->biaya }}</strong>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Pesan') }}
                                </button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection