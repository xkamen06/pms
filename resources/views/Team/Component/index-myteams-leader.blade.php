<h4>{{ trans('pms::Team.index.leader') }}</h4>

@if($myteamsLeader)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('pms::Team.index.no') }}</th>
            <th>{{ trans('pms::Team.index.shortcut') }}</th>
            <th>{{ trans('pms::Team.index.fullname') }}</th>
            <th>{{ trans('pms::Team.index.team_leader') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($myteamsLeader as $i => $team)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $team->getShortcut() }}
                    @if($team->getLeaderId() === auth()->user()->id)
                        <span class="label label-primary">{{ trans('pms::Team.index.team_leader') }}</span>
                    @endif
                </td>
                <td>
                    {{ $team->getFullname() }}
                </td>
                <td>
                    <a href="{{ route('userprofile', ['userId' => $team->getLeaderId()]) }}">
                        {{ $team->getLeader()->getFirstname() }} {{ $team->getLeader()->getSurname() }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('showteam', ['teamId' => $team->getTeamId()]) }}" class="btn btn-default"
                       title="{{ trans('pms::Team.index.show_team') }}">
                        <span class="glyphicon glyphicon-search"></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <b>{{ trans('pms::Team.index.not_team_leader') }}</b>
@endif