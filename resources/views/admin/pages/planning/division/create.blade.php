@extends('admin.layouts.default')

@section('title')
	Create Division
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}
</style>
@endsection

@section('scripts')
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
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
			<li class="breadcrumb-item">
				<a href="{{ url('admin/division-management') }}">Division Management</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Create</h2>
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
						<input type="hidden" name="is_settings" value="1">
						
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group form-inline">
									<label>Division Code</label>
									<input type="text" class="form-control form-control-sm" id="division_code" name="division_code" value="{{ $data['division_code'] }}">
								</div>

								<div class="form-group form-inline">
									<label>Organization </label>
									<select name="org_id" id="org_id" class="form-control form-control-sm b-r-xs">
										@foreach($data['organizations'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->org_title}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Short Name</label>
									<input type="text" class="form-control form-control-sm" id="short_name" name="short_name">
								</div>

								<div class="form-group form-inline">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name">
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
			<a href="javascript:void(0)" id="save_division" role-type="0" class="btn btn-success btn-sm pull-right">Save</a>
		</div>
	</div>
</div>
@endsection