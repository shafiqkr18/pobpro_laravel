@extends('employee_portal.layouts.inner')

@section('title')
Update Profile
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.skill small {
	cursor: pointer;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	// add skill
	$(document).on('click', '.btn-add', function (e) {
		e.preventDefault();

		var $input_area = $(this).next('div');

		if ($input_area.hasClass('hide')) {
			$input_area.removeClass('hide');
		}
	});

	// cancel skill add
	$(document).on('click', '.cancel-add', function (e) {
		e.preventDefault();

		var $input_area = $(this).closest('div');
		$input_area.addClass('hide');
	});

	// save skill
	$(document).on('click', '.save-skill', function (e) {
		e.preventDefault();

		var $input_area = $(this).closest('div'), 
				$skills_area = $(this).closest('.form-group').find('.form-control-static'),
				skill = $('[name="new_skill"]').val();

		$skills_area.append('<span class="skill border border-muted p-1 mr-2 mb-2">' + skill + ' <small class="fas fa-times text-danger font-weight-lighter remove-skill"></small></span>');

		$input_area.addClass('hide');
		$('[name="new_skill"]').val('');
	});

	// remove skill
	$(document).on('click', '.remove-skill', function (e) {
		e.preventDefault();

		$(this).closest('span').remove();
	});

	// change file name on file select
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});
});
</script>
@endsection

@section('content')
<div class="my-profile">
	<h2 class="section-title d-flex flex-nowrap align-items-center border-0">
		<span>My Profile <span class="sub d-block">Manage your personal details, contact information, language, country and timezone settings.</span></span>
	</h2>

	<div class="card mb-4">
		<div class="card-body pl-5 pr-5">
			<div class="row">

				<div class="col-md-2">
					@php $avatar = $employee && $employee->avatar ? json_decode($employee->avatar, true) : null; @endphp
					<img src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" class="img-fluid">
				</div>

				<div class="col-md-10">
					<div class="row">
						<div class="col-md-12">
							<h6 class="form-heading d-flex align-items-center">
								<img src="{{ URL::asset('employee_portal/img/user-icon.png') }}" class="img-fluid mr-2">
								Personal details
							</h6>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">First name:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="employee_name" value="{{ $employee ? $employee->employee_name : '' }}">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Last name:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="employee_last_name" value="{{ $employee ? $employee->employee_last_name : '' }}">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Email:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="email" value="{{ $employee ? $employee->email : '' }}">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Mobile No:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="mobile_number" value="{{ $employee ? $employee->mobile_number : '' }}">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Telephone No:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="phone_number" value="{{ $employee ? $employee->phone_number : '' }}">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Birthdate:</label>
								<div class="input-daterange input-group" id="datepicker">
									<i class="far fa-calendar text-blue mr-2 align-self-center"></i>
									<input type="text" class="form-control-sm form-control text-left" name="date_of_birth" value="{{ $candidate ? date('m/d/Y', strtotime($candidate->date_of_birth)) : '' }}" />
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Address line 1:</label>
								<input type="text" class="form-control form-control-sm rounded-0" value="ITforce technology">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Address line 2:</label>
								<input type="text" class="form-control form-control-sm rounded-0" value="HDS Towers">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">City:</label>
								<input type="text" class="form-control form-control-sm rounded-0" value="Dubai">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Country:</label>
								<input type="text" class="form-control form-control-sm rounded-0" value="UAE">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Gender:</label>
								<div class="d-flex align-items-center">
									<input type="radio" id="gender_male" name="gender" class="form-control mr-2" value="Male" {{ $employee->gender == 'Male' ? 'checked' : '' }}> <label for="gender_male">Male</label>
									<input type="radio" id="gender_female" name="gender" class="form-control mr-2 ml-4" value="Female" {{ $employee->gender == 'Female' ? 'checked' : '' }}> <label for="gender_female">Female</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="font-weight-bold">About yourself:</label>
								<textarea name="notes" id="" rows="5" class="form-control rounded-0">{!! $employee->notes !!}</textarea>
							</div>
						</div>
					</div>

					<hr class="pb-4">

					<div class="row">
						<div class="col-md-12">
							<h6 class="form-heading d-flex align-items-center">
								<img src="{{ URL::asset('employee_portal/img/icon-education.png') }}" class="img-fluid mr-2">
								Education
							</h6>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Highest Education:</label>
								<input type="text" class="form-control form-control-sm rounded-0 w-100" name="education_level" value="{{ $employee->educationLevel ? $employee->educationLevel->title : '' }}">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Major:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="major" value="{{ $candidate ? $candidate->major : '' }}">
							</div>
						</div>
					</div>

					<hr class="pb-4">

					<div class="row">
						<div class="col-md-12">
							<h6 class="form-heading d-flex align-items-center">
								<img src="{{ URL::asset('employee_portal/img/icon-experience.png') }}" class="img-fluid mr-2">
								Experience
							</h6>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Work Experience:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="work_experience" value="{{ $candidate ? $candidate->work_experience : '' }}">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Certification:</label>
								<input type="text" class="form-control form-control-sm rounded-0" name="certifications" value="{{ $candidate ? $candidate->certifications : '' }}">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold align-self-start mt-1">Skills:</label>
								<p class="form-control-static m-0 d-flex flex-wrap">
									<span class="skill border border-muted p-1 mr-2 mb-2">Management <small class="fas fa-times text-danger font-weight-lighter remove-skill"></small></span>
									<span class="skill border border-muted p-1 mr-2 mb-2">Marketing <small class="fas fa-times text-danger font-weight-lighter remove-skill"></small></span>
								</p>
								<a href="" class="btn btn-sm text-blue w-100 d-flex btn-add">
									<small class="ml-auto">
										<small class="fas fa-plus mr-1"></small> Add skill
									</small>
								</a>
								<div class="w-100 text-right hide">
									<input type="text" name="new_skill" class="form-control form-control-sm w-100 rounded-0" placeholder="Add skill">
									<a href="" class="text-muted mr-2 cancel-add"><small>Cancel</small></a>
									<a href="" class="text-blue save-skill"><small>Add</small></a>
								</div>
							</div>
						</div>
					</div>

					<hr class="pb-4">

					<div class="row">
						<div class="col-md-12">
							<h6 class="form-heading d-flex align-items-center">
								<img src="{{ URL::asset('employee_portal/img/icon-documents.png') }}" class="img-fluid mr-2">
								Documents
							</h6>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3">
							<div class="bg-light p-2">
								<img src="{{ URL::asset('employee_portal/img/doc1.png') }}" class="img-fluid mr-2">
							</div>

							<div class="dropdown">
								<a class="btn btn-white mt-1 dropdown-toggle btn-sm text-left text-main font-weight-bold" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Passport
								</a>

								<div class="dropdown-menu pt-0 pb-0" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item pl-3 pr-3" href="#" data-toggle="modal" data-target="#document_modal"><i class="fas fa-times text-white mr-1"></i> Replace</a>
									<a class="dropdown-item pl-3 pr-3" href="#"><i class="fas fa-times text-danger mr-1"></i> Remove</a>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="bg-light p-2">
								<img src="{{ URL::asset('employee_portal/img/doc3.png') }}" class="img-fluid mr-2">
							</div>
							
							<div class="dropdown">
								<a class="btn btn-white mt-1 dropdown-toggle btn-sm text-left text-main font-weight-bold" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Education Certificate
								</a>

								<div class="dropdown-menu pt-0 pb-0" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item pl-3 pr-3" href="#" data-toggle="modal" data-target="#document_modal"><i class="fas fa-times text-white mr-1"></i> Replace</a>
									<a class="dropdown-item pl-3 pr-3" href="#"><i class="fas fa-times text-danger mr-1"></i> Remove</a>
								</div>
							</div>
						</div>

						<div class="col-md-3">
							<div class="bg-light p-2">
								<img src="{{ URL::asset('employee_portal/img/doc2.png') }}" class="img-fluid mr-2">
							</div>
							
							<div class="dropdown">
								<a class="btn btn-white mt-1 dropdown-toggle btn-sm text-left text-main font-weight-bold" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Certificate
								</a>

								<div class="dropdown-menu pt-0 pb-0" aria-labelledby="dropdownMenuLink">
									<a class="dropdown-item pl-3 pr-3" href="#" data-toggle="modal" data-target="#document_modal"><i class="fas fa-times text-white mr-1"></i> Replace</a>
									<a class="dropdown-item pl-3 pr-3" href="#"><i class="fas fa-times text-danger mr-1"></i> Remove</a>
								</div>
							</div>
						</div>

						<div class="col-md-3 d-flex flex-column">
							<a href="" class="bg-light d-flex flex-fill flex-column align-items-center text-blue justify-content-center"  data-toggle="modal" data-target="#document_modal">
								<i class="fas fa-plus d-block"></i>
								<span>Add new</span>
							</a>
							<label class="font-weight-bold d-block mt-2">&nbsp;</label>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>

	<div class="d-flex align-items-center mt-4 mb-5">
		<a href="" class="btn btn-sm text-secondary pr-4 pl-4 ml-auto">Cancel</a>
		<a href="" class="btn btn-sm btn-primary pr-4 pl-4 ml-3">Save</a>
	</div>
</div>

<div class="modal fade" id="document_modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header p-3">
				<h6 class="text-blue m-0 w-100 d-flex align-items-center flex-nowrap">
					Add new document

					<a href="" class="ml-auto" data-dismiss="modal" aria-label="Close">
						<i class="fas fa-times text-muted"></i>
					</a>
				</h6>
			</div>
			
      <div class="modal-body">
				<div class="form-group form-inline mb-2">
					<label>File</label>

					<div class="custom-file">
						<input type="file" name="new_document" class="custom-file-input rounded-0" id="customFile">
						<label class="custom-file-label form-control form-control-sm rounded-0" for="customFile">Choose file</label>
					</div>
				</div>

				<div class="form-group form-inline">
					<label>File name</label>
					<input type="text" class="form-control form-control-sm rounded-0">
				</div>
			</div>
			
      <div class="modal-footer pt-2 pb-2">
        <button type="button" class="btn btn-sm btn-light mt-1 mb-1" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-sm btn-primary mt-1 mb-1">Add document</button>
      </div>
    </div>
  </div>
</div>
@endsection