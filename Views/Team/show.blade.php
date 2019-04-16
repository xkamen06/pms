@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Team.show.team_detail') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <h2>
                                {{ trans('Team.show.team_detail') }} {{ $team->getShortcut() }}
                                @if(auth()->user()->role === 'admin' || $team->getLeaderId() === auth()->user()->id)
                                    <a href="{{ route('deleteteam', ['teamId' => $team->getTeamId()]) }}"
                                       title="{{ trans('Team.show.button-delete_team') }}" class="btn btn-danger"
                                       onclick="
                                               return confirm('<?php echo (trans('Team.show.are_you_sure_team')
                                           . $team->getShortcut()
                                           . trans('Team.show.from_system'))?>');">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                @endif
                            </h2>

                            @if($team->isMember(auth()->user()->id))
                                <a href="{{ route('deleteteammember', ['teamId' => $team->getTeamId(), 'userId' => auth()->user()->id]) }}"
                                   class="btn btn-default" title="{{ trans('Team.show.button-leave_team') }}">
                                    {{ trans('Team.show.button-leave_team') }} <span class="glyphicon glyphicon-log-out"></span>
                                </a>
                            @endif
                            @if(auth()->user()->role === 'admin' || $team->getLeaderId() === auth()->user()->id)
                                <a href="{{ route('editteam', ['teamId' => $team->getTeamId()]) }}" class="btn btn-default"
                                        title="{{ trans('Team.show.button-edit_team') }}">
                                        {{ trans('Team.show.button-edit_team') }} <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            @endif
                            <br>

                            @if($team->getLeaderId() === auth()->user()->id)
                                <span class="label label-primary">{{ trans('Team.show.team_leader') }}</span>
                                <br>
                            @endif

                            <b>{{ trans('Team.show.shortcut') }}</b> {{ $team->getShortcut() }}
                            <br>

                            <b>{{ trans('Team.show.fullname') }}</b> {{ $team->getFullname() }}
                            <br>

                            @if($team->getLeaderId())
                                @if($team->getLeaderId() !== auth()->user()->id)
                                    <b>{{ trans('Team.show.team_leader') }}:</b>
                                        <a href="{{ route('userprofile', ['userId' => $leader->getUserId()]) }}">
                                            {{ $leader->getSurname() }}
                                        </a>
                                    <br>
                                @endif
                            @else
                                <b>{{ trans('Team.show.team_leader') }}:</b>
                                <span class="text-muted">{{ trans('Team.show.deleted_user') }}</span>
                                <br>
                            @endif

                            <b>{{ trans('Team.show.description') }}</b>
                            <br>
                            {{ $team->getDescription() }}
                            <br>

                            <b>{{ trans('Team.show.added') }}</b> {{ $team->getAddedAt() }}
                            <br>
                        </div>
                        <div class="col-md-12">
                            @include('pms::Team.Component.show-articles')

                            @include('pms::Team.Component.show-members')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection