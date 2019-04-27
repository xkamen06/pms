@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Team.edit.header') }}
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
                            <form class="form-horizontal" action="{{ route('updateteam', ['teamId' => $team->getTeamId()]) }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <small class="col-sm-8 col-sm-offset-2 text-muted">
                                        {{ trans('Team.edit.unique_shortcut') }}
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                    </small>
                                    <br>
                                    <label class="control-label col-sm-2" for="shortcut">
                                        <b>{{ trans('Team.edit.shortcut') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="shortcut" id="shortcut" type="text" value="{{ $team->getShortcut() }}" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="fullname">
                                        <b>{{ trans('Team.edit.fullname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="fullname" id="fullname" type="text" value="{{ $team->getFullname() }}" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="description">
                                        <b>{{ trans('Team.edit.description') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" rows="5">{{ $team->getDescription() }}
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <label class="control-label col-sm-2" for="permissions">
                                        <b>{{ trans('Team.edit.permissions') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="permissions" id="permissions">
                                            @if($team->getPermissions() === 'all')
                                                <option value="all" selected>{{ trans('Team.edit.all') }}</option>
                                                <option value="members">{{ trans('Team.edit.members') }}</option>
                                            @else
                                                <option value="all">{{ trans('Team.edit.all') }}</option>
                                                <option value="members" selected>{{ trans('Team.edit.members') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <br><br><br>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" class="btn btn-default" title="{{ trans('Team.edit.button-edit_team') }}">
                                            {{ trans('Team.edit.button-edit_team') }}
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