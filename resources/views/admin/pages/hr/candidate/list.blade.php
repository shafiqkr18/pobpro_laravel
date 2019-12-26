@extends('admin.layouts.default')

@section('title')
	Candidate Management
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
    <style type="text/css">
        .myclass{
            padding-right: 20px !important;
            background-color: #4cc636 !important;

        }
        table.dataTable{border-collapse:collapse !important;}
    </style>
@endsection

@section('scripts')
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(11,99)}}"></script>


@endsection

@section('content')
<div class="row page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Candidates</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Candidate Management</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/candidate/create') }}">Candidates</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover " id="candidates_list" style="width: 100%;">
							<thead>
								<tr>
									<th></th>
									<th>RefNo</th>
									<th>Badge ID</th>
									<th>Name</th>
									<th>Nationality</th>
									<th>Location</th>
									<th>Gender</th>
									<th>Salary</th>
									<th>Position Level</th>
									<th>Education Level</th>
									<th>Position Applied</th>
									<th>Status</th>
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