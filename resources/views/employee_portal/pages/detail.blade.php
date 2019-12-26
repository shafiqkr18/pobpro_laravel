@extends('employee_portal.layouts.inner')

@section('title')
Detail
@endsection

@section('content')
<div class="finance-detail finance-view background-white p-5">

	<div class="form-wrap">
			<h2 class="mb-5 ml-2">Visa process</h2> 

			<form action="">
				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="ml-2">Name</label>
							<input type="text" class="form-control" value="Nick Chen" disabled>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="ml-2">Mobile Number</label>
							<input type="text" class="form-control" value="050 984 2982" disabled>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="ml-2">Location</label>
							<input type="text" class="form-control" value="Dubai" disabled>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="ml-2">Job Title</label>
							<input type="text" class="form-control" value="Construction Engineer" disabled>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-6">
						<div class="form-group">
							<label class="ml-2">Applied Date</label>
							<input type="text" class="form-control" value="12 July 2019" disabled>
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label class="ml-2">Approval Date</label>
							<input type="text" class="form-control" value="Pending" disabled>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group">
							<label class="ml-2">Description</label>
							<textarea name="" id="" rows="5" class="form-control" disabled>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</textarea>
						</div>
					</div>
				</div>
			</form>
	</div>
	
</div>

@endsection