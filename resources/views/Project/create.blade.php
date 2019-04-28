@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Project.create.create_project') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            @if(isset($error))
                                <div class="alert alert-danger text-center">
                                    <strong>{{ trans('pms::Project.create.error') }}:</strong> {{ $error }}
                                </div>
                            @else
                                <br><br>
                            @endif
                            <form class="form-horizontal" action="{{ route('createproject')  }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <small class="col-sm-8 col-sm-offset-2 text-muted">
                                        {{ trans('pms::Project.create.unique_shortcut') }}
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                    </small>
                                    <br>
                                    <label class="control-label col-sm-2" for="shortcut">
                                        <b>{{ trans('pms::Project.create.shortcut') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="shortcut" id="shortcut" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="fullname">
                                        <b>{{ trans('pms::Project.create.fullname') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="fullname" id="fullname" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="description">
                                        <b>{{ trans('pms::Project.create.content') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description"
                                                  id="description" rows="5"></textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>
                                    <label class="control-label col-sm-2" for="permissions">
                                        <b>{{ trans('pms::Project.create.permissions') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="permissions" id="permissions">
                                            <option value="all">{{ trans('pms::Project.create.all') }}</option>
                                            <option value="members">{{ trans('pms::Project.create.members') }}</option>
                                        </select>
                                    </div>
                                    <br><br><br>
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button type="submit" title="{{ trans('pms::Project.create.button-create_project') }}"
                                            class="btn btn-default">
                                            {{ trans('pms::Project.create.button-create_project') }}
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