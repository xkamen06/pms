@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Project.show.project_detail') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3 text-center">
                            @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id)
                                <h2>
                                    {{ trans('Project.show.project_detail') }} {{ $project->getShortcut() }}
                                    <a href="{{ route('deleteproject', ['projectId' => $project->getProjectId()]) }}"
                                       title="{{ trans('Project.show.delete_project') }}" class="btn btn-danger"
                                       onclick="
                                               return confirm('<?php echo (trans('Project.show.are_you_sure_project')
                                           . $project->getShortcut()
                                           . trans('Project.show.from_system'))?>');">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </h2>
                            @else
                                <h2>{{ trans('Project.show.project_detail') }} {{ $project->getShortcut() }}</h2>
                            @endif
                            @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id)
                                @if($project->getStatus() === 'active')
                                    <a href="{{ route('changeprojectstatus', ['projectId' => $project->getProjectId(), 'change' => 'closed']) }}"
                                       title="{{ trans('Project.show.close_project') }}" class="btn btn-default">
                                        {{ trans('Project.show.close_project') }}
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </a>
                                @else
                                    <a href="{{ route('changeprojectstatus', ['projectId' => $project->getProjectId(), 'change' => 'active']) }}"
                                       title="{{ trans('Project.show.open_project') }}" class="btn btn-default">
                                        {{ trans('Project.show.open_project') }}
                                        <span class="glyphicon glyphicon-ok"></span>
                                    </a>
                                @endif
                                <a href="{{ route('editproject', ['projectId' => $project->getProjectId()]) }}"
                                   title="{{ trans('Project.show.edit_project') }}" class="btn btn-default">
                                    {{ trans('Project.show.edit_project') }}
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <br>
                                <br>
                            @endif

                            @if($project->getLeaderId() === auth()->user()->id)
                                <span class="label label-primary">{{ trans('Project.show.project_leader') }}</span>
                                <br>
                            @endif

                            <b>{{ trans('Project.show.shortcut') }}</b> {{ $project->getShortcut() }}
                            <br>

                            <b>{{ trans('Project.show.fullname') }}</b> {{ $project->getFullname() }}
                            <br>

                            @if($project->getLeader())
                                @if($project->getLeaderId() !== auth()->user()->id)
                                    <b>{{ trans('Project.show.project_leader') }}:</b>
                                    <a href="{{ route('userprofile', ['userId' => $leader->getUserId()]) }}">
                                        {{ $leader->getSurname() }}
                                    </a>
                                @endif
                            @else
                                <b>{{ trans('Project.show.project_leader') }}:</b>
                                <span class="text-muted">{{ trans('Project.show.deleted_user') }}</span>
                            @endif
                            <br>
                            <b>{{ trans('Project.show.status') }}:</b>
                            @if($project->getStatus() === 'active')
                                <span class="label label-success">{{ trans('Project.show.active') }}</span>
                            @else
                                <span class="label label-danger">{{ trans('Project.show.closed') }}</span>
                            @endif
                            <br>

                            <b>{{ trans('Project.show.description') }}</b>
                            <br>
                            {{ $project->getDescription() }}
                            <br>

                            <b>{{ trans('Project.show.created_at') }}</b> {{ $project->getAddedAt() }}
                            <br>
                        </div>

                        <div class="col-md-12">
                            @if($project->getPermissions() === 'all' || auth()->user()->role === 'admin'
                                || auth()->user()->id === $project->getLeaderId()
                                || $project->isMember(auth()->user()->id))
                                @include('pms::Project.Component.show-files')
                                <br>
                            @endif

                            @include('pms::Project.Component.show-tasks')

                            <br>

                            @include('pms::Project.Component.show-members')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection