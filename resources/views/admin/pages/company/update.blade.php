@extends('admin.layouts.default')

@section('title')
	Update Enterprise
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script>
$(document).ready(function(){

	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});

});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Update Enterprise</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>SaaS Admin</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<form role="form" id="frm_saas" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
				<input type="hidden" name="is_update" value="1">
				<input type="hidden" name="listing_id" value="{{ $company->id }}">
                <input type="hidden" name="subscription_type" value="{{ $company->subscription_type }}">

				<div class="ibox">
					<div class="ibox-title">
						<h5>Company Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Company Name</label>
									<input type="text" class="form-control form-control-sm" name="company_name" id="company_name" value="{{ $company->company_name }}">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Website</label>
									<input type="text" class="form-control form-control-sm" name="website" id="website" value="{{ $company->website }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Email</label>
									<input type="text" class="form-control form-control-sm" name="company_email" id="company_email" value="{{  $company->email }}">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Phone No.</label>
									<input type="text" class="form-control form-control-sm" name="phone_no" id="phone_no" value="{{ $company->phone_no }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Address</label>
									<input type="text" class="form-control form-control-sm" name="address" id="address" value="{{ $company->address }}">
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>City</label>
									<input type="text" class="form-control form-control-sm" name="city" id="city" value="{{ $company->city }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label>Country</label>
									<input type="text" class="form-control form-control-sm" name="country" id="country" value="{{ $company->country }}">
								</div>
							</div>
						</div>

					</div>
				</div>

{{--				<div class="ibox">--}}
{{--					<div class="ibox-title">--}}
{{--						<h5>Product Modules</h5>--}}
{{--					</div>--}}

{{--					<div class="ibox-content">--}}
{{--						<div class="row">--}}
{{--							<div class="col-lg-6">--}}
{{--								<div class="form-group form-inline">--}}
{{--									@if (count($product_modules) > 0)--}}
{{--										@foreach ($product_modules as $module)--}}
{{--										<div class="i-checks mr-5"><label> <input type="checkbox" name="module_id[]" value="{{ $module->id }}" {{ in_array($module->module_name, $company_modules) ? 'checked' : '' }}> <i></i> <span class="ml-2">{{ $module->module_name }}</span> </label></div>--}}
{{--										@endforeach--}}
{{--									@endif--}}
{{--								</div>--}}
{{--							</div>--}}
{{--						</div>--}}

{{--					</div>--}}
{{--				</div>--}}

				<div class="row">
					<div class="col-lg-12">
						<a href="{{ url('saas') }}" class="btn btn-primary float-right register-company">Update</a>
					</div>
				</div>

			</form>

		</div>
	</div>
</div>

@endsection