@extends('pms::Layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        {{ trans('pms::Project.index.projects_review') }}
                    </div>
                    <div class="panel-body">

                        <a title="{{ trans('pms::Project.index.create_project') }}" href="{{ route('createprojectform') }}"
                           class="btn btn-primary">
                            <span class="glyphicon glyphicon-plus"></span>
                        </a>
                        <br><hr>

                        <h3>{{ trans('pms::Project.index.my_projects') }}</h3>

                        @include('pms::Project.Component.index-myprojects-leader')
                        <br>
                        <br>

                        @include('pms::Project.Component.index-myprojects-member')
                        <br><hr>
                        <br>

                        @include('pms::Project.Component.index-otherprojects')
                        <hr>
                        <div class="col-md-6 col-md-offset-3 text-center">
                            {{ $projectsPaginator->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection