@extends('admin.layouts.default')

@section('title')
	View Correspondence Address
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function(){

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
				Correspondence Mgt.
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/correspondence/address') }}">Correspondence Address</a>
			</li>
			<li class="breadcrumb-item">
				<strong>View</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/correspondence/address') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			{{ $address->getName() }}

			<a href="{{ url('admin/correspondence/address/update/' . $address->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>

			<!-- <a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/correspondence/address/delete/' . $address->id) }}">
				<i class="far fa-trash-alt mr-1"></i>
				Delete
			</a> -->
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_division" enctype="multipart/form-data">

		<div class="row">
			<div class="col-lg-12">

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Personal Information</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted">First Name</label>
									<p class="form-control-static font-weight-bold">{{ $address->first_name }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted">Middle Name</label>
									<p class="form-control-static font-weight-bold">{{ $address->middle_name }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted">Last Name</label>
									<p class="form-control-static font-weight-bold">{{ $address->last_name }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted">Company Name</label>
									<p class="form-control-static font-weight-bold">{{ $address->company }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted">Position</label>
									<p class="form-control-static font-weight-bold">{{ $address->position }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted">Email</label>
									<p class="form-control-static font-weight-bold">{{ $address->email }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="text-muted">Country</label>
									<p class="form-control-static font-weight-bold">{{ $address->country }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted">City</label>
									<p class="form-control-static font-weight-bold">{{ $address->city }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start mt-1">Address</label>
									<p class="form-control-static font-weight-bold">{{ $address->address }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted">Web</label>
									<p class="form-control-static font-weight-bold">{{ $address->website }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start mt-2">Avatar</label>
									@php
									$avatar = $address->contact_person_avatar ? json_decode($address->contact_person_avatar, true) : null;
									@endphp

									@if ($avatar)
									<img alt="image" class="rounded-circle m-t-xs img-fluid" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" style="width: 72px; height: 72px; object-fit: cover;">
									@endif
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start mt-2">Company Logo</label>
									@php
									$company_logo = $address->company_logo ? json_decode($address->company_logo, true) : null;
									@endphp
									
									@if ($company_logo)
									<img alt="image" class="rounded-circle m-t-xs img-fluid" src="{{ asset('/storage/' . $company_logo[0]['download_link']) }}" style="width: 72px; height: 72px; object-fit: cover;">
									@endif
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

	</form>
</div>

@endsection