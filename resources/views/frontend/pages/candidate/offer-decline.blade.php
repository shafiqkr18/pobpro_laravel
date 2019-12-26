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

@section('content')
<div class="card candidate">
	<h6 class="card-header pt-2 pb-2">
		My Offer
	</h6>

	<div class="card-body bg-grey">
		<form action="" class="form-stripes">
			<div class="form-row bg-yellow">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pl-4 justify-content-start text-dark font-weight-bold">Reject this offer:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-0" disabled>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Applied Job Position:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-0" value="IT Manager" disabled>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Report To:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-0" value="GM" disabled>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Start Work Date:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0" value="18-08-2019" disabled>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Position Type:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-top-0 border-bottom-0" value="Full Time" disabled>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group form-inline">
						<label class="pr-2 justify-content-end">Base Location:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-0" value="Office 2206 HDS Tower, JLT, Dubai UAE" disabled>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-11">
					<div class="form-group form-inline">
						<label class="pl-4 justify-content-start text-dark font-weight-bold">Please provide required information:</label>
						<input type="text" class="form-control form-control-sm rounded-0 border-0" disabled>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="form-group form-inline">
						<label for="" class="pr-2 justify-content-end align-self-start pt-2">Feedback:</label>
						<div class="flex-75">
							<span class="directions">We regret your decision to decline this offer. We would appreciate it if you can send some feedback for us to better understand your decision.</span>
							<textarea name="" id="" rows="6" class="form-control rounded-0 bg-white mt-2 mb-2 d-block w-100"></textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="row action-row p-3">
		<div class="col-md-12 d-flex justify-content-center">
			<a href="" class="btn btn-sm btn-info mr-2">Send Feedback</a>
			<a href="" class="btn btn-sm btn-info ml-2">Ignore</a>
		</div>
	</div>
</div>
@endsection