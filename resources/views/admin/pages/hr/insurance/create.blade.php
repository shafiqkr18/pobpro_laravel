@extends('admin.layouts.default')

@section('title')
	Create Insurance
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
<div class="row wrapper page-heading">
	<div class="col-lg-10">
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
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Create Insurance</h2>
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
									<label>Insurance Type</label>
									<select name="" id="" class="form-control form-control-sm">
										<option value="" selected>By Person</option>
										<option value="">By Insurance Offer</option>
									</select>
								</div>

								<div class="form-group">
									<label>Insurer Name</label>
									<input type="text" class="form-control form-control-sm">
								</div>

								<div class="form-group">
									<label>Entity</label>
									<input type="text" class="form-control form-control-sm">
								</div>
							</div>

							<div class="col-sm-4 b-r">
								<div class="form-group">
									<label>Policy No.</label>
									<input type="text" class="form-control form-control-sm">
								</div>

								<div class="form-group">
									<label>Policy Holder</label>
									<input type="text" class="form-control form-control-sm">
								</div>

								<div class="form-group">
									<label>Card No.</label>
									<input type="text" class="form-control form-control-sm">
								</div>
							</div>

							<div class="col-sm-4 b-r">
								<div class="form-group">
									<label class="font-normal">Issue/Expiry Date</label>
									<div class="input-daterange input-group" id="datepicker">
										<input type="text" class="form-control-sm form-control" name="start" />
										<span class="input-group-addon">to</span>
										<input type="text" class="form-control-sm form-control" name="end" />
									</div>
								</div>


								<div class="form-group">
									<label>Description</label>
									<textarea name="" id="" rows="4" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection