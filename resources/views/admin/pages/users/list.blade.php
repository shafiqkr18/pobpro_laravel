@extends('admin.layouts.default')

@section('title')
    Users Management
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
                        className: 'btn-create @php echo !Auth::user()->hasRole("itfpobadmin") && !Auth::user()->organization ? "disabled" : ""; @endphp',
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
    <div class="row wrapper page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>User Admin</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Users</strong>
                </li>
            </ol>
						<h2 class="d-flex align-items-center">Users Management</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
					<div class="col-lg-12">
						@if (!Auth::user()->hasRole('itfpobadmin') && !Auth::user()->organization)
						<div class="alert alert-warning text-center">
							You currently do not have an organization. Please <a href="{{ url('admin/organization/create') }}" class="text-success">create an organization</a> or <a href="{{ url('admin/organization/use_template') }}" class="text-success">use an exiting template</a> before adding a user.
						</div>
						@endif
					</div>

            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="{{ route('users.create') }}">Users</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th width="50">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($data['all_users'] as $key => $user)

                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><a href="{{ route('users.show',$user->id) }}" class="text-success">{{ $user->name }} {{ $user->last_name }}</a></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if(!empty($user->getRoleNames()))
                                            @foreach($user->getRoleNames() as $v)
                                                <label class="badge badge-success">{{ $v }}</label>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="text-right action-column">
                                        <a href="{{ route('users.show',$user->id) }}" title="View"><i class="fa fa-eye text-info"></i></a>
                                        <a href="{{ route('users.edit',$user->id) }}" title="Edit"><i class="fas fa-pen text-success"></i></a>
{{--                                        <a href="" title="Download"><i class="fa fa-download text-muted"></i></a>--}}
{{--                                        <a href="" title="Delete"><i class="fa fa-trash text-danger"></i></a>--}}
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