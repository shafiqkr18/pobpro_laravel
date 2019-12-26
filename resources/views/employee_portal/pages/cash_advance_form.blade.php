@extends('employee_portal.layouts.inner')

@section('title')
Cash Advance Form
@endsection

@section('content')
<div class="cash-advance-form">
	<h2 class="section-title">
		Cash Advance Form
	</h2>

	<div class="card mb-4">
		<div class="card-body pl-5 pr-5">

			<form action="">
				<div class="row">

					<div class="col-md-4">
						<div class="form-group">
							<label for="">Ref No.</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Apply Date</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Department</label>
							<select name="" id="" class="form-control">
								<option value="" selected></option>
								<option value="">IT</option>
								<option value="">HR</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Requested By</label>
							<select name="" id="" class="form-control">
								<option value="" selected>Iama</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Travel Request No.</label>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="col-md-6 offset-md-1">
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Amount</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Currency</label>
									<select name="" id="" class="form-control">
										<option value="" selected>AED</option>
										<option value="">USD</option>
										<option value="">IQD</option>
									</select>
								</div>
							</div>
						</div>

						<!-- <div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="" class="d-block">Currency</label>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline1" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline1">AED</label>
									</div>
									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline2" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline2">USD</label>
									</div>

									<div class="custom-control custom-radio custom-control-inline">
										<input type="radio" id="customRadioInline3" name="customRadioInline1" class="custom-control-input">
										<label class="custom-control-label" for="customRadioInline3">IQD</label>
									</div>
								</div>
							</div>
						</div> -->

						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">In Words</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Justification</label>
									<textarea name="" id="" cols="30" rows="6" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Payment Method</label>
									<select name="" id="" class="form-control">
										<option value="" selected></option>
										<option value="">Bank Transfer</option>
										<option value="">Cheque</option>
									</select>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Beneficiary Bank</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Beneficiary Account No.</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Beneficiary Name</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Swift Code</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Correspondence Bank</label>
									<input type="text" class="form-control">
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