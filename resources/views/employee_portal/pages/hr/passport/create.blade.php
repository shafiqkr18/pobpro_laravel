@extends('employee_portal.layouts.inner')

@section('title')
My Passport
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
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

	// change file name on file select
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

});
</script>
@endsection

@section('content')
<div class="create-passport">
	<h2 class="section-title">
		Create Passport Form
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="row">

				<div class="col-md-8 offset-md-2">
					<form action="">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Issue Date:</label>
									<div class="input-daterange input-group" id="datepicker">
										<i class="far fa-calendar text-blue mr-2 align-self-center"></i>
										<input type="text" class="form-control-sm rounded-0 form-control text-left" name="issue_date"/>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Expiry Date:</label>
									<div class="input-daterange input-group" id="datepicker">
										<i class="far fa-calendar text-blue mr-2 align-self-center"></i>
										<input type="text" class="form-control-sm rounded-0 form-control text-left" name="expiry_date"/>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Date of Birth:</label>
									<div class="input-daterange input-group" id="datepicker">
										<i class="far fa-calendar text-blue mr-2 align-self-center"></i>
										<input type="text" class="form-control-sm rounded-0 form-control text-left" name="dob"/>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Place of Birth:</label>
									<input type="text" class="form-control form-control-sm rounded-0">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Place of Issue:</label>
									<input type="text" class="form-control form-control-sm rounded-0">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Attachment:</label>
									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm rounded-0">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm rounded-0 m-0">Choose file...</label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Is primary?</label>
									<input type="checkbox" class="form-control">
								</div>
							</div>
						</div>

						<div class="row mt-4">
							<div class="col-lg-12">
								<div class="form-group">
									<div class="d-flex align-items-center justify-content-end">
										<a href="{{ url('employee-portal/my-passport') }}" class="btn btn-sm btn-light rounded-0 ml-auto mr-3">Cancel</a>
										<a href="" class="btn btn-sm btn-primary rounded-0">Submit</a>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection