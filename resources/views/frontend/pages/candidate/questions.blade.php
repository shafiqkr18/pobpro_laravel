@extends('frontend.layouts.candidate')

@section('title')
	Q &amp; A
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
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

#questions_accordion .card-body {
	font-size: 12.5px !important;
}

.form-control:focus {
	background: #fff !important;
}

#search {
	width: 250px !important;
}

.dashboard-content .accordion .card .card-header h2 button {
	font-size: 12px !important;
	color: #747474 !important;
	font-weight: lighter !important;
	white-space: unset;
	position: relative;
}

.dashboard-content .accordion .card .card-header h2 button:hover,
.dashboard-content .accordion .card .card-header h2 button:focus {
	text-decoration: none;
}

.dashboard-content .accordion .card .card-header h2 button i {
	position: absolute;
	top: 5px;
	left: -15px;
	font-size: 8px;
}

h6.card-header {
	font-size: 15px !important;
	color: #4c4c4c !important;
	font-weight: bold !important;
	padding-bottom: 20px;
}

.question .date {
	font-size: 11px;
	color: #4c4c4c;
	opacity: 0.5;
}

.question .title {
	font-size: 12px;
	color: #383838;
	font-weight: bold;
}

.question .text-warning {
	color: #ec9e46;
}

.question .content {
	font-size: 12px;
	margin-bottom: 0;
}

.question label {
	font-size: 12px;
	font-weight: bold;
}

.question .attachment {
	font-size: 12px;
	display: inline-block;
}

.answer {
	font-size: 12px;
	color: #858585;
	font-weight: lighter;
	margin-bottom: 10px;
}

.answer p {
	margin-bottom: 5px;
}

.answer .trimmed,
.answer.expand .full {
	display: inline-block
}

.answer .full,
.answer.expand .trimmed {
	display: none;
}

.answer small {
	cursor: pointer;
	color: #585858;
}

input, 
textarea, 
select,
.custom-file-label {
	background-color: #f0f0f0 !important;
	border: 0 !important;
}

input.form-control:focus, 
textarea.form-control:focus, 
select.form-control:focus {
	background: #f0f0f0 !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
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

	$(document).on('click', '.answer small', function () {
		$(this).closest('.answer').toggleClass('expand');

		// if ($(this).closest('.answer').hasClass('expand')) {
		// 	$(this).text('Read less');
		// }
		// else {
		// 	$(this).text('Read more');
		// }
	});
});
</script>
@endsection

@section('content')
<div class="card candidate">
	<!-- <h6 class="card-header pt-2 pb-2">
		Q &amp; A
	</h6> -->

	<div class="card-body p-0 border-0">

		<div class="row">
			<div class="col-sm-8 border-right pr-5">
				<h6 class="card-header text-dark pl-0">
					<img src="{{ URL::asset('frontend/img/icon-query.png') }}" srcset="{{ URL::asset('frontend/img/icon-query.png') }} 1x, {{ URL::asset('frontend/img/icon-query@2x.png') }} 2x" class="img-fluid mr-2">
					Ask your queries
				</h6>

				<form role="form" id="frm_question" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="status_id">
					<input type="hidden" name="question_type" value="private">

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<select name="category_id" id="category_id" class="form-control form-control-sm">
									<option value="0">Choose Category</option>
									@foreach ($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<input type="text" class="form-control" name="title" id="title" placeholder="Type your question in one line">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<textarea name="content" id="content" rows="5" class="form-control" placeholder="Type your questions here"></textarea>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<div class="custom-file">
									<input id="attachment" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
									<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Attachments</label>
								</div>
							</div>
						</div>
					</div>
				</form>

				<div class="row mb-4">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="save_question" class="btn btn-info rounded btn-sm pull-right" data-status="1">Submit</a>
						<!-- <a href="javascript:void(0)" id="save_question_draft" class="btn btn-secondary rounded btn-outline btn-sm pull-right mr-2" data-status="2">Save as draft</a> -->
					</div>
				</div>
				
				<h6 class="card-header text-dark pl-0">
					<img src="{{ URL::asset('frontend/img/icon-my-queries.png') }}" srcset="{{ URL::asset('frontend/img/icon-my-queries.png') }} 1x, {{ URL::asset('frontend/img/icon-my-queries@2x.png') }} 2x" class="img-fluid mr-2">
					My Queries
				</h6>
				
				@if (count($questions) > 0)
					@foreach ($questions as $question)
					@php
					$attachments = $question->attachments ? json_decode($question->attachments, true) : [];
					@endphp
					<div class="question border rounded pt-2 pb-0 pl-4 pr-4 {{ $loop->last ? '' : 'mb-4' }}">
						<span class="date">{{ date('d M Y', strtotime($question->created_at)) }}</span>
						<div class="title font-weight-bold">{{ $question->title }}</div>
						<p class="content">{{ $question->content }}</p>
						@if (count($attachments) > 0)
							@foreach ($attachments as $attachment)
							<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="attachment mr-3 mb-2 text-primary">{{ $attachment['original_name'] }}</a>
							@endforeach
						@endif

						@if (count($question->answer) > 0)
						<label class="text-success mb-0 d-block mt-1">Answer:</label>
							@foreach  ($question->answer as $answer)
							<div class="answer">
								@if (strlen($answer->content) > 160)
									<div class="trimmed">{!! substr($answer->content, 0, 160) !!} <small class="font-weight-bold">Read more</small></div>
									<div class="full">{!! substr($answer->content, 0) !!} <small class="font-weight-bold">Read less</small></div>
								@else
									{!! $answer->content !!}
								@endif

								@php
								$answer_attachments = $answer->attachments ? json_decode($answer->attachments, true) : [];
								@endphp

								@if (count($answer_attachments) > 0)
								<div>
									@foreach ($answer_attachments as $attachment)
									<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="d-inline-block mr-3 text-primary">{{ $attachment['original_name'] }}</a>
									@endforeach
								</div>
								@endif
							</div>
							@endforeach
						@else
						<label class="text-warning mb-3 d-block">Waiting for reply</label>
						@endif
					</div>
					@endforeach
				@else
				<p class="m-0 pt-3 pb-3 pt-3 pl-0"><small>You currently do not have any questions.</small></p>
				<!-- <p class="text-center">
					<a href="{{ url('candidate/question/create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Create Question</a>
				</p> -->
				@endif
			</div>

			<div class="col-sm-4 pl-5 pr-0">
				<h6 class="card-header text-dark pl-3">
					FAQs
				</h6>

				<div class="accordion" id="questions_accordion">
					@if (count($faqs) > 0)
						@foreach ($faqs as $faq)
						<div class="card bg-white mb-4 {{ $loop->index == 0 ? 'mt-2' : '' }}">
							<div class="card-header bg-white border-0 pt-0 pb-1 pl-3 pr-0" id="question_header_{{ $faq->id }}">
							<h2 class="mb-0">
									<button class="btn btn-link p-0 border-0 text-left" type="button" data-toggle="collapse" data-target="#question_{{ $faq->id }}" aria-expanded="{{ $loop->index == 0 ? true : false }}" aria-controls="question_{{ $faq->id }}">
										<i class="fas fa-chevron-right"></i> {{ $faq->title }}
								</button>
							</h2>
						</div>

							<div id="question_{{ $faq->id }}" class="collapse {{ $loop->index == 0 ? 'show' : '' }}" aria-labelledby="question_header_{{ $faq->id }}" data-parent="#questions_accordion">
							<div class="card-body border-0 pt-3 pl-3 pb-3 pr-0">
									{!! $faq->content !!}

									@php
									$faq_attachments = $faq->attachments ? json_decode($faq->attachments, true) : [];
									@endphp
									@if (count($faq_attachments) > 0)
									<div>
										@foreach ($faq_attachments as $attachment)
										<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="d-inline-block mr-3 text-primary">{{ $attachment['original_name'] }}</a>
										@endforeach
									</div>
									@endif
							</div>
						</div>
					</div>
						@endforeach

					@else
					<small class="pl-3">No queries.</small>
					@endif
				</div>

			</div>
		</div>

	</div>
</div>
@endsection