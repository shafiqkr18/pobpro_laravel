@extends('admin.layouts.clean')

@section('title')
	SaaS Registration
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/landing.css') }}" rel="stylesheet">
<style>
	.pricing-plan.selected {
		border: 1px solid #1ab394;
	}

	.pricing-plan.professional.selected {
		border: 1px solid #127d73;
	}

	.pricing-plan.premium.selected {
		border: 1px solid #fa9b2c;
	}

	.pricing-plan.professional .pricing-title,
	.pricing-plan.professional li .btn-primary {
		background: #127d73;
		border-color: #127d73;
	}
	.pricing-plan.premium .pricing-title,
	.pricing-plan.premium li .btn-primary {
		background: #fa9b2c;
		border-color: #fa9b2c;
	}

	form.ibox-content {
		background: none !important;
	}

	.custom-file-label,
	.custom-file-label:after {
		line-height: 1;
	}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
$(document).ready(function(){
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass('selected').html(fileName);
    });
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});

	$(document).on('click', '.plan-action a', function(e) {
		e.preventDefault();

		$('.pricing-plan.selected').removeClass('selected');
		$(this).closest('.pricing-plan').addClass('selected');

		$('[name="subscription_type"]').val($(this).attr('data-type'));
	});

	$(document).on('click', '.register-company', function(e) {
		e.preventDefault();

		var iboxContent = $('.ibox-content');
		iboxContent.toggleClass('sk-loading');

		$('.validation_error').remove();
		$('.form-group').removeClass('has-error');
		let formData = new FormData($('#frm_saas')[0]);

		$.ajax({
				url: $(this).attr('href'),
				type: 'POST',
				dataType: 'JSON',
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					iboxContent.toggleClass('sk-loading');

					if(data.success == false) {
						if(data.errors)
						{
							toastr.warning('Fill the required fields!');
							jQuery.each(data.errors, function( key, value ) {
								$('#' + key).closest('.form-group').addClass('has-error');
								$('#' + key).closest('.form-group').append('<small class="validation_error text-danger">' + value + '</small>');
								if (key == 'password') {
									$('#password_confirmation').closest('.form-group').addClass('has-error');
								}
							});
						}
						else{
							//Show toastr message
							toastr.error('Error Saving Data');
						}
					}
					else {
						toastr.success(data.message, 'Success!');
						setTimeout(function(){
							window.location.href = baseUrl+'/admin/dashboard';
						}, 1500);
					}

				}
		});
	});

});
</script>
@endsection
@php
    //$file = $data['vacancy'] && $data['vacancy']->attachments ? json_decode($data['vacancy']->attachments, true) : null;
 $file = null;
@endphp
@section('content')
<div class="navbar-wrapper">
    <nav class="navbar navbar-default navbar-fixed-top navbar-expand-md navbar-scroll" role="navigation">
        <div class="container">
            <a class="" href="index.html"><img src="{{ URL::asset('img/logo.png') }}"  height="58" alt=""/></a>
            <div class="navbar-header page-scroll">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="collapse navbar-collapse justify-content-end" id="navbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="nav-link page-scroll" href="http://www.pobpro.com#page-top">Home</a></li>
                    <li><a class="nav-link page-scroll" href="http://www.pobpro.com#features">Features</a></li>
                    <li><a class="nav-link page-scroll" href="http://www.pobpro.com#team">Customers</a></li>
                    <li><a class="nav-link page-scroll" href="http://www.pobpro.com#testimonials">Testimonials</a></li>
                    <li><a class="nav-link page-scroll" href="http://www.pobpro.com#contact">Contact</a></li>
                    <li><a class="nav-link page-scroll" href="http://itforce.pobpro.com/candidate/vacancies">Jobs</a></li>
										<li><a class="nav-link page-scroll" href="http://www.pobpro.com#pricing">Pricing</a></li>
										<li><a class="nav-link page-scroll" href="http://itforce.pobpro.com/">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>

{{--
<section id="pricing" class="pricing white-bg mt-4 pt-4 row">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Services or License Pricing</h1>
                <p>We provide both Cloud SaaS services and On-Premise solution</p>
            </div>
        </div>
        <div class="row pb-5 mb-3">
            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled basic {{ $subscription_type == 0 ? 'selected' : '' }}">
                    <li class="pricing-title">
                        Basic
                    </li>
                    <li class="pricing-desc">
                        Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.
                    </li>
                    <li class="pricing-price">
                        <i class="fa fa-check text-navy mr-2"></i> <span>$0</span> /user/month
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> Management Board
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> HR Mobilization
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> Travel & Visa
                    </li>
					 <li>
                       -
                    </li>
                  <li>
                       -
                    </li>
					<li>
                       -
                    </li>
					<li>
                       -
                    </li>
					<li>
                       -
                    </li>
                    <li class="plan-action">
                        <a class="btn btn-primary btn-xs" href="" data-type="0">Free 30 Days Trial</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled professional {{ $subscription_type == 1 ? 'selected' : '' }}">
                    <li class="pricing-title">
                        Professional
                    </li>
                    <li class="pricing-desc">
                        Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.
                    </li>
                    <li class="pricing-price">
                        <i class="fa fa-check text-navy mr-2"></i> <span>$30</span> /user/month
                    </li>
                     <li>
                        <i class="fa fa-check text-navy mr-2"></i> Management Board
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> HR Mobilization
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> Travel & Visa
                    </li>

                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> IT Assets
                    </li>
					<li>
                       -
                    </li>
					<li>
                       -
                    </li>
					<li>
                       -
                    </li>
					<li>
                       -
                    </li>
                    <li class="plan-action">
                        <a class="btn btn-primary btn-xs" href="" data-type="1">Free 30 Days Trial</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-4 wow zoomIn">
                <ul class="pricing-plan list-unstyled premium {{ $subscription_type == 2 ? 'selected' : '' }}">
                    <li class="pricing-title">
                        Enterprise Premium
                    </li>
                    <li class="pricing-desc">
                        Lorem ipsum dolor sit amet, illum fastidii dissentias quo ne. Sea ne sint animal iisque, nam an soluta sensibus.
                    </li>
                    <li class="pricing-price">
                        <i class="fa fa-check text-navy mr-2"></i> <span>$60</span> /user/month
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> Management Board
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> HR Mobilization
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> Travel & Visa
                    </li>
					 <li>
                        <i class="fa fa-check text-navy mr-2"></i> IT Assets
                    </li>
                    <li>
                        <i class="fa fa-check text-navy mr-2"></i> HSE PPE Management
                    </li>
					<li>
                        <i class="fa fa-check text-navy mr-2"></i> Accommadation
                    </li>
					<li>
                        <i class="fa fa-check text-navy mr-2"></i> Security and Contractor
                    </li>

					<li>
                        <i class="fa fa-check text-navy mr-2"></i> Rotation & Handover Scheduling
                    </li>
                    <li class="plan-action">
                        <a class="btn btn-primary btn-xs" href="" data-type="2">Free 30 Days Trial</a>
                    </li>
                </ul>
            </div>
        </div>

    </div>

</section>
--}}

<div class="wrapper wrapper-content  animated fadeInRight article mt-5 pt-5">
	<div class="row justify-content-md-center mt-2">
		<div class="col-lg-10">

			<!-- <h2 class="text-center">Register for your free trial</h2>
			<h4 class="text-center mb-5">Get 30 days free trial when you register</h4> -->

			<form role="form" id="frm_saas" enctype="multipart/form-data" class="ibox-content p-0 border-0">
				<div class="sk-spinner sk-spinner-three-bounce">
					<div class="sk-bounce1"></div>
					<div class="sk-bounce2"></div>
					<div class="sk-bounce3"></div>
				</div>
				@csrf
				<input type="hidden" name="subscription_type" value="{{ $subscription_type }}">

				<div class="ibox">
					<div class="ibox-title">
						<h5>Login Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Email</label>
											<input type="email" class="form-control form-control-sm" name="email" id="email">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>First Name</label>
											<input type="text" class="form-control form-control-sm" name="name" id="name">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label>Last Name</label>
											<input type="text" class="form-control form-control-sm" name="last_name" id="last_name">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Password</label>
											<input type="password" class="form-control form-control-sm" name="password" id="password">
										</div>
									</div>

									<div class="col-lg-6">
										<div class="form-group">
											<label>Confirm Password</label>
											<input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation">
										</div>
									</div>
								</div>

							</div>
						</div>

					</div>
				</div>

				<div class="ibox">
					<div class="ibox-title">
						<h5>Company Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Company Name</label>
									<input type="text" class="form-control form-control-sm" name="company_name" id="company_name">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Company Website</label>
									<input type="text" class="form-control form-control-sm" name="website" id="website">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Company Email</label>
									<input type="text" class="form-control form-control-sm" name="company_email" id="company_email">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Phone No.</label>
									<input type="text" class="form-control form-control-sm" name="phone_no" id="phone_no">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Address</label>
									<input type="text" class="form-control form-control-sm" name="address" id="address">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>City</label>
									<input type="text" class="form-control form-control-sm" name="city" id="city">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Country</label>
									<input type="text" class="form-control form-control-sm" name="country" id="country">
								</div>
							</div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <div class="custom-file">
                                        <input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
                                        <label for="logo" class="custom-file-label b-r-xs form-control-sm m-0 justify-content-start">{{ $file ? 'Update file' : 'Choose file...' }}</label>
                                        @if ($file)
                                            <a href="{{ asset('/storage/' . $file[0]['download_link']) }}" target="_blank" class="d-inline-block text-success font-weight-bold mt-2">{{ $file[0]['original_name'] }}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
						</div>

					</div>
				</div>

				{{--
				<div class="ibox">
					<div class="ibox-title">
						<h5>Product Modules</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									@if (count($product_modules) > 0)
										@foreach ($product_modules as $module)
										<div class="i-checks mr-5"><label> <input type="checkbox" name="module_id[]" value="{{ $module->id }}"> <i></i> <span class="ml-2">{{ $module->module_name }}</span> </label></div>
										@endforeach
									@endif
								</div>
							</div>
						</div>

					</div>
				</div>
				--}}

				<div class="row">
					<div class="col-lg-12">
						<a href="{{ url('saas') }}" class="btn btn-primary float-right register-company">Register</a>
					</div>
				</div>

			</form>

		</div>
	</div>
</div>

@endsection