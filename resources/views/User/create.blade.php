@extends('pms::Layouts.main')

@section('content')
    <head>
        <script>
            function showPassword() {
                var x = document.getElementById("password");
                var y = document.getElementById("password_again");
                if (x.type === "password") {
                    x.type = "text";
                    y.type = "text";
                } else {
                    x.type = "password";
                    y.type = "password";
                }
            }
        </script>
    </head>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::User.create.add_user') }}
                    </div>
                    <div class="panel-body">
                        @if(isset($error))
                            <div class="alert alert-danger text-center">
                                <strong>{{ trans('pms::User.create.error') }}:</strong> {{ $error }}
                            </div>
                        @else
                            <br><br>
                        @endif
                        <div class="col-sm-10 col-sm-offset-1">
                            <form class="form-horizontal" action="{{ route('adduser') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="firstname">
                                        <b>{{ trans('pms::User.create.firstname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="firstname" id="firstname" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="surname">
                                        <b>{{ trans('pms::User.create.surname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="surname" id="surname" type="text" required>
                                    </div>
                                    <br><br><br>


                                    <label class="control-label col-sm-2" for="email">
                                        <b>{{ trans('pms::User.create.email') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="email" id="email" type="email" required>
                                    </div>
                                    <br><br><br>
                                    <small class="col-sm-8 col-sm-offset-2 text-muted">
                                        {{ trans('pms::User.create.password_minimum_length') }}
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                    </small>
                                    <br>
                                    <label class="control-label col-sm-2" for="password">
                                        <b>{{ trans('pms::User.create.password') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="password" id="password" type="password" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="password_again">
                                        <b>{{ trans('pms::User.create.password_again') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="password_again"
                                               id="password_again" type="password" required>
                                    </div>
                                    <br><br><br>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <input type="checkbox" onclick="showPassword()">
                                        <b>{{ trans('pms::User.create.show_password') }}</b>
                                        <br><br>
                                        <button class="btn btn-default" title="{{ trans('pms::User.create.button-add_user') }}"
                                               type="submit">
                                            {{ trans('pms::User.create.button-add_user') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection