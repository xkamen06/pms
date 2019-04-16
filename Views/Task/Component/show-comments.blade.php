<h4>{{ trans('Task.show.comments') }}</h4>
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
                        {{ trans('Task.show.deleted_user') }}
                    @endif
                </b>
                <span class="badge">{{ trans('Task.show.added') }} {{ $comment->getAddedAt() }}</span>
                @if($editCommentId === $comment->getCommentId())
                    <br><br>
                    <div class="col-sm-10">
                        <form class="form-horizontal" action="{{ route('updatetaskcomment', ['commentId' => $comment->getCommentId(),
                                                                         'articleId' => $task->getTaskId()]) }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-sm-8">
                                    <input class="form-control" type="text" name="content" value="{{ $comment->getContent() }}">
                                </div>
                                <button class="btn btn-default" type="submit" title="{{ trans('Task.show.edit') }}">
                                    {{ trans('Task.show.edit') }}
                                </button>
                                <a href="{{ route('showtask', ['taskId' => $task->getTaskId()]) }}" class="btn btn-default"
                                    title="{{ trans('Task.show.cancel') }}">
                                        {{ trans('Task.show.cancel') }}
                                </a>
                            </div>
                        </form>
                    </div>
                @else
                    @if($editCommentId === null)
                        @if(auth()->user()->role === 'admin' || $comment->getUserId() === auth()->user()->id)
                            <a href="{{ route('showtask', ['taskId' => $task->getTaskId(),
                               'editCommentId' => $comment->getCommentId()]) }}" class="btn-xs btn-default"
                                title="{{ trans('Task.show.edit') }}">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>
                        @endif
                        @if(auth()->user()->role === 'admin' || $comment->getUserId() === auth()->user()->id
                            || $project->getLeader() === auth()->user()->id
                            || $task->getLeader() === auth()->user()->id)
                            <a href="{{ route('deletecomment', ['commentId' => $comment->getCommentId()]) }}"
                               title="{{ trans('Task.show.delete_comment') }}" class="btn-xs btn-danger"
                               onclick="
                                       return confirm('<?php echo (trans('Task.show.are_you_sure_comment')
                                   . trans('Task.show.from_task'))?>');">
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
    @if(auth()->user()->role === 'admin' || $project->isMember(auth()->user()->id))
        <br>
        <div class="col-sm-10">
            <form class="form-horizontal" action="{{ route('addtaskcomment', ['taskId' => $task->getTaskId()]) }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-sm-8">
                        <input class="form-control" type="text" name="content">
                    </div>
                    <button class="btn btn-primary" type="submit" title="{{ trans('Task.show.add_comment') }}">
                        <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </div>
            </form>
        </div>
    @endif
@endif