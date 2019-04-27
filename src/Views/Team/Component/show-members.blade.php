<h3>Členové:</h3>
@if(auth()->user()->role === 'admin' || auth()->user()->id === $team->getLeaderId())
    <a href="{{ route('addmembertoteamform', ['teamId' => $team->getTeamId()]) }}"
       title="{{ trans('Team.show.add_member') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
@endif
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ trans('Team.show.no') }}</th>
        <th>{{ trans('Team.show.surname') }}</th>
        <th>{{ trans('Team.show.firstname') }}</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($members as $i => $user)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>
                {{ $user->getFirstname() }}
            </td>
            <td>{{ $user->getSurname() }}</td>
            <td>
                <a href="{{ route('userprofile', ['userId' => $user->getUserId()]) }}"
                    title="{{ trans('Team.show.show_member') }}" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </td>
            <td>@if(auth()->user()->role === 'admin' || auth()->user()->id === $team->getLeaderId())
                    <a href="{{ route('deleteteammember', [
                            'userId' => $user->getUserId(),
                            'teamId' => $team->getTeamId()
                        ]) }}"
                       class="btn btn-danger" title="{{ trans('Team.show.delete_member') }}"
                       onclick="
                               return confirm('<?php echo (trans('Team.show.are_you_sure_member')
                           . $user->getFirstname() . ' ' . $user->getSurname()
                           . trans('Team.show.from_team'))?>');">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>