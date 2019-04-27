@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Team.index.header') }}
                    </div>
                    <div class="panel-body">
                        <a href="{{ route('createteamform') }}" class="btn btn-primary"
                            title="{{ trans('Team.index.button-create_team') }}">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                        <br>
                        <hr>
                        <h3>{{ trans('Team.index.my_teams') }}</h3>

                        @include('pms::Team.Component.index-myteams-leader')
                        <br>
                        <br>

                        @include('pms::Team.Component.index-myteams-member')
                        <br>
                        <hr>
                        <br>

                        @include('pms::Team.Component.index-otherteams')
                        <hr>
                        <div class="col-md-6 col-md-offset-3 text-center">
                            {{ $teamsPaginator->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection