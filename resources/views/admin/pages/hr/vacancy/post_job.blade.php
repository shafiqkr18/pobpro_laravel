@extends('admin.layouts.default')

@section('title')
	 Job Details
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
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Job Details</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Planning
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/contract-management') }}">Job Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Job Details</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Job Details</h5>
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
					<form role="form" id="frm_post_job" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-sm-4 b-r">

								<div class="form-group">
									<label>Job RefNo.</label>
									<input type="text" class="form-control form-control-sm" value="{{ $data['job_no'] }}" id="job_ref_no" name="job_ref_no">
								</div>

								<div class="form-group">
									<label>Job Title</label>
									<input type="text" class="form-control form-control-sm" value="" id="job_title" name="job_title">
								</div>
								<div class="form-group">
									<label> Work Type</label>
									<select name="work_type" id="work_type" class="form-control form-control-sm" size>
										<option value="FT" selected="selected">Full Time</option>
										<option value="PT">Part Time</option>
										<option value="CO">Contract</option>
										<option value="TP">Temporary</option>
										<option value="OT">Other</option>
									</select>
								</div>
								<div class="form-group">
									<label> Education Level</label>
									<select name="education_level" id="education_level" class="form-control form-control-sm" size>

										<option value="0">N/A</option>
										<option value="1">High-School / Secondary</option>
										<option value="2" selected="selected">Bachelors Degree</option>
										<option value="3">Masters Degree</option>
										<option value="4">PhD</option>
									</select>
								</div>
							</div>

							<div class="col-sm-4 b-r">
								<div class="form-group">
									<label>Nationality</label>
									<select name="nationality" id="nationality" class="form-control form-control-sm" size>
										<option value="Chinese" selected>Chinese</option>
										<option value="Iraqi">Iraqi</option>
										<option value="Emirati">Emirati</option>
									</select>
								</div>

								<div class="form-group">
									<label> Job Location</label>
									<select name="location" id="location" class="form-control form-control-sm" size>
										<option value="Dubai" selected>Dubai</option>
										<option value="China">China</option>
										<option value="Iraq">Iraq</option>
									</select>

								</div>
								<div class="form-group">
									<label>Gender</label>
									<select name="gender" id="gender" class="form-control form-control-sm" size>
										<option value="Male" selected>Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
								<div class="form-group">
									<label>Age</label>
									<input type="number" class="form-control form-control-sm" id="age" name="age">
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label>Salary</label>

									<input type="text" class="form-control form-control-sm" id="salary" name="salary">
								</div>

								<div class="form-group">
									<label>Job Description</label>
									<textarea name="job_description" id="job_description" rows="8" class="form-control"></textarea>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-md-12">

								<input type="hidden" name="position_id" value="{{$data['position_id']}}">
								<a href="javascript:void(0)" id="save_job" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection