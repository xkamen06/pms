<div class="col-md-6 col-md-offset-3 text-center">
    <h2>{{ trans('pms::User.show.projects') }}</h2>
</div>
<br><br><br><br>
@if($projects)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>{{ trans('pms::User.show.shortcut') }}</th>
            <th>{{ trans('pms::User.show.fullname') }}</th>
            <th>{{ trans('pms::User.show.project_leader') }}</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td>
                    {{ $project->getShortcut() }}
                </td>
                <td>
                    {{ $project->getFullname() }}
                </td>
                <td>
                    @if($project->getLeaderId())
                        <a href="{{ route('userprofile', ['userId' => $project->getLeaderId()]) }}">
                            {{ $project->getLeader()->getFirstname() }} {{ $project->getLeader()->getSurname() }}
                        </a>
                    @else
                        <span class="text-muted">{{ trans('pms::Project.index.deleted_user') }}</span>
                    @endif
                </td>
                <td>
                    @if($project->getLeaderId())
                        @if($project->getLeader()->getUserId() === $user->getUserId())
                            <span class="label label-warning">{{ trans('pms::User.show.leader') }}</span>
                        @else
                            <span class="label label-primary">{{ trans('pms::User.show.member') }}</span>
                        @endif
                    @else
                        <span class="label label-primary">{{ trans('pms::User.show.member') }}</span>
                    @endif
                </td>
                <td>
                    <a title="{{ trans('pms::User.show.show_project') }}" class="btn btn-default"
                       href="{{ route('showproject', ['projectId' => $project->getProjectId()]) }}">
                        <span class="glyphicon glyphicon-search"></span>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="text-center">
        <b>{{ trans('pms::User.show.not_a_project_member') }}</b>
    </div>
@endif