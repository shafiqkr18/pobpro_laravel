@extends('admin.layouts.default')

@section('title')
	Department Management
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ URL::asset('js/operations/listings.js') }}"></script>

	<!-- Page-Level Scripts -->

@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Settings
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Department Management</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/department-management/create') }}">Departments</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="department_list" style="width: 100%;">
							<thead>
								<tr>
									<th></th>
									<th>Department Code</th>
									<th>Short Name</th>
									<th>Full Name</th>
									<th>Division Name</th>
									<th>Organization Name</th>
									<th>Created By</th>
									<th>Created Date</th>
									<th></th>
								</tr>
							</thead>

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection