@extends('admin.layouts.default')

@section('title')
	Passport Management
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
				<a>Passport Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>List</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Passport Management</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/candidate/create') }}">Passports</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover " id="passport_list" style="width: 100%">
							<thead>
								<tr>
									<th>Passport No.</th>
									<th>User</th>
									<th style="width: 80px;">Is Primary</th>
									<th>Issue Date</th>
									<th>Expiry Date</th>
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