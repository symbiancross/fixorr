@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Daftar Sebagai Tukang') }}</div>
                @if (session('status'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {!! session('status') !!}
                    </div>
                @endif
                <div class="card-body">
                    <form method="POST" action="{{ route('tukang.register.submit') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ __('Alamat') }}</label>

                            <div class="col-md-6">
                                <input id="alamat" type="text" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}" name="alamat" value="{{ old('alamat') }}" required autofocus>

                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>
                            {!! $map['js'] !!}
                            {!! $map['html'] !!}
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telephone" class="col-md-4 col-form-label text-md-right">{{ __('Nomor Telepon') }}</label>

                            <div class="col-md-6">
                                <input id="telephone" type="tel" pattern="^[0-9]*$" class="form-control{{ $errors->has('telephone') ? ' is-invalid' : '' }}" name="telephone" value="{{ old('telephone') }}" required>

                                @if ($errors->has('telephone'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('telephone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('foto') ? ' has-error' : '' }} row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>
                            
                            <div class="col-md-6">
                            <img src="http://placehold.it/100x100" id="showgambar" style="max-width:200px;max-height:200px;float:left;" class="form-control">
                            <input type="file" id="inputgambar" name="foto" class="form-control">
                            @if ($errors->has('foto'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('foto') }}</strong>
                                </span>
                            @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="keahlian" class="col-md-4 col-form-label text-md-right">{{ __('Keahlian') }}</label>

                            <div class="col-md-6">
                                <select name="keahlian" id="keahlian" class="form-control" >
                                    @foreach($keahlians as $keahlian)
                                        <option class="keahlian" value="{{ $keahlian->keahlian_id }} "> {{ $keahlian->nama_keahlian }} </option>
                                    @endforeach
                                        <option class="keahlian" value="0"> Tambah keahlian </option>
                                </select>

                                @if ($errors->has('keahlian'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('keahlian') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row keahlian_baru">
                            <label for="keahlian_baru" class="col-md-4 col-form-label text-md-right">{{ __('Tambah Keahlian') }}</label>

                            <div class="col-md-6">
                                <input id="keahlian_baru" type="keahlian_baru" class="form-control{{ $errors->has('keahlian_baru') ? ' is-invalid' : '' }}" name="keahlian_baru">

                                @if ($errors->has('keahlian_baru'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('keahlian_baru') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
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
