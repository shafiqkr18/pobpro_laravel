<!DOCTYPE html>
<html>

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Register Organization</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="font-awesome/css/font-awesome.css" rel="stylesheet">
	<link href="css/plugins/iCheck/custom.css" rel="stylesheet">
	<link href="css/plugins/steps/jquery.steps.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">

</head>

<body>
	@yield('content')



	<!-- Mainly scripts -->
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="js/inspinia.js"></script>
	<script src="js/plugins/pace/pace.min.js"></script>

	<!-- Steps -->
	<script src="js/plugins/steps/jquery.steps.min.js"></script>

	<!-- Jquery Validate -->
	<script src="js/plugins/validate/jquery.validate.min.js"></script>


	<script>
			$(document).ready(function(){
					$("#wizard").steps();
					$("#form").steps({
							bodyTag: "fieldset",
							onStepChanging: function (event, currentIndex, newIndex)
							{
									// Always allow going backward even if the current step contains invalid fields!
									if (currentIndex > newIndex)
									{
											return true;
									}

									// Forbid suppressing "Warning" step if the user is to young
									if (newIndex === 3 && Number($("#age").val()) < 18)
									{
											return false;
									}

									var form = $(this);

									// Clean up if user went backward before
									if (currentIndex < newIndex)
									{
											// To remove error styles
											$(".body:eq(" + newIndex + ") label.error", form).remove();
											$(".body:eq(" + newIndex + ") .error", form).removeClass("error");
									}

									// Disable validation on fields that are disabled or hidden.
									form.validate().settings.ignore = ":disabled,:hidden";

									// Start validation; Prevent going forward if false
									return form.valid();
							},
							onStepChanged: function (event, currentIndex, priorIndex)
							{
									// Suppress (skip) "Warning" step if the user is old enough.
									if (currentIndex === 2 && Number($("#age").val()) >= 18)
									{
											$(this).steps("next");
									}

									// Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
									if (currentIndex === 2 && priorIndex === 3)
									{
											$(this).steps("previous");
									}
							},
							onFinishing: function (event, currentIndex)
							{
									var form = $(this);

									// Disable validation on fields that are disabled.
									// At this point it's recommended to do an overall check (mean ignoring only disabled fields)
									form.validate().settings.ignore = ":disabled";

									// Start validation; Prevent form submission if false
									return form.valid();
							},
							onFinished: function (event, currentIndex)
							{
									var form = $(this);

									// Submit form input
									form.submit();
							}
					}).validate({
											errorPlacement: function (error, element)
											{
													element.before(error);
											},
											rules: {
													confirm: {
															equalTo: "#password"
													}
											}
									});
			});
	</script>

</body>

</html>
