@extends('admin.layouts.default')

@section('title')
	Onboarding
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function(){
	$('#onboarding_list').DataTable({
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: 'lTfgitp',
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
					window.location.href = '';
				}
			}
		]

	});

});
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				HR
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Onboarding</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/division-management/create') }}">Messages</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="onboarding_list" style="width: 100%;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Name</th>
									<th>Position</th>
									<th>Department</th>
									<th>Nationality</th>
									<th>Location</th>
									<th>Email</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
							@if (count($candidates) > 0)
								@foreach ($candidates as $candidate)
								<tr>
									<td>{{ $candidate->id }}</td>
									<td>{{ $candidate->getName() }}</td>
									<td>{{ $candidate->position ? $candidate->position->title : '' }}</td>
									<td>{{ $candidate->position && $candidate->position->department ? $candidate->position->department->department_short_name : '' }}</td>
									<td>{{ $candidate->nationality }}</td>
									<td>{{ $candidate->location }}</td>
									<td><a href="mailto:{{ $candidate->email }}" class="text-success">{{ $candidate->email }}</a></td>
									<td class="text-nowrap text-center action-column">
										<a href="" class="btn btn-success btn-xs">Create request</a>
									</td>
								</tr>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection