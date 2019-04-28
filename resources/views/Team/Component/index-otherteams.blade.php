<h4>{{ trans('pms::Team.index.other_teams') }}</h4>

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
    @foreach($teamsPaginator as $i => $team)
        <tr>
            <td>{{ $i + 1 + 10 * (request('page', 1) - 1) }}</td>
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
                    <span class="text-muted">{{ trans('pms::Team.index.deleted_user') }}</span>
                @endif
            </td>
            <td>
                <a class="btn btn-default" href="{{ route('showteam', ['teamId' => $team->getTeamId()]) }}"
                    title="{{ trans('pms::Team.index.show_team') }}">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>