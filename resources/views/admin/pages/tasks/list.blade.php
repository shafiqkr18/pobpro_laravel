@extends('admin.layouts.default')

@section('title')
	Tasks
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<style>
table.dataTable {
	table-layout: fixed;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Tasks</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Tasks</h5>
				</div>

				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-bordered" id="tasks_list" style="width: 99.5%;">
							<thead>
								<tr>
									<th style="width: 70%">Title</th>
									<!-- <th>Contents</th> -->
									<!-- <th>Type</th> -->
									<th>Status</th>
									<!-- <th>Start Date</th> -->
									<th>Due Date</th>
									<!-- <th>Company</th> -->
									<th style="max-width: 70px;"></th>
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