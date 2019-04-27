@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Task.edit.edit_task') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            <br><br>
                            <form class="form-horizontal" action="{{ route('updatetask', ['taskId' => $task->getTaskId()])  }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="name">
                                        <b>{{ trans('Task.edit.name') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="name" id="name" type="text" value="{{ $task->getName() }}" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="description">
                                        <b>{{ trans('Task.edit.description') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="5">{{ $task->getDescription() }}
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <label class="control-label col-sm-2" for="type">
                                        <b>{{ trans('Task.edit.type') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type" id="type">
                                            @if($task->getType() === 'bug')
                                                <option value="bug" selected>{{ trans('Task.edit.bug') }}</option>
                                                <option value="requirement">{{ trans('Task.edit.requirement') }}</option>
                                            @else
                                                <option value="requirement" selected>{{ trans('Task.edit.requirement') }}</option>
                                                <option value="bug">{{ trans('Task.edit.bug') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="status">
                                        <b>{{ trans('Task.edit.status') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="status" id="status">
                                            @if($task->getStatus() === 'new')
                                                <option value="new" selected>{{ trans('Task.edit.new') }}</option>
                                                <option value="in_progress">{{ trans('Task.edit.in_progress') }}</option>
                                                <option value="done">{{ trans('Task.edit.done') }}</option>
                                            @elseif ($task->getStatus() === 'in_progress')
                                                <option value="in_progress" selected>{{ trans('Task.edit.in_progress') }}</option>
                                                <option value="new">{{ trans('Task.edit.new') }}</option>
                                                <option value="done">{{ trans('Task.edit.done') }}</option>
                                            @else
                                                <option value="done" selected>{{ trans('Task.edit.done') }}</option>
                                                <option value="new">{{ trans('Task.edit.new') }}</option>
                                                <option value="in_progress">{{ trans('Task.edit.in_progress') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <br><br><br>

                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-default" type="submit" title="{{ trans('Task.edit.edit_task') }}">
                                            {{ trans('Task.edit.edit_task') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection