@extends('admin.layouts.default')

@section('title')
	Employees
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ URL::asset('js/operations/listings.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Employees</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Employees</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/employee/create') }}">Employees</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="employee_list">
							<thead>
								<tr>
{{--									<th></th>--}}
									<th>ID</th>
                                    <th>RefNo</th>
									<th>Name</th>
									<th>Email</th>
									<th>Mobile Number</th>
									<th>Organization</th>
									<th>Department</th>
									<th>Position</th>
									<th>Work Type</th>
									<th>Join Date</th>
									<th>Gender</th>
									<th>Nationality</th>
									<th>Passport No.</th>
									<th></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection