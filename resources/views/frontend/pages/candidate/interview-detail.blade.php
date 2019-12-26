@extends('frontend.layouts.candidate')

@section('title')
	Interview Detail
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('frontend/css/new-styles.css') }}" rel="stylesheet">
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
$status = ['Pending Response', 'Confirmed', 'Requested to reschedule', 'Declined'];
@endphp

@section('content')
<div class="card candidate">
	<h6 class="card-header mb-2 pt-0 pl-0">
		My Interview Detail
	</h6>

	<div class="interview-detail-wrap">
		<div class="card-body">
			<form id="interview-response" action="{{ url('candidate/interview/respond') }}" class="form-stripes">
				@csrf
				<input type="hidden" name="id" value="{{ $interview->id }}">
				<input type="hidden" name="is_confirmed" value="">

				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Subject:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->subject ? $interview->subject : '' }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Scheduled Interview Time:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->interview_date ? $interview->interview_date : '' }}</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Applied Job Position:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->position ? $interview->position->title : '' }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Location:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->location ? $interview->location : '' }}</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Contact:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->createdBy && $interview->createdBy->department ? $interview->createdBy->department->department_short_name : '' }}</p>
							</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Telephone:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->company ? $interview->company->phone_no : '' }}</p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Email:</label>
							<p class="form-control-static font-weight-bold">{{ $interview->company ? $interview->company->email : '' }}</p>
						</div>
					</div>
					@if ($interview->is_confirmed != 0)
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Status:</label>
							<p class="form-control-static font-weight-bold">{{ $status[$interview->is_confirmed] }}</p>
						</div>
					</div>
					@endif
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="pr-2 mb-0 text-muted">Documents to bring:</label>
							<p class="form-control-static font-weight-bold"></p>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1 form-inline">
							<label class="align-self-start mt-2">Interview Description:</label>
							<div class="text-content rounded">
								@php
								$view_link = '#';
								$applicant_name = $interview->candidate->name . ' ' . $interview->candidate->last_name;
								$company_name = $interview->company ? $interview->company->company_name : 'ITForce.com';
								$position = $interview->position ? $interview->position->title : '';
								$date = date('Y-m-d', strtotime($interview->interview_date));
								$time = date('H:i', strtotime($interview->interview_date));

								$temp_var_values = array($view_link, $applicant_name, $company_name, $position, $date, $time, $interview->location);
								$temp_var = array('{view_link}', '{name}', '{company_name}', '{position}', '{interviewdate}', '{interviewtime}', '{location}');
								$template_data = str_replace($temp_var, $temp_var_values, $interview->notes);
								@endphp

								{!! $template_data !!}
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>

		@if ($interview->is_confirmed == 0)
		<div class="row mt-4">
			<div class="col-md-12 d-flex justify-content-center">
				<a href="{{ url('candidate/interview/feedback') }}" class="btn btn-sm btn-success rounded mr-2 btn-interview-response" data-response="1">Accept</a>
				<a href="{{ url('candidate/interview/feedback') }}" class="btn btn-sm btn-info rounded ml-2 mr-2 btn-interview-response" data-response="2">Request to reschedule</a>
				<a href="{{ url('candidate/interview/feedback') }}" class="btn btn-sm btn-warning rounded ml-2 btn-interview-response" data-response="3">Decline</a>
			</div>
		</div>
		@endif
	</div>

	<div class="interview-feedback-wrap">
		<div class="card-body p-0">
			<div class="text-content font-weight-bold text-success border-0 pl-0">Feedback Sent Successfully</div>
			<div class="text-content rounded border-0 pl-0">
				{!! $template_data !!}
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-12 d-flex justify-content-center">
				<a href="{{ url('candidate/interview') }}" class="btn btn-sm btn-info rounded">OK</a>
			</div>
		</div>
	</div>
</div>
@endsection