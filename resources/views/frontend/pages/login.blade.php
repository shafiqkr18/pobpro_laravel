@extends('frontend.layouts.login')

@section('styles')

@endsection

@section('scripts')

@endsection

@section('content')
<div class="d-flex justify-content-between">
	<div class="about">
		<div class="logo">
			<img src="{{ URL::asset('frontend/img/itf-logo.png') }}" srcset="{{ URL::asset('frontend/img/itf-logo.png') }} 1x, {{ URL::asset('frontend/img/itf-logo@2x.png') }} 2x" class="img-fluid">
		</div>

		<h1>Personnel On Board (POB) <span>Tracking Systems</span></h1>
		<p>Personnel On Board (POB) Tracking System enables users to efficiently monitor and control the movements of personnel without the need for manual effort and facilitates faster emergency evacuation at industrial oil & gas, onshore / offshore and marine facilities.</p>
		<a href="" class="text-uppercase">Know More</a>
	</div>

	<div class="form-wrap d-flex flex-column align-items-center">
		<img src="{{ URL::asset('frontend/img/logo.png') }}" srcset="{{ URL::asset('frontend/img/logo.png') }} 1x, {{ URL::asset('frontend/img/logo@2x.png') }} 2x" class="img-fluid pob-logo">
		<span class="sign-in">Sign in to access ITF POB</span>

		<form action="">
			<div class="form-group username">
				<input type="text" class="form-control" placeholder="Username">
			</div>

			<div class="form-group password">
				<input type="password" class="form-control" placeholder="Password">
			</div>

			<div class="row pt-2">
				<div class="col-md-6">
					<div class="form-group mb-1">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input">
							<span class="custom-control-label">Remember Me</span>
						</label>
					</div>
				</div>

				<div class="col-md-6 text-right">
					<a href="" class="forgot-password d-block">Forgot Password?</a>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 text-center">
					<a href="dashboard.php" class="submit">Sign In</a>
					<a href="admin/register" class="create"><img src="{{ URL::asset('frontend/img/icon-create.png') }}" srcset="{{ URL::asset('frontend/img/icon-create.png') }} 1x, {{ URL::asset('frontend/img/icon-create@2x.png') }} 2x" class="img-fluid mr-2 ml-2"> Create new account</a>
					<a href="{{ url('register-organization') }}" class="d-block text-muted mt-1"><small>Register Organization</small></a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection