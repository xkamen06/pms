<h3>{{ trans('Task.show.files') }}</h3>
@if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
    || $project->isMember(auth()->user()->id))
    <a href="{{ route('showaddtotaskfileform', ['taskId' => $task->getTaskId()]) }}"
       title="{{ trans('Task.show.add_file') }}" class="btn btn-primary">
        <span class="glyphicon glyphicon-plus"></span>
    </a>
@endif
<h4>{{ trans('Task.show.task') }}</h4>
@if($taskFiles)
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('Task.show.filename') }}</th>
            <th>{{ trans('Task.show.added') }}</th>
            <th>{{ trans('Task.show.description_file') }}</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($taskFiles as $file)
            <tr>
                <td>
                    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
                        || $project->isMember(auth()->user()->id))
                        <a href="{{ route('downloadfile', ['fileId' => $file->getFileId()]) }}"
                           title="{{ trans('Task.show.download_file') }}" class="btn btn-default">
                            <span class="glyphicon glyphicon-download-alt"></span>
                        </a>
                    @endif
                </td>
                <td>
                    {{ $file->getFilename() }}
                </td>
                <td>
                    {{ $file->getAddedAt() }}
                </td>
                <td>
                    {{ $file->getDescription() }}
                </td>
                <td>
                    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
                        || $project->isMember(auth()->user()->id))
                        <a href="{{ route('copyfiletoproject', ['fileId' => $file->getFileId(), 'projectId' => $project->getProjectId()]) }}"
                           title="{{ trans('Task.show.copy_to_project') }}" class="btn btn-default">
                            {{ trans('Task.show.copy_to_project') }}
                        </a>
                    @endif
                </td>
                <td>
                    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
                        || $project->isMember(auth()->user()->id))
                        <a href="{{ route('movefiletoproject', ['fileId' => $file->getFileId(), 'projectId' => $project->getProjectId()]) }}"
                           title="{{ trans('Task.show.move_to_project') }}" class="btn btn-default">
                            {{ trans('Task.show.move_to_project') }}
                        </a>
                    @endif
                </td>
                <td>
                    @if(auth()->user()->role === 'admin' ||
                        auth()->user()->id === $project->getLeaderId() ||
                        auth()->user()->id === $file->getUserId())
                        <a href="{{ route('deletefile', ['fileId' => $file->getFileId()]) }}"
                           title="{{ trans('Task.show.delete_file') }}" class="btn btn-danger"
                           onclick="
                                   return confirm('<?php echo (trans('Task.show.are_you_sure_file')
                               . $file->getFilename()
                               . trans('Task.show.from_task'))?>');">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <br>
    {{ trans('Task.show.no_task_files') }}
@endif
<br>
<h4>{{ trans('Task.show.submit') }}</h4>
@if($submitFiles)
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('Task.show.filename') }}</th>
            <th>{{ trans('Task.show.added') }}</th>
            <th>{{ trans('Task.show.description_file') }}</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($submitFiles as $file)
            <tr>
                <td>
                    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
                        || $project->isMember(auth()->user()->id))
                        <a href="{{ route('downloadfile', ['fileId' => $file->getFileId()]) }}"
                            title="{{ trans('Task.show.download_file') }}" class="btn btn-default">
                            <span class="glyphicon glyphicon-download-alt"></span>
                        </a>
                    @endif
                </td>
                <td>
                    {{ $file->getFilename() }}
                </td>
                <td>
                    {{ $file->getAddedAt() }}
                </td>
                <td>
                    {{ $file->getDescription() }}
                </td>
                <td>
                    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
                        || $project->isMember(auth()->user()->id))
                        <a href="{{ route('copyfiletoproject', ['fileId' => $file->getFileId(), 'projectId' => $project->getProjectId()]) }}"
                           title="{{ trans('Task.show.copy_to_project') }}" class="btn btn-default">
                            {{ trans('Task.show.copy_to_project') }}
                        </a>
                    @endif
                </td>
                <td>
                    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
                        || $project->isMember(auth()->user()->id))
                        <a href="{{ route('movefiletoproject', ['fileId' => $file->getFileId(), 'projectId' => $project->getProjectId()]) }}"
                           title="{{ trans('Task.show.move_to_project') }}" class="btn btn-default">
                            {{ trans('Task.show.move_to_project') }}
                        </a>
                    @endif
                </td>
                <td>
                    @if($project->getStatus() === 'active')
                        @if(auth()->user()->role === 'admin' ||
                            auth()->user()->id === $project->getLeaderId() ||
                            auth()->user()->id === $file->getUserId())
                            <a href="{{ route('deletefile', ['fileId' => $file->getFileId()]) }}"
                               title="{{ trans('Task.show.delete_file') }}" class="btn btn-danger"
                               onclick="
                                       return confirm('<?php echo (trans('Task.show.are_you_sure_file')
                                   . $file->getFilename()
                                   . trans('Task.show.from_task'))?>');">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                        @endif
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <br>
    {{ trans('Task.show.no_submit_files') }}
@endif