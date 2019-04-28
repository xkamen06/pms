@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Article.index_by_team.articles') }}
                    </div>
                    <div class="panel-body">
                        @if(auth()->user()->role === 'admin' || $team->isMember(auth()->user()->id)
                               || $team->getLeaderId() === auth()->user()->id)
                            <a href="{{ route('addarticleform', ['teamId' => $team->getTeamId()]) }}" class="btn btn-primary"
                                title="{{ trans('pms::Article.index_by_team.add_article') }}">
                                <span class="glyphicon glyphicon-plus"></span>
                            </a>
                        @endif

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($articles as $article)
                                <tr>
                                    <td>
                                        <h4>
                                            <a href="{{ route('articlebyid', ['articleId' => $article->getArticleId()]) }}">
                                                {{ $article->getTitle() }}
                                            </a>
                                            @if($article->getType() === 'requirement')
                                                <span class="label label-warning">{{ trans('pms::Article.index_by_team.requirement') }}</span>
                                            @elseif($article->getType() === 'info')
                                                <span class="label label-primary">{{ trans('pms::Article.index_by_team.info') }}</span>
                                            @else
                                                <span class="label label-danger">{{ trans('pms::Article.index_by_team.attention') }}</span>
                                            @endif
                                        </h4>

                                        <h5>{{ $article->getSubtitle() }}</h5>
                                        {{ $article->getContent() }}
                                        <br>

                                        <span class="badge">{{ trans('pms::Article.index_by_team.added') }} {{ $article->getAddedAt() }}</span>
                                        @if($article->getOwner())
                                            <a href="{{ route('userprofile', ['userid' => $article->getUserId()]) }}" class="btn">
                                                {{ $article->getOwner()->getFirstname()}} {{$article->getOwner()->getSurname() }}
                                            </a>
                                        @endif
                                        <br>
                                        <div class="text-right">
                                            @if(auth()->user()->role === 'admin' || $article->getUserId() === auth()->user()->id)
                                                <a href="{{ route('editarticle', ['articleId' => $article->getArticleId()]) }}"
                                                   class="btn btn-default" title="{{ trans('pms::Article.index_by_team.edit_article') }}">
                                                    <span class="glyphicon glyphicon-pencil"></span>
                                                </a>
                                            @endif

                                            @if(auth()->user()->role === 'admin' || $article->getUserId() === auth()->user()->id
                                                || $team->getLeaderId() === auth()->user()->id)
                                                <a href="{{ route('deletearticle', ['articleId' => $article->getArticleId()]) }}"
                                                   class="btn btn-danger" title="{{ trans('pms::Article.index_by_team.delete_article') }}"
                                                   onclick="
                                                           return confirm('<?php echo (trans('pms::Team.show.are_you_sure_article')
                                                       . trans('pms::Team.show.from_team'))?>');">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection