@extends('pms::Layouts.main')

@section('content')
    <head>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        @if(auth()->user()->role === 'admin')
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var projectStatusData = google.visualization.arrayToDataTable([
                    ['<?php echo trans('pms::Dashboard.status') ?>', 'Activer and closed projects'],
                    ['<?php echo trans('pms::Dashboard.active') ?>', <?php echo $activeProjectsCount ?>],
                    ['<?php echo trans('pms::Dashboard.closed') ?>', <?php echo $closedProjectsCount ?>]
                ]);
                var taskTypeData = google.visualization.arrayToDataTable([
                    ['', '<?php echo trans('pms::Dashboard.requirements') ?>', '<?php echo trans('pms::Dashboard.bugs') ?>'],
                    ['<?php echo trans('pms::Dashboard.count') ?>', <?php echo $requirementTasksCount ?>,  <?php echo $bugTasksCount ?>]
                ]);
                var taskStatusData = google.visualization.arrayToDataTable([
                    ['', '<?php echo trans('pms::Dashboard.new') ?>', '<?php echo trans('pms::Dashboard.in_progress') ?>', '<?php echo trans('pms::Dashboard.done') ?>'],
                    ['<?php echo trans('pms::Dashboard.count') ?>', <?php echo $newTasksCount ?>,  <?php echo $inProgressTasksCount ?>,  <?php echo $doneTasksCount ?>]
                ]);
                var projectStatusOptions = {
                    title: ''
                };
                var taskTypeOptions = {
                    title: ''
                };
                var taskStatusOptions = {
                    title: ''
                };
                var projectStatusOptionsChart = new google.visualization.PieChart(document.getElementById('piechart_projects'));
                var taskTypechart = new google.charts.Bar(document.getElementById('columnchart_taks_types'));
                var taskStatuschart = new google.charts.Bar(document.getElementById('columnchart_taks_status'));
                projectStatusOptionsChart.draw(projectStatusData, projectStatusOptions);
                taskTypechart.draw(taskTypeData, google.charts.Bar.convertOptions(taskTypeOptions));
                taskStatuschart.draw(taskStatusData, google.charts.Bar.convertOptions(taskStatusOptions));
            }
        </script>
        @else
            <?php
                $tasksBugsCount = 0;
                $tasksRequirementsCount = 0;
                $tasksNewCount = 0;
                $tasksDoneCount = 0;
                $tasksInProgressCount = 0;
                $myTasksCount = 0;
            ?>
            @foreach($tasks as $task)
                <?php $myTasksCount++; ?>
                @if($task->getType() === 'bug')
                    <?php $tasksBugsCount++; ?>
                @else
                    <?php $tasksRequirementsCount++; ?>
                @endif
                @if($task->getStatus() === 'new')
                    <?php $tasksNewCount++; ?>
                @elseif($task->getStatus() === 'done')
                    <?php $tasksDoneCount++; ?>
                @else
                    <?php $tasksInProgressCount++; ?>
                @endif
            @endforeach
            <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart', 'bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                    var fileTypeData = google.visualization.arrayToDataTable([
                        ['<?php echo trans('pms::Dashboard.type') ?>', 'Submit and task files'],
                        ['<?php echo trans('pms::Dashboard.with_task') ?>', <?php echo $filesSubmitCount ?>],
                        ['<?php echo trans('pms::Dashboard.with_submit') ?>', <?php echo ($filesCount - $filesSubmitCount) ?>]
                    ]);
                    var projectStatusData = google.visualization.arrayToDataTable([
                        ['<?php echo trans('pms::Dashboard.status') ?>', 'Activer and closed projects'],
                        ['<?php echo trans('pms::Dashboard.active') ?>', <?php echo $myActiveProjectsCount ?>],
                        ['<?php echo trans('pms::Dashboard.closed') ?>', <?php echo ($myProjectsCount - $myActiveProjectsCount) ?>]
                    ]);
                    var taskTypeData = google.visualization.arrayToDataTable([
                        ['', '<?php echo trans('pms::Dashboard.requirements') ?>', '<?php echo trans('pms::Dashboard.bugs') ?>'],
                        ['<?php echo trans('pms::Dashboard.count') ?>', <?php echo $tasksRequirementsCount ?>,  <?php echo $tasksBugsCount ?>]
                    ]);
                    var taskStatusData = google.visualization.arrayToDataTable([
                        ['', '<?php echo trans('pms::Dashboard.new') ?>', '<?php echo trans('pms::Dashboard.in_progress') ?>', '<?php echo trans('pms::Dashboard.done') ?>'],
                        ['<?php echo trans('pms::Dashboard.count') ?>', <?php echo $tasksNewCount ?>,  <?php echo $tasksInProgressCount ?>,  <?php echo $tasksDoneCount ?>]
                    ]);
                    var fileTypeOptions = {
                        title: ''
                    };
                    var projectStatusOptions = {
                        title: ''
                    };
                    var taskTypeOptions = {
                        title: ''
                    };
                    var taskStatusOptions = {
                        title: ''
                    };
                    var fileTypeOptionsChart = new google.visualization.PieChart(document.getElementById('piechart_files'));
                    var projectStatusOptionsChart = new google.visualization.PieChart(document.getElementById('piechart_projects'));
                    var taskTypechart = new google.charts.Bar(document.getElementById('columnchart_taks_types'));
                    var taskStatuschart = new google.charts.Bar(document.getElementById('columnchart_taks_status'));
                    fileTypeOptionsChart.draw(fileTypeData, fileTypeOptions);
                    projectStatusOptionsChart.draw(projectStatusData, projectStatusOptions);
                    taskTypechart.draw(taskTypeData, google.charts.Bar.convertOptions(taskTypeOptions));
                    taskStatuschart.draw(taskStatusData, google.charts.Bar.convertOptions(taskStatusOptions));
                }
            </script>
        @endif
    </head>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Dashboard.header') }}
                    </div>
                    <div class="panel-body">
                        @if(auth()->user()->role === 'admin')
                            <div class="text-center">
                                <h2>{{ trans('pms::Dashboard.users') }}</h2>
                            </div>
                            <b>{{ trans('pms::Dashboard.users_of_system') }}</b> {{ $usersCount }}
                            <a class="btn btn-default" href="{{ route('allusers') }}">{{ trans('pms::Dashboard.show_all_users') }}</a>
                            <hr>
                            <div class="text-center">
                                <h2>{{ trans('pms::Dashboard.projects') }}</h2>
                            </div>
                            <b>{{ trans('pms::Dashboard.projects_of_system') }}</b> {{ $projectsCount }}
                            <a class="btn btn-default" href="{{ route('allprojects') }}">{{ trans('pms::Dashboard.show_all_projects') }}</a>
                            <br>
                            <b>{{ trans('pms::Dashboard.tasks') }}</b> {{ $tasksCount }}
                            <br><br>
                            <div class="col-md-4">
                                <h4>{{ trans('pms::Dashboard.opened_and_closed_projects') }}</h4>
                                <div id="piechart_projects" style="width: 400px; height: 300px;"></div>
                            </div>
                            <div class="col-md-4">
                                <h4>{{ trans('pms::Dashboard.types_of_tasks') }}</h4>
                                <br><br><br>
                                <div id="columnchart_taks_types" style="width: 270px; height: 200px;"></div>
                            </div>
                            <div class="col-md-4">
                                <h4>{{ trans('pms::Dashboard.statuses_of_tasks') }}</h4>
                                <br><br><br>
                                <div id="columnchart_taks_status" style="width: 270px; height: 200px;"></div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <b>{{ trans('pms::Dashboard.files') }}</b> {{ $filesCount }}
                                <br>
                                <b>{{ trans('pms::Dashboard.files_with_tasks') }}</b> {{ $taskFilesCount }}
                                <br>
                                <b>{{ trans('pms::Dashboard.files_with_submit') }}</b> {{ $submitFilesCount }}
                                <hr>
                                <div class="text-center">
                                    <h2>{{ trans('pms::Dashboard.teams') }}</h2>
                                </div>
                                <b>{{ trans('pms::Dashboard.teams_of_system') }}</b> {{ $teamsCount }}
                                <a class="btn btn-default" href="{{ route('allteams') }}">{{ trans('pms::Dashboard.show_all_teams') }}</a>
                                <br>
                                <b>{{ trans('pms::Dashboard.team_articles') }}</b> {{ $articlesCount }}
                                <br><br><br><br>
                            </div>
                        @else
                            <div class="text-center">
                                <h2>{{ trans('pms::Dashboard.my_projects') }}</h2>
                            </div>
                            <a href="{{ route('allprojects') }}" class="btn btn-default">
                                {{ trans('pms::Dashboard.show_all_projects') }}
                            </a>
                            <br>
                            <b>{{ trans('pms::Dashboard.my_projects_of_system') }}</b> {{ $myProjectsCount }}
                            <br>
                            <b>{{ trans('pms::Dashboard.my_tasks') }}</b> {{ $myTasksCount }}
                            <br>
                            @if($myProjectsCount !== 0)
                                <div class="col-md-4">
                                    <h4>{{ trans('pms::Dashboard.my_opened_and_closed_projects') }}</h4>
                                    <div id="piechart_projects" style="width: 400px; height: 300px;"></div>
                                </div>
                            @else
                                <br>
                                {{ trans('pms::Dashboard.not_project_member_of_leader') }}
                            @endif
                            @if($myTasksCount !== 0)
                                <div class="col-md-4">
                                    <h4>{{ trans('pms::Dashboard.tasks_types') }}</h4>
                                    <br><br><br>
                                    <div id="columnchart_taks_types" style="width: 270px; height: 200px;"></div>
                                </div>
                                <div class="col-md-4">
                                    <h4>{{ trans('pms::Dashboard.tasks_statuses') }}</h4>
                                    <br><br><br>
                                    <div id="columnchart_taks_status" style="width: 270px; height: 200px;"></div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2>{{ trans('pms::Dashboard.my_files') }}</h2>
                                </div>
                                <b>{{ trans('pms::Dashboard.my_system_files') }}</b> {{ $filesCount }}
                                <br><br>
                                @if($filesCount !== 0)
                                    <div class="col-md-4 text-center">
                                        <h4>{{ trans('pms::Dashboard.files_types') }}</h4>
                                        <div id="piechart_files" style="width: 400px; height: 300px;"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2>{{ trans('pms::Dashboard.my_teams') }}</h2>
                                </div>
                                <a href="{{ route('allteams') }}" class="btn btn-default">
                                    {{ trans('pms::Dashboard.show_all_teams') }}
                                </a>
                                <br>
                                <b>{{ trans('pms::Dashboard.my_teams_of_system') }}</b> {{ $teamsCount }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection