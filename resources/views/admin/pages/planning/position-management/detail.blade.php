@extends('admin.layouts.default')

@section('title')
	View Position
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
				Planning
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/position-management') }}">Position Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
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
		<a href="{{ url('admin/position-management/export_docx/' . $position->id) }}" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-file-export"></i>
            Export Docx</a>
		<a href="{{ url('admin/position-management/update/' . $position->id) }}" class="btn btn-success btn-sm pull-right ml-1">
			<i class="fas fa-pen-square mr-1"></i>
			Edit
		</a>
        @if($position->is_lock != 1)
		<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-1" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/position-management/delete/' . $position->id) }}">
			<i class="far fa-trash-alt mr-1"></i>
			Delete
		</a>
            @endif
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Position Details</h5>
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
					<form action="" role="form">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">RefNo</label>
									<p class="form-control-static font-weight-bold">{{ $position->reference_no }}</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Position Name</label>
									<p class="form-control-static font-weight-bold">{{ $position->title }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Total Positions</label>
									<p class="form-control-static font-weight-bold">{{ $position->total_positions }}</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Department</label>
									<p class="form-control-static font-weight-bold">{{ $position->department? $position->department->department_name: '' }}</p>
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Location</label>
									<p class="form-control-static font-weight-bold">{{ $position->location ? $position->location : '-' }}</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Remarks</label>
									<p class="form-control-static font-weight-bold">{{ $position->job_description }}</p>
								</div>
							</div>
						</div>

						<!-- <div class="row">
							<div class="col-md-12">
								<a href="{{ url('admin/position-management/update/1') }}" class="btn btn-success btn-sm pull-right">Update</a>
							</div>
						</div> -->
					</form>

				</div>

			</div>

			@if ($position->vacancy)
			<div class="ibox">
				<div class="ibox-title">
					<h5>Vacancy</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>

				<div class="ibox-content">
					<div class="vacancy-wrapper">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Job Title</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->job_title ? $position->vacancy->job_title : $position->title }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Gender</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->gender ? $position->vacancy->gender : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Nationality</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->nationality ? $position->vacancy->nationality : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Age</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->ageRange ? $position->vacancy->ageRange->age : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Work Type</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->workType ? $position->vacancy->workType->full_name : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Education Level</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->educationLevel ? $position->vacancy->educationLevel->title : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Salary (USD)</label>
									<p class="form-control-static font-weight-bold">$ {{ $position->vacancy->salary ? number_format($position->vacancy->salary) : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Report to</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->reportTo ? $position->vacancy->reportTo->title : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Rotation Pattern</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->rotationType ? $position->vacancy->rotationType->title : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Job Purpose</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->job_purpose ? $position->vacancy->job_purpose : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Duties and Responsibilities</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->duty_responsibility ? $position->vacancy->duty_responsibility : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Certifications &amp; Training</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->certifications ? $position->vacancy->certifications : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Experience</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->experience_details ? $position->vacancy->experience_details : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Language proficiency, computer and software skills</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->skills ? $position->vacancy->skills : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label class="text-muted mb-0">Others</label>
									<p class="form-control-static font-weight-bold">{{ $position->vacancy->others ? $position->vacancy->others : '-' }}</p>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
			@endif

		</div>
	</div>
</div>
@endsection