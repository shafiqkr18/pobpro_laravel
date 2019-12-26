@extends('admin.layouts.default')

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

.more-info,
.more-info p {
	font-weight: 700;
}

.more-info:not(:last-child) {
	margin-bottom: 16px;
	border-bottom: 1px solid #eee;
}

.more-info p {
	margin-bottom: 16px;
}

.hide {
	display: none !important;
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

	$(document).on('click', '.show-answer-field', function (e) {
		e.preventDefault();
		toggleAnswerField(true);
	});

	$(document).on('click', '.hide-answer-field', function (e) {
		e.preventDefault();
		toggleAnswerField(false);
	});

	function toggleAnswerField(display) {
		if (display) {
			$('.show-answer-field').addClass('hide');
			$('.answer-field').removeClass('hide');
		}
		else {
			$('.show-answer-field').removeClass('hide');
			$('.answer-field').addClass('hide');
		}
	}


    $(".submit-answer").click(function (e) {
        e.preventDefault();

        $('input[name="content_answer"]').val($('.summernote').summernote('code'));

        $(".validation_error").hide();
        //let queryString =  $("#frm_contract").serialize();
        let formData = new FormData($('#frm_answer')[0]);
        $.ajax({
            /* the route pointing to the post function */
            url: baseUrl + '/admin/save_question_answer',
            type: 'POST',
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.success == false) {
                    if (data.errors) {
                        toastr.warning("Fill the required fields!");
                        jQuery.each(data.errors, function (key, value) {
                            //$('#'+key).addClass('text-danger');
                            $('#' + key).addClass('has-error');

                        });

                    } else {
                        //Show toastr message
                        toastr.error("Error Saving Data");
                    }
                } else {
                    var msg = data.is_update ? 'Answer data updated.' : 'Answer Saved';
                    toastr.success(msg, 'Success!');
                    setTimeout(function () {
                       // window.location.href = baseUrl + '/admin/questions';
                        window.location.href = baseUrl + '/admin/question/detail/' + data.question_id;
                    }, 1000);

                }

            }
        });
    });

});
</script>
@endsection

@php
$attachments = $question->attachments ? json_decode($question->attachments, true) : null;
$status_class = ['', 'primary', 'default'];
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
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
			View Question
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<a href="{{ url('admin/question/update/' . $question->id) }}" class="btn btn-success btn-sm ml-1">
			<i class="fas fa-pen-square mr-1"></i>
			Edit
		</a>

		<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm ml-2" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/question/delete/' . $question->id) }}">
			<i class="far fa-trash-alt mr-1"></i>
			Delete
		</a>
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
						<h5>{{ $question->title }}</h5>
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
									<label class="text-muted mb-0">Category</label>
									<p class="form-control-static font-weight-bold">{{ $question->category->name }}</p>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Created By</label>
									<p class="form-control-static font-weight-bold">{{ $question->createdBy->name }}</p>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Created Date</label>
									<p class="form-control-static font-weight-bold">{{ date('Y-m-d', strtotime($question->created_at)) }}</p>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="text-muted mb-0 d-block">Status</label>
									<div class="badge badge-{{ $status_class[$question->status_id] }}">{{ $question->status->status_name }}</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group more-info form-inline">
									<label class="text-muted mb-0 font-weight-normal">More information</label>
									@php
									echo $question->content;
									@endphp
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
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
					</div>

				</div>
			</form>

			@if (count($question->answer) > 0)
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title">
							<h5>Answer</h5>
						</div>

						<div class="ibox-content">
							<input type="hidden" name="content[]">
							
							@foreach ($question->answer as $answer)
							<div class="more-info">
								{!! $answer->content !!}

								@php
								$answer_attachments = $answer->attachments ? json_decode($answer->attachments, true) : null;
								@endphp

								<p class="form-control-static">
								@if ($answer_attachments)
									@foreach ($answer_attachments as $attachment)
										{{ $loop->index > 0 ? ', ' : '' }}
										<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="d-inline-block text-success">{{ $attachment['original_name'] }}</a>
									@endforeach
								@else
								{{ 'No attachments.' }}
								@endif
								</p>
							</div>
							@endforeach
							
						</div>
					</div>
				</div>
			</div>
			@endif

			<div class="row answer-btn-wrap mt-3">
				<div class="col-lg-12">
					<a href="" class="btn btn-primary btn-sm show-answer-field">{{ count($question->answer) > 0 ? 'Add answer' : 'Answer this question' }}</a>
				</div>
			</div>

			<div class="answer-field hide">
				<form role="form" id="frm_answer" enctype="multipart/form-data">
					<input type="hidden" name="question_id" value="{{ $question->id }}">
					@csrf
					<div class="ibox">
						<div class="ibox-title">
							<h5>Answer</h5>
						</div>

						<div class="ibox-content">
							<input type="hidden" name="content_answer">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-0">
										<div class="summernote" id="answer">

										</div>
									</div>
								</div>
							</div>

							

							<div class="row mt-4">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Attachments</label>
										<div class="custom-file">
											<input id="attachment" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
											<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
										</div>
									</div>
								</div>

								<div class="col-lg-4">
									<div class="form-group">
										<label>&nbsp;</label>
										<select name="question_type" id="question_type" class="form-control form-control-sm">
											<option value="private" {{ $question->question_type == 'private' ? 'selected' : '' }}>Private</option>
											<option value="public" {{ $question->question_type == 'public' ? 'selected' : '' }}>Public</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row mt-3">
						<div class="col-lg-12">
							<a href="" class="btn btn-sm btn-primary float-right submit-answer ml-2">Submit</a>
							<a href="" class="btn btn-sm btn-secondary btn-outline float-right hide-answer-field">Cancel</a>
						</div>
					</div>
				</form>
			</div>

		</div>

	</div>
</div>
@endsection