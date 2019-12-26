@extends('admin.layouts.default')

@section('title')
	Create Template
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.custom-radio-tabs {
	display: flex;
	flex-wrap: nowrap;
}

.custom-radio-tabs input {
	position: absolute;
  left: -99999px;
  top: -99999px;
  opacity: 0;
  z-index: -1;
	visibility: hidden;
}

.custom-radio-tabs label {
	cursor: pointer;
	padding: 8px 15px;
	font-size: 13px;
	border: 1px solid rgba(24,28,33,0.06);
	margin: 0;
	line-height: 1;
}

.custom-radio-tabs input[type=radio]:checked+label {
  background-color: #e6e6e6;
  z-index: 1;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	$('.summernote').summernote({
		toolbar: [
			// [groupName, [list of button]]
			['style', ['bold', 'italic', 'underline', 'clear']],
			['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['insert', ['link']],
			['view', ['codeview']],
		]
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
				Settings
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/templates') }}">Templates</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/templates') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Create Template
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Template Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_template" enctype="multipart/form-data">
						<input type="hidden" id="reference_no" name="reference_no" value="{{ $data['ref_no'] }}">
						<input type="hidden" name="contents">

						<div class="row">
							<div class="col-sm-8 b-r">
								<div class="form-group form-inline">
									<label>Type</label>
									<div class="custom-radio-tabs">
										<input type="radio" name="type" id="offer" value="offer" checked><label for="offer">Offer</label>
										<input type="radio" name="type" id="contract" value="contract"><label for="contract">Contract</label>
									</div>
								</div>

								<div class="form-group form-inline">
									<label>Template name</label>
									<input type="text" class="form-control form-control-sm" name="template_name" id="template_name">
								</div>

								<div class="form-group form-inline">
									<label>Subject</label>
									<input type="text" class="form-control form-control-sm" name="subject" id="subject">
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start">Message</label>
									<div class="summernote">
										<p>Dear {applicant_name},</p>
										<br>
										<p>Content here.</p>
										<br>
										<p>
											-<br>
											{company_name}
										</p>
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									<label>Variables</label>
									<p>You can use these variables in the content of the letter. It will be replaced by real data when sending the email.</p>

									<p>
										{applicant_name} - Candidate name<br>
										{company_name} - Company name<br>
										{job_title} - Job title<br>
										{report_to} - Reporting to<br>
										{join_date} - Joining date<br>
										{location} - Work location<br>
										{offer_amount} - Offer amount<br>
										{work_type} - Work type (full time or part time)<br>
										{level} - Level<br>
										{rotation_type} - Rotation type<br>
										{view_link} - Link for URL<br>
									</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_template" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection