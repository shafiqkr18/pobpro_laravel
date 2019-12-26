@extends('admin.layouts.default')

@section('title')
	Contractors
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/company-contracts.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/company-contracts.js') }}"></script>
<script>
$(document).ready(function(){
	$('#contractor_employees_list').DataTable({
		pageLength: 10,
		responsive: true,
		lengthChange: false,
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
					window.location.href = baseUrl + '/admin/contracts-mgt/contractor/employee/create/' + @php echo $contractor ? $contractor->id : '\'\''; @endphp;
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
				Contracts Mgt.
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			{{ $contractor ? $contractor->title : 'Contractor' }} Employees
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
	
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Employees</h5>
				</div>

				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="contractor_employees_list" style="width: 100%;">
							<thead>
								<tr>
									<th>Ref No.</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Contractor</th>
									<th>Position</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
								@if (count($employees) > 0)
									@foreach ($employees as $employee)
									<tr>
										<td>{{ $employee->employee_ref }}</td>
										<td>{{ $employee->getName() }}</td>
										<td>{{ $employee->email }}</td>
										<td>{{ $employee->phone }}</td>
										<td>{{ $employee->contractor ? $employee->contractor->title : '' }}</td>
										<td>{{ $employee->position }}</td>
										<td>
											<div class="d-flex justify-content-center align-items-center flex-nowrap">
												<a href="{{ url('admin/contracts-mgt/contractor/employee/update/' . $employee->id) }}" class="ml-1 mr-1" title="Edit">
													<i class="fa fa-pen-square text-success"></i>
												</a>

												<!-- <a href="{{ url('admin/modal/delete') }}" class="ml-1 mr-1" title="Delete" confirmation-modal="delete" data-view="table" data-url="{{ url('admin/contracts-mgt/contractor/employee/delete/' . $employee->id) }}">
													<i class="fa fa-trash text-danger"></i>
												</a> -->
											</div>
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