@extends('frontend.layouts.candidate')

@section('title')
	Vacancy Detail
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

.dashboard-content .candidate .save-profile {
	display: block !important;
}

.custom-file,
.custom-file-input {
	width: auto;
	height: 29px;
	cursor: pointer;
}

.custom-file-label::after {
	display: none;
}

.custom-file-label {
	background-color: #17a2b8;
	color: #fff !important;
	border: 0;
	display: flex;
	align-items: center;
	justify-content: center !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});
});
</script>
@endsection

@section('content')
<div class="card candidate">
	<h6 class="card-header pt-2 pb-2">
		<span class="font-weight-normal">Apply job position:</span> {{ $vacancy->position->title }}
	</h6>

	<div class="card-body">
		<form action="{{ url('candidate/save-profile') }}" class="form-stripes">
			@csrf
			<input type="hidden" name="is_online" value="1">
			<input type="hidden" value="{{ $vacancy->position_id }}" name="position_id">
			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">First Name:</label>
						<input type="text" id="name" name="name" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Last Name:</label>
						<input type="text" id="last_name" name="last_name" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0">
					</div>
				</div>
			</div>

			<div class="form-row">
				<!-- <div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">User ID:</label>
						<input type="text" id="user_id" name="user_id" class="form-control form-control-sm rounded-0 border-0">
					</div>
				</div> -->

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Email:</label>
						<input type="email" id="email" name="email" class="form-control form-control-sm rounded-0 border-0" >
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Mobile No:</label>
						<input type="text" id="phone" name="phone" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Telephone:</label>
						<input type="text" id="telephone" name="telephone" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0">
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Birthdate:</label>
						<div class="input-daterange input-group border-0 w-50" id="datepicker">
							<input type="text" id="birthdate" name="birthdate" class="form-control-sm form-control rounded-0 border-0 bg-none text-left" />
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Gender:</label>
						<select name="gender" id="gender" class="form-control form-control-sm border-0" >
							<option value=""></option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
						</select>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Highest Education:</label>
						<select name="education_level" id="education_level" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0" >
							<option value="" selected></option>
							<option value="3">Master's Degree</option>
							<option value="2">Bachelor's Degree</option>
							<option value="1">High School</option>
						</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Major:</label>
						<input type="text" id="major" name="major" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0">
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Address:</label>
						<input type="text" id="address" name="address" class="form-control form-control-sm rounded-0 border-0">
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Self Introduce:</label>
						<textarea name="self_introduce" id="self_introduce" rows="3" class="form-control rounded-0 border-top-0 border-bottom-0" ></textarea>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Work Experience:</label>
						<textarea name="work_experience" id="work_experience" rows="3" class="form-control rounded-0 border-0"></textarea>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Certification:</label>
						<textarea name="certification" id="certification" rows="2" class="form-control rounded-0 border-top-0 border-bottom-0"></textarea>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Skills:</label>
						<textarea name="skills" id="skills" rows="2" class="form-control rounded-0 border-0"></textarea>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12 p-2 d-flex justify-content-end">
					<!-- <a href="" class="btn btn-sm btn-info float-right edit-profile">Attach</a> -->
					<div class="custom-file">
						<input id="file" name="file" type="file" class="custom-file-input form-control-sm">
						<label for="logo" class="custom-file-label b-r-xs form-control-sm rounded-0 justify-content-start btn btn-sm btn-info">Attach Original CV</label>
					</div>
					<a href="" class="btn btn-sm btn-primary float-right save-profile ml-3">Apply</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection