@extends('admin.layouts.login') 

@section('title') 
Register 
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

	<div class="form-wrap d-flex flex-column align-items-center register">
		<img src="{{ URL::asset('img/logo.png') }}" srcset="{{ URL::asset('img/logo.png') }} 1x, {{ URL::asset('img/logo@2x.png') }} 2x" class="img-fluid pob-logo">
		<span class="sign-in">Register an account with ITF POB</span>

		<form action="#" role="form" id="frm_register">
			@csrf
			<div style="display: none;" id="div_msg"></div>
			<div class="form-group username">
				<input type="text" class="form-control form-control-sm" placeholder="Name" required="" id="name" name="name">
			</div>

			<div class="form-group username">
				<input type="email" class="form-control form-control-sm" placeholder="Email" required="" name="email" id="email">
			</div>

			<div class="form-group password">
				<input type="password" class="form-control form-control-sm" placeholder="Password" required="" name="password" id="password"
				 autocomplete="new-password">
			</div>

			<div class="form-group password">
				<input id="password-confirm" type="password" name="password_confirmation" placeholder="Confirm Password" required="required" autocomplete="new-password" class="form-control form-control-sm">
			</div>

			<div class="row pt-2">
				<div class="col-md-12">
					<div class="form-group mb-1">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input">
							<span class="custom-control-label">Agree the terms and policy</span>
						</label>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12 text-center">
					<a href="javascript:void(0)" class="submit postbuttonRegister">Register</a>
					<!-- <a href="{{ url('admin/register') }}" class="create"><img src="{{ URL::asset('frontend/img/icon-create.png') }}" srcset="{{ URL::asset('frontend/img/icon-create.png') }} 1x, {{ URL::asset('frontend/img/icon-create@2x.png') }} 2x" class="img-fluid mr-2 ml-2"> Create new account</a> -->
					<a href="{{ url('/login') }}" class="text-muted"><small>Already have an account? Login</small></a>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection