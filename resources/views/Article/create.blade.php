@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Article.create.header') }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            <br><br>
                            <form class="form-horizontal" action="{{ route('addarticle', ['teamId' => $teamId]) }}" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="title">
                                        <b>{{ trans('pms::Article.create.title') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="title" id="title" type="text" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="subtitle">
                                        <b>{{ trans('pms::Article.create.subtitle') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="subtitle" id="subtitle" type="text">
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="type">
                                        <b>{{ trans('pms::Article.create.type') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type" id="type" required>
                                            <option value="info" selected>{{ trans('pms::Article.create.info') }}</option>
                                            <option value="requirement">{{ trans('pms::Article.create.requirement') }}</option>
                                            <option value="attention">{{ trans('pms::Article.create.attention') }}</option>
                                        </select>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="content">
                                        <b>{{ trans('pms::Article.create.content') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="content" id="content" rows="5" required>
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <label class="control-label col-sm-2" for="image">
                                        <b>{{ trans('pms::Article.create.image') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="image" id="image" type="file">
                                    </div>
                                    <br><br><br>

                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-default" type="submit" title="{{ trans('pms::Article.create.add') }}">
                                            {{ trans('pms::Article.create.add') }}
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