@extends('admin.layouts.default')

@section('title')
    Jobs
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('#jobs').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'JobsFile'},
                    {extend: 'pdf', title: 'JobsFile'},

                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    },
                    {
                        className: 'btn-create',
                        text: '<i class="fa fa-plus mr-1"></i> Create',
                        action: function ( e, dt, node, config ) {
                            window.location.href = $('.ibox-title h5').attr('data-url');
                        }
                    }
                ]

            });
        });
    </script>
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Jobs Management</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>HR</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Jobs</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="{{ url('admin/vacancy-management') }}">Jobs</h5>

                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="jobs" >
                                <thead>
                                <tr>
                                    <th>RefNo</th>
                                    <th>Job Title</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Nationality</th>
                                    <th>Location</th>
                                    <th>Salary</th>
                                    <th>Job Description</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data['jobs'] as $job)
                                <tr>

                                    <td>{{$job->job_ref_no}}</td>
                                    <td>{{$job->job_title}}</td>
                                    <td>{{$job->gender}}</td>
                                    <td>{{$job->age}}</td>
                                    <td>{{$job->nationality}}</td>
                                    <td>{{$job->location}}</td>
                                    <td>{{$job->salary}}</td>
                                    <td>{{$job->job_description}}</td>
                                    <td class="text-right">
                                        <a href="{{ url('admin/vacancy/detail/') }}/{{$job->id}}" title="View"><i class="fa fa-eye text-info"></i></a>
                                        <a href="{{ url('admin/vacancy/update/') }}/{{$job->id}}" title="Edit"><i class="fas fa-pen text-success"></i></a>
                                        <a href="" title="Delete"><i class="fa fa-trash text-danger"></i></a>
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
    </div>

@endsection