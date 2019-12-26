@extends('admin.layouts.default')

@section('title')
	View Section
@endsection

@section('scripts')
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{mt_rand(1000000, 9999999)}}"></script>
<script src="{{ URL::asset('js/operations/dropdowns.js?version=') }}{{mt_rand(10000000, 99999999)}}"></script>
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
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Settings
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/section-management') }}">Section Management</a>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">
			{{ $section->short_name }}
			<a href="{{ url('admin/section-management/update/' . $section->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/section-management/delete/' . $section->id) }}">
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
					<h5>Section Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_section" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">



								<div class="form-group form-inline">
									<label class="text-muted mb-0">Organization </label>
									<p class="form-control-static font-weight-bold">{{ $section->getOrg($section->org_id) }}</p>
								</div>
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Division </label>
									<p class="form-control-static font-weight-bold">{{ $section->getDivision($section->div_id) }}</p>
								</div>
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Department </label>
									<p class="form-control-static font-weight-bold">{{ $section->department->department_short_name }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Section Code</label>
									<p class="form-control-static font-weight-bold">{{ $section->section_code }}</p>
								</div>
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Short Name</label>
									<p class="form-control-static font-weight-bold">{{ $section->short_name }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Full Name</label>
									<p class="form-control-static font-weight-bold">{{ $section->full_name }}</p>
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