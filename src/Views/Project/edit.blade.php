@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Project.edit.header') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            @if(isset($error))
                                <div class="alert alert-danger text-center">
                                    <strong>{{ trans('Project.edit.error') }}:</strong> {{ $error }}
                                </div>
                            @else
                                <br><br>
                            @endif
                            <form class="form-horizontal" action="{{ route('updateproject', ['projectId' => $project->getprojectId()]) }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="shortcut">
                                        <b>{{ trans('Project.edit.shortcut') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="shortcut" id="shortcut" type="text"
                                               value="{{ $project->getShortcut() }}" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="fullname">
                                        <b>{{ trans('Project.edit.fullname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="fullname" id="fullname" type="text"
                                               value="{{ $project->getFullname() }}" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="description">
                                        <b>{{ trans('Project.edit.content') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="5">{{ $project->getDescription() }}
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <label class="control-label col-sm-2" for="permissions">
                                        <b>{{ trans('Project.edit.permissions') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="permissions" id="permissions">
                                            @if($project->getPermissions() === 'all')
                                                <option value="all" selected>{{ trans('Project.edit.all') }}</option>
                                                <option value="members">{{ trans('Project.edit.members') }}</option>
                                            @else
                                                <option value="all">{{ trans('Project.edit.all') }}</option>
                                                <option value="members" selected>{{ trans('Project.edit.members') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <br><br><br>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-default" type="submit" title="{{ trans('Project.edit.button-edit_project') }}">
                                            {{ trans('Project.edit.button-edit_project') }}
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