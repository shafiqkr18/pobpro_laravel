@extends('admin.layouts.default')

@section('title')
	View Role
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.role-group > div:last-child .name,
.role-group > div:last-child .function {
	padding-bottom: 8px;
}

.role-group > .role-group .name {
	padding-left: 2rem;
	/* margin-bottom: 10px; */
}

.role-group > .role-group > div:nth-child(even) {
	background: #f8f8f8;
}

.i-checks input[type="checkbox"] {
	position: absolute;
	opacity: 0;
}

.i-checks input[type="checkbox"] + label {
	position: relative;
	cursor: pointer;
	padding: 0;
	margin-bottom: 0;
	font-size: 14px;
}

.i-checks input[type="checkbox"] + label:before {
	content: '';
	margin-right: 10px;
	margin-top: 4px;
	display: inline-block;
	vertical-align: text-top;
	width: 12px;
	height: 12px;
	background: white;
	border: 1px solid #e7eaec;
}

.i-checks input[type="checkbox"]:checked + label:before {
	background: #18a689;
	border-color: #18a689;
}

.i-checks input[type="checkbox"]:checked + label:after {
	content: '\f00c';
	font: normal normal normal 8px/1 FontAwesome;
	position: absolute;
	left: 2px;
	top: 6px;
	color: #fff;
}

/* .root:nth-child(even) {
	background: #f3f3f4;
} */

.permission-row {
	display: flex;
	flex: 0 0 100%;
	flex-wrap: nowrap;
}

.permission-row .name {
	flex: 0 0 50%;
	padding: 5px 8px;
}

.permission-row .name h5 {
	padding: 5px;
}

.permission-row .function {
	flex: 0 0 12.5%;
	text-align: center;
	border-left: 1px solid #e7eaec;
	padding: 4px 8px;
}

.root {
	flex: 0 0 100%;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{mt_rand(1000000, 9999999)}}"></script>
<script>
$(document).ready(function(){

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
				<a href="{{ url('admin/role-management') }}">Role Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
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
		<!-- <a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-1" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/role-management/delete/' . $role->id) }}">Delete</a> -->
		<a href="{{ url('admin/role-management/update/' . $role->id) }}" class="btn btn-success btn-sm pull-right ml-1">
			<i class="fas fa-pen-square mr-1"></i>
			Edit
		</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Role Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_role" enctype="multipart/form-data">
						<input type="hidden" name="is_update" value="1">
						<input type="hidden" name="listing_id" value="{{ $role->id }}">
						<div class="row mb-4">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Name</label>
									<p class="form-control-static font-weight-bold">{{ $role->name }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Display Name</label>
									<p class="form-control-static font-weight-bold">{{ $role->display_name }}</p>
								</div>
							</div>
						</div>

						<div class="row">
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
										@include('admin/pages/roles/_permission_detail', ['permission' => $permission, 'role_permissions' => $role_permissions])
									@endforeach
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