<h4>{{ trans('Project.index.member') }}</h4>

@if($myprojects)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('Project.index.no') }}</th>
            <th>{{ trans('Project.index.shortcut') }}</th>
            <th>{{ trans('Project.index.fullname') }}</th>
            <th>{{ trans('Project.index.project_leader') }}</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($myprojects as $i => $project)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $project->getShortcut() }}
                </td>
                <td>
                    {{ $project->getFullname() }}
                </td>
                <td>
                    @if($project->getLeader())
                        <a href="{{ route('userprofile', ['userId' => $project->getLeaderId()]) }}">
                            {{ $project->getLeader()->getFirstname() }} {{ $project->getLeader()->getSurname() }}
                        </a>
                    @else
                        <span class="text-muted">{{ trans('Project.index.deleted_user') }}</span>
                    @endif
                </td>
                <td>
                    <a class="btn btn-default" title="{{ trans('Project.index.show_project') }}"
                       href="{{ route('showproject', ['projectId' => $project->getProjectId()]) }}">
                        <span class="glyphicon glyphicon-search"></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <b>{{ trans('Project.index.not_a_project_member') }}</b>
@endif