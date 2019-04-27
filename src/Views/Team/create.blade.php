@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Team.create.create_team') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            @if(isset($error))
                                <div class="alert alert-danger text-center">
                                    <strong>{{ trans('Project.create.error') }}:</strong> {{ $error }}
                                </div>
                            @else
                                <br><br>
                            @endif
                            <form class="form-horizontal" action="{{ route('createteam')  }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <small class="col-sm-8 col-sm-offset-2 text-muted">
                                        {{ trans('Team.create.unique_shortcut') }}
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                    </small>
                                    <br>
                                    <label class="control-label col-sm-2" for="shortcut">
                                        <b>{{ trans('Team.create.shortcut') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="shortcut" id="shortcut" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="fullname">
                                        <b>{{ trans('Team.create.fullname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="fullname" id="fullname" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="description">
                                        <b>{{ trans('Team.create.description') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="5">
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <label class="control-label col-sm-2" for="permisssions">
                                        <b>{{ trans('Team.create.permissions') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="permissions" id="permisssions">
                                            <option value="all">{{ trans('Team.create.all') }}</option>
                                            <option value="members">{{ trans('Team.create.members') }}</option>
                                        </select>
                                    </div>
                                    <br><br><br>

                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default" title="{{ trans('Team.create.button-create_team') }}">
                                            {{ trans('Team.create.button-create_team') }}
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