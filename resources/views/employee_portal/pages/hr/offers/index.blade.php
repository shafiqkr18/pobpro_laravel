@extends('employee_portal.layouts.inner')

@section('title')
My Offers
@endsection

@php
$work_type = ['FT' => 'Full Time', 'PT' => 'Part Time', 'CO' => 'Contract', 'TP' => 'Temporary', 'OT' => 'Other'];
@endphp

@section('content')
<div class="training">
	<h2 class="section-title">
		My Offers
	</h2>

	<div class="card mb-4">
		<div class="finances-list jobs-list">
			<div class="finances-list jobs-list">
				@if ($candidate)
				<ul class="finances list-unstyled">
					@if (count($candidate->offers) > 0)
						@foreach ($candidate->offers as $offer)
						<li class="p-4 background-white mb-4">
							<h4>{{ $offer->position->title }}</h4>
							<div class="date d-flex align-items-center mb-4">
								@if ($offer->position && $offer->position->department)
								<i class="fas fa-th-list mr-1"></i>
								{{ $offer->position->department->department_short_name }}
								@endif

								@if ($offer->location)
								<img src="{{ URL::asset('employee_portal/img/icon-marker.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-marker.png') }} 1x, {{ URL::asset('employee_portal/img/icon-marker@2x.png') }} 2x" class="img-fluid ml-4 mr-1">
								{{ $offer->location }}
								@endif

								@if ($offer->position_type)
								<i class="far fa-clock ml-4 mr-1"></i>
								{{ $work_type[$offer->position_type] }}
								@endif
							</div>
							<p>{{ $offer->notes }}</p>

							<a href="" class="mt-4">View more</a>
							@endforeach
					</li>
					@endif
				</ul>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection