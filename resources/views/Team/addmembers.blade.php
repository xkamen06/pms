@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Team.add_members.header') }}
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('addmemberstoteam', ['teamId' => $teamId]) }}" method="post">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary" title="{{ trans('pms::Team.add_members.add') }}">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                            <br>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            {{ $user->getFirstname() . ' ' . $user->getSurname() }}
                                        </td>
                                        <td>
                                            {{ $user->getEmail() }}
                                        </td>
                                        <td>
                                            <input name="{{ $user->getUserId() }}" id="{{ $user->getUserId() }}" type="checkbox">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-primary" title="{{ trans('pms::Team.add_members.add') }}">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection