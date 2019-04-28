<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="google" content="notranslate">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PMS</title>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
</head>
    <body class="main">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ route('dashboard') }}"> {{ trans('pms::Layouts.main.dashboard') }} </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;<li><a class="nav-link" href="{{ route('allprojects') }}"> {{ trans('pms::Layouts.main.projects') }} </a></li>
                        &nbsp;<li><a class="nav-link" href="{{ route('allteams') }}"> {{ trans('pms::Layouts.main.teams') }} </a></li>
                        &nbsp;<li><a class="nav-link" href="{{ route('allusers') }}"> {{ trans('pms::Layouts.main.users') }} </a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Drivers -->
                        @if(driverRepository()->getDriver() === 'item')
                            <li>
                                <a class="nav-link" href="{{ route('changedriver', ['driver' => 'eloquent']) }}">
                                    {{ trans('pms::Layouts.main.eloquents') }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a class="nav-link" href="{{ route('changedriver', ['driver' => 'item']) }}">
                                    {{ trans('pms::Layouts.main.items') }}
                                </a>
                            </li>
                        @endif
                        <!-- Language -->
                        <li class="dropdown">
                            @if(app()->getLocale() === 'cz')
                                <a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ trans('pms::Layouts.main.cz') }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('language', ['locale' => 'sk']) }}">
                                            {{ trans('pms::Layouts.main.sk') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('language', ['locale' => 'en']) }}">
                                            {{ trans('pms::Layouts.main.en') }}
                                        </a>
                                    </li>
                                </ul>
                            @elseif(app()->getLocale() === 'en')
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ trans('pms::Layouts.main.en') }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('language', ['locale' => 'cz']) }}">
                                            {{ trans('pms::Layouts.main.cz') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('language', ['locale' => 'sk']) }}">
                                            {{ trans('pms::Layouts.main.sk') }}
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ trans('pms::Layouts.main.sk') }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('language', ['locale' => 'cz']) }}">
                                            {{ trans('pms::Layouts.main.cz') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('language', ['locale' => 'en']) }}">
                                            {{ trans('pms::Layouts.main.en') }}
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        <!-- Authentication Links -->
                        @guest
                        <li><a href="{{ route('login') }}"> {{ trans('pms::Layouts.main.login') }} </a></li>
                        <li><a href="{{ route('register') }}"> {{ trans('pms::Layouts.main.register') }} </a></li>
                        @else
                            <li class="dropdown">
                                <a class="nav-link" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                                    {{ auth()->user()->firstname . " " . auth()->user()->surname }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('userprofile', ['userId' => auth()->user()->id]) }}">
                                            {{ trans('pms::Layouts.main.show_profile') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            {{ trans('pms::Layouts.main.logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
    </div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
</body>
</html>