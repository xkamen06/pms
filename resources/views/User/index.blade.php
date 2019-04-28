@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::User.index.header') }}
                    </div>
                    <div class="panel-body">
                        @if(auth()->user()->role === 'admin')
                            <a title="{{ trans('pms::User.index.add_user') }}" class="btn btn-primary"
                               href="{{ route('adduserform') }}">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        @endif
                        <br><hr>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{ trans('pms::User.index.no') }}</th>
                                <th>{{ trans('pms::User.index.firstname') }}</th>
                                <th>{{ trans('pms::User.index.surname') }}</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($usersPaginator as $i => $user)
                                    <tr class="clickable-row" data-href="{{ route('userprofile', ['userId' => $user->getUserId()]) }}">
                                        <td>{{ $i + 1 + $perPage * (request('page', 1) - 1) }}</td>
                                        <td>{{ $user->getFirstname() }}</td>
                                        <td>
                                            {{ $user->getSurname() }}
                                            @if($user->getRole() === 'admin')
                                                <span class="label label-danger">Admin</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a title="{{ trans('pms::User.index.show') }}" class="btn btn-default"
                                               href="{{ route('userprofile', ['userId' => $user->getUserId()]) }}">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </a>
                                        </td>
                                        <td>
                                            @if(auth()->user()->role === 'admin')
                                                <a title="{{ trans('pms::User.index.delete') }}" class="btn btn-danger"
                                                   href="{{ route('deleteuser', ['userId' => $user->getUserId()]) }}"
                                                   onclick="
                                                           return confirm('<?php echo (trans('pms::User.index.are_you_sure')
                                                            . $user->getFirstname() . ' ' . $user->getSurname()
                                                            . trans('pms::User.index.from_system'))?>');">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                            <hr>
                            <div class="col-md-6 col-md-offset-3 text-center">
                                {{ $usersPaginator->links() }}
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection