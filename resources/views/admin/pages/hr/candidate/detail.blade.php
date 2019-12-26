@extends($modal == 0 ? 'admin.layouts.default' : 'admin.layouts.modal_regular')

@section('title')
	{{ $modal == 0 ? 'View Candidate' : 'Details for ' . $candidate->name . ' ' . $candidate->last_name }}
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
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
});
</script>
@endsection

@php
$file = json_decode($candidate->resume, true);
$expected_salary = ['', '0 - 1,999', '2,000 - 3,999', '4,000 - 5,999', '6,000 - 7,999', '8,000 - 11,999', '12,000 - 19,999', '20,000 - 29,999', '30,000 - 49,999', '50,000 - 99,999', '100,000+'];
$work_type = ['FT' => 'Full Time', 'PT' => 'Part Time', 'CO' => 'Contract', 'TP' => 'Temporary', 'OT' => 'Other'];
@endphp

@section('content')
@if ($modal == 0)
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="javascript:void(0);">HR</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/candidates') }}">Candidates</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/candidates') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $candidate->reference_no }} ({{ strtoupper($candidate->status) }})
		</h2>
		
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		@if ($candidate->status != 'interviewed')
{{--		<a href="#" class="btn btn-warning btn-sm pull-right ml-1" data-toggle="modal" data-target="#myModaInterview">Schedule Interview</a>--}}
		@endif

		<a href="{{ url('admin/candidate/update/' . $candidate->id) }}" class="btn btn-success btn-sm pull-right ml-2">
			<i class="fas fa-pen-square mr-1"></i>
			Edit
		</a>
		<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/candidate/delete/' . $candidate->id) }}">
			<i class="far fa-trash-alt mr-1"></i>
			Delete
		</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
@endif
	<form role="form">
		<div class="form-row">
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
									<p class="form-control-static font-weight-bold">{{ $candidate->name }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Gender</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->gender }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Position</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->position->title }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Last Name</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->last_name }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Age</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->age }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Badge ID</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->badge_id }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Expected Salary (USD)</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->fixed_salary? number_format($candidate->fixed_salary) : '' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Expected Work Type</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->workType ? $candidate->workType->full_name : '' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Expected Benefits</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->other_benefits ? $candidate->other_benefits : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Education Level</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->educationLevel ? $candidate->educationLevel->title : '-' }}</p>
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
									<p class="form-control-static font-weight-bold">{{ $candidate->phone }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Email</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->email }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Skype</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->skype ? $candidate->skype : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Other Contact</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->other_contact ? $candidate->other_contact : '-' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Nationality</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->nationality }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Location</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->location }}</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="form-row">
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
									<p class="form-control-static font-weight-bold">{{ $candidate->notes ? $candidate->notes : '-' }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">CV</label>
									@if ($candidate->resume)
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
									<p class="form-control-static font-weight-bold">{{ $candidate->level ? $candidate->level : '-' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Company</label>
									<p class="form-control-static font-weight-bold">{{ $candidate->company ? $candidate->company->company_name : '-' }}</p>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</form>
@if ($modal == 0)
</div>


<div class="modal inmodal" id="myModaInterview" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated fadeIn">
			<div class="modal-header" style="text-align: center">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-clock-o modal-icon"></i>
				<h4 class="modal-title">Confirmation</h4>
				<small>Schedule Interview</small>
			</div>
			<div class="modal-body">
				<p><strong>Are you sure you want to Invite this candidate for interview?</p>
			</div>
			<div class="modal-footer">
				<form action="{{url('admin/call_for_interview')}}" id="bulk_delete_form" method="GET">

					<input type="hidden" name="ids" id="bulk_delete_input" value="{{ $candidate->id }}">
					<input type="submit" class="btn btn-danger pull-right delete-confirm"
						   value="Yes, Sure">
				</form>
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@endif
@endsection