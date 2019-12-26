@extends('admin.layouts.default')

@section('title')
	View Contract
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/company-contracts.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/company-contracts.js') }}"></script>
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

			{{ $contract->tender_title }}

			<a href="{{ url('admin/contracts-mgt/contract/update/' . $contract->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/contracts-mgt/contract/delete/' . $contract->id) }}">
				<i class="far fa-trash-alt mr-1"></i>
				Delete
			</a>
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
					<form role="form" enctype="multipart/form-data">
						<input type="hidden" name="is_update" value="1">
						<input type="hidden" name="contract_id" value="{{ $contract->id }}">

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Tender No.</label>
									<p class="form-control-static font-weight-bold">{{ $contract->tender_reference }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Tender Title</label>
									<p class="form-control-static font-weight-bold">{{ $contract->tender_title }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Department</label>
									<p class="form-control-static font-weight-bold">{{ $contract->department ? $contract->department->department_short_name : '' }}</p>
								</div>
							</div>
					
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Contractor</label>
									<p class="form-control-static font-weight-bold">{{ $contract->contractor ? $contract->contractor->title : '' }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Amount</label>
									<p class="form-control-static font-weight-bold">{{ $contract->amount }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Currency</label>
									<p class="form-control-static font-weight-bold">{{ $contract->currency }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Start Date</label>
									<p class="form-control-static font-weight-bold">{{ date('m/d/Y', strtotime($contract->start_date)) }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>End Date</label>
									<p class="form-control-static font-weight-bold">{{ date('m/d/Y', strtotime($contract->end_date)) }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Location</label>
									<p class="form-control-static font-weight-bold">{{ $contract->location }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Primary Term</label>
									<p class="form-control-static font-weight-bold">{{ $contract->primary_term }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<label class="align-self-start">Summary</label>
									<p class="form-control-static font-weight-bold">{{ $contract->notes }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Attachment</label>
									@php 
									$file = $contract && $contract->attachments ? json_decode($contract->attachments, true) : null;
									@endphp
									<div class="custom-file">

										@if ($file)
										<a href="{{ asset('/storage/' . $file[0]['download_link']) }}" target="_blank" class="d-inline-block text-success font-weight-bold mt-2">{{ $file[0]['original_name'] }}</a>
										@endif
									</div>
								</div>
							</div>
						</div>

					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection