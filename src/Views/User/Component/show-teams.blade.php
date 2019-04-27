
<div class="col-md-6 col-md-offset-3 text-center">
    <h2>{{ trans('User.show.teams') }}</h2>
</div>
<br><br><br><br>
@if($teams)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('User.show.shortcut') }}</th>
            <th>{{ trans('User.show.fullname') }}</th>
            <th>{{ trans('User.show.team_leader') }}</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td>
                    {{ $team->getShortcut() }}
                </td>
                <td>
                    {{ $team->getFullname() }}
                </td>
                <td>
                    @if($team->getLeaderId())
                        <a href="{{ route('userprofile', ['userId' => $team->getLeaderId()]) }}">
                            {{ $team->getLeader()->getFirstname() }} {{ $team->getLeader()->getSurname() }}
                        </a>
                    @else
                        <span class="text-muted">{{ trans('Team.index.deleted_user') }}</span>
                    @endif
                </td>
                <td>
                    @if($team->getLeaderId())
                        @if($team->getLeader()->getUserId() === $user->getUserId())
                            <span class="label label-warning">{{ trans('User.show.leader') }}</span>
                        @else
                            <span class="label label-primary">{{ trans('User.show.member') }}</span>
                        @endif
                    @else
                        <span class="label label-primary">{{ trans('User.show.member') }}</span>
                    @endif
                </td>
                <td>
                    <a title="{{ trans('User.show.show_team')}}" class="btn btn-default"
                       href="{{ route('showteam', ['teamId' => $team->getTeamId()]) }}">
                        <span class="glyphicon glyphicon-search"></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <b>{{ trans('User.show.not_a_team_member') }}</b>
    </div>
@endif