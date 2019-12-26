@extends('employee_portal.layouts.inner')

@section('title')
My Profile
@endsection

@section('content')
<div class="my-profile">
	<h2 class="section-title d-flex flex-nowrap align-items-center border-0">
		<span>My Profile <span class="sub d-block">Manage your personal details, contact information, language, country and timezone settings.</span></span>

		<a href="{{ url('employee-portal/my-profile/update') }}" class="btn btn-primary ml-auto">Edit</a>
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
								<p class="form-control-static m-0">{{ $employee ? $employee->employee_name : '' }}</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Last name:</label>
								<p class="form-control-static m-0">{{ $employee ? $employee->employee_last_name : '' }}</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Email:</label>
								<p class="form-control-static m-0">{{ $employee ? $employee->email : '' }}</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Mobile No:</label>
								<p class="form-control-static m-0">{{ $employee ? $employee->mobile_number : '' }}</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Telephone No:</label>
								<p class="form-control-static m-0">{{ $employee ? $employee->phone_number : '' }}</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Birthdate:</label>
								<p class="form-control-static m-0"><i class="far fa-calendar text-blue mr-2"></i> {{ $candidate ? date('m/d/Y', strtotime($candidate->date_of_birth)) : '' }}</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Address line 1:</label>
								<p class="form-control-static m-0">ITforce technology</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Address line 2:</label>
								<p class="form-control-static m-0">HDS Towers</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">City:</label>
								<p class="form-control-static m-0">Dubai</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Country:</label>
								<p class="form-control-static m-0">UAE</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Gender:</label>
								<p class="form-control-static m-0">{{ $employee ? $employee->gender : '' }}</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label class="font-weight-bold">About yourself:</label>
								<p class="form-control-static m-0">{{ $employee ? $employee->notes : '' }}</p>
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
								<p class="form-control-static m-0">{{ $employee->educationLevel ? $employee->educationLevel->title : '' }}</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Major:</label>
								<p class="form-control-static m-0">{{ $candidate ? $candidate->major : '' }}</p>
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
								<p class="form-control-static m-0">{{ $candidate ? $candidate->work_experience : '' }}</p>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Certification:</label>
								<p class="form-control-static m-0">{{ $candidate ? $candidate->certifications : '' }}</p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="form-group form-inline">
								<label class="font-weight-bold">Skills:</label>
								<p class="form-control-static m-0">
									<span class="border border-muted p-1 mr-2">Management</span>
									<span class="border border-muted p-1 mr-2">Marketing</span>
								</p>
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
							<label class="font-weight-bold d-block mt-2">Passport</label>
						</div>

						<div class="col-md-3">
							<div class="bg-light p-2">
								<img src="{{ URL::asset('employee_portal/img/doc3.png') }}" class="img-fluid mr-2">
							</div>
							<label class="font-weight-bold d-block mt-2">Education Certificate</label>
						</div>

						<div class="col-md-3">
							<div class="bg-light p-2">
								<img src="{{ URL::asset('employee_portal/img/doc2.png') }}" class="img-fluid mr-2">
							</div>
							<label class="font-weight-bold d-block mt-2">Certificate</label>
						</div>
					</div>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection