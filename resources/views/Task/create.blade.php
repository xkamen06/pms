@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Task.create.create_task') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            <br><br>
                            <form class="form-horizontal" action="{{ route('createtask', ['projectId' => $projectId])  }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="name">
                                        <b>{{ trans('pms::Task.create.name') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="name" id="name" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="description">
                                        <b>{{ trans('pms::Task.create.description') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="5">
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <label class="control-label col-sm-2" for="type">
                                        <b>{{ trans('pms::Task.create.type') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type" id="type">
                                            <option value="requirement">{{ trans('pms::Task.create.requirement') }}</option>
                                            <option value="bug">{{ trans('pms::Task.create.bug') }}</option>
                                        </select>
                                    </div>
                                    <br><br><br>

                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-default" type="submit" title="{{ trans('pms::Task.create.create_task') }}">
                                            {{ trans('pms::Task.create.create_task') }}
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