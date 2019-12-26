@extends('admin.layouts.default')

@section('title')
	Update Organization
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

@php
$organization = $data['organization'];
@endphp

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>{{ $organization->org_refno }}</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Planning
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/organization-management') }}">Organization Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Organization Details</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						    <i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li>
								<a href="#" class="dropdown-item">Config option 1</a>
							</li>
							<li>
								<a href="#" class="dropdown-item">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_org" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group">
									<label>Organization Code</label>
									<input type="text" name="org_refno" id="org_refno" class="form-control form-control-sm" value="{{ $organization->org_refno }}">
								</div>

								<div class="form-group">
									<label>Organization Name</label>
									<input type="text" name="org_title" id="org_title" class="form-control form-control-sm" value="{{ $organization->org_title }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Parent Organization</label>
									<input type="text" name="org_parent" id="org_parent" class="form-control form-control-sm" value="{{ $organization->org_parent }}">
								</div>

								<div class="form-group">
									<label>Remarks</label>
									<textarea  name="notes" id="notes" rows="2" class="form-control">{{ $organization->notes }}</textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<input type="hidden" name="is_update" id="is_update" value="{{$data['is_update'] ? true : false}}">
								<input type="hidden" name="listing_id" value="{{$data['is_update'] ? $organization->id : ''}}">
								<a href="javascript:void(0)" id="save_org" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection