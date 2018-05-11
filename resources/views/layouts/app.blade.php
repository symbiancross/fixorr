<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/star-rating.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="@if(Auth::guard('tukang')->check()){{ url('/tukang') }} @else {{ url('/')  }} @endif">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @if(Auth::guard('web')->check())
                        <li><a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        @endif
                        @if(Auth::guard('tukang')->check())
                        <li><a class="nav-link" href="{{ route('tukang.home') }}">{{ __('Home') }}</a></li>
                        @endif
                        <li><a class="nav-link" href="{{ route('faq') }}">{{ __('FAQ') }}</a></li>
                        <li><a class="nav-link" href="{{ route('testi') }}">{{ __('Testimoni') }}</a></li>
                        <li><a class="nav-link" href="{{ route('kontak') }}">{{ __('Kontak Kami') }}</a></li>

                        <!-- Authentication Links -->
                        
                        
                        @if(Auth::guard('web')->check())
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('web')->user()->nama }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">﻿
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @elseif(Auth::guard('tukang')->check())
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('tukang')->user()->nama }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('tukang.logout') }}" method="POST" style="display: none;">﻿
                                        @csrf
                                    </form>
                                </div>
                            </li>    
                        @else
                            <li><a class="nav-link" href="{{ route('log.as') }}">{{ __('Masuk') }}</a></li>
                            <li><a class="nav-link" href="{{ route('reg.as') }}">{{ __('Daftar') }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/previewphoto.js') }}" defer></script>
    <script src="{{ asset('js/hideorshownewkeahlianform.js') }}" defer></script>
</body>
</html>
