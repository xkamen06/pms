@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('Article.edit.header')  }}
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-10 col-sm-offset-1">
                            <br><br>
                            <form action="{{ route('updatearticle', ['articleId' => $article->getArticleId()]) }}" method="post"
                                  enctype="multipart/form-data" class="form-horizontal">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="title">
                                        <b>{{ trans('Article.edit.title') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="title" id="title" type="text" value="{{ $article->getTitle() }}" required>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="subtitle">
                                        <b>{{ trans('Article.edit.subtitle') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="subtitle" id="subtitle" type="text" value="{{ $article->getSubtitle() }}">
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="type">
                                        <b>{{ trans('Article.edit.type') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="type" id="type" required>
                                            @if($article->getType() === 'info')
                                                <option value="info" selected>{{ trans('Article.edit.info') }}</option>
                                                <option value="requirement">{{ trans('Article.edit.requirement') }}</option>
                                                <option value="attention">{{ trans('Article.edit.attention') }}</option>
                                            @elseif($article->getType() === 'requirement')
                                                <option value="info">{{ trans('Article.edit.info') }}</option>
                                                <option value="requirement" selected>{{ trans('Article.edit.requirement') }}</option>
                                                <option value="attention">{{ trans('Article.edit.attention') }}</option>
                                            @elseif($article->getType() === 'attention')
                                                <option value="info">{{ trans('Article.edit.info') }}</option>
                                                <option value="requirement">{{ trans('Article.edit.requirement') }}</option>
                                                <option value="attention" selected>{{ trans('Article.edit.attention') }}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <br><br><br>

                                    <label class="control-label col-sm-2" for="content">
                                        <b>{{ trans('Article.edit.content') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="content" id="content" rows="5" required>{{ $article->getContent() }}
                                        </textarea>
                                    </div>
                                    <br><br><br><br><br><br><br>

                                    <small class="col-sm-8 col-sm-offset-2 text-muted">
                                        {{ trans('Article.edit.select_image') }}
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                    </small>
                                    <br>
                                    <label class="control-label col-sm-2" for="image">
                                        <b>{{ trans('Article.create.image') }}</b>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="image" id="image" type="file" src="{{ $article->getImage() }}">
                                    </div>
                                    <br><br><br>

                                    <div class="col-sm-offset-2 col-sm-10">
                                        <button class="btn btn-default" type="submit" title="{{ trans('Article.edit.edit') }}">
                                            {{ trans('Article.edit.edit') }}
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