@extends('admin.layouts.default')

@section('title')
	View Department
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}
</style>
@endsection

@section('scripts')
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script src="{{ URL::asset('js/operations/dropdowns.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
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
				Settings
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/department-management') }}">Department Management</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			{{ $department->department_name }}
			<a href="{{ url('admin/department-management/update/' . $department->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/department-management/delete/' . $department->id) }}">
				<i class="far fa-trash-alt mr-1"></i>
				Delete
			</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Department Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_dept" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Department Code</label>
									<p class="form-control-static font-weight-bold">{{ $department->dept_code ? $department->dept_code : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Organization </label>
									<p class="form-control-static font-weight-bold">{{ $department->div_id ? $department->division->organization->org_title : '-' }}</p>
								</div>
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Division </label>
									<p class="form-control-static font-weight-bold">{{ $department->division ? $department->division->short_name : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Short Name</label>
									<p class="form-control-static font-weight-bold">{{ $department->department_short_name ? $department->department_short_name : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Full Name</label>
									<p class="form-control-static font-weight-bold">{{ $department->department_name ? $department->department_name : '-' }}</p>
								</div>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection