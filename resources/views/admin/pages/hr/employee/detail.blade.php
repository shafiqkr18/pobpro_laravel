@extends('admin.layouts.default')

@section('title')
	View Employee
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
	<div class="col-lg-12">
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
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/employees') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $employee->reference_no }}
			<!-- <a href="{{ url('admin/employee/update/' . $employee->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/employee/delete/' . $employee->id) }}">
				<i class="far fa-trash-alt mr-1"></i>
				Delete
			</a> -->
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_employee" enctype="multipart/form-data">
		@csrf
		
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Candidate Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">First Name</label>
									<p class="form-control-static font-weight-bold">{{ $employee->employee_name ? $employee->employee_name : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Gender</label>
									<p class="form-control-static font-weight-bold">{{ $employee->gender ? $employee->gender : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Position</label>
									<p class="form-control-static font-weight-bold">{{ $employee->position && $employee->position->title ? $employee->position->title : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Last Name</label>
									<p class="form-control-static font-weight-bold">{{ $employee->last_name ? $employee->last_name : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Age</label>
									<p class="form-control-static font-weight-bold">{{ $employee->age ? $employee->age : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Badge ID</label>
									<p class="form-control-static font-weight-bold">{{ $employee->badge_id ? $employee->badge_id : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Expected Salary (USD)</label>
									<p class="form-control-static font-weight-bold">{{ $employee->salary ? number_format($employee->salary) : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Expected Work Type</label>
									<p class="form-control-static font-weight-bold">{{ $employee->workType ? $employee->workType->full_name : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Education Level</label>
									<p class="form-control-static font-weight-bold">{{ $employee->educationLevel ? $employee->educationLevel->title : '-' }}</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Contact Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Phone</label>
									<p class="form-control-static font-weight-bold">{{ $employee->phone_number ? $employee->phone_number : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Email</label>
									<p class="form-control-static font-weight-bold">{{ $employee->email ? $employee->email : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Skype</label>
									<p class="form-control-static font-weight-bold">{{ $employee->skype ? $employee->skype : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Other Contact</label>
									<p class="form-control-static font-weight-bold">{{ $employee->other_contact ? $employee->other_contact : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Nationality</label>
									<p class="form-control-static font-weight-bold">{{ $employee->nationality ? $employee->nationality : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Location</label>
									<p class="form-control-static font-weight-bold">{{ $employee->location ? $employee->location : '-' }}</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Profile Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Description</label>
									<p class="form-control-static font-weight-bold">{{ $employee->notes ? $employee->notes : '-' }}</p>
								</div>
								@php
								$file = $employee->resume ? json_decode($employee->resume, true) : null;
								@endphp
								<div class="form-group form-inline">
									<label class="text-muted mb-0">CV</label>
									@if ($file)
									<a href="{{ asset('/storage/' . $file[0]['download_link']) }}" target="_blank" class="text-success"><p class="form-control-static font-weight-bold mb-0">{{ $file[0]['original_name'] }}</p></a>
									@else
									<p class="form-control-static font-weight-bold mb-0">No CV uploaded.</p>
									@endif
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Level</label>
									<p class="form-control-static font-weight-bold">{{ $employee->level ? $employee->level : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Company</label>
									<p class="form-control-static font-weight-bold">{{ $employee->company ? $employee->company->company_name : '-' }}</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

	</form>
</div>
@endsection