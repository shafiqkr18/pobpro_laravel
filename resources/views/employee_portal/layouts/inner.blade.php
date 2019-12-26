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
	<link href="{{ URL::asset('fontawesome-free-5.10.2/css/all.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

	<script>
		var baseUrl = "{{ url('/') }}";
	</script>

	<!-- Toastr style -->
	<link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

	@yield('styles')
	<link rel="stylesheet" href="{{ URL::asset('employee_portal/css/dashboard.css') }}">
</head>

<body class="user-candidate h-100">
	<div class="dashboard h-100">
		@include('employee_portal.layouts.includes.header')

		<div class="dashboard-content">
			<div class="container">
				@yield('content')
			</div>
		</div>
		<!-- .dashboard-content -->

	</div>
	<!-- .dashboard -->

	<script src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
	<script src="{{ URL::asset('js/popper.min.js') }}"></script>
	<script src="{{ URL::asset('js/bootstrap.js') }}"></script>

	<!-- Toastr -->
	<script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>

	@yield('scripts')
	<script src="{{ URL::asset('employee_portal/js/main.js?version=') }}{{rand(11,99)}}"></script>
</body>

</html>