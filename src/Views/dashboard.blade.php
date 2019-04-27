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
                    ['<?php echo trans('Dashboard.status') ?>', 'Activer and closed projects'],
                    ['<?php echo trans('Dashboard.active') ?>', <?php echo $activeProjectsCount ?>],
                    ['<?php echo trans('Dashboard.closed') ?>', <?php echo $closedProjectsCount ?>]
                ]);
                var taskTypeData = google.visualization.arrayToDataTable([
                    ['', '<?php echo trans('Dashboard.requirements') ?>', '<?php echo trans('Dashboard.bugs') ?>'],
                    ['<?php echo trans('Dashboard.count') ?>', <?php echo $requirementTasksCount ?>,  <?php echo $bugTasksCount ?>]
                ]);
                var taskStatusData = google.visualization.arrayToDataTable([
                    ['', '<?php echo trans('Dashboard.new') ?>', '<?php echo trans('Dashboard.in_progress') ?>', '<?php echo trans('Dashboard.done') ?>'],
                    ['<?php echo trans('Dashboard.count') ?>', <?php echo $newTasksCount ?>,  <?php echo $inProgressTasksCount ?>,  <?php echo $doneTasksCount ?>]
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
                        ['<?php echo trans('Dashboard.type') ?>', 'Submit and task files'],
                        ['<?php echo trans('Dashboard.with_task') ?>', <?php echo $filesSubmitCount ?>],
                        ['<?php echo trans('Dashboard.with_submit') ?>', <?php echo ($filesCount - $filesSubmitCount) ?>]
                    ]);
                    var projectStatusData = google.visualization.arrayToDataTable([
                        ['<?php echo trans('Dashboard.status') ?>', 'Activer and closed projects'],
                        ['<?php echo trans('Dashboard.active') ?>', <?php echo $myActiveProjectsCount ?>],
                        ['<?php echo trans('Dashboard.closed') ?>', <?php echo ($myProjectsCount - $myActiveProjectsCount) ?>]
                    ]);
                    var taskTypeData = google.visualization.arrayToDataTable([
                        ['', '<?php echo trans('Dashboard.requirements') ?>', '<?php echo trans('Dashboard.bugs') ?>'],
                        ['<?php echo trans('Dashboard.count') ?>', <?php echo $tasksRequirementsCount ?>,  <?php echo $tasksBugsCount ?>]
                    ]);
                    var taskStatusData = google.visualization.arrayToDataTable([
                        ['', '<?php echo trans('Dashboard.new') ?>', '<?php echo trans('Dashboard.in_progress') ?>', '<?php echo trans('Dashboard.done') ?>'],
                        ['<?php echo trans('Dashboard.count') ?>', <?php echo $tasksNewCount ?>,  <?php echo $tasksInProgressCount ?>,  <?php echo $tasksDoneCount ?>]
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
                        {{ trans('Dashboard.header') }}
                    </div>
                    <div class="panel-body">
                        @if(auth()->user()->role === 'admin')
                            <div class="text-center">
                                <h2>{{ trans('Dashboard.users') }}</h2>
                            </div>
                            <b>{{ trans('Dashboard.users_of_system') }}</b> {{ $usersCount }}
                            <a class="btn btn-default" href="{{ route('allusers') }}">{{ trans('Dashboard.show_all_users') }}</a>
                            <hr>
                            <div class="text-center">
                                <h2>{{ trans('Dashboard.projects') }}</h2>
                            </div>
                            <b>{{ trans('Dashboard.projects_of_system') }}</b> {{ $projectsCount }}
                            <a class="btn btn-default" href="{{ route('allprojects') }}">{{ trans('Dashboard.show_all_projects') }}</a>
                            <br>
                            <b>{{ trans('Dashboard.tasks') }}</b> {{ $tasksCount }}
                            <br><br>
                            <div class="col-md-4">
                                <h4>{{ trans('Dashboard.opened_and_closed_projects') }}</h4>
                                <div id="piechart_projects" style="width: 400px; height: 300px;"></div>
                            </div>
                            <div class="col-md-4">
                                <h4>{{ trans('Dashboard.types_of_tasks') }}</h4>
                                <br><br><br>
                                <div id="columnchart_taks_types" style="width: 270px; height: 200px;"></div>
                            </div>
                            <div class="col-md-4">
                                <h4>{{ trans('Dashboard.statuses_of_tasks') }}</h4>
                                <br><br><br>
                                <div id="columnchart_taks_status" style="width: 270px; height: 200px;"></div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <b>{{ trans('Dashboard.files') }}</b> {{ $filesCount }}
                                <br>
                                <b>{{ trans('Dashboard.files_with_tasks') }}</b> {{ $taskFilesCount }}
                                <br>
                                <b>{{ trans('Dashboard.files_with_submit') }}</b> {{ $submitFilesCount }}
                                <hr>
                                <div class="text-center">
                                    <h2>{{ trans('Dashboard.teams') }}</h2>
                                </div>
                                <b>{{ trans('Dashboard.teams_of_system') }}</b> {{ $teamsCount }}
                                <a class="btn btn-default" href="{{ route('allteams') }}">{{ trans('Dashboard.show_all_teams') }}</a>
                                <br>
                                <b>{{ trans('Dashboard.team_articles') }}</b> {{ $articlesCount }}
                                <br><br><br><br>
                            </div>
                        @else
                            <div class="text-center">
                                <h2>{{ trans('Dashboard.my_projects') }}</h2>
                            </div>
                            <a href="{{ route('allprojects') }}" class="btn btn-default">
                                {{ trans('Dashboard.show_all_projects') }}
                            </a>
                            <br>
                            <b>{{ trans('Dashboard.my_projects_of_system') }}</b> {{ $myProjectsCount }}
                            <br>
                            <b>{{ trans('Dashboard.my_tasks') }}</b> {{ $myTasksCount }}
                            <br>
                            @if($myProjectsCount !== 0)
                                <div class="col-md-4">
                                    <h4>{{ trans('Dashboard.my_opened_and_closed_projects') }}</h4>
                                    <div id="piechart_projects" style="width: 400px; height: 300px;"></div>
                                </div>
                            @else
                                <br>
                                {{ trans('Dashboard.not_project_member_of_leader') }}
                            @endif
                            @if($myTasksCount !== 0)
                                <div class="col-md-4">
                                    <h4>{{ trans('Dashboard.tasks_types') }}</h4>
                                    <br><br><br>
                                    <div id="columnchart_taks_types" style="width: 270px; height: 200px;"></div>
                                </div>
                                <div class="col-md-4">
                                    <h4>{{ trans('Dashboard.tasks_statuses') }}</h4>
                                    <br><br><br>
                                    <div id="columnchart_taks_status" style="width: 270px; height: 200px;"></div>
                                </div>
                            @endif
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2>{{ trans('Dashboard.my_files') }}</h2>
                                </div>
                                <b>{{ trans('Dashboard.my_system_files') }}</b> {{ $filesCount }}
                                <br><br>
                                @if($filesCount !== 0)
                                    <div class="col-md-4 text-center">
                                        <h4>{{ trans('Dashboard.files_types') }}</h4>
                                        <div id="piechart_files" style="width: 400px; height: 300px;"></div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <h2>{{ trans('Dashboard.my_teams') }}</h2>
                                </div>
                                <a href="{{ route('allteams') }}" class="btn btn-default">
                                    {{ trans('Dashboard.show_all_teams') }}
                                </a>
                                <br>
                                <b>{{ trans('Dashboard.my_teams_of_system') }}</b> {{ $teamsCount }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection