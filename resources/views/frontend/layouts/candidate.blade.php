<!DOCTYPE html>

<html lang="en" class="default-style h-100">

<head>
  <title>POB pro | @yield('title')</title>

  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="IE=edge,chrome=1">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<!-- <link rel="icon" type="image/x-icon" href="favicon.ico"> -->
	<meta name="csrf-token" content="{{ csrf_token() }}" />

  <link href="{{ URL::asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
	<link href="{{ URL::asset('fontawesome-free-5.10.2/css/all.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

	<script>
		var baseUrl = "{{ url('/') }}";
	</script>

	<!-- Toastr style -->
	<link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

	@yield('styles')
	<link rel="stylesheet" href="{{ URL::asset('frontend/css/dashboard.css') }}">
	<link rel="stylesheet" href="{{ URL::asset('frontend/css/candidate.css') }}">
</head>

<body class="user-candidate h-100">
	<div class="dashboard h-100">
		@include('frontend.layouts.includes.candidate.header')

		<div class="dashboard-content h-100">
  		<div class="container h-100">

				<div class="row h-100">

					@include('frontend.layouts.includes.candidate.sidebar')

					<div class="col-md-9 candidate-content">
						@yield('content')
					</div>
				</div>

			</div>
			<!-- .container -->
		</div>
		<!-- .dashboard-content -->
	</div>
	<!-- .dashboard -->

	<script src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
	<script src="{{ URL::asset('js/popper.min.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap.js') }}"></script>

	<!-- Toastr -->
	<script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>

	@yield('scripts')
	<script src="{{ URL::asset('frontend/js/main.js?version=') }}{{rand(11,99)}}"></script>
	<script src="{{ URL::asset('frontend/js/candidate.js?version=') }}{{rand(11,99)}}"></script>
</body>

</html>