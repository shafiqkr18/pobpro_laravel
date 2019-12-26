@extends('admin.layouts.default')

@section('title')
	Update Passport
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<style>
	.hide {
		display: none;
	}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
	<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{mt_rand(1000000, 9999999)}}"></script>
	<script src="{{ URL::asset('js/operations/dropdowns.js?version=') }}{{mt_rand(10000000, 99999999)}}"></script>
<script>

$(document).ready(function(){

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});

});
</script>
@endsection

@php
$file = $passport && $passport->attachments ? json_decode($passport->attachments, true) : null;
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/passport-management') }}">Passport Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/passport-management') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $passport->passport_number }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<form role="form" id="frm_user" enctype="multipart/form-data">
				<input type="hidden" name="is_update" value="1">
				<input type="hidden" name="passport_id" value="{{ $passport->id }}">
				@csrf

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Passport Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Passport Number</label>
									<input type="text" class="form-control form-control-sm" id="passport_number" name="passport_number" autocomplete="off" value="{{ $passport->passport_number }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>User</label>
									<select name="user_id" id="user_id" class="form-control form-control-sm">
										@if (count($users) > 0)
											<option value=""></option>
											@foreach ($users as $user)
											<option value="{{ $user->id }}" {{ $passport->user_id == $user->id ? 'selected' : '' }}>{{ $user->getName() }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Issue Date</label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" name="issue_date" id="issue_date" value="{{ date('Y-m-d', strtotime($passport->issue_date)) }}" />
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Expiry Date</label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" name="expiry_date" id="expiry_date" value="{{ date('Y-m-d', strtotime($passport->expiry_date)) }}" />
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Date of Birth</label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" name="date_of_birth" id="date_of_birth" value="{{ date('Y-m-d', strtotime($passport->date_of_birth)) }}" />
									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Place of Birth</label>
									<input type="text" class="form-control form-control-sm" id="place_of_birth" name="place_of_birth" autocomplete="off" value="{{ $passport->place_of_birth }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Place of Issue</label>
									<input type="text" class="form-control form-control-sm" id="place_of_issue" name="place_of_issue" autocomplete="off" value="{{ $passport->place_of_issue }}">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Attachment</label>
									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">{{ $file ? 'Update file' : 'Choose file...' }}</label>
										@if ($file)
										<a href="{{ asset('/storage/' . $file[0]['download_link']) }}" target="_blank" class="d-inline-block text-success font-weight-bold mt-2">{{ $file[0]['original_name'] }}</a>
										@endif
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Is Primary</label>
									<div class="i-checks mr-5"><label> <input type="checkbox" name="is_primary"> <i></i> </label></div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="save_user" class="btn btn-success btn-sm pull-right">Save</a>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection