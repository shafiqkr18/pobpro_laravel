@extends('admin.layouts.default')

@section('title')
	Create Correspondence Address
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
		</ol>

		<h2 class="d-flex align-items-center">Create</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_address_book" enctype="multipart/form-data">

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
									<input type="text" class="form-control form-control-sm" id="first_name" name="first_name">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Middle Name</label>
									<input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Last Name</label>
									<input type="text" class="form-control form-control-sm" id="last_name" name="last_name">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Company Name</label>
									<input type="text" class="form-control form-control-sm" id="company" name="company">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Position</label>
									<input type="text" class="form-control form-control-sm" id="position" name="position">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="email" class="form-control form-control-sm" id="email" name="email">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Country</label>
									<input type="text" class="form-control form-control-sm" id="country" name="country">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Web</label>
									<input type="text" class="form-control form-control-sm" id="website" name="website">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>City</label>
									<input type="text" class="form-control form-control-sm" id="city" name="city">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Avatar</label>
									<div class="custom-file">
										<input id="contact_person_avatar" name="contact_person_avatar" type="file" class="custom-file-input form-control-sm">
										<label for="contact_person_avatar" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label class="align-self-start mt-1">Address</label>
									<textarea name="address" id="address" class="form-control" rows="5"></textarea>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Company Logo</label>
									<div class="custom-file">
										<input id="company_logo" name="company_logo" type="file" class="custom-file-input form-control-sm">
										<label for="company_logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
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
				<a href="javascript:void(0)" id="save_address_book" class="btn btn-sm btn-success ml-auto">Save</a>
			</div>
		</div>

	</form>
</div>

@endsection