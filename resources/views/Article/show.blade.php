@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Article.show.article_detail') }}
                    </div>
                    <div class="panel-body">
                        @if(auth()->user()->role === 'admin' || $article->getUserId() === auth()->user()->id)
                            <a href="{{ route('editarticle', ['articleId' => $article->getArticleId()]) }}"
                                class="btn btn-default" title="{{ trans('pms::Article.show.edit_article') }}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        @endif
                        @if(auth()->user()->role === 'admin' || $article->getUserId() === auth()->user()->id
                            || $team->getLeaderId() === auth()->user()->id)
                            <a href="{{ route('deletearticle', ['articleId' => $article->getArticleId()]) }}"
                               class="btn btn-danger" title="{{ trans('pms::Article.show.delete_article') }}">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        @endif

                        <h2>{{ $article->getTitle() }}
                            @if($article->getType() === 'requirement')
                                <span class="label label-warning">{{ trans('pms::Article.show.requirement') }}</span>
                            @elseif($article->getType() === 'info')
                                <span class="label label-primary">{{ trans('pms::Article.show.info') }}</span>
                            @else
                                <span class="label label-danger">{{ trans('pms::Article.show.attention') }}</span>
                            @endif
                        </h2>

                        <h4>{{ $article->getSubtitle() }}</h4>
                        <span class="badge">{{ trans('pms::Article.show.added') }} {{ $article->getAddedAt() }}</span>
                        <br>

                        <b>{{ trans('pms::Article.show.author') }}</b>
                        @if($article->getOwner())
                            <a href="{{ route('userprofile', ['userid' => $article->getUserId()]) }}" class="btn">
                                {{ $article->getOwner()->getFirstname()}} {{$article->getOwner()->getSurname() }}
                            </a>
                        @else
                            {{ trans('pms::Article.show.deleted_user') }}
                        @endif
                        <br>

                        @if($article->getImage())
                            <img class="article-image" src="{{ \Illuminate\Support\Facades\Storage::url($article->getImage()) }}" alt="article-image"
                            >
                            <br><br>
                        @endif

                        {{ $article->getContent() }}

                        <br><br>
                        @include('pms::Article.Component.show-comments')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection