@extends($modal == 0 ? 'admin.layouts.default' : 'admin.layouts.modal_regular')

@php
$avatar = $employee->avatar ? json_decode($employee->avatar, true) : null;
@endphp

@section('content')
<div class="address-book p-4">
	<a href="" data-dismiss="modal" class="close-modal ml-auto"><i class="fas fa-times text-muted"></i></a>

	<div class="row border-bottom pb-3">
		<div class="col-md-4 d-flex align-items-center flex-nowrap">
			<label>
				<div class="avatar">
					@if ($avatar)
					<img src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" alt="">
					@else
					<img src="{{ URL::asset('img/default_avatar.jpg') }}" srcset="{{ URL::asset('img/default_avatar.jpg') }} 1x, {{ URL::asset('img/default_avatar@2x.jpg') }} 2x" class="img-fluid">
					@endif
				</div>
			</label>

			<div class="value">
				<h3 class="m-0">{{ $employee->name." ".$employee->last_name }}</h3>
				<span class="position block">{{ $employee->position ? $employee->position->title : '' }}</span>
				<span class="department block">{{ $employee->department ? $employee->department->department_short_name : '' }}</span>
			</div>
		</div>

		<div class="col-md-8">
			<div class="row mt-3">
				<div class="col-sm-2 b-r">
					<label class="block text-center">Badge ID</label>
					<div class="value text-center">
						<span>{{ $employee->badge_id }}</span>
					</div>
				</div>

				<div class="col-sm-2 b-r">
					<label class="block text-center">Age</label>
					<div class="value text-center">
						<span>{{ $employee->age }}</span>
					</div>
				</div>

				<div class="col-sm-2 b-r">
					<label class="block text-center">Gender</label>
					<div class="value text-center">
						<span>{{ $employee->gender }}</span>
					</div>
				</div>

				<div class="col-sm-2">
					<label class="block text-center">Nationality</label>
					<div class="value text-center">
						<span>{{ $employee->nationality }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row pt-4">
		<div class="col-md-4">
			<div class="form-group d-flex flex-nowrap">
				<label>Mobile Number</label>
				<div class="value">
					<span>{{ $employee->mobile_number }}</span>
				</div>
			</div>

			<div class="form-group d-flex flex-nowrap">
				<label>Email</label>
				<div class="value">
					<a href="mailto:{{ $employee->email }}" class="text-success">{{ $employee->email }}</a>
				</div>
			</div>

			<div class="form-group d-flex flex-nowrap">
				<label>Address</label>
				<div class="value">
					<span>{!! $employee->location !!}</span>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group d-flex flex-nowrap">
				<label class="pl-3">Education</label>
				<div class="value">
					<span>{{ $employee->educationLevel ? $employee->educationLevel->title : '' }}</span>
				</div>
			</div>

			<div class="form-group d-flex flex-nowrap">
				<label class="pl-3">Work Type</label>
				<div class="value">
					<span>{{ $employee->workType ? $employee->workType->full_name : '' }}</span>
				</div>
			</div>

			<div class="form-group d-flex flex-nowrap">
				<label class="pl-3">Level</label>
				<div class="value">
					<span>{{ $employee->level }}</span>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="form-group d-flex flex-nowrap">
				<label>Report To</label>
				<div class="value">
					<span>{{ $employee->reportTo ? $employee->reportTo->title : '' }}</span>
				</div>
			</div>

			<div class="form-group d-flex flex-nowrap">
				<label>Rotation Type</label>
				<div class="value">
					<span>{{ $employee->rotationType ? $employee->rotationType->title : '' }}</span>
				</div>
			</div>

			<div class="form-group d-flex flex-nowrap">
				<label>Salary per month</label>
				<div class="value">
					<span>{{ $employee->salary ? number_format($employee->salary) . ' (USD)' : '' }}</span>
				</div>
			</div>
		</div>
	</div>

	<div class="row d-flex justify-content-end mt-2">
		<a href="" class="btn btn-outline btn-primary">
			<i class="fas fa-print"></i> Print
		</a>
	</div>
</div>
@endsection
