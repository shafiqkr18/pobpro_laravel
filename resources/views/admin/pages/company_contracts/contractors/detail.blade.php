@extends('admin.layouts.default')

@section('title')
	View Contractor
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
				<a href="{{ url('admin/contracts-mgt/contractors') }}">Contractor Management</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/contracts-mgt/contractors') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			{{ $contractor->title }}
			
			<a href="{{ url('admin/contracts-mgt/contractor/employees/' . $contractor->id) }}" class="btn btn-white btn-sm ml-auto">
				<i class="fas fa-user mr-1"></i> Employees
			</a>

			<a href="" class="btn btn-white btn-sm ml-2">
				<i class="fas fa-globe mr-1"></i> Visa
			</a>

			<a href="" class="btn btn-white btn-sm ml-2">
				<i class="fas fa-bed mr-1"></i> Accommodation
			</a>

			<a href="{{ url('admin/contracts-mgt/contractor/update/' . $contractor->id) }}" class="btn btn-success btn-sm ml-2">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/contracts-mgt/contractor/delete/' . $contractor->id) }}">
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
					<h5>Contractor Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Reference No.</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->reference_number }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Title</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->title }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Contact Person</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->contact_person }}</p>
								</div>
							</div>
						
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Email</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->email }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Phone</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->phone }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Fax</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->fax }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Website</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->website }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>City</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->city }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Country</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->country }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<label class="align-self-start">Address</label>
									<p class="form-control-static font-weight-bold">{{ $contractor->address }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="align-self-start">Logo</label>
									@php 
									$file = $contractor && $contractor->logo ? json_decode($contractor->logo, true) : null;
									@endphp
										
									@if ($file)
									<img src="{{ asset('/storage/' . $file[0]['download_link']) }}" class="img-fluid" alt="" style="max-height: 110px;">
									@endif
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