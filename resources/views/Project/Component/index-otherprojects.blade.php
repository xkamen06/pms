<h4>{{ trans('pms::Project.index.other_projects') }}</h4>

<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ trans('pms::Project.index.no') }}</th>
        <th>{{ trans('pms::Project.index.shortcut') }}</th>
        <th>{{ trans('pms::Project.index.fullname') }}</th>
        <th>{{ trans('pms::Project.index.project_leader') }}</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($projectsPaginator as $i => $project)
        <tr>
            <td>{{ $i + 1 + 10 * (request('page', 1) - 1) }}</td>
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
                    <span class="text-muted">{{ trans('pms::Project.index.deleted_user') }}</span>
                @endif
            </td>
            <td>
                <a class="btn btn-default" title="{{ trans('pms::Project.index.show_project') }}"
                   href="{{ route('showproject', ['teamId' => $project->getProjectId()]) }}">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>