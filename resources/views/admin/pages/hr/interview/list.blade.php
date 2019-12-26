@extends('admin.layouts.default')

@section('title')
	Interviews
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
table.dataTable thead > tr > th.sorting_asc {
	padding-right: 8px !important;
	width: 14px !important;
}

table.dataTable thead > tr > th.sorting_asc:after {
	display: none;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(11,99)}}"></script>
<script>
$(document).ready(function () {

	$('.select_all').on('click', function(e) {
		$('input[name="row_id"]').prop('checked', $(this).prop('checked'));
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
				<a href="javascript:void(0);">HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Interviews</strong>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">Interviews</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/hr-plan/create') }}">Scheduled Interviews</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="interview_list" style="width: 100%">
							<thead>
								<tr>
									<th><input type="checkbox" class="select_all"></th>
									<th>Batch No.</th>
									<th>Name</th>
									<th>Interview Date</th>
									<th>Position</th>
									<th>Plan</th>
									<th>Status</th>
                                    <th>Qualified</th>
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