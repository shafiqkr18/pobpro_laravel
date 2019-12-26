@extends('admin.layouts.default')

@section('title')
	Update Division
@endsection

@section('scripts')
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/division-management') }}">Division Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			{{ $division->division_code }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Division Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_division" enctype="multipart/form-data">
						<input type="hidden" name="is_update" id="is_update" value="{{ $is_update ? true : false }}">
						<input type="hidden" name="listing_id" value="{{ $is_update ? $division->id : '' }}">

						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group form-inline">
									<label>Division Code</label>
									<input type="text" class="form-control form-control-sm" id="division_code" name="division_code" value="{{ $division->division_code }}">
								</div>

								<div class="form-group form-inline">
									<label>Organization </label>
									<select name="org_id" id="org_id" class="form-control form-control-sm b-r-xs">
										@foreach($organizations as $key => $val)
											<option value="{{ $val->id }}" {{ $division->org_id == $val->id ? 'selected' : '' }}>{{ $val->org_title }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Short Name</label>
									<input type="text" class="form-control form-control-sm" id="short_name" name="short_name" value="{{ $division->short_name }}">
								</div>

								<div class="form-group form-inline">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name" value="{{ $division->full_name }}">
								</div>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-12">
			<a href="javascript:void(0)" role-type="0" id="save_division" class="btn btn-success btn-sm pull-right">Save</a>
		</div>
	</div>
</div>
@endsection