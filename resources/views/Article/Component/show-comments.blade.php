<h4>{{ trans('pms::Article.show.comments') }}</h4>
<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
    </tr>
    </thead>
    <tbody>
    @foreach($comments as $comment)
        <tr>
            <td>
                <b>
                    @if($comment->getUserId())
                        <a href="{{ $comment->getOwner()->getUserId() }}">
                            {{ $comment->getOwner()->getFirstname() }} {{ $comment->getOwner()->getSurname() }}
                        </a>
                    @else
                        {{ trans('pms::Article.show.deleted_user') }}
                    @endif
                </b>
                <span class="badge">{{ trans('pms::Article.show.added') }} {{ $comment->getAddedAt() }}</span>
                @if($editCommentId === $comment->getCommentId())
                    <br><br>
                    <div class="col-sm-10">
                        <form class="form-horizontal" action="{{ route('updatearticlecomment', ['commentId' => $comment->getCommentId(),
                                                                         'articleId' => $article->getArticleId()]) }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="content" value="{{ $comment->getContent() }}">
                                </div>
                                <button class="btn btn-default" type="submit" title="{{ trans('pms::Article.show.edit') }}">
                                    {{ trans('pms::Article.show.edit') }}
                                </button>
                                <a href="{{ route('articlebyid', ['articleId' => $article->getArticleId()]) }}" class="btn btn-default"
                                   title="{{ trans('pms::Article.show.cancel') }}">
                                    {{ trans('pms::Article.show.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                @else
                    @if($editCommentId === null)
                        @if(auth()->user()->role === 'admin' || $comment->getUserId() === auth()->user()->id)
                            <a href="{{ route('articlebyid', ['articleId' => $article->getArticleId(),
                             'editCommentId' => $comment->getCommentId()]) }}" class="btn-xs btn-default"
                               title="{{ trans('pms::Article.show.edit') }}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        @endif
                        @if(auth()->user()->role === 'admin' || $comment->getUserId() === auth()->user()->id
                            || $team->getLeaderId() === auth()->user()->id)
                            <a href="{{ route('deletecomment', ['commentId' => $comment->getCommentId()]) }}"
                               title="{{ trans('pms::Article.show.delete_comment') }}" class="btn-xs btn-danger"
                               onclick="
                                       return confirm('<?php echo (trans('pms::Article.show.are_you_sure_comment')
                                   . trans('pms::Article.show.from_article'))?>');">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                            <br>
                        @endif
                    @endif
                    {{ $comment->getContent() }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@if($editCommentId === null)
    @if(auth()->user()->role === 'admin' || $team->isMember(auth()->user()->id)
        || $team->getLeaderId() === auth()->user()->id)
        <br>
        <div class="col-sm-10">
            <form class="form-horizontal" action="{{ route('addarticlecomment', ['artcileId' => $article->getArticleId()]) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="content">
                    </div>
                    <button class="btn btn-primary" type="submit" title="{{ trans('pms::Article.show.add_comment') }}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </form>
        </div>
    @endif
@endif