<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>POB pro | @yield('title')</title>

	<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

	<!-- Toastr style -->
	<link href="{{ URL::asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

	<!-- Gritter -->
	<link href="{{ URL::asset('js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

	<link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link href="{{ URL::asset('css/admin.css') }}" rel="stylesheet">


	@yield('styles')

</head>

<body class="canvas-menu landing-page">
		<div id="wrapper">
			<div id="page-wrapper" class="gray-bg">
				@yield('content')
			</div>
		</div>

		<div class="modal inmodal fade" id="modal" tabindex="-1" role="dialog"  aria-hidden="true">
			
		</div>

		<script>
			var baseUrl = "{{ url('/') }}";
		</script>
		<!-- Mainly scripts -->
		<script src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
		<script src="{{ URL::asset('js/popper.min.js') }}"></script>
		<script src="{{ URL::asset('js/bootstrap.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

		<!-- Flot -->
		<script src="{{ URL::asset('js/plugins/flot/jquery.flot.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>

		<!-- Peity -->
		<script src="{{ URL::asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
		<script src="{{ URL::asset('js/demo/peity-demo.js') }}"></script>

		<!-- Custom and plugin javascript -->
		<script src="{{ URL::asset('js/inspinia.js') }}"></script>
		<script src="{{ URL::asset('js/plugins/pace/pace.min.js') }}"></script>

		<!-- jQuery UI -->
		<!-- <script src="{{ URL::asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script> -->

		<!-- GITTER -->
		<script src="{{ URL::asset('js/plugins/gritter/jquery.gritter.min.js') }}"></script>

		<!-- Sparkline -->
		<script src="{{ URL::asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

		<!-- Sparkline demo data  -->
		<script src="{{ URL::asset('js/demo/sparkline-demo.js') }}"></script>

		<!-- ChartJS-->
		<script src="{{ URL::asset('js/plugins/chartJs/Chart.min.js') }}"></script>

		<!-- Toastr -->
		<script src="{{ URL::asset('js/plugins/toastr/toastr.min.js') }}"></script>
		<script type="text/javascript">
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
            @if(Session::has('alert-message'))

            // TODO: change Controllers to use AlertsMessages trait... then remove this
            var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
            var alertMessage = {!! json_encode(Session::get('alert-message')) !!};
            var alerter = toastr[alertType];

            if (alerter) {
                alerter(alertMessage);
            } else {
                toastr.error("toastr alert-type " + alertType + " is unknown");
            }
            @endif
		</script>

		@yield('scripts')

		<script src="{{ URL::asset('js/admin.js') }}"></script>
</body>
</html>