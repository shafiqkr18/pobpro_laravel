@extends('employee_portal.layouts.inner')

@section('title')
Daily POB Submit
@endsection

@section('content')
<div class="security-form">
	<h2 class="section-title">
		Personnel On Board (POB) Data Submit Form
	</h2>

	<div class="card mb-4">
		<div class="card-body pl-5 pr-5">

			<form action="">
				<div class="row">

					<div class="col-md-4">

						<div class="form-group">
							<label for="">Date</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Name</label>
							<input type="text" class="form-control">
						</div>
					
						<div class="form-group">
							<label for="">Email</label>
							<input type="text" class="form-control">
						</div>

						<div class="form-group">
							<label for="">Phone</label>
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
							<label for="">Position</label>
							<input type="text" class="form-control">
						</div>
					</div>

					<div class="col-md-6 offset-md-1">
						<h6 class="text-center mb-4">Office</h6>
						
						<div class="table-responsive">
							<table class="table-borderless">
								<thead>
									<tr>
										<th>Nationality</th>
										<th>Anton</th>
										<th>Contractor</th>
										<th>Visitor</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>CHN</td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
									</tr>

									<tr>
										<td>IDH</td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
									</tr>

									<tr>
										<td>Local</td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<h6 class="text-center mb-4 mt-5">Other Facilities (SWP &amp; FSF)</h6>
						
						<div class="table-responsive">
							<table class="table-borderless">
								<thead>
									<tr>
										<th>Nationality</th>
										<th>Anton</th>
										<th>Contractor</th>
										<th>Visitor</th>
									</tr>
								</thead>

								<tbody>
									<tr>
										<td>CHN</td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
									</tr>

									<tr>
										<td>IDH</td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
									</tr>

									<tr>
										<td>Local</td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
										<td><input type="text" class="form-control"></td>
									</tr>
								</tbody>
							</table>
						</div>

						<h6 class="text-center mb-4 mt-5">Summary Total (For reference only)</h6>

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="">CHN</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="">IDH</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="">Local</label>
									<input type="text" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label for="">Total</label>
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