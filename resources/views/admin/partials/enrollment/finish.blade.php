<h2>Summary</h2>

<h3 class="mt-4 mb-3">Profile</h3>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">First Name</label>
					<p class="form-control-static font-weight-bold">erere</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Last Name</label>
					<p class="form-control-static font-weight-bold">addsa</p>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Gender</label>
					<p class="form-control-static font-weight-bold">asdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Age</label>
					<p class="form-control-static font-weight-bold">asdasd</p>
			</div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Mobile Number</label>
					<p class="form-control-static font-weight-bold">11111</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Phone Number</label>
					<p class="form-control-static font-weight-bold">123123</p>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Skype</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Other Contact</label>
					<p class="form-control-static font-weight-bold">asdasd1</p>
			</div>
	</div>
</div>

<br>

<div class="row">
<div class="col-lg-6">
		<div class="form-group">
				<label class="text-muted mb-0">Nationality</label>
				<p class="form-control-static font-weight-bold">asdd</p>
		</div>
</div>

<div class="col-lg-6">
		<div class="form-group">
				<label class="text-muted mb-0">Passport No.</label>
				<p class="form-control-static font-weight-bold">spdods12</p>
		</div>
</div>
</div>

<div class="row">
<div class="col-lg-6">
	<div class="form-group">
			<label class="text-muted mb-0">Location</label>
			<p class="form-control-static font-weight-bold">asdasd</p>
	</div>
</div>
</div>

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="form-group">
				<label class="text-muted mb-0">Notes</label>
				<p class="form-control-static font-weight-bold">asdjaskldjasdlkasjdlkasdlkasdlkasdklas</p>
		</div>
	</div>
	</div>

	<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Education Level</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Resume</label>
					<div class="custom-file d-flex justify-content-between">
							@if ($candidate->resume)
									<a href="{{ asset('/storage/' . $resume[0]['download_link']) }}" target="_blank" class="text-success"><p class="form-control-static font-weight-bold">{{ $resume[0]['original_name'] }}</p></a>
							@else
									<p>No resume uploaded.</p>
							@endif
					</div>
			</div>
	</div>
</div>

<br>

<h3 class="mt-4 mb-3">HR</h3>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Position</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Report To</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

</div>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Badge ID</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Work Type</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>
	
<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Level</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
	
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Rotation Type</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>

<div class="row">
<div class="col-lg-6">
		<div class="form-group">
				<label class="text-muted mb-0">Salary</label>
				<p class="form-control-static font-weight-bold">asdasdas</p>
		</div>
</div>

<div class="col-lg-6">
		<div class="form-group">
				<label class="text-muted mb-0">Company</label>
				<p class="form-control-static font-weight-bold">asdasdas</p>
		</div>
</div>
</div>

<br>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Organization</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Division</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Department</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Section</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Agreement Start Date</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>

	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Agreement End Date</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Join Date</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>

<br>

<div class="row">
	<div class="col-lg-12">
			<div class="form-group">
					<label class="text-muted mb-0">Other Benefits</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
			<div class="form-group">
					<label class="text-muted mb-0">Contract</label>
					<div class="custom-file d-flex justify-content-between">
							@if ($candidate->contract)
								@php $contract = json_decode($candidate->contract->attachments, true); @endphp
									<a href="{{ asset('/storage/' . $contract[0]['download_link']) }}" target="_blank" class="text-success"><p class="form-control-static font-weight-bold">{{ $contract[0]['original_name'] }}</p></a>
							@else
									<p>No contract uploaded.</p>
							@endif
					</div>
			</div>
	</div>
</div>

<br>

<h3 class="mt-4 mb-3">IT</h3>

<div class="row">
	<div class="col-lg-8">
			<div class="form-group">
					<label class="text-muted mb-0">UserId *</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>

			<div class="form-group">
					<label class="text-muted mb-0">Email *</label>
					<p class="form-control-static font-weight-bold">asdasdas</p>
			</div>
	</div>
</div>
