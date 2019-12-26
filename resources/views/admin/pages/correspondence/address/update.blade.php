@extends('admin.layouts.default')

@section('title')
	Update Correspondence Address
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/correspondence_create_forms.js?v=') }}{{rand(11,99)}}"></script>
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
<div class="row wrapper page-heading">
	<div class="col-lg-10">
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
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">{{ $address->u_id }}</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_address_book" enctype="multipart/form-data">
		<input type="hidden" name="id" value="{{ $address->id }}">
        <input type="hidden" name="listing_id" value="{{ $address->id }}">
		<input type="hidden" name="is_update" value="1">

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
									<label>First Name</label>
									<input type="text" class="form-control form-control-sm" id="first_name" name="first_name" value="{{ $address->first_name }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Middle Name</label>
									<input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name" value="{{ $address->middle_name }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Last Name</label>
									<input type="text" class="form-control form-control-sm" id="last_name" name="last_name" value="{{ $address->last_name }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Company Name</label>
									<input type="text" class="form-control form-control-sm" id="company" name="company" value="{{ $address->company }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Position</label>
									<input type="text" class="form-control form-control-sm" id="position" name="position" value="{{ $address->position }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="email" class="form-control form-control-sm" id="email" name="email" value="{{ $address->email }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Country</label>
									<input type="text" class="form-control form-control-sm" id="country" name="country" value="{{ $address->country }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Web</label>
									<input type="text" class="form-control form-control-sm" id="website" name="website" value="{{ $address->website }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>City</label>
									<input type="text" class="form-control form-control-sm" id="city" name="city" value="{{ $address->city }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Avatar</label>
									@php
									$avatar = $address->contact_person_avatar ? json_decode($address->contact_person_avatar, true) : null;
									@endphp
									<div class="custom-file">
										<input id="contact_person_avatar" name="contact_person_avatar" type="file" class="custom-file-input form-control-sm">
										<label for="contact_person_avatar" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
										@if ($avatar)
										<a href="{{ asset('/storage/' . $avatar[0]['download_link']) }}" target="_blank" class="d-flex text-success font-weight-bold"><small>{{ $avatar[0]['original_name'] }}</small></a>
										@endif
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="align-self-start mt-1">Address</label>
									<textarea name="address" id="address" class="form-control" rows="5">{{ $address->address }}</textarea>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Company Logo</label>
									@php
									$company_logo = $address->company_logo ? json_decode($address->company_logo, true) : null;
									@endphp
									<div class="custom-file">
										<input id="company_logo" name="company_logo" type="file" class="custom-file-input form-control-sm">
										<label for="company_logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
										@if ($company_logo)
										<a href="{{ asset('/storage/' . $company_logo[0]['download_link']) }}" target="_blank" class="d-flex text-success font-weight-bold"><small>{{ $company_logo[0]['original_name'] }}</small></a>
										@endif
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-12 d-flex align-items-center">
				<a href="javascript:void(0)" id="save_address_book"  class="btn btn-sm btn-success ml-auto">Save</a>
			</div>
		</div>

	</form>
</div>

@endsection