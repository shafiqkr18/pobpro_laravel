@extends('admin.layouts.default')

@section('title')
	View Organization
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
				<strong>View</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<a href="{{ url('admin/organization-management') }}" class="btn btn-white btn-sm pull-right">Return to list</a>
		<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-1" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/organization-management/delete/' . $organization->id) }}">Delete</a>
		<a href="{{ url('admin/organization-management/update/' . $organization->id) }}" class="btn btn-success btn-sm pull-right ml-1">Update</a>
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
					<form action="" role="form">
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group">
									<label class="text-muted mb-0">Organization Code</label>
									<p class="form-control-static font-weight-bold">{{ $organization->org_refno }}</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Organization Name</label>
									<p class="form-control-static font-weight-bold">{{ $organization->org_title }}</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Created Date</label>
									<p class="form-control-static font-weight-bold">{{ db_date_format($organization->created_at) }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="text-muted mb-0">Parent Organization</label>
									<p class="form-control-static font-weight-bold">{{ $organization->org_parent }}</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Remarks</label>
									<p class="form-control-static font-weight-bold">{{ $organization->notes }}</p>
								</div>
							</div>
						</div>

						<!-- <div class="row">
							<div class="col-md-12">
								<a href="{{ url('admin/organization-management/update/1') }}" class="btn btn-success btn-sm pull-right">Update</a>
							</div>
						</div> -->
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection