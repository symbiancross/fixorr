@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref">
          

            <div class="content">
            	<div class="title m-b-md">
                    Masuk Sebagai
                </div>
                <div class="title m-b-md">
                    <a href="{{ route('login') }}">{{ __('Pengguna') }}</a> atau <a href="{{ route('tukang.login') }}">{{ __('Tukang') }}
                </div>

                
            </div>
        </div>
@endsection