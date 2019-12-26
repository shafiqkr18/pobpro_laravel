@extends('admin.layouts.default')

@section('title')
	Update PDF Template
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
				<a href="{{ url('admin/pdf-templates') }}">PDF Templates</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/pdf-templates') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $template->reference_no }}
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
						<input type="hidden" name="is_update" value="1">
						<input type="hidden" name="listing_id" value="{{ $template->id }}">
						<input type="hidden" id="reference_no" name="reference_no" value="{{ $template->reference_no }}">
						<input type="hidden" name="summary">

						<div class="row">
							<div class="col-sm-8 b-r">
								<div class="form-group form-inline">
									<label>Type</label>
									<div class="custom-radio-tabs">
										<input type="radio" name="type" id="offer" value="offer" {{ $template->type == 'offer' ? 'checked' : '' }}><label for="offer">Offer</label>
										<input type="radio" name="type" id="contract" value="contract" {{ $template->type == 'contract' ? 'checked' : '' }}><label for="contract">Contract</label>
									</div>
								</div>

								<div class="form-group form-inline">
									<label>Title</label>
									<input type="text" class="form-control form-control-sm" name="title" id="title" value="{{ $template->title }}">
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start">Message</label>
									<div class="summernote">
										@php
											echo $template->summary;
										@endphp
									</div>
								</div>
							</div>

							<div class="col-sm-4">
								<!-- <div class="form-group">
									<label>Template name</label>
									<input type="text" class="form-control form-control-sm" name="template_name" id="template_name">
								</div> -->

								<div class="form-group">
									<label>Variables</label>
									<p>You can use these variables in the content of the letter. It will be replaced by real data when sending the email.</p>

									<p>
										{date} - Date
										{name} - Candidate name<br>
										{email} - Candidate email<br>
										{position} - Position / Job Title<br>
										{effective_date} - Effective date<br>
										{contract_end_date} - Contract end date<br>
										{days_work} - Continuous days work<br>
										{days_leave} - Continuous days leave<br>
                                        {salary} - Monthly salary<br>
                                        {pay_type} - Pay Type (Monthly/Daily)<br>
                                        {pay_days} - Pay Days
									</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_pdftemplate" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection