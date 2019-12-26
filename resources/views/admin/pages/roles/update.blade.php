@extends('admin.layouts.default')

@section('title')
	Update Role
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/roles.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{mt_rand(1000000, 9999999)}}"></script>
<script src="{{ URL::asset('js/roles.js') }}"></script>
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
				<a href="{{ url('admin/role-management') }}">Role Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/role-management') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $role->name }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_role" enctype="multipart/form-data">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<div class="ibox-title indented">
						<h5>Role Details</h5>
					</div>

					<div class="ibox-content">
						
						<input type="hidden" name="is_update" value="1">
						<input type="hidden" name="listing_id" value="{{ $role->id }}">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $role->name }}">
								</div>

								@if (Auth::user()->hasRole('itfpobadmin'))
								<div class="form-group form-inline">
									<label>Company</label>
									<select name="company_id" id="company_id" class="form-control">
										@if ($companies)
												@foreach ($companies as $company)
														<option value="{{ $company->id }}" {{($role->company_id ==$company->id ) ? 'selected':''}}>{{ $company->company_name }}</option>
												@endforeach
										@endif
									</select>
								</div>
								@endif
							</div>

							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Display Name <span class="text-danger">*</span></label>
									<input type="text" class="form-control form-control-sm" id="display_name" name="display_name" value="{{ $role->display_name }}">
								</div>
							</div>
						</div>

						<div class="row mt-4">
							<div class="col-sm-12">

								<div class="permissions-table border border-bottom-0 d-flex flex-wrap">
									<div class="permission-row heading border-bottom">
										<div class="name"></div>
										<div class="function p-2">Menu</div>
										<div class="function p-2">Create</div>
										<div class="function p-2">Update</div>
										<div class="function p-2">Delete</div>
									</div>

									@foreach($permissions as $permission)
										@include('admin/pages/roles/_permission', ['permission' => $permission, 'role_permissions' => $role_permissions])
									@endforeach
								</div>


							</div>
						</div>

					</div>

				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-12">
				<a href="javascript:void(0)" id="save_role" class="btn btn-success btn-sm pull-right">Save</a>
			</div>
		</div>
	</form>
</div>
@endsection