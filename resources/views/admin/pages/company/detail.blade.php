@extends('admin.layouts.default')

@section('title')
	View Enterprise
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<style>
	.form-group label {
		width: 25%;
		justify-content: flex-end;
		text-align: right;
		padding-right: 10px;
	}

	.form-group .form-control {
		width: 75%;
	}
</style>
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

@php
$expiry_date = strtotime($company->expired_at);
$today = strtotime('now');
$days_left = floor(($expiry_date - $today) / 86400);
@endphp

@section('content')
<div class="row wrapper border-bottom white-bg page-heading ">
	<div class="col-lg-10">
		<h4 class="font-weight-normal mt-3"> Your Plan: <span class="font-weight-bold">Trial</span> <span class="text-{{ $expiry_date - $today > 0 ? 'navy' : 'danger' }}">({{ $days_left > 0 ? $days_left : '0' }} days left)</span></h4 class="font-weight-normal">
		<p class="m-0">Your account currently has 0 expirations.</p>
		
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-9">
			<div class="ibox">
				<div class="ibox-content">
					
					<div class="row">
						<div class="col-lg-12">
							<div class="d-flex flex-nowrap align-items-center">
								<h2>{{ $company->company_name }}</h2>
							</div>
							
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">
										<span class="label label-{{ $expiry_date - $today > 0 ? 'primary' : 'default' }}">{{ $expiry_date - $today > 0 ? 'Active' : 'Inactive' }} </span>
									</dd>
								</div>
							</dl>
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt> Company:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ $company->company_name }}</dd></div>
							</dl>
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Website:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1"><span class="text-navy"> {{ $company->website }}</span> </dd></div>
							</dl>
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt> Email:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ $company->email }}</dd></div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt> Phone No:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ $company->phone_no }}</dd></div>
							</dl>
						</div>

						<div class="col-lg-6" id="cluster_info">
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right">
									<dt>Due Date:</dt>
								</div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1"> {{ date('Y-m-d', strtotime($company->expired_at)) }}</dd>
								</div>
							</dl>
							<dl class="row mb-0">
									<div class="col-sm-4 text-sm-right">
											<dt>Address:</dt>
									</div>
									<div class="col-sm-8 text-sm-left">
											<dd class="mb-1"> {{ $company->address }}</dd>
									</div>
							</dl>
							<dl class="row mb-0">
									<div class="col-sm-4 text-sm-right">
											<dt>City:</dt>
									</div>
									<div class="col-sm-8 text-sm-left">
											<dd class="mb-1"> {{ $company->city }}</dd>
									</div>
							</dl>

							<dl class="row mb-0">
									<div class="col-sm-4 text-sm-right">
											<dt>Country:</dt>
									</div>
									<div class="col-sm-8 text-sm-left">
											<dd class="mb-1"> {{ $company->country }}</dd>
									</div>
							</dl>
						</div>
					</div>


				</div>
			</div>

			<div class="ibox">
				<div class="ibox-content">

					<div class="package border p-4">
						<div class="row">
							<div class="col-sm-6">
								<label class="mb-0 text-uppercase">New Plan</label>
								<h1 class="text-uppercase mb-0">Starter</h1>
							</div>

							<div class="col-sm-3 text-right">
								<label class="mb-0 text-uppercase">Expirations</label>
								<h1 class="text-uppercase mb-0">25</h1>
							</div>

							<div class="col-sm-3 text-right">
								<label class="mb-0 text-uppercase">Expirations</label>
								<h1 class="text-uppercase mb-0">$12</h1>
							</div>
						</div>
					</div>

					<div class="border border-top-0 pt-3 pb-3 pl-4 pr-4">
						<div class="row">
							<div class="col-sm-3">
								<label class="mb-0">Plan includes:</label>
							</div>

							<div class="col-sm-9 text-right">
								@if ($company_modules)
									@foreach ($company_modules as $product)
									<span class="font-weight-bold text-uppercase ml-3">{{ $product }}</span>
									@endforeach
								@endif
							</div>
						</div>
					</div>

					<div class="border border-top-0 bg-light p-3">
						<div class="row">
							<div class="col-lg-9 d-flex align-items-center">
								<h4 class="font-weight-normal m-0">Switch to annual billing and save <strong>$8</strong> per year.</h4>
							</div>

							<div class="col-lg-3 text-right">
								<a href="" class="btn btn-sm btn-success text-uppercase">Go Annual</a>
							</div>
						</div>
					</div>

					<form role="form" id="frm_package" enctype="multipart/form-data" class="mt-4">
						<div class="row">
							<div class="col-lg-8">
								<div class="form-group form-inline">
									<label>Credit Card Number</label>
									<input type="text" class="form-control form-control-sm">
								</div>

								<div class="form-group form-inline">
									<label>Expiration Year</label>
									<select name="" id="" class="form-control">
										<option value="">2019</option>
										<option value="">2020</option>
										<option value="">2021</option>
										<option value="">2022</option>
										<option value="">2023</option>
										<option value="">2024</option>
										<option value="">2025</option>
										<option value="">2026</option>
										<option value="">2027</option>
										<option value="">2028</option>
										<option value="">2029</option>
										<option value="">2030</option>
									</select>
								</div>

								<div class="form-group form-inline">
									<label>Expiration Month</label>
									<select name="" id="" class="form-control">
										<option value="">January</option>
										<option value="">February</option>
										<option value="">March</option>
										<option value="">April</option>
										<option value="">May</option>
										<option value="">June</option>
										<option value="">July</option>
										<option value="">August</option>
										<option value="">September</option>
										<option value="">October</option>
										<option value="">November</option>
										<option value="">December</option>
									</select>
								</div>

								<div class="form-group form-inline">
									<label>Name on Card</label>
									<input type="text" class="form-control form-control-sm">
								</div>

								<div class="form-group form-inline">
									<label>CVV</label>
									<input type="number" class="form-control form-control-sm">
								</div>

								<div class="form-group form-inline">
									<label>Expiration Month</label>
									<select name="" id="" class="form-control">
										<option value="">United Arab Emirates</option>
										<option value="">China</option>
									</select>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<a href="" class="btn btn-sm btn-success float-right mt-3">Activate Expiration Reminder Now!</a>
									</div>
								</div>
							</div>

							<div class="col-lg-4">
								<div class="border">
									<div class="border-bottom p-2">
										<div class="row">
											<div class="col-sm-7">
												<span>Starter (Monthly)</span>
											</div>

											<div class="col-sm-5 text-right">
												<span class="font-weight-bold">$12.00</span>
											</div>
										</div>
									</div>

									<div class="border-bottom p-2">
										<div class="row">
											<div class="col-sm-7">
												<span>Sub Total: </span>
											</div>

											<div class="col-sm-5 text-right">
												<span class="font-weight-bold">$12.00</span>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-7">
												<span>Tax: </span>
											</div>

											<div class="col-sm-5 text-right">
												<span class="font-weight-bold">$0.00</span>
											</div>
										</div>
									</div>

									<div class="p-2">
										<div class="row">
											<div class="col-sm-7">
												<span>Total</span>
											</div>

											<div class="col-sm-5 text-right">
												<span class="font-weight-bold">$12.00</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</form>

				</div>
			</div>

		</div>

	</div>
</div>
@endsection