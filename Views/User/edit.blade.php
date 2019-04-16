@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('User.edit.header') }}
                    </div>
                    <div class="panel-body">
                        @if(isset($error))
                            <div class="alert alert-danger text-center">
                                <strong>{{ trans('User.edit.error') }}:</strong> {{ $error }}
                            </div>
                        @else
                            <br><br>
                        @endif
                        <div class="col-sm-10 col-sm-offset-1">
                            <form class="form-horizontal" action="{{ route('updateuser', ['userId' => $user->getUserId()]) }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="firstname">
                                        <b>{{ trans('User.edit.firstname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="firstname" id="firstname" type="text" value="{{ $user->getFirstname() }}">
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="surname">
                                        <b>{{ trans('User.edit.surname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="surname" id="surname" type="text" value="{{ $user->getSurname() }}">
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="email">
                                        <b>{{ trans('User.edit.email') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="email" id="email" type="text" value="{{ $user->getEmail() }}">
                                    </div>
                                    <br><br><br>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-default" title="{{ trans('User.edit.button-edit') }}"
                                                type="submit">
                                            {{ trans('User.edit.button-edit') }}
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