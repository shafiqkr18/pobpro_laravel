@extends('admin.layouts.default')

@section('title')
	Company Profile
@endsection

@section('styles')

@endsection

@section('scripts')
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
			let fileName = $(this).val().split('\\').pop();
			$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$(document).on('click', '#save_company', function(e) {
		e.preventDefault();

		// var iboxContent = $('.ibox-content');
		// iboxContent.toggleClass('sk-loading');

		$('.validation_error').remove();
		$('.form-group').removeClass('has-error');
		let formData = new FormData($(this).closest('form')[0]);

		$.ajax({
				url: $(this).closest('form').attr('action'),
				type: 'POST',
				dataType: 'JSON',
				data: formData,
				processData: false,
				contentType: false,
				success: function (data) {
					// iboxContent.toggleClass('sk-loading');

					if(data.success == false) {
						if(data.errors)
						{
							toastr.warning('Fill the required fields!');
							jQuery.each(data.errors, function( key, value ) {
								$('#' + key).closest('.form-group').addClass('has-error');
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
						toastr.success(data.message);
						setTimeout(function(){
							window.location.href = data.redirect;
						}, 500);
					}

				}
		});
	});

});
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Company Profile</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			{{ $company ? $company->company_name : '' }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" action="{{ url('admin/company/save') }}" enctype="multipart/form-data">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<div class="ibox-title indented">
						<h5>Company Details</h5>
					</div>

					<div class="ibox-content">
						<input type="hidden" name="is_update" value="1">
						<input type="hidden" name="listing_id" value="{{ $company->id }}">

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Name</label>
									<input type="text" class="form-control form-control-sm" id="company_name" name="company_name" value="{{ $company->company_name }}">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Website</label>
									<input type="text" class="form-control form-control-sm" id="website" name="website" value="{{ $company->website }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="text" class="form-control form-control-sm" id="email" name="email" value="{{ $company->email }}">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Phone</label>
									<input type="text" class="form-control form-control-sm" id="phone_no" name="phone_no" value="{{ $company->phone_no }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Address</label>
									<input type="text" class="form-control form-control-sm" id="address" name="address" value="{{ $company->address }}">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>City</label>
									<input type="text" class="form-control form-control-sm" id="city" name="city" value="{{ $company->city }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Country</label>
									<input type="text" class="form-control form-control-sm" id="country" name="country" value="{{ $company->country }}">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Logo</label>
									<div class="custom-file">
										@php
										$file = $company->logo ? json_decode($company->logo, true) : null;
										@endphp
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
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-12">
				<a href="javascript:void(0)" id="save_company" class="btn btn-success btn-sm pull-right">Save</a>
			</div>
		</div>
	</form>
</div>
@endsection