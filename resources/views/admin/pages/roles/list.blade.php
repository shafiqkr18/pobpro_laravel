@extends('admin.layouts.default')

@section('title')
    Roles Management
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
            $('.dataTables-example').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

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
    <div class="row page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item text-muted">
                    <a>User Admin</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Roles</strong>
                </li>
            </ol>
						<h2 class="d-flex align-items-center">Roles Management</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="{{ route('roles.create') }}">Roles</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>

                                    <th width="50">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data['roles'] as $key => $role)

                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td><a href="{{ route('roles.show',$role->id) }}" class="text-success">{{ $role->name }}</a></td>


                                    <td class="text-right">
                                        <a href="{{ route('roles.show',$role->id) }}" title="View"><i class="fa fa-eye text-info"></i></a>
{{--                                        @can('role-edit')--}}
                                        <a href="{{ route('roles.edit',$role->id) }}" title="Edit"><i class="fas fa-pen text-success"></i></a>
{{--                                        @endcan--}}

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