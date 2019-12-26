@extends('admin.layouts.default')

@section('title')
	Create Position
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
<script src="{{ URL::asset('js/operations/dropdowns.js?versions=') }}{{rand(11,99)}}"></script>
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
		<h2>Create Position</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Planning
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/position-management') }}">Position Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
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
					<h5>Position Details</h5>
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
					<form role="form" id="frm_position" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-4 b-r">

								<div class="form-group">
									<label>RefNo</label>
									<input type="text" class="form-control form-control-sm" id="reference_no" name="reference_no" value="{{$data['reference_no']}}">
								</div>

								<div class="form-group">
									<label>Position Name </label>
									<input type="text" class="form-control form-control-sm" id="title" name="title">
								</div>
								<div class="form-group">
									<label> Total Positions </label>
									<input type="number" class="form-control form-control-sm" id="total_positions" name="total_positions" >
								</div>
							</div>

							<div class="col-sm-4 b-r">


								<div class="form-group">
									<label>Department </label>
									<select name="department_id" id="department_id" class="form-control form-control-sm b-r-xs">
										<option value="">Select Department</option>
										@foreach($data['depts'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->department_name}}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group">
									<label>Section </label>
									<select name="section_id" id="section_id" class="form-control form-control-sm b-r-xs">

									</select>
								</div>

							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label>Location</label>
									<input type="text" class="form-control form-control-sm" id="location" name="location">
								</div>
								<div class="form-group">
									<label>Remarks</label>
									<textarea name="notes" rows="1" class="form-control" id="notes"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_position" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection