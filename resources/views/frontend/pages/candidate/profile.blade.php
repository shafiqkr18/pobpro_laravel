@extends('frontend.layouts.candidate')

@section('title')
	My Profile
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

@php
$documents = $candidate->resume ? json_decode($candidate->resume, true) : [];
@endphp

@section('content')
<div class="card candidate">
	<h6 class="card-header pt-2 pb-2 pl-0">
		My Profile
	</h6>

	<div class="card-body">
		<form action="{{ url('candidate/save-profile') }}" class="form-stripes mt-3">
			@csrf
			<input type="hidden" name="uuid" value="{{ $candidate->user_uuid }}">

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>First Name:</label>
						<input type="text" id="name" name="name" class="form-control form-control-sm" value="{{ $candidate->name ? $candidate->name : '' }}" disabled>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Last Name:</label>
						<input type="text" id="last_name" name="last_name" class="form-control form-control-sm" value="{{ $candidate->last_name }}" disabled>
					</div>
				</div>
			</div>

			<div class="row">
				<!-- <div class="col-md-6">
					<div class="form-group">
						<label>User ID:</label>
						<input type="text" id="user_id" name="user_id" class="form-control form-control-sm rounded-0 border-0" value="" disabled>
					</div>
				</div> -->

				<div class="col-md-6">
					<div class="form-group">
						<label>Email:</label>
						<input type="email" id="email" name="email" class="form-control form-control-sm" value="{{ $candidate->email ? $candidate->email : '' }}" disabled>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Mobile No:</label>
						<input type="text" id="phone" name="phone" class="form-control form-control-sm" value="{{ $candidate->phone ? $candidate->phone : '' }}" disabled>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Telephone:</label>
						<input type="text" id="telephone" name="telephone" class="form-control form-control-sm" value="{{ $candidate->phone ? $candidate->phone : '' }}" disabled>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Birthdate:</label>
						<div class="input-daterange input-group border-0 w-100" id="datepicker">
							<input type="text" id="date_of_birth" name="date_of_birth" class="form-control-sm form-control bg-none text-left" value="{{ $candidate->date_of_birth }}" disabled />
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Gender:</label>
						<select name="gender" id="gender" class="form-control form-control-sm" disabled>
							<option value=""></option>
							<option value="Male" {{ $candidate->gender == 'Male' ? 'selected' : '' }}>Male</option>
							<option value="Female" {{ $candidate->gender == 'Female' ? 'selected' : '' }}>Female</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Highest Education:</label>
						<select name="education_level" id="education_level" class="form-control form-control-sm" disabled>
							<option value=""></option>
							<option value="3" {{ $candidate->education_level == 3 ? 'selected' : '' }}>Master's Degree</option>
							<option value="2" {{ $candidate->education_level == 2 ? 'selected' : '' }}>Bachelor's Degree</option>
							<option value="1" {{ $candidate->education_level == 1 ? 'selected' : '' }}>High School</option>
						</select>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Major:</label>
						<input type="text" id="major" name="major" class="form-control form-control-sm" value="{{ $candidate->major }}" disabled>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Address:</label>
						<input type="text" id="location" name="location" class="form-control form-control-sm" value="{{ $candidate->location }}" disabled>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Self Introduce:</label>
						<textarea name="introduction" id="introduction" rows="3" class="form-control" disabled>{{ $candidate->introduction }}</textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Work Experience:</label>
						<textarea name="work_experience" id="work_experience" rows="3" class="form-control" disabled>{{ $candidate->work_experience }}</textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Certification:</label>
						<textarea name="certifications" id="certifications" rows="3" class="form-control" disabled>{{ $candidate->certifications }}</textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label>Skills:</label>
						<textarea name="skills" id="skills" rows="3" class="form-control" disabled></textarea>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div class="form-group mb-0 mt-3">
						<label class="justify-content-start text-dark font-weight-bold">My Documents:</label>
						<!-- <input type="text" class="form-control form-control-sm" style="opacity: 0; z-index: -1" disabled> -->
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="pr-2 justify-content-end align-self-start pt-2">Passport:</label>
						<div class="flex-75">
							<div class="custom-file">
								<input id="logo" name="file[]" type="file" class="custom-file-input form-control-sm" disabled>
								<label for="logo" class="custom-file-label b-r-xs form-control-sm justify-content-start">{{ count($documents) == 1 ? $documents[0]['original_name'] : 'Choose file...' }}</label>
							</div>
						</div>
					</div>
				</div>
			
				<div class="col-md-6">
					<div class="form-group">
						<label class="pr-2 justify-content-end align-self-start pt-2">Education Certificate:</label>
						<div class="flex-75">
							<div class="custom-file">
								<input id="logo" name="file[]" type="file" class="custom-file-input form-control-sm" disabled>
								<label for="logo" class="custom-file-label b-r-xs form-control-sm justify-content-start">{{ count($documents) == 2 ? $documents[1]['original_name'] : 'Choose file...' }}</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="pr-2 justify-content-end align-self-start pt-2">Photo:</label>
						<div class="flex-75">
							<div class="custom-file">
								<input id="logo" name="file[]" type="file" class="custom-file-input form-control-sm" disabled>
								<label for="logo" class="custom-file-label b-r-xs form-control-sm justify-content-start">{{ count($documents) == 3 ? $documents[2]['original_name'] : 'Choose file...' }}</label>
							</div>
						</div>
					</div>
				</div>
			
				<div class="col-md-6">
					<div class="form-group">
						<label class="pr-2 justify-content-end align-self-start pt-2">NOC:</label>
						<div class="flex-75">
							<div class="custom-file">
								<input id="logo" name="file[]" type="file" class="custom-file-input form-control-sm" disabled>
								<label for="logo" class="custom-file-label b-r-xs form-control-sm justify-content-start">{{ count($documents) == 4 ? $documents[3]['original_name'] : 'Choose file...' }}</label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 mt-3 p-2">
					<a href="" class="btn btn-sm btn-info rounded font-weight-bold float-right edit-profile">Edit</a>
					<a href="" class="btn btn-sm btn-info rounded font-weight-bold float-right save-profile">Update</a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection