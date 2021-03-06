@extends('admin.layouts.default')

@section('title')
	View Insurance
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
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
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>987456321</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/insurance') }}">Insurance</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<a href="{{ url('admin/insurance/update/1') }}" class="btn btn-success btn-sm pull-right">Update</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Insurance Details</h5>
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
							<div class="col-sm-4 b-r">

								<div class="form-group">
									<label class="text-muted mb-0">Insurance Type</label>
									<p class="form-control-static font-weight-bold">By Person</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Insurer Name</label>
									<p class="form-control-static font-weight-bold">MetLife</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Entity</label>
									<p class="form-control-static font-weight-bold">NA</p>
								</div>
							</div>

							<div class="col-sm-4 b-r">
								<div class="form-group">
									<label class="text-muted mb-0">Policy No.</label>
									<p class="form-control-static font-weight-bold">987456321</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Policy Holder</label>
									<p class="form-control-static font-weight-bold">ITF</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Card No.</label>
									<p class="form-control-static font-weight-bold">NA</p>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label class="text-muted mb-0">Issue/Expiry Date</label>
									<p class="form-control-static font-weight-bold">09/05/2019 - 08/05/2020</p>
								</div>


								<div class="form-group">
									<label class="text-muted mb-0">Description</label>
									<p class="form-control-static font-weight-bold">Lorem ipsum dolore sit amet..</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="{{ url('admin/insurance/update/1') }}" class="btn btn-success btn-sm pull-right">Update</a>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection