<h3>{{ trans('pms::Project.show.tasks') }}</h3>
@if($project->getStatus() === 'active')
    @if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId()
         || $project->isMember(auth()->user()->id))
        <a href="{{ route('showcreatetaskform', ['projectId' => $project->getProjectId()]) }}"
           title="{{ trans('pms::Project.show.create_task') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif
@endif
@if($tasks)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('pms::Project.show.no') }}</th>
            <th>{{ trans('pms::Project.show.name') }}</th>
            <th>{{ trans('pms::Project.show.type') }}</th>
            <th>{{ trans('pms::Project.show.status') }}</th>
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
                        <span class="label label-danger">{{ trans('pms::Project.show.bug') }}</span>
                    @else
                        <span class="label label-success">{{ trans('pms::Project.show.requirement') }}</span>
                    @endif
                </td>
                <td>
                    @if($task->getStatus() === 'new')
                        <span class="label label-primary">{{ trans('pms::Project.show.new') }}</span>
                    @elseif($task->getStatus() === 'in_progress')
                        <span class="label label-warning">{{ trans('pms::Project.show.in_progress') }}</span>
                    @else
                        <span class="label label-success">{{ trans('pms::Project.show.done') }}</span>
                    @endif
                </td>
                <td>
                    @if($project->getPermissions() === 'all' || auth()->user()->role === 'admin'
                         || auth()->user()->id === $project->getLeaderId()
                         || $project->isMember(auth()->user()->id))
                        <a href="{{ route('showtask', ['taskId' => $task->getTaskId()]) }}"
                            title="{{ trans('pms::Project.show.show_task') }}" class="btn btn-default">
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
    <b>{{ trans('pms::Project.show.no_tasks') }}</b>
@endif