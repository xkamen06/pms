@if( $team->getPermissions() === 'all' ||  auth()->user()->role === 'admin' || $team->isMember(auth()->user()->id))
    <h3>{{ trans('pms::Team.show.articles') }}</h3>
    @if(auth()->user()->role === 'admin' || $team->isMember(auth()->user()->id)
        || $team->getLeaderId() === auth()->user()->id)
        <a href="{{ route('addarticleform', ['teamId' => $team->getTeamId()]) }}" class="btn btn-primary"
            title="{{ trans('pms::Team.show.add_article') }}">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif
    @if($articles)
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
                                <span class="label label-warning">{{ trans('pms::Team.show.requirement') }}</span>
                            @elseif($article->getType() === 'info')
                                <span class="label label-primary">{{ trans('pms::Team.show.info') }}</span>
                            @else
                                <span class="label label-danger">{{ trans('pms::Team.show.warning') }}</span>
                            @endif
                        </h4>
                        <h5>{{ $article->getSubtitle() }}</h5>
                        {{ substr($article->getContent(), 0, 200) }}...
                        <br>
                        <span class="badge">{{ trans('pms::Team.show.added_at') }} {{ $article->getAddedAt() }}</span>
                        @if($article->getUserId())
                            <a href="{{ route('userprofile', ['userid' => $article->getUserId()]) }}" class="btn">
                                {{ $article->getOwner()->getFirstname()}} {{$article->getOwner()->getSurname() }}
                            </a>
                        @endif
                        <div class="text-right">
                            @if(auth()->user()->role === 'admin' || $article->getUserId() === auth()->user()->id)
                                <a href="{{ route('editarticle', ['articleId' => $article->getArticleId()]) }}"
                                   class="btn btn-default" title="{{ trans('pms::Team.show.edit_article') }}">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            @endif
                            @if(auth()->user()->role === 'admin' || $article->getUserId() === auth()->user()->id
                                || $team->getLeaderId() === auth()->user()->id)
                                <a href="{{ route('deletearticle', ['articleId' => $article->getArticleId()]) }}"
                                   class="btn btn-danger" title="{{ trans('pms::Team.show.delete_article') }}"
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
        <hr>
        <a href="{{ route('articlesbyteam', ['teamId' => $team->getTeamId()]) }}" class="btn">
            {{ trans('pms::Team.show.show_all_articles') }}
        </a>
    @else
        <b>{{ trans('pms::Team.show.no_articles') }}</b>
    @endif
    <br>
@endif