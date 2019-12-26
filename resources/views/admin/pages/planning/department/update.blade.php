@extends('admin.layouts.default')

@section('title')
	Update Department
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
	<div class="col-lg-10">
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
			<li class="breadcrumb-item">
				Update
			</li>
		</ol>
		<h2 class="d-flex align-items-center">{{ $department->department_short_name }}</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
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
						<input type="hidden" name="is_update" id="is_update" value="{{ $is_update ? true : false }}">
						<input type="hidden" name="listing_id" value="{{ $is_update ? $department->id : '' }}">
						
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group form-inline">
									<label>Department Code</label>
									<input type="text" class="form-control form-control-sm" id="dept_code" name="dept_code" value="{{ $department->dept_code }}">
								</div>

								<div class="form-group form-inline">
									<label>Organization </label>
									<select name="org_id" id="org_id" class="form-control form-control-sm b-r-xs">
										<option value="">Select Organization</option>
										@foreach($organizations as $key => $val)
											<option value="{{ $val->id }}" {{ $department->org_id == $val->id ? 'selected' : '' }}>{{ $val->org_title }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group form-inline">
									<label>Division </label>
									<select name="div_id" id="div_id" class="form-control form-control-sm b-r-xs">
										<option value="">Select Division</option>
										@foreach($divisions as $key => $val)
											<option value="{{ $val->id }}" {{ $department->div_id == $val->id ? 'selected' : '' }}>{{ $val->short_name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Short Name</label>
									<input type="text" class="form-control form-control-sm" id="short_name" name="short_name" value="{{ $department->department_short_name }}">
								</div>

								<div class="form-group form-inline">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name" value="{{ $department->department_name }}">
								</div>
							</div>
						</div>

					</form>
					
				</div>

			</div>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-12">
			<a href="javascript:void(0)" id="save_dept" class="btn btn-success btn-sm pull-right">Save</a>
		</div>
	</div>
</div>
@endsection