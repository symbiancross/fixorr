@extends('layouts.app')

@section('content')
        <div class="flex-center position-ref">
          

            <div class="content">
                <div class="title m-b-md">
                    Fixorr
                </div>

                <div class="subtitle m-b-md2">
                    Pesan Tukang Dengan Mudah
                </div>

                <div class="subtitle2 m-b-md2">
                    Tukang akan mencari anda
                </div>

                <div class="subtitle2 m-b-md">
                    Mulai pesan tukang anda
                </div>

                <div class="links">
                    <a href="{{ route('pesan.tukang', 1) }}">Tukang Listrik</a>
                    <a href="{{ route('pesan.tukang', 2) }}">Tukang Ledeng</a>
                    <a href="{{ route('pesan.tukang', 3) }}">Tukang Cat</a>
                    <a href="{{ route('cari.keahlian') }}">Lain-lain</a>
                </div>
            </div>
        </div>
@endsection
