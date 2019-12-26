@extends('employee_portal.layouts.inner')

@section('title')
My Passport
@endsection

@section('styles')
<style>
h2.section-title > a {
	border-radius: 15px !important;
}
</style>
@endsection

@section('content')
<div class="my-passport">
	<h2 class="section-title d-flex flex-nowrap align-items-center border-0 bg-transparent">
		<span>My Current Passport</span>

		<a href="{{ url('employee-portal/my-passport/update/' . ($primary_passport ? $primary_passport->id : '')) }}" class="btn btn-sm btn-primary rounded ml-auto">
			<i class="far fa-edit mr-2"></i> Update Info
		</a>
	</h2>

	<div class="card mb-4">
		<div class="card-body pt-4 pb-4 pl-5 pr-5">

			<div class="row align-items-center">
				<div class="col-lg-2">
					@php $avatar = $employee && $employee->avatar ? json_decode($employee->avatar, true) : null; @endphp
					<img src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" class="img-fluid">
				</div>

				<div class="col-lg-10">
					<div class="row">
						<div class="col-lg-3 border-right">
							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Name:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $user->getName() }}</h6>
							</div>

							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Passport No:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $primary_passport ? $primary_passport->passport_number : '' }}</h6>
							</div>
						</div>

						<div class="col-lg-3 border-right">
							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Issue Date:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $primary_passport ? date('m/d/Y', strtotime($primary_passport->issue_date)) : '' }}</h6>
							</div>

							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Expiry Date:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $primary_passport ? date('m/d/Y', strtotime($primary_passport->expiry_date)) : '' }}</h6>
							</div>
						</div>

						<div class="col-lg-3 border-right">
							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Date of Birth:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $primary_passport ? date('m/d/Y', strtotime($primary_passport['date-of-birth'])) : '' }}</h6>
							</div>

							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Place of Birth:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $primary_passport ? $primary_passport->place_of_birth : '' }}</h6>
							</div>
						</div>

						<div class="col-lg-3">
							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Place of Issue:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">{{ $primary_passport ? $primary_passport->place_of_issue : '' }}</h6>
							</div>

							<div class="form-group">
								<label class="mb-0"><small class="text-muted">Status:</small></label>
								<h6 class="form-control-static font-weight-bold m-0">Active</h6>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>

	<h2 class="section-title d-flex flex-nowrap align-items-center border-0 bg-transparent">
		<span>My Passport History</span>
	</h2>

	<div class="card mb-4">
		<div class="card-body">

			<div class="table-responsive">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>No.</th>
							<th>Passport No.</th>
							<th>Name</th>
							<th>Issue Date</th>
							<th>Expiry Date</th>
							<th>Status</th>
						</tr>
					</thead>

					<tbody>
						@if (count($user->previousPassports) > 0)
							@foreach ($user->previousPassports as $previous_passport)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $previous_passport->passport_number }}</td>
								<td>{{ $user->getName() }}</td>
								<td>{{ date('m/d/Y', strtotime($previous_passport->issue_date)) }}</td>
								<td>{{ date('m/d/Y', strtotime($previous_passport->expiry_date)) }}</td>
								<td>Expired</td>
							</tr>
							@endforeach
						@endif
					</tbody>
				</table>
			</div>

		</div>
	</div>

</div>
@endsection