@extends('admin.layouts.default')

@section('title')
	View User
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
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

	$('#org_id').trigger('change');

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
				<strong>View</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/user-management') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $user->name }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-1" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/user-management/delete/' . $user->id) }}">Delete</a> -->
		<a href="{{ url('admin/user-management/update/' . $user->id) }}" class="btn btn-success btn-sm pull-right ml-1">
			<i class="fas fa-pen-square mr-1"></i>
			Edit
		</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<form role="form" id="frm_user" enctype="multipart/form-data">
				<input type="hidden" name="is_update" value="1">
				<input type="hidden" name="user_id" value="{{ $user->id }}">
				@csrf

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Login Details</h5>
					</div>

					<div class="ibox-content">
						<div class="form-row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Email</label>
									<p class="form-control-static font-weight-bold">{{ $user->email }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Password</label>
									<p class="form-control-static font-weight-bold">********</p>
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
									<label class="text-muted mb-0">Name</label>
									<p class="form-control-static font-weight-bold">{{ $user->getName() }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Mobile No</label>
									<p class="form-control-static font-weight-bold">{{ $user->mobile_number }}</p>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Avatar</label>
									@php $avatar = $user->avatar ? json_decode($user->avatar, true) : null; @endphp
									<p class="form-control-static font-weight-bold">
										@if ($avatar)
										<a href="{{ asset('/storage/' . $avatar[0]['download_link']) }}" target="_blank" class="text-success">{{ $avatar[0]['original_name'] }}</a>
										@else
										&nbsp;
										@endif
									</p>
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
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Organization </label>
									<p class="form-control-static font-weight-bold">{{ $user->organization ? $user->organization->org_title : '' }}</p>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Division </label>
									<p class="form-control-static font-weight-bold">{{ $user->division ? $user->division->short_name : '' }}</p>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Department </label>
									<p class="form-control-static font-weight-bold">{{ $user->department ? $user->department->department_short_name : '' }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Section </label>
									<p class="form-control-static font-weight-bold">{{ $user->section ? $user->section->short_name : '' }}</p>
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
									<label class="text-muted mb-0">Role</label>
									<p class="form-control-static font-weight-bold">
									@if (count($user->roles->pluck('display_name')) > 0)
										@foreach ($user->roles->pluck('display_name') as $role)
										<span class="badge">{{ $role }}</span>
										@endforeach
									@endif
									</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">User Type </label>
									@php
										$user_type = ['Default', 'POB', 'Candidate', 'Employee','Enterprise','WeChatWork'];
									@endphp
									<p class="form-control-static font-weight-bold">{{ $user->user_type ? $user_type[$user->user_type] : '' }}</p>
								</div>
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Active </label>
									<p class="form-control-static font-weight-bold">{{ $user->is_active == 1 ? 'Yes' : 'No' }}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection