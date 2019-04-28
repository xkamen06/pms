@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::File.create.header') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            <br><br>
                            @if(isset($projectId))
                                <form class="form-horizontal" action="{{ route('addfiletoproject', ['projectId' => $projectId]) }}"
                                      method="post" enctype="multipart/form-data">
                            @else
                                <form class="form-horizontal" action="{{ route('addfiletotask', ['taskId' => $taskId]) }}"
                                      method="post" enctype="multipart/form-data">
                            @endif
                                    {!! csrf_field() !!}
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="filename">
                                            <b>{{ trans('pms::File.create.file') }}</b>
                                        </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="filename" id="filename" type="file" required>
                                        </div>
                                        <br><br><br>

                                        <label class="control-label col-sm-2" for="type">
                                            <b>{{ trans('pms::File.create.type') }}</b>
                                        </label>
                                        <div class="col-sm-8">
                                            <select class="form-control" name="type" id="type">
                                                <option value="task">{{ trans('pms::File.create.task') }}</option>
                                                <option value="submit">{{ trans('pms::File.create.submit') }}</option>
                                            </select>
                                        </div>
                                        <br><br><br>

                                        <label class="control-label col-sm-2" for="description">
                                            <b>{{ trans('pms::File.create.description') }}</b>
                                        </label>
                                        <div class="col-sm-8">
                                            <input class="form-control" name="description" id="description" type="text" maxlength="30">
                                        </div>
                                        <br><br><br>
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button class="btn btn-default" type="submit" title="{{ trans('pms::File.create.button-add_file') }}">
                                                {{ trans('pms::File.create.button-add_file') }}
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