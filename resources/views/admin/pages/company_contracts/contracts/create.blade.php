@extends('admin.layouts.default')

@section('title')
	Create Contract
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/company-contracts.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/company-contracts.js') }}"></script>
<script src="{{ URL::asset('js/operations/contract_create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Contracts Mgt.
			</li>
			<li class="breadcrumb-item active">
				<a href="{{ url('admin/contracts-mgt/contracts') }}">Contract Management</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/contracts-mgt/contracts') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			
			Create
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Contract Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_contract_mgt" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Tender No.</label>
									<input type="text" class="form-control form-control-sm" id="tender_reference" name="tender_reference">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Tender Title</label>
									<input type="text" class="form-control form-control-sm" name="tender_title" id="tender_title">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Department</label>
									<select class="form-control form-control-sm" name="department_id" id="department_id">
										<option value=""></option>
										@foreach($departments as $department)
										<option value="{{$department->id}}">{{$department->department_short_name}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Contractor</label>
									<select class="form-control form-control-sm" name="contractor_id" id="contractor_id">
										<option value=""></option>
										@foreach($contractors as $contractor)
										<option value="{{$contractor->id}}">{{$contractor->title}}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Amount</label>
									<input type="number" class="form-control form-control-sm" name="amount" id="amount">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Currency</label>
									<select class="form-control form-control-sm" name="currency" id="currency">
										<option value="USD">USD</option>
										<option value="AED">AED</option>
										<option value="CNY">CNY</option>
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Start Date</label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" id="start_date" name="start_date">
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>End Date</label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" id="end_date" name="end_date">
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Location</label>
									<input type="text" class="form-control form-control-sm" name="location" id="location">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Primary Term</label>
									<input type="text" class="form-control form-control-sm" name="primary_term" id="primary_term">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<label class="align-self-start mt-2">Summary</label>
									<textarea class="form-control" name="notes" id="notes" rows="5"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Attachment</label>
									<div class="custom-file">
										<input id="attachment" name="file" type="file" class="custom-file-input form-control-sm">
										<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
									</div>
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
			<a href="javascript:void(0)" id="btn_contract_new" class="btn btn-success btn-sm pull-right">Save</a>
		</div>
	</div>
</div>
@endsection