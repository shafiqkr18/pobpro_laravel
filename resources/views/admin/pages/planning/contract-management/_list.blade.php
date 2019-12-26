@extends('admin.layouts.default')

@section('title')
	Contract Management
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
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Contract Management</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>Planning</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Contract Management</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="{{ url('admin/contract-management/update/1') }}" class="btn btn-success btn-sm pull-right">Create</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/contract-management/create') }}">Contracts</h5>
					<!-- <a href="{{ url('admin/contract-management/update/1') }}" class="btn btn-success btn-sm">Create</a> -->
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
					<!-- <div class="row mb-4">
						<div class="col-md-12">
							<a href="{{ url('admin/contract-management/create') }}" class="btn btn-sm btn-outline btn-success">Create</a>
						</div>
					</div> -->

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover " id="contract_list" >
							<thead>
								<tr>
									<th></th>
									<th>Contract Number</th>
									<th>Contract Title</th>
									<th>Create User</th>
									<th>Submit Date</th>
									<th>Remark</th>
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