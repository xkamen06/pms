@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Task.show.task_detail') }}
                    </div>
                    <div class="panel-body">
                        <a href="{{ route('showproject', ['projectId' => $project->getProjectId()]) }}"
                            title="{{ trans('Task.show.back_to_project') }}" class="btn btn-default">
                            <span class="glyphicon glyphicon-arrow-left"></span>
                        </a>
                        <br>
                        <div class="col-md-6 col-md-offset-3 text-center">
                            <h2>
                                {{ trans('Task.show.task_detail') }} {{ $task->getName() }}
                                @if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId()
                                || $task->getLeaderId() === auth()->user()->id)
                                    <a href="{{ route('deletetaskbyid', ['taskId' => $task->getTaskId()]) }}"
                                       title="{{ trans('Task.show.delete_task') }}" class="btn btn-danger"
                                       onclick="
                                               return confirm('<?php echo (trans('Task.show.are_you_sure_task')
                                           . $task->getName()
                                           . trans('Task.show.from_project'))?>');">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                    <br>
                                @endif
                            </h2>

                            @if($task->isMember(auth()->user()->id))
                                <a href="{{ route('deletetaskmember', [
                                                    'userId' => auth()->user()->id,
                                                    'taskId' => $task->getTaskId()
                                                ]) }}"
                                   title="{{ trans('Task.show.leave_task') }}" class="btn btn-default">
                                    {{ trans('Task.show.leave_task') }} <span class="glyphicon glyphicon-log-out"></span>
                                </a>
                            @else
                                @if ($task->getLeaderId() !== auth()->user()->id && (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId() ||
                                         $project->isMember(auth()->user()->id)))
                                    <a href="{{ route('assigntasktome', ['taskId' => $task->getTaskId()]) }}"
                                       title="{{ trans('Task.show.assign_task_to_me') }}" class="btn btn-default">
                                        {{ trans('Task.show.assign_task_to_me') }} <span class="glyphicon glyphicon-log-in"></span>
                                    </a>
                                @endif
                            @endif

                            @if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId()
                                || $task->getLeaderId() === auth()->user()->id)
                                <a href="{{ route('showedittaskform', ['taskId' => $task->getTaskId()]) }}"
                                   title="{{ trans('Task.show.edit_task') }}" class="btn btn-default">
                                    {{ trans('Task.show.edit_task') }} <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                                <br>
                            @endif
                            <br>
                            <b>{{ trans('Task.show.name') }}</b>
                            {{ $task->getName() }}
                            <br>

                            <b>{{ trans('Task.show.leader') }}</b>
                            @if($task->getLeaderId())
                                <a href="{{ route('userprofile', ['userId' => $task->getLeaderId()]) }}">
                                    {{ $task->getLeader()->getFirstName() }} {{ $task->getLeader()->getSurname() }}
                                </a>
                            @else
                                <span class="text-muted">{{ trans('Task.show.deleted_user') }}</span>
                            @endif
                            <br>

                            <b>{{ trans('Task.show.type') }}</b>
                            @if($task->getType() === 'bug')
                                <span class="label label-danger">{{ trans('Task.show.bug') }}</span>
                            @else
                                <span class="label label-success">{{ trans('Task.show.requirement') }}</span>
                            @endif
                            <br>

                            <b>{{ trans('Task.show.status') }}</b>
                            @if($task->getStatus() === 'new')
                                <span class="label label-primary">{{ trans('Task.show.new') }}</span>
                            @elseif($task->getStatus() === 'in_progress')
                                <span class="label label-warning">{{ trans('Task.show.in_progress') }}</span>
                            @else
                                <span class="label label-success">{{ trans('Task.show.done') }}</span>
                            @endif

                            @if (auth()->user()->role === 'admin' || auth()->user()->id === $project->getLeaderId()
                                || $task->getLeaderId() === auth()->user()->id)
                                <br>
                                @if($task->getStatus() === 'new')
                                    <a href="{{ route('changetaskstatus', ['status' => 'in_progress', 'taskid' => $task->getTaskId()]) }}">
                                        {{ trans('Task.show.set_as_in_progress') }}
                                    </a>
                                @elseif($task->getStatus() === 'in_progress')
                                    <a href="{{ route('changetaskstatus', ['status' => 'done', 'taskid' => $task->getTaskId()]) }}">
                                        {{ trans('Task.show.set_as_done') }}
                                    </a>
                                @else
                                    <a href="{{ route('changetaskstatus', ['status' => 'new', 'taskid' => $task->getTaskId()]) }}">
                                        {{ trans('Task.show.set_as_new') }}
                                    </a>
                                @endif
                            @endif
                            <br>
                            <b>{{ trans('Task.show.created_at') }}</b>
                            {{ $task->getAddedAt() }}
                            <br>
                            <b>{{ trans('Task.show.description') }}</b>
                            <br>
                            {{ $task->getDescription() }}
                            <br>
                        </div>

                        <div class="col-md-12">
                            @include('pms::Task.Component.show-files')
                            <br>
                            @include('pms::Task.Component.show-assigned-users')

                            @include('pms::Task.Component.show-comments')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection