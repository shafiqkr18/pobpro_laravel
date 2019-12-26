@extends('admin.layouts.default')

@section('title')
	Update Question
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.plan-position-placeholder {
	display: none;
}

#positions .form-row:nth-child(even) {
	background: #f8f9fa;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		todayHighlight: true,
		startDate: 'today'
	});

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.summernote').summernote({
		minHeight: 200,
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

@php
$attachments = $question->attachments ? json_decode($question->attachments, true) : null;
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item text-muted">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/questions') }}">Questions</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Update</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/questions') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Update Question
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="form-row">
		<div class="col-lg-12">
			<form role="form" id="frm_question" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="is_update" value="1">
				<input type="hidden" name="listing_id" value="{{ $question->id }}">
				<input type="hidden" name="status_id">
				<input type="hidden" name="content">

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Question Details</h5>
						<div class="ibox-tools">

						</div>
					</div>

					<div class="ibox-content">
						<div class="sk-spinner sk-spinner-three-bounce">
							<div class="sk-bounce1"></div>
							<div class="sk-bounce2"></div>
							<div class="sk-bounce3"></div>
						</div>
						
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label>The question in one sentence</label>
									<input type="text" class="form-control form-control-sm" name="title" id="title" value="{{ $question->title }}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Category</label>
									<select name="category_id" id="category_id" class="form-control form-control-sm" size>
									@foreach ($categories as $category)
										<option value="{{ $category->id }}" {{ $question->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
									@endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="align-self-start">More information about the question</label>
									<div class="summernote" id="content">
										@php
										echo $question->content;
										@endphp
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Attachments</label>
									<div class="custom-file">
										<input id="attachment" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
										<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
									@if ($attachments)
										@foreach ($attachments as $attachment)
											{{ $loop->index > 0 ? ', ' : '' }}
											<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="d-inline-block text-success ml-2">{{ $attachment['original_name'] }}</a>
										@endforeach
									@endif
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="row mt-3">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="save_question" class="btn btn-success btn-sm pull-right" data-status="1">Submit</a>
						<a href="javascript:void(0)" id="save_question_draft" class="btn btn-success btn-outline btn-sm pull-right mr-2" data-status="2">Save as draft</a>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
@endsection