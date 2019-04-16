<h3>{{ trans('Project.show.files') }}</h3>
@if($project->getStatus() === 'active')
    @if(auth()->user()->role === 'admin' || $project->getLeaderId() === auth()->user()->id
        || $project->isMember(auth()->user()->id))
        <a href="{{ route('showaddtoprojectfileform', ['projectId' => $project->getProjectId()]) }}"
           title="{{ trans('Project.show.add_file') }}" class="btn btn-primary">
            <span class="glyphicon glyphicon-plus"></span>
        </a>
    @endif
@endif
<h4>{{ trans('Project.show.task') }}</h4>
@if($taskFiles)
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('Project.show.filename') }}</th>
            <th>{{ trans('Project.show.added') }}</th>
            <th>{{ trans('Project.show.description_file') }}</th>
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
                           title="{{ trans('Project.show.download_file') }}" class="btn btn-default">
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
                    @if($project->getStatus() === 'active')
                        @if(auth()->user()->role === 'admin' ||
                            auth()->user()->id === $project->getLeaderId() ||
                            auth()->user()->id === $file->getUserId())
                            <a href="{{ route('deletefile', ['fileId' => $file->getFileId()]) }}"
                               title="{{ trans('Project.show.delete_file') }}" class="btn btn-danger"
                               onclick="
                                       return confirm('<?php echo (trans('Project.show.are_you_sure_file')
                                   . $file->getFilename()
                                   . trans('Project.show.from_project'))?>');">
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
    {{ trans('Project.show.no_task_files') }}
@endif
<br>
<h4>{{ trans('Project.show.submit') }}</h4>
@if($submitFiles)
    <table class="table table-striped">
        <thead>
        <tr>
            <th></th>
            <th>{{ trans('Project.show.filename') }}</th>
            <th>{{ trans('Project.show.added') }}</th>
            <th>{{ trans('Project.show.description_file') }}</th>
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
                           title="{{ trans('Project.show.download_file') }}" class="btn btn-default">
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
                    @if($project->getStatus() === 'active')
                        @if(auth()->user()->role === 'admin' ||
                            auth()->user()->id === $project->getLeaderId() ||
                            auth()->user()->id === $file->getUserId())
                            <a href="{{ route('deletefile', ['fileId' => $file->getFileId()]) }}"
                               title="{{ trans('Project.show.delete_file') }}" class="btn btn-danger"
                               onclick="
                                       return confirm('<?php echo (trans('Project.show.are_you_sure_file')
                                   . $file->getFilename()
                                   . trans('Project.show.from_project'))?>');">
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
    {{ trans('Project.show.no_submit_files') }}
@endif