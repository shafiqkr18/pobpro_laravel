@extends('admin.layouts.default')

@section('title')
	Update Position
@endsection

@section('styles')
<link href="{{ URL::asset('css/new-pages.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

input[type="checkbox"] {
	position: absolute;
	opacity: 0;
}

input[type="checkbox"] + label {
	position: relative;
	cursor: pointer;
	padding: 0;
}

input[type="checkbox"] + label:before {
	content: '';
	margin-right: 10px;
	display: inline-block;
	vertical-align: text-top;
	width: 20px;
	height: 20px;
	background: white;
	border: 1px solid #e7eaec;
}

input[type="checkbox"]:checked + label:before {
	background: #18a689;
	border-color: #18a689;
}

input[type="checkbox"]:checked + label:after {
	content: '\f00c';
	font: normal normal normal 11px/1 FontAwesome;
	position: absolute;
	left: 5px;
	top: 5px;
	color: #fff;
}

.hide {
	display: none !important;
}

input[type="checkbox"].checkbox-switch {
	height: 0;
	width: 0;
	visibility: hidden;
}

input[type="checkbox"].checkbox-switch + label {
	cursor: pointer;
	text-indent: -9999px;
	width: 33px;
	height: 20px;
	background: #d6d6d6;
	display: block;
	border-radius: 20px;
	position: relative;
}

input[type="checkbox"].checkbox-switch + label:after {
	content: '';
	position: absolute;
	top: 2px;
	left: 2px;
	width: 16px;
	height: 16px;
	background: #fff;
	border-radius: 16px;
	transition: 0.3s;
}

input[type="checkbox"].checkbox-switch:checked + label {
	background: #18a689;
}

input[type="checkbox"].checkbox-switch:checked + label:after {
	left: calc(100% - 2px);
	transform: translateX(-100%);
}

input[type="checkbox"].checkbox-switch + label:active:after {
	width: 33px;
}
</style>
@endsection

@section('scripts')
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<!-- <script src="{{ URL::asset('js/operations/create_forms.js') }}"></script> -->
<script>
$(document).ready(function(){
    $('[name="create_vacancy"]').prop('checked', true);
    $('.vacancy-wrapper').removeClass('hide');
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$(document).on('change', '[name="create_vacancy"]', function (e) {
		if (this.checked) {
			$('.vacancy-wrapper').removeClass('hide');
		}
		else {
			$('.vacancy-wrapper').addClass('hide');
		}
	});

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$(document).on('change', '.qty1', function() {
		var sum = 0;
		$('.qty1').each(function(){
			sum += +$(this).val();
		});
		$('.total_all').val(sum);
	});

	$("#save_position").click(function(e) {
		e.preventDefault();

		$(".validation_error").hide();
		//let queryString =  $("#frm_contract").serialize();
		let formData = new FormData($('#frm_position')[0]);
		$.ajax({
				/* the route pointing to the post function */
				url: baseUrl + '/admin/save_position',
				type: 'POST',
				dataType: "JSON",
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
						if(data.success == false) {
								if(data.errors)
								{
										toastr.warning("Fill the required fields!");
										jQuery.each(data.errors, function( key, value ) {
												$('#'+key).closest('.form-group').addClass('has-error');

										});

								}else{
										//Show toastr message
										toastr.error("Error Saving Data");
								}
						}else{
								toastr.success("Position Saved Successfully! ");
								$('#myPositions').modal('toggle');
										window.location.href = baseUrl + '/admin/position-management';
								// setTimeout(function(){
								//     window.location.href = baseUrl+'/admin/organization-plan';
								// },3000);

						}

				}
		});
});
});
</script>
@endsection

@php
$position = $data['position'];
$departments = $data['departments'];
$sections = $data['sections'];
$file = $data['vacancy'] && $data['vacancy']->attachments ? json_decode($data['vacancy']->attachments, true) : null;
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item text-muted">
				Planning
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/position-management') }}">Position Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/position-management') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $position->reference_no }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<form role="form" id="frm_position" enctype="multipart/form-data">
				<input type="hidden" name="is_update" id="is_update" value="{{$data['is_update'] ? true : false}}">
				<input type="hidden" name="listing_id" value="{{ $data['is_update'] ? $position->id : '' }}">
				<input type="hidden" name="vacancy_id" value="{{ $data['vacancy'] ? $data['vacancy']->id : null }}">

				<div class="ibox ">
					<div class="ibox-title indented">
						<h5>Position Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>RefNo</label>
									<input type="text" class="form-control form-control-sm" id="reference_no" name="reference_no" value="{{ $position->reference_no }}" readonly>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Lock</label>
									<div class="d-flex align-items-center justify-content-end">
										<input type="checkbox" class="checkbox-switch" id="is_lock" name="is_lock" {{ $position->is_lock ? 'checked' : '' }} />
										<label for="is_lock"></label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Department</label>
									<select name="department_id" id="department_id" class="form-control form-control-sm b-r-xs">
										@foreach($departments as $key => $val)
										<option value="{{ $val->id}}" {{ $position->department_id == $val->id ? 'selected' : '' }}>{{$val->department_name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
									<div class="form-group form-inline">
											<label>Section</label>
											<select name="section_id" id="section_id" class="form-control form-control-sm b-r-xs">
													@foreach($sections as $key => $val)
															<option value="{{ $val->id}}" {{ $position->section_id == $val->id ? 'selected' : '' }}>{{$val->short_name}}</option>
													@endforeach
											</select>
									</div>
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Position Name</label>
									<input type="text" class="form-control form-control-sm" id="title" name="title" value="{{ $position->title }}" {{ $position->is_lock ? 'readonly' : '' }}>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline mb-0">
									<label>Location</label>
									<input type="text" class="form-control form-control-sm" id="location" name="location" value="{{ $position->location }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline mb-0">
									<small>Head Count:</small>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Local</label>
									<input type="text" class="form-control form-control-sm qty1" id="local_positions" name="local_positions" value="{{ $position->local_positions }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Expat</label>
									<input type="text" class="form-control form-control-sm qty1" id="expat_positions" name="expat_positions" value="{{ $position->expat_positions }}">
								</div>
							</div>
						</div>

						<div class="row mb-3">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline mb-0">
									<label> Total Positions </label>
									<input type="number" class="form-control form-control-sm total_all" id="total_positions" name="total_positions" value="{{ $position->total_positions }}" readonly>
								</div>
							</div>

							<div class="col-sm-6">
								
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-inline">
									<label class="align-self-start">Remarks</label>
									<textarea name="notes" id="notes" rows="6" class="form-control">{{ $position->job_description }}</textarea>
								</div>
							</div>
						</div>

					</div>

				</div>

				<div class="ibox">
					<div class="ibox-title">
						<h5>Vacancy</h5>
					</div>

					<div class="ibox-content mb-3">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<input name="create_vacancy" type="checkbox" id="create_vacancy" {{ $data['vacancy'] != NULL ? 'checked' : '' }}>
									<label for="create_vacancy" class="">Create Vacancy</label>
								</div>
							</div>
						</div>

						<div class="vacancy-wrapper {{ $data['vacancy'] != NULL ? '' : 'hide' }}">
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Job RefNo</label>
										<input type="text" class="form-control form-control-sm" id="job_ref_no" name="job_ref_no" value="{{ $data['vacancy'] ? $data['vacancy']->job_ref_no : 'J' . date('ymdHis') }}" readonly>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label>Job Title</label>
										<input type="text" class="form-control form-control-sm" id="job_title" name="job_title" value="{{ $data['vacancy'] ? $data['vacancy']->job_title : $position->title }}">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Gender</label>
										<select name="gender" id="gender" class="form-control form-control-sm" size>
											<option value="Male" {{ $data['vacancy'] && $data['vacancy']->gender && $data['vacancy']->gender == 'Both' ? 'selected' : '' }}>Both</option>
											<option value="Female" {{ $data['vacancy'] && $data['vacancy']->gender && $data['vacancy']->gender == 'Female' ? 'selected' : '' }}>Female</option>
											<option value="Male" {{ $data['vacancy'] && $data['vacancy']->gender && $data['vacancy']->gender == 'Male' ? 'selected' : '' }}>Male</option>
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label>Nationality</label>
										<input type="text" class="form-control form-control-sm" id="nationality" name="nationality" value="{{ $data['vacancy'] ? $data['vacancy']->nationality : '' }}">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Age</label>
										<select name="age" id="age" class="form-control form-control-sm">
											@foreach ($data['ages'] as $age)
											<option value="{{ $age->id }}" {{ $data['vacancy'] && $data['vacancy']->ageRange && $data['vacancy']->ageRange->age == $age->id ? 'selected' : '' }}>{{ $age->age }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label>Work Type</label>
										<select name="work_type" id="work_type" class="form-control form-control-sm" size>
											@foreach ($data['work_types'] as $work_type)
											<option value="{{ $work_type->id }}" {{ $data['vacancy'] && $data['vacancy']->work_type && $data['vacancy']->work_type == $work_type->id ? 'selected' : '' }}>{{ $work_type->full_name }}</option>
											@endforeach
										</select>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Education Level</label>
										<select name="education_level" id="education_level" class="form-control form-control-sm" size>
											@foreach ($data['education_levels'] as $education_level)
											<option value="{{ $education_level->id }}" {{ $data['vacancy'] && $data['vacancy']->education_level && $data['vacancy']->education_level == $education_level->id ? 'selected' : '' }}>{{ $education_level->title	 }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label>Salary (USD)</label>
										<input type="number" class="form-control form-control-sm" id="salary" name="salary" value="{{ $data['vacancy'] ? $data['vacancy']->salary : '' }}">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Report to</label>
										<select name="report_to" id="report_to" class="form-control form-control-sm" size>
											<option value=""></option>
											@if ($data['dept_positions'])
												@foreach ($data['dept_positions'] as $pos)
												<option value="{{ $pos->id }}" {{ $data['vacancy'] && $data['vacancy']->report_to == $pos->id ? 'selected' : '' }}>{{ $pos->title }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>

							<div class="row mb-3">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline mb-0">
										<label>Rotation Pattern</label>
										<select name="rotation_pattern" id="rotation_pattern" class="form-control form-control-sm" size>
											@if ($data['rotation_types'])
												@foreach ($data['rotation_types'] as $type)
												<option value="{{ $type->id }}" {{ $data['vacancy'] && $data['vacancy']->rotation_pattern && $data['vacancy']->rotation_pattern == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="align-self-start">Job Purpose</label>
										<textarea name="job_purpose" id="job_purpose" class="form-control" rows="5">{{ $data['vacancy'] ? $data['vacancy']->job_purpose : '' }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="align-self-start">Duties and Responsibilities</label>
										<textarea name="duty_responsibility" id="duty_responsibility" class="form-control" rows="5">{{ $data['vacancy'] ? $data['vacancy']->duty_responsibility : '' }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="align-self-start">Certifications &amp; Training</label>
										<textarea name="certifications" id="certifications" class="form-control" rows="5">{{ $data['vacancy'] ? $data['vacancy']->certifications : '' }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="align-self-start">Experience</label>
										<textarea name="experience_details" id="experience_details" class="form-control" rows="5">{{ $data['vacancy'] ? $data['vacancy']->experience_details : '' }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="align-self-start">Language proficiency, computer and software skills</label>
										<textarea name="skills" id="skills" class="form-control" rows="5">{{ $data['vacancy'] ? $data['vacancy']->skills : '' }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="align-self-start">Others</label>
										<textarea name="others" id="others" class="form-control" rows="5">{{ $data['vacancy'] ? $data['vacancy']->others : '' }}</textarea>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Attachment</label>
										<div class="custom-file">
											<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
											<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">{{ $file ? 'Update file' : 'Choose file...' }}</label>
											@if ($file)
											<a href="{{ asset('/storage/' . $file[0]['download_link']) }}" target="_blank" class="d-inline-block text-success font-weight-bold mt-2">{{ $file[0]['original_name'] }}</a>
											@endif
										</div>
									</div>
								</div>
							</div>

						</div>

					</div>
				</div>

				<div class="row">
					<div class="col-sm-12">
						<a href="javascript:void(0)" id="save_position" class="btn btn-success btn-sm pull-right">Save</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection