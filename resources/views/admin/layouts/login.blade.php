<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>POB pro | @yield('title')</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="{{ URL::asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
  <link href="{{ URL::asset('css/animate.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('css/style.css') }}" rel="stylesheet">
	
	<link rel="stylesheet" href="{{ URL::asset('frontend/css/login.css') }}">
  <script src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
  <script src="{{ URL::asset('js/login.js?version=') }}{{rand(111111111,99999999)}}"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <script>
    var baseUrl = "{{ url('/') }}";
  </script>
  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
</head>

<body>
	<div class="login">
		@yield('content')
	</div>
</body>

</html>