@extends('pms::Auth.layout')

@section('content')
    <!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
    <div class="container">
        <div class="card card-container">
            <div class="login">
                <h1>{{ trans('Auth.login.sign_in') }}</h1>
            </div>
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form class="form-signin" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <span id="reauth-email" class="reauth-email"></span>
                <input type="email" id="email" class="form-control" name="email" placeholder="Email" required autofocus>
                <input type="password" id="password" name="password" class="form-control" placeholder="Heslo" required>
                <div id="remember" class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"> {{ trans('Auth.login.remmember_me')}}
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">
                    {{ trans('Auth.login.sign_in') }}
                </button>
            </form><!-- /form -->
            {{--<a href="#" class="forgot-password">--}}
                 {{--{{ trans('Auth.login.forget_password') }}--}}
            {{--</a>--}}
        </div><!-- /card-container -->
    </div><!-- /container -->
@endsection
