@extends('employee_portal.layouts.inner')

@section('title')
Reimbursement Form
@endsection

@section('content')
<div class="reimbursement-form">
	<h2 class="section-title">
		Reiumbursement Form
	</h2>

	<div class="card mb-4">
		<div class="card-body pl-5 pr-5">

			<form action="">
				<div class="row">

					<div class="col-md-4">
						
						<div class="form-group">
							<label for="">Payment Method</label>
							<select name="" id="" class="form-control">
								<option value="" selected></option>
								<option value="">Bank Transfer</option>
								<option value="">Cheque</option>
							</select>
						</div>
					
						<div class="form-group">
							<label for="">Beneficiary Bank</label>
							<input type="text" class="form-control">
						</div>
					
						<div class="form-group">
							<label for="">Beneficiary Account No.</label>
							<input type="text" class="form-control">
						</div>
					
						<div class="form-group">
							<label for="">Beneficiary Name</label>
							<input type="text" class="form-control">
						</div>
						
						<div class="form-group">
							<label for="">Swift Code</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Correspondence Bank</label>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="col-md-6 offset-md-1">
						<h6 class="text-center mb-4">Total Claim</h6>
						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">AED</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Ex. Rate</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">USD</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Ex. Rate</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">IQD</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Ex. Rate</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group">
								<label for="">Attachments</label>
								<input type="file" name="file" id="file" class="inputfile" />
								<label for="file">
									<img src="{{ URL::asset('employee_portal/img/icon-upload.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-upload.png') }} 1x, {{ URL::asset('employee_portal/img/icon-upload@2x.png') }} 2x" class="img-fluid mr-2">
									Upload
								</label>
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