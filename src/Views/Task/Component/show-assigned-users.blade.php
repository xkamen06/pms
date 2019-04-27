<h3>{{ trans('Task.show.assigned_users') }}</h3>
@if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId() ||
    $project->isMember(auth()->user()->id))
    <a href="{{ route('addmembertotaskform', ['taskId' => $task->getTaskId()]) }}"
       title="{{ trans('Task.show.add_member') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
@endif
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ trans('Task.show.no') }}</th>
        <th>{{ trans('Task.show.surname') }}</th>
        <th>{{ trans('Task.show.firstname') }}</th>
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
                    title="{{ trans('Task.show.show_member') }}" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </td>
            <td>
                @if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId() ||
                 $project->isMember(auth()->user()->id))
                    <a href="{{ route('deletetaskmember', [
                            'userId' => $user->getUserId(),
                            'taskId' => $task->getTaskId()
                        ]) }}"
                       title="{{ trans('Task.show.delete_member') }}" class="btn btn-danger"
                       onclick="
                               return confirm('<?php echo (trans('Task.show.are_you_sure_member')
                           . $user->getFirstname() . ' ' . $user->getSurname()
                           . trans('Task.show.from_task'))?>');">
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>