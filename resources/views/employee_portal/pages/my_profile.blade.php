@extends('employee_portal.layouts.inner')

@section('title')
My Profile
@endsection

@section('content')
<div class="my-profile">
	<h2 class="section-title">
		My Profile
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
									<label for="">Gender</label>
									<select name="" id="" class="form-control">
										<option value="" selected></option>
										<option value="">Male</option>
										<option value="">Female</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Email</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Age</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Phone</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Position</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Job Type</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label for="">Job Location</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Expected Salary</label>
									<input type="text" class="form-control">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<input type="file" name="file" id="file" class="inputfile" />
									<label for="file">
										<img src="{{ URL::asset('employee_portal/img/icon-upload.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-upload.png') }} 1x, {{ URL::asset('employee_portal/img/icon-upload@2x.png') }} 2x" class="img-fluid mr-2">
										Upload CV
									</label>
								</div>
							</div>
						</div>

						<div class="row mt-5">
							<div class="col-md-12 d-flex align-items-center justify-content-end">
								<!-- <a href="" class="btn-cancel mr-3">Cancel</a> -->
								<a href="" class="btn-submit">Save</a>
							</div>
						</div>
					</form>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection