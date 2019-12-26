@extends('admin.layouts.default')

@section('title')
	Update User
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<style>
	.hide {
		display: none;
	}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
	<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{mt_rand(1000000, 9999999)}}"></script>
	<script src="{{ URL::asset('js/operations/dropdowns.js?version=') }}{{mt_rand(10000000, 99999999)}}"></script>
<script>

$(document).ready(function(){

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('#org_id').trigger('change');
	$('#div_id').trigger('change');

    setTimeout(function(){
        $('#div_id').val($('#drop_div_id').val());
        $('#div_id').trigger('change');
    }, 1000);

    setTimeout(function(){
        $('#dept_id').val($('#drop_dept_id').val());
        $('#dept_id').trigger('change');
    }, 2000);
    setTimeout(function(){
        $('#sec_id').val($('#drop_sec_id').val());
     }, 3000);

	$('.chosen-select').chosen({width: "100%"});

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
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/user-management') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $user->name }}User
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
				<input type="hidden" name="is_update" value="1">
				<input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" id="drop_org_id" value="{{$user->org_id}}">
                <input type="hidden" id="drop_div_id" value="{{$user->div_id}}">
                <input type="hidden" id="drop_dept_id" value="{{$user->dept_id}}">
                <input type="hidden" id="drop_sec_id" value="{{$user->sec_id}}">
				@csrf

				<div class="ibox">
					<div class="ibox-title">
						<h5>Login Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="text" class="form-control form-control-sm" id="email" name="email" autocomplete="off" value="{{ $user->email }}">
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
					<div class="ibox-title">
						<h5>Personal Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>First Name</label>
									<input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $user->name }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Last Name</label>
									<input type="text" class="form-control form-control-sm" id="last_name" name="last_name" value="{{ $user->last_name }}">
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Mobile No</label>
									<input type="text" class="form-control form-control-sm" id="mobile_number" name="mobile_number" value="{{ $user->mobile_number }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Avatar</label>
									@php $avatar = $user->avatar ? json_decode($user->avatar, true) : null; @endphp
									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
									@if ($avatar)
									<span class="form-text">
										<a href="{{ asset('/storage/' . $avatar[0]['download_link']) }}" target="_blank" class="text-success">{{ $avatar[0]['original_name'] }}</a>
									</span>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="ibox">
					<div class="ibox-title">
						<h5>Organization Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r {{ !Auth::user()->hasRole('itfpobadmin') ? 'hide' : '' }}">
								<div class="form-group form-inline">
									<label>Organization </label>
									<select name="org_id" id="org_id" class="form-control form-control-sm b-r-xs" size>
										<option value="">Select Organization</option>
										@foreach($organizations as $key=>$val)
											<option value="{{ $val->id}}" {{ $user->org_id == $val->id ? 'selected' : '' }}>{{$val->org_title}}</option>
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
                                        @foreach($positions as $key=>$val)
                                            <option value="{{ $val->id }}" {{$user->position_id == $val->id ? 'selected': ''}} >{{$val->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
						</div>
					</div>
				</div>

				<div class="ibox">
					<div class="ibox-title">
						<h5>Role Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Role</label>
									<select data-placeholder="Select role" class="chosen-select form-control" multiple tabindex="2" id="roles" name="roles[]">
										@foreach($roles as $key=>$val)
										<option value="{{ $val->id }}" {{ in_array($val->name, $user_roles) ? 'selected' : '' }}><span class="text-primary font-weight-bold">{{ $val->name }}</span></option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>User Type</label>
									<select name="user_type" id="user_type" class="form-control form-control-sm b-r-xs">
										<option value="0" {{ $user->user_type == 0 ? 'selected' : '' }}>Default</option>
										<option value="1" {{ $user->user_type == 1 ? 'selected' : '' }}>POB</option>
										<option value="2" {{ $user->user_type == 2 ? 'selected' : '' }}>Candidate</option>
										<option value="3" {{ $user->user_type == 3 ? 'selected' : '' }}>Employee</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Active </label>
									<select name="is_active" id="is_active" class="form-control form-control-sm b-r-xs">
										<option value="1" {{ $user->is_active == 1 ? 'selected' : '' }}>Yes</option>
										<option value="0" {{ $user->is_active == 0 ? 'selected' : '' }}>No</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				@role('itfpobadmin')
				<div class="ibox">
					<div class="ibox-title">
						<h5>Company Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Company</label>
									<select data-placeholder="Select role" class="form-control" id="company_id" name="company_id">
										<option value=""></option>
										@if($user->company)
										<option value="{{ $user->company->id }}" selected><span class="text-primary font-weight-bold">{{ $user->company->company_name }}</span></option>
										@endif
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