@extends('frontend.layouts.candidate')

@section('title')
	My Contract
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
$attachments = $contract && $contract->attachments ? json_decode($contract->attachments, true) : null;
@endphp

@section('content')
<div class="card candidate">
	<h6 class="card-header mb-2 pt-0 pl-0">
		My Contract
	</h6>

	@if ($contract)
	<div class="card-body">
		<form id="send-contract" action="{{ url('candidate/contract/send') }}" class="form-stripes">
			@csrf
			<input type="hidden" name="id" value="{{ $contract->id }}">
			<input type="hidden" name="type" value="1">
			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Applied Job Position:</label>
						<p class="form-control-static font-weight-bold mb-0">{{ $contract->position->title }}</p>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Report To:</label>
						<p class="form-control-static font-weight-bold mb-0">{{ $contract->report_to }}</p>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Start Work Date:</label>
						<p class="form-control-static font-weight-bold mb-0">{{ $contract->work_start_date }}</p>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Position Type:</label>
						<p class="form-control-static font-weight-bold mb-0">{{ $contract->position_type }}</p>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Base Location:</label>
						<p class="form-control-static font-weight-bold mb-0">&nbsp;</p>
					</div>
				</div>
			</div>

			<!-- <div class="form-row">
				<div class="col-md-6">
					<div class="form-group mb-2 pb-1">
						<label class="pl-4 justify-content-start text-dark font-weight-bold">&nbsp;</label>
						<input type="text" class="form-control form-control-sm" disabled>
					</div>
				</div>
			</div> -->

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Subject:</label>
						<p class="form-control-static font-weight-bold mb-0">{{ $contract->subject }}</p>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group mb-4">
						<label class="pr-2 justify-content-end align-self-start">Content:</label>
						<div class="text-content">
							<p>Dear {{ $contract->candidate->gender == 'Male' ? 'Mr.' : 'Ms.' }} {{ $contract->candidate->name }},</p> 

							<p>
								@php
								echo $contract->notes;
								@endphp
							</p>
														
							@if ($attachments)
							<p>
								Attachments:<br>
								@foreach ($attachments as $attachment)
								<a href="{{ asset('storage/' . $attachment['download_link']) }}" class="d-block" target="_blank">{{ $attachment['original_name'] }}</a>
								@endforeach
							</p>
							@endif

							<p>
							--------	<br>
							HR Department
							</p>
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Status:</label>
						<p class="form-control-static font-weight-bold mb-0">{{ $contract->accepted == 1 ? 'Accepted' : ($contract->accepted == 2 ? 'Declined' : 'Awaiting feedback') }}</p>
					</div>
				</div>
			</div>

			@if ($contract->accepted == 0)
			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Acceptance:</label>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="accepted" id="accepted">
							<label class="form-check-label font-weight-bold" for="accepted">
								I, {{ $contract->candidate->name }}, accept the contract and this contract is signed on behalf as myself.
							</label>
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group mb-2 pb-1">
						<label class="pr-2 mb-0 text-muted">Acceptance Description:</label>
						<div class="flex-50">
							<span class="directions font-weight-bold">Please print the contract out. Sign and scan photocopy to us by 19-09-2019.</span>
							<div class="custom-file mt-2 w-50">
								<input id="file" name="file" type="file" class="custom-file-input form-control-sm">
								<label for="logo" class="custom-file-label b-r-xs form-control-sm rounded-0 justify-content-start">Choose file...</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endif

		</form>
	</div>

	@if ($contract->accepted == 0)
	<div class="row mt-4">
		<div class="col-md-12 d-flex justify-content-center">
			<a href="{{ url('candidate/offer/accept') }}" class="btn btn-sm btn-info btn-send-contract rounded">Send Back</a>
		</div>
	</div>
	@endif

	@else
	<p class="m-0 pt-3 pb-3 pt-3 pl-0"><small>You currently do not have a contract.</small></p>
	@endif
	
</div>
@endsection