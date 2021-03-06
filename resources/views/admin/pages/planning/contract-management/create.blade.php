@extends('admin.layouts.default')

@section('title')
	Create Contract
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>

$(document).ready(function(){

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.input-group.date').datepicker({
		todayBtn: 'linked',
		keyboardNavigation: false,
		forceParse: false,
		calendarWeeks: true,
		autoclose: true
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Create Contract</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Planning
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/contract-management') }}">Contract Management</a>
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
					<h5>Contract Details</h5>
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
					<form role="form" id="frm_contract" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-sm-4 b-r">

								<div class="form-group">
									<label>Contract No.</label>
									<input type="text" class="form-control form-control-sm" value="{{ $data['cn_no'] }}" id="contract_refno" name="contract_refno">
								</div>

								<div class="form-group">
									<label>Created By</label>
									<select name="created_by" id="created_by" class="form-control form-control-sm b-r-xs">
										@foreach($data['all_users'] as $key=>$val)
											<option value="{{ $val->id}}" {{ ((isset($data['user_id']) && $val->id==$data['user_id'])? "selected":"") }}>{{$val->name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-4 b-r">
								<div class="form-group">
									<label>Contract Title</label>
									<input type="text" class="form-control form-control-sm" id="contract_title" name="contract_title">
								</div>

								<div class="form-group">
									<label>Contract Date</label>
									<div class="input-group date">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control form-control-sm" id="contract_date" name="contract_date">
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label>Upload Contract</label>

									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>

								<div class="form-group">
									<label>Remarks</label>
									<textarea name="notes" id="notes" rows="2" class="form-control"></textarea>
								</div>

							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_contract" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection