@extends('frontend.layouts.candidate')

@section('title')
	My Offer
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
$attachments = $offer->attachments ? json_decode($offer->attachments, true) : null;
$status = ['Awaiting feedback', 'Accepted', 'Declined'];
@endphp

@section('content')
<div class="card candidate">
	<h6 class="card-header mb-2 pt-0 pl-0">
		My Offer
		@if ($attachments)
		<a href="{{ asset('storage/' . $attachments[0]['download_link']) }}" class="ml-3 text-muted" target="_blank">
			<i class="fas fa-file-pdf"></i>
		</a>
		@endif
	</h6>

	<div id="offer-detail">
		<div class="card-body">
			<form action="" class="form-stripes">
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="font-weight-bold mb-0">Offer Summary:</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Applied Job Position:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->position->title }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Report To:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->reportTo ? $offer->reportTo->title : '' }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Start Work Date:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->work_start_date }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Position Type:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->position_type }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Base Location:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->location }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Salary (USD):</label>
							<p class="form-control-static font-weight-bold">{{ $offer->offer_amount ? number_format($offer->offer_amount) : '' }}</p>
						</div>
					</div>

					@if ($offer->accepted != 0)
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Status:</label>
							<p class="form-control-static font-weight-bold">{{ $status[$offer->accepted] }}</p>
						</div>
					</div>
					@endif
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="font-weight-bold">Offer Letter:</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12 text-center">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Subject:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->subject }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1">
							<label class="pr-2 justify-content-end align-self-start mt-2">Offer Letter Description:</label>
							<div class="text-content bordered-side">
								<p>
								@php
								$view_link = '#';
								$applicant_name = $offer->candidate->name;
								$company_name = Auth::user()->company ? Auth::user()->company->company_name : 'ITForce.com';
								$offer_amount = $offer->offer_amount ? '$ ' . number_format($offer->offer_amount) : '';
								$rotation_type = $offer->rotationType ? $offer->rotationType->title : '';
								$temp_var_values = array($view_link, $applicant_name, $company_name, $offer_amount, $rotation_type);
								$temp_var = array('{view_link}', '{applicant_name}', '{company_name}', '{offer_amount}', '{rotation_type}');
								if(empty($offer->notes))
								{
								$template_data = '';
								}else{
								$template_data = str_replace($temp_var, $temp_var_values, $offer->notes);
								}

								echo $template_data;
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

								</p>
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>

		@if ($offer->accepted == 0)
		<div class="row mt-4">
			<div class="col-md-12 d-flex justify-content-center">
				<a href="#offer-accept" class="btn btn-sm btn-success rounded mr-2 btn-offer-feedback">Accept</a>
				<a href="#offer-decline" class="btn btn-sm btn-warning rounded ml-2 btn-offer-feedback">Decline</a>
			</div>
		</div>
		@endif
	</div>

	<div id="offer-accept" class="offer-feedback">
		<div class="card-body">
			<form action="{{ url('candidate/offer/feedback') }}" class="form-stripes">
				@csrf
				<input type="hidden" name="id" value="{{ $offer->id }}">
				<input type="hidden" name="accepted" value="1">
				<input type="hidden" name="type" value="{{ $offer->type }}">
				<div class="form-row alert-success mb-3">
					<div class="col-md-6">
						<div class="form-group mb-0">
							<label class="font-weight-bold mb-0">Accept this offer:</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Applied Job Position:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->position->title }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Report To:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->reportTo ? $offer->reportTo->title : '' }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Start Work Date:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->work_start_date }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Position Type:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->position_type }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Base Location:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->location }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Salary (USD):</label>
							<p class="form-control-static font-weight-bold">{{ $offer->offer_amount ? number_format($offer->offer_amount) : '' }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-11">
						<div class="form-group mb-2 pb-1">
							<label class="font-weight-bold mb-0 text-muted">Please provide required documents:</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Signed Offer Letter:</label>
							<div class="flex-50">
								<span class="directions mb-1">Please print and sign on your offer letter with initial on each page. Scan as PDF copy with 200 PPI.</span>
								<div class="custom-file w-50">
									<input id="file" name="file[]" type="file" class="custom-file-input form-control-sm">
									<label for="file" class="custom-file-label b-r-xs form-control-sm rounded-0 justify-content-start">Choose file...</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Passport and Visa Copy:</label>
							<div class="flex-50">
								<div class="custom-file w-50">
									<input id="file" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
									<label for="file" class="custom-file-label b-r-xs form-control-sm rounded-0 justify-content-start">Choose file...</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1">
							<label for="" class="mb-0 text-muted">Acceptance Description:</label>
							<textarea name="notes" id="notes" rows="6" class="form-control rounded-0 bg-white mt-2 mb-2"></textarea>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="row p-3">
			<div class="col-md-12 d-flex justify-content-center">
				<a href="" class="btn btn-sm btn-success rounded btn-offer-decision">Accept</a>
			</div>
		</div>
	</div>

	<div id="offer-decline" class="offer-feedback">
		<div class="card-body">
			<form action="{{ url('candidate/offer/feedback') }}" class="form-stripes">
				@csrf
				<input type="hidden" name="id" value="{{ $offer->id }}">
				<input type="hidden" name="accepted" value="2">
				<input type="hidden" name="ignore" value="0">
				<input type="hidden" name="type" value="{{ $offer->type }}">
				<div class="form-row alert-warning mb-3">
					<div class="col-md-6">
						<div class="form-group mb-0">
							<label class="font-weight-bold mb-0">Reject this offer:</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Applied Job Position:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->position->title }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Report To:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->reportTo ? $offer->reportTo->title : '' }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Start Work Date:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->work_start_date }}</p>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Position Type:</label>
							<p class="form-control-static font-weight-bold">{{ $offer->position_type }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Base Location:</label>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group mb-2 pb-1">
							<label class="mb-0 text-muted">Salary (USD):</label>
							<p class="form-control-static font-weight-bold">{{ $offer->offer_amount ? number_format($offer->offer_amount) : '' }}</p>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-11">
						<div class="form-group mb-0 mt-3">
							<label class="font-weight-bold">Please provide required information:</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group mb-2 pb-1">
							<label for="" class="mb-0">Feedback:</label>
							<div class="flex-75">
								<span class="directions">We regret your decision to decline this offer. We would appreciate it if you can send some feedback for us to better understand your decision.</span>
								<textarea name="notes" id="notes" rows="6" class="form-control rounded-0 bg-white mt-2 mb-2 d-block w-100"></textarea>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<div class="row mt-3">
			<div class="col-md-12 d-flex justify-content-center">
				<a href="" class="btn btn-sm btn-info mr-2 rounded btn-offer-decision">Send Feedback</a>
				<a href="" class="btn btn-sm btn-info ml-2 rounded btn-offer-decision ignore">Ignore</a>
			</div>
		</div>
	</div>
</div>
@endsection