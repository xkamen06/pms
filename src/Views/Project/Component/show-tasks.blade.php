<h3>{{ trans('Project.show.tasks') }}</h3>
@if($project->getStatus() === 'active')
    @if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId()
         || $project->isMember(auth()->user()->id))
        <a href="{{ route('showcreatetaskform', ['projectId' => $project->getProjectId()]) }}"
           title="{{ trans('Project.show.create_task') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif
@endif
@if($tasks)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('Project.show.no') }}</th>
            <th>{{ trans('Project.show.name') }}</th>
            <th>{{ trans('Project.show.type') }}</th>
            <th>{{ trans('Project.show.status') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($tasks as $i => $task)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $task->getName() }}
                </td>
                <td>
                    @if($task->getType() === 'bug')
                        <span class="label label-danger">{{ trans('Project.show.bug') }}</span>
                    @else
                        <span class="label label-success">{{ trans('Project.show.requirement') }}</span>
                    @endif
                </td>
                <td>
                    @if($task->getStatus() === 'new')
                        <span class="label label-primary">{{ trans('Project.show.new') }}</span>
                    @elseif($task->getStatus() === 'in_progress')
                        <span class="label label-warning">{{ trans('Project.show.in_progress') }}</span>
                    @else
                        <span class="label label-success">{{ trans('Project.show.done') }}</span>
                    @endif
                </td>
                <td>
                    @if($project->getPermissions() === 'all' || auth()->user()->role === 'admin'
                         || auth()->user()->id === $project->getLeaderId()
                         || $project->isMember(auth()->user()->id))
                        <a href="{{ route('showtask', ['taskId' => $task->getTaskId()]) }}"
                            title="{{ trans('Project.show.show_task') }}" class="btn btn-default">
                            <span class="glyphicon glyphicon-search"></span>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <br>
    <b>{{ trans('Project.show.no_tasks') }}</b>
@endif