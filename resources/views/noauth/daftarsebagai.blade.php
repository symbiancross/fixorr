@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref">
          

            <div class="content">
                <div class="title m-b-md">
                    <a href="{{ route('register') }}">{{ __('Pengguna') }}</a> atau <a href="{{ route('tukang.register') }}">{{ __('Tukang') }}
                </div>

                
            </div>
        </div>
@endsection