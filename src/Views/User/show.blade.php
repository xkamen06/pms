@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('User.show.user_profile') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <h2>
                                {{ $user->getFirstname() }} {{ $user->getSurname() }}
                                @if(auth()->user()->role === 'admin')
                                    <a title="{{ trans('User.show.delete') }}" class="btn btn-danger"
                                       href="{{ route('deleteuser', ['userId' => $user->getUserId()]) }}"
                                       onclick="
                                               return confirm('<?php echo (trans('User.index.are_you_sure')
                                           . $user->getFirstname() . ' ' . $user->getSurname()
                                           . trans('User.show.from_system'))?>');">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                @endif
                                @if($user->getRole() === 'admin')
                                    <br>
                                    <span class="label label-danger">Admin</span>
                                    <br>
                                @endif
                            </h2>

                            @if(auth()->user()->role === 'admin' || $user->getUserId() === auth()->user()->id)
                                <a href="{{ route('edituser', ['userId' => $user->getUserId()]) }}" class="btn btn-default"
                                    title="{{ trans('User.show.change_informations') }}">
                                    {{ trans('User.show.change_informations') }} <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <a href="{{ route('changepassword', ['userId' => $user->getUserId()]) }}" class="btn btn-default"
                                    title="{{ trans('User.show.change_password') }}">
                                    {{ trans('User.show.change_password') }} <span class="glyphicon glyphicon-lock"></span>
                                </a>
                                <br><br>
                            @endif
                            <b>{{ trans('User.show.firstname') }}</b> {{ $user->getFirstname() }}
                            <br>

                            <b>{{ trans('User.show.surname') }}</b> {{ $user->getSurname() }}
                            <br>

                            <b>{{ trans('User.show.email') }}</b>
                            <a title="{{ trans('User.show.send_mail') }}" class="user-mail"
                               href="mailto:{{ $user->getEmail() }}">{{ $user->getEmail() }}
                                <span class="glyphicon glyphicon-envelope"></span>
                            </a>
                            <br>

                            <b>{{ trans('User.show.added') }}</b> {{ $user->getAddedAt() }}
                            <br>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            @include('pms::User.Component.show-teams')
                            @include('pms::User.Component.show-projects')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection