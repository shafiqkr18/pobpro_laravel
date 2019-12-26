@extends('employee_portal.layouts.inner')

@section('title')
My Offers
@endsection

@section('content')
<div class="training">
	<h2 class="section-title">
		My Offers
	</h2>

	<div class="card mb-4">
		<div class="finances-list jobs-list">
			<div class="finances-list jobs-list">
				<ul class="finances list-unstyled">
					<li class="p-4 background-white mb-4">
						<h4>Account Director</h4>
						<div class="date d-flex align-items-center mb-4">
							<i class="fas fa-th-list mr-1"></i>
							Marketing
							<img src="{{ URL::asset('employee_portal/img/icon-marker.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-marker.png') }} 1x, {{ URL::asset('employee_portal/img/icon-marker@2x.png') }} 2x" class="img-fluid ml-4 mr-1">
							Dubai
							<i class="far fa-clock ml-4 mr-1"></i>
							Full-time
						</div>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>

						<a href="{{ url('employee-portal/detail') }}" class="mt-4">View more</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection