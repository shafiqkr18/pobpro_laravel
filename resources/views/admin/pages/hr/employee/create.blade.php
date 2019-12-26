@extends('admin.layouts.default')

@section('title')
	Create Employee
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.plan-position-placeholder {
	display: none;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$(document).on('click', '.add-position', function (e) {
		e.preventDefault();

		var $positionContents = $('.plan-position-placeholder').html();
		$('#positions').append($positionContents);
	});

	$(document).on('click', '.delete-position', function (e) {
		e.preventDefault();

		$(this).closest('.row').remove();
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
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/employees') }}">Employees</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/employees') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Create Employee
		</h2>
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
					<h5>Employee Details</h5>
				</div>

				<div class="ibox-content">
                    <form role="form" id="frm_employee" enctype="multipart/form-data">
                        @csrf
						<div class="form-row">
							<div class="col-md-4">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control form-control-sm" name="employee_name" id="employee_name">
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label>Email</label>
									<input type="text" class="form-control form-control-sm" name="email" id="email">
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Gender</label>
									<select name="gender" id="gender" class="form-control form-control-sm">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>

							<div class="col-md-2">
								<div class="form-group">
									<label>Age</label>
									<input type="text" class="form-control form-control-sm" name="age" id="age">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Mobile Number</label>
									<input type="text" class="form-control form-control-sm" name="mobile_number" id="mobile_number">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Phone Number</label>
									<input type="text" class="form-control form-control-sm" name="phone_number" id="phone_number">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Nationality</label>
                                    <select name="nationality" id="nationality" class="form-control form-control-sm" size>
                                        <option value="Chinese" selected>Chinese</option>
                                        <option value="Iraqi">Iraqi</option>
                                        <option value="Emirati">Emirati</option>
                                    </select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Passport Number</label>
									<input type="text" class="form-control form-control-sm" name="passport_no" id="passport_no">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-3">
								<div class="form-group">
									<label>Position</label>
									<select name="position_id" id="position_id" class="form-control form-control-sm" size>
										<option value=""></option>
										@foreach ($positions as $position)
										<option value="{{ $position->id }}">{{ $position->title }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Organization</label>
									<select name="org_id" id="org_id" class="form-control form-control-sm" size>
{{--										<option value=""></option>--}}
										@foreach ($organizations as $organization)
										<option value="{{ $organization->id }}">{{ $organization->org_title }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Division</label>
									<select name="div_id" id="div_id" class="form-control form-control-sm" size>
										<option value=""></option>
										@foreach ($divisions as $division)
										<option value="{{ $division->id }}">{{ $division->short_name }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Section</label>
									<select name="sec_id" id="sec_id" class="form-control form-control-sm" size>
										<option value=""></option>
										@foreach ($sections as $section)
										<option value="{{ $section->id }}">{{ $section->short_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Work Type</label>
											<select name="work_type" id="work_type" class="form-control form-control-sm" size>
                                                <option value="FT" selected="selected">Full Time</option>
                                                <option value="PT">Part Time</option>
                                                <option value="CO">Contract</option>
                                                <option value="TP">Temporary</option>
                                                <option value="OT">Other</option>
											</select>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Education Level</label>
											<select name="education_level" id="education_level" class="form-control form-control-sm" size>

                                                <option value="0">N/A</option>
                                                <option value="1">High-School / Secondary</option>
                                                <option value="2" selected="selected">Bachelors Degree</option>
                                                <option value="3">Masters Degree</option>
                                                <option value="4">PhD</option>
											</select>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Join Date</label>
											<div class="input-daterange input-group">
													<input type="text" class="form-control-sm form-control text-left" name="joining_date" id="joining_date" />
												</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Agreement Start Date</label>
											<div class="input-daterange input-group">
													<input type="text" class="form-control-sm form-control text-left" name="agreement_start_date" id="agreement_start_date" />
												</div>
										</div>
									</div>
								</div>

								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Termination Date</label>
											<div class="input-daterange input-group">
													<input type="text" class="form-control-sm form-control text-left" name="termination_date" id="termination_date" />
												</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Agreement End Date</label>
											<div class="input-daterange input-group">
													<input type="text" class="form-control-sm form-control text-left" name="agreement_end_date" id="agreement_end_date" />
												</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Avatar</label>
									<div class="custom-file">
										<input id="avatar" name="file" type="file" class="custom-file-input form-control-sm" multiple>
										<label for="avatar" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>

								<div class="form-group">
									<label>Notes</label>
									<textarea name="notes" id="notes" rows="4" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_employee" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection