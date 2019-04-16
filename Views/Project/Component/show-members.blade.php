<h3>{{ trans('Project.show.members') }}</h3>
@if($project->getStatus() === 'active')
    @if(auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId())
        <a href="{{ route('addmembertoprojectform', ['projectId' => $project->getProjectId()]) }}"
           title="{{ trans('Project.show.add_member') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif
@endif
<table class="table table-striped">
    <thead>
    <tr>
        <th>{{ trans('Project.show.no') }}</th>
        <th>{{ trans('Project.show.surname') }}</th>
        <th>{{ trans('Project.show.firstname') }}</th>
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
                    title="{{ trans('Project.show.show_user') }}" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </a>
            </td>
            <td>
                @if($project->getStatus() === 'active')
                    @if(auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId())
                        <a href="{{ route('deleteprojectmember', [
                                'userId' => $user->getUserId(),
                                'projectId' => $project->getProjectId()
                            ]) }}"
                           title="{{ trans('Project.show.delete_member') }}" class="btn btn-danger"
                           onclick="
                                   return confirm('<?php echo (trans('Project.show.are_you_sure_member')
                               . $user->getFirstname() . ' ' . $user->getSurname()
                               . trans('Project.show.from_project'))?>');">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>