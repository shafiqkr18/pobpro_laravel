@extends('admin.layouts.default')

@section('title')
	Create Contractor
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
				<a href="{{ url('admin/contracts-mgt/contractors') }}">Contractor Management</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/contracts-mgt/contractors') }}" class="d-flex pt-2 pb-2 pr-3">
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
					<h5>Contractor Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_contractor_mgt" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Reference No.</label>
									<input type="text" class="form-control form-control-sm" name="reference_number" id="reference_number" value="{{$ref_no}}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Title</label>
									<input type="text" class="form-control form-control-sm" name="title" id="title">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Contact Person</label>
									<input type="text" class="form-control form-control-sm" name="contact_person" id="contact_person">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="email" class="form-control form-control-sm" name="email" id="email">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Phone</label>
									<input type="number" class="form-control form-control-sm" name="phone" id="phone">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Fax</label>
									<input type="number" class="form-control form-control-sm" name="fax" id="fax">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Website</label>
									<input type="text" class="form-control form-control-sm" name="website" id="website">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>City</label>
									<input type="text" class="form-control form-control-sm" name="city" id="city">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Country</label>
									<input type="text" class="form-control form-control-sm" name="country" id="country">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<label class="align-self-start mt-2">Address</label>
									<textarea class="form-control" name="address" id="address" rows="5"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Logo</label>
									<div class="custom-file">
										<input id="logo" name="file" type="file" accept="image/x-png,image/jpeg" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
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
			<a href="javascript:void(0)" id="btn_contractor_new" class="btn btn-success btn-sm pull-right">Save</a>
		</div>
	</div>
</div>
@endsection