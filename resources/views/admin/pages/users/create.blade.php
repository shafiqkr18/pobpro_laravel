@extends('admin.layouts.default')

@section('title')
	Create User
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
	.hide {
		display: none;
	}
</style>
@endsection

@section('scripts')
	<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{mt_rand(1000000, 9999999)}}"></script>
	<script src="{{ URL::asset('js/operations/dropdowns.js?version=') }}{{mt_rand(10000000, 99999999)}}"></script>
<script>

$(document).ready(function(){

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('[name="org_id"]').trigger('change');

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
			<li class="breadcrumb-item text-muted">
				User Admin
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/user-management') }}">User Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/user-management') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Create User
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<form role="form" id="frm_user" enctype="multipart/form-data">
				@csrf

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Login Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="text" class="form-control form-control-sm" id="email" name="email" autocomplete="off">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Password</label>
									<input type="password" class="form-control form-control-sm" id="password" name="password" autocomplete="off">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Confirm Password</label>
									<input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Personal Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>First Name</label>
									<input type="text" class="form-control form-control-sm" id="name" name="name">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Last Name</label>
									<input type="text" class="form-control form-control-sm" id="last_name" name="last_name">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Mobile No</label>
									<input type="text" class="form-control form-control-sm" id="mobile_number" name="mobile_number">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Avatar</label>

									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Organization Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r {{ !Auth::user()->hasRole('itfpobadmin') ? 'hide' : '' }}">
								<div class="form-group form-inline">
									<label>Organization </label>
									<select name="org_id" id="org_id" class="form-control form-control-sm b-r-xs" size>
										<option value="">Select Organization</option>
										@foreach($data['organizations'] as $key=>$val)
											<option value="{{ $val->id }}" {{ !Auth::user()->hasRole('itfpobadmin') && Auth::user()->org_id == $val->id ? 'selected' : '' }}>{{$val->org_title}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Division </label>
									<select name="div_id" id="div_id" class="form-control form-control-sm b-r-xs" size>
										<option value="">Select Division</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Department </label>
									<select name="dept_id" id="dept_id" class="form-control form-control-sm b-r-xs" size>
										<option value="">Select Department</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Section </label>
									<select name="sec_id" id="sec_id" class="form-control form-control-sm b-r-xs" size>
										<option value="">Select Section</option>
									</select>
								</div>
							</div>
                            <div class="col-sm-6">
                                <div class="form-group form-inline">
                                    <label>Position </label>
                                    <select name="position_id" id="position_id" class="form-control form-control-sm b-r-xs" size>
                                        <option value="">Select Position</option>
                                        @foreach($data['positions'] as $key=>$val)
                                            <option value="{{ $val->id }}" >{{$val->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
						</div>
					</div>
				</div>

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Role Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Role</label>
									<select name="roles" id="roles" class="form-control form-control-sm b-r-xs">
										<option value="">Select Role</option>
										@foreach($data['roles'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>User Type</label>
									<select name="user_type" id="user_type" class="form-control form-control-sm b-r-xs">
										<option value="0">Default</option>
										<option value="1">POB</option>
										<option value="2">Candidate</option>
										<option value="3">Employee</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Active </label>
									<select name="is_active" id="is_active" class="form-control form-control-sm b-r-xs">
										<option value="1">Yes</option>
										<option value="0">No</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				@role('itfpobadmin')
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Company Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-4">
								<div class="form-group form-inline">
									<label>Company</label>
									<select data-placeholder="Select role" class="form-control" id="company_id" name="company_id">
                                        {{--he can see only his company --}}
                                        @role('itfpobadmin')
                                        @foreach($data['all_companies'] as $company)
                                            <option value="{{ $company->id }}"><span class="text-primary font-weight-bold">
                                                {{$company->company_name}}
                                                </span></option>
                                        @endforeach
                                        @else
										@if (Auth::user()->company)
										<option value="{{ Auth::user()->company->id }}"><span class="text-primary font-weight-bold">{{ Auth::user()->company->company_name }}</span></option>
										@endif
                                        @endrole
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				@endrole

				<div class="row mt-3">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="save_user" class="btn btn-success btn-sm pull-right">Save</a>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection