@extends('employee_portal.layouts.inner')

@section('title')
Create Ticket
@endsection

@section('content')
<div class="create-ticket-form">
	<h2 class="section-title">
		Ticket Details
	</h2>

	<div class="card mb-4">
		<div class="card-body pl-5 pr-5">

			<form action="">
				<div class="row">

					<div class="col-md-4">
						<div class="form-group">
							<label for="">Ticket No.</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Desk No.</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Room No.</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Date</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Time</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Select File</label>
							<input type="file" name="file" id="file" class="inputfile" />
							<label for="file">
								<img src="{{ URL::asset('employee_portal/img/icon-upload.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-upload.png') }} 1x, {{ URL::asset('employee_portal/img/icon-upload@2x.png') }} 2x" class="img-fluid mr-2">
								Upload
							</label>
						</div>
					</div>

					<div class="col-md-6 offset-md-1">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Subject</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Notify Person</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="" class="d-block">Priority</label>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline1">Low</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline2">Normal</label>
									</div>

									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline3">High</label>
									</div>

									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline4" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline4">Critical</label>
									</div>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Description</label>
									<textarea name="" id="" cols="30" rows="6" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Tags</label>
									<input type="text" class="form-control" placeholder="(Keyword for search, ie., If Email issue, add 'email', print and email issue)">
								</div>
							</div>
						</div>
					</div>

				</div>
				
				<div class="row mt-5 mb-4">
					<div class="col-md-12 d-flex align-items-center justify-content-end">
						<a href="" class="btn-cancel mr-3">Cancel</a>
						<a href="" class="btn-submit">Submit</a>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>
@endsection