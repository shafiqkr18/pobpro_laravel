@extends('frontend.layouts.candidate')

@section('title')
	View Question
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

.more-info p {
	font-weight: 700;
}

.card.candidate {
	background: none;
}

#questions_accordion .card {
	background: none;
}

#questions_accordion .card-header {
	border-width: 1px !important;
}

#questions_accordion .card-header h2 button {
	font-size: 13.5px !important;
}

#questions_accordion .card-body {
	font-size: 12.5px !important;
}

.form-control:focus {
	background: #fff !important;
}

#search {
	width: 250px !important;
}

.note-editor.card {
	border: 1px solid #dee2e6!important;
}

.note-toolbar.card-header {
	border-radius: 0 !important;
	border: 0 !important;
}

.has-error .form-control {
	border-color: #ed5565;
}

.has-error .note-editor.note-frame {
	border-color: #ed5565 !important;
}

p.form-control-static font-weight-bold,
.more-info,
.more-info p {
	font-size: 12.5px;
	font-weight: normal;
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
$status_class = ['', 'primary', 'default'];
@endphp

@section('content')
<div class="card candidate">
	<h6 class="card-header pt-2 pb-2">
		{{ $question->title }}
	</h6>

	<form role="form" id="frm_question" enctype="multipart/form-data">
		<div class="card-body p-3 bg-white border mt-4">

			<div class="form-row">
				<div class="col-lg-12">
					<!-- <form role="form" id="frm_question" enctype="multipart/form-data"> -->
						@csrf
						<input type="hidden" name="status_id">
						<input type="hidden" name="content">

						<div class="ibox">
							<!-- <div class="ibox-title">
								<h5>Question Details</h5>
								<div class="ibox-tools">

								</div>
							</div> -->

							<div class="ibox-content">
								<div class="sk-spinner sk-spinner-three-bounce">
									<div class="sk-bounce1"></div>
									<div class="sk-bounce2"></div>
									<div class="sk-bounce3"></div>
								</div>
								
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<label class="text-muted mb-0">Category</label>
											<p class="form-control-static font-weight-bold">{{ $question->category->name }}</p>
										</div>
									</div>

									<div class="col-lg-3">
										<div class="form-group">
											<label class="text-muted mb-0">Created By</label>
											<p class="form-control-static font-weight-bold">{{ $question->createdBy->name }}</p>
										</div>
									</div>

									<div class="col-lg-3">
										<div class="form-group">
											<label class="text-muted mb-0">Created Date</label>
											<p class="form-control-static font-weight-bold">{{ date('Y-m-d', strtotime($question->created_at)) }}</p>
										</div>
									</div>

									<div class="col-lg-3">
										<div class="form-group">
											<label class="text-muted mb-0 d-block">Status</label>
											<div class="badge badge-{{ $status_class[$question->status_id] }}">{{ $question->status->status_name }}</div>
										</div>
									</div>
								</div>

								<div class="row mt-2">
									<div class="col-lg-12">
										<div class="form-group more-info font-weight-bold">
											<!-- <label class="text-muted mb-0">More information</label> -->
											@php
											echo $question->content;
											@endphp
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label class="text-muted mb-0">Attachments</label>
											<p class="form-control-static font-weight-bold">
												@if ($attachments)
													@foreach ($attachments as $attachment)
														{{ $loop->index > 0 ? ', ' : '' }}
														<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="d-inline-block text-success">{{ $attachment['original_name'] }}</a>
													@endforeach
												@else
												{{ 'No attachments.' }}
												@endif
											</p>
										</div>
									</div>
								</div>

								<hr>

								<div class="row">
									<div class="col-lg-12">
										<label class="text-success mb-0">Answer</label>
										@if (count($question->answer) > 0)
										<div class="more-info">
											@foreach ($question->answer as $answer)
												@php
												echo $answer->content;
												@endphp
											@endforeach
										</div>
										@else
										<p class="form-control-static font-weight-bold">No answer yet.</p>
										@endif
									</div>
								</div>
							</div>

						</div>

					<!-- </form> -->
				</div>

			</div>

		</div>
	</form>

</div>
@endsection