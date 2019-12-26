@extends('employee_portal.layouts.inner')

@section('title')
Access Application Form
@endsection

@section('content')
<div class="access-application-form">
	<h2 class="section-title">
		Access Request Form
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="row">

				<div class="col-md-6 offset-md-3">
					<form action="">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Name</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Application Date</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Job Title</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Department</label>
									<select name="" id="" class="form-control">
										<option value="" selected></option>
										<option value="">IT</option>
										<option value="">Production</option>
										<option value="">HR</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Type</label>
									<select name="" id="" class="form-control">
										<option value="" selected>New</option>
										<option value="">Authorization</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Access Requirements</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="">Justification</label>
									<textarea name="" id=""rows="7" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row mt-5">
							<div class="col-md-12 d-flex align-items-center justify-content-end">
								<a href="" class="btn-cancel mr-3">Cancel</a>
								<a href="" class="btn-submit">Submit</a>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection