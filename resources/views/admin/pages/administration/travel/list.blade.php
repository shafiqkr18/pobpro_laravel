@extends('admin.layouts.default')

@section('title')
	Travel Request
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
				<a>Administration</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Travel Request</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/hr-plan/create') }}">Travel Requests</h5>

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
						<table class="table table-striped table-bordered table-hover" id="travel_list">
							<thead>
								<tr>
									<th>Name</th>
									<th>Job Title</th>
									<th>Department</th>
									<th>Application Date</th>
									<th>Class</th>
									<th>Hotel</th>
									<th>Departure Date</th>
									<th>Return Date</th>
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