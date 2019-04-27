@extends('pms::Layouts.main')

@section('content')
    <head>
        <script>
            function showPassword() {
                var x = document.getElementById("oldpassword");
                var y = document.getElementById("newpassword");
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
                        {{ trans('User.change_password.header') }}
                    </div>
                    <div class="panel-body">
                        @if(isset($error))
                            <div class="alert alert-danger">
                                <strong>{{ trans('User.change_password.error') }}</strong> {{ $error }}
                            </div>
                        @else
                            <br><br>
                        @endif
                        <div class="col-sm-10 col-sm-offset-1">
                            <form class="form-horizontal" action="{{ route('updatepassword', ['userId' => $userId]) }}"
                                  method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    @if(auth()->user()->role === 'admin')
                                        <label class="control-label col-sm-4" for="oldpassword">
                                            <b>{{ trans('User.change_password.insert_your_password') }}</b>
                                        </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" name="oldpassword" id="oldpassword" type="password" required>
                                        </div>
                                        <br><br><br>
                                        <small class="col-sm-8 col-sm-offset-4 text-muted">
                                            {{ trans('User.change_password.password_minimum_length') }}
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                        </small>
                                        <br>
                                        <label class="control-label col-sm-4" for="newpassword">
                                            <b>{{ trans('User.change_password.insert_new_password_this_user') }}</b>
                                        </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" name="newpassword" id="newpassword" type="password" required>
                                        </div>
                                    @else
                                        <label class="control-label col-sm-4" for="oldpassword">
                                            <b>{{ trans('User.change_password.insert_old_password') }}</b>
                                        </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" name="oldpassword" id="oldpassword" type="password" required>
                                        </div>
                                        <br><br><br>
                                        <small class="col-sm-8 col-sm-offset-4 text-muted">
                                            {{ trans('User.change_password.password_minimum_length') }}
                                            <span class="glyphicon glyphicon-info-sign"></span>
                                        </small>
                                        <br>
                                        <label class="control-label col-sm-4" for="newpassword">
                                            <b>{{ trans('User.change_password.insert_new_password') }}</b>
                                        </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" name="newpassword" id="newpassword" type="password" required>
                                        </div>
                                    @endif
                                    <br><br><br>
                                    <div class="col-sm-offset-4 col-sm-10">
                                        <input type="checkbox" onclick="showPassword()">
                                        <b>{{ trans('User.create.show_password') }}</b>
                                        <br><br>
                                        <button class="btn btn-default" title="{{ trans('User.change_password.button-change_password') }}"
                                                type="submit">
                                            {{ trans('User.change_password.button-change_password') }}
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