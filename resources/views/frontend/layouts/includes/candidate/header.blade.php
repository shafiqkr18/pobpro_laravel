@php
$avatar = Auth::user() && Auth::user()->avatar ? json_decode(Auth::user()->avatar, true) : null;
@endphp

<nav class="header pt-2 pb-2">
	<div class="container d-flex align-items-center flex-nowrap h-100">
		<div class="logo mr-4">
			<a href="dashboard.php">
				<img src="{{ URL::asset('frontend/img/dashboard-logo.png') }}" srcset="{{ URL::asset('frontend/img/dashboard-logo.png') }} 1x, {{ URL::asset('frontend/img/dashboard-logo@2x.png') }} 2x" class="img-fluid">
			</a>
		</div>

		@if (Auth::user() && Auth::user()->user_type == 2)
		<h3 class="header-label font-weight-light text-white mb-0 ml-5 pl-5">Candidate Communication Center</h3>
		@endif

		<div class="profile d-flex align-items-center flex-nowrap ml-auto">
			<div class="avatar">
				@if ($avatar)
				<img alt="image" class="rounded-circle img-fluid" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" />
				@else
				<i class="fas fa-user-circle text-white" style="font-size: 33px;"></i>
				@endif
			</div>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ Auth::user() && Auth::user()->name ? Auth::user()->name : '' }}
				</a>

				<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
					<a class="dropdown-item" href="">Set Password</a>
					<a class="dropdown-item" href="{{ url('admin/logout') }}">Log out</a>
				</div>
			</div>
		</div>
	</div>
</nav>