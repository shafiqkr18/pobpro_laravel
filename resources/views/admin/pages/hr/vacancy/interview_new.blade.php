@extends('admin.layouts.default')

@section('title')
	Interview
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<style>
.form-inline.form-group > label {
	flex: 0 0 40%;
	width: 40%;
}

/* .form-inline.form-group > input,
.form-inline.form-group > .input-group {
	flex: 0 0 50%;
	width: 50%;
} */

.form-inline.form-group input {
	font-size: 12.5px;
}

ul.how-it-works li {
	position: relative;
}

ul.how-it-works li:before {
	content: '-';
	position: absolute;
	left: 0;
}

#interval {
	max-width: 50px;
}

.schedule-list li .schedule,
.schedule-list li .name {
	width: 50%;
}

.preview-list {
	display: none;
}

form.ibox-content {
	background: none !important;
}

.note-editor.note-frame,
.chosen-container-multi .chosen-choices {
	-webkit-border-radius: 0;
	border-radius: 0;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		todayHighlight: true,
		startDate: 'today'
	});

	var interviewDate = '',
			start = '',
			startTime = '',
			endTime = '';

	$('.clockpicker').clockpicker({
		afterDone: function() {
			startTime = $('#start_time').val();
			endTime = $('#end_time').val();

			calculateInterval();
		}
	});

	// var l = $('.ladda-button').ladda();

	$(document).on('change', '#interview_date', function (e) {
		e.preventDefault();

		interviewDate = $(this).val();
		calculateInterval();
	});

	$(document).on('blur', '#start_time, #end_time', function (e) {
		e.preventDefault();

		startTime = $('#start_time').val();
		endTime = $('#end_time').val();
		calculateInterval();
	});

	function calculateInterval() {
		// console.log(interviewDate);
		// console.log(startTime);
		// console.log(endTime);

		if (interviewDate != '' && startTime != '' && endTime != '') {
			start = new Date(interviewDate + ' ' + startTime);
			var end = new Date(interviewDate + ' ' + endTime);

			if (start > end) {
				console.log('end time can not be before start time');
				$('#interview-schedule-modal').modal('show');
				$('#interval').val('');
				$('input[name="start"]').val('');
			}
			else {
				var diff = (end - start) / 1000;
				var mins = diff / 60;

				var interval = Math.floor(mins / $('.number-of-candidates').text());
				$('#interval').val(interval);
				$('input[name="start"]').val(start / 1000);

				var _ids = $('input[name="ids"]').val();
				var candidateIds = _ids.split(',');
				candidateIds.sort(function(a, b){return a-b});
				$.each(candidateIds, function( index, value ) {
					var st = new Date(start);
					st.setMinutes(st.getMinutes() + (index * interval));
					$('.schedule-list').find('li[data-id="' + value + '"]').find('.schedule').html((st.getMonth() + 1) + '/' + st.getDate() + '/' + st.getFullYear() + ' ' + (st.getHours() < 10 ? '0' : '') + st.getHours() + ':' + (st.getMinutes() < 10 ? '0' : '') + st.getMinutes());
				});
			}

		}
		else {
			console.log('missing fields');
			$('#interval').val('');
			$('input[name="start"]').val('');
		}
	}

	$(document).on('click', '.save-interview', function (e) {
		e.preventDefault();

		var $this = $(this);
		$this.addClass('disabled');

		var iboxContent = $('.ibox-content');
		iboxContent.toggleClass('sk-loading');

		$('input[name="notes"]').val($('.summernote').summernote('code'));

		$.ajax({
			url: $('#interview-form').attr('action'),
			type: 'POST',
			dataType: "JSON",
			data: new FormData($('#interview-form')[0]),
			processData: false,
			contentType: false,
			success: function (data) {
				$this.removeClass('disabled');
				iboxContent.toggleClass('sk-loading');

				if(data.success == false) {

					if(data.errors)
					{
						toastr.warning("Fill the required fields!");
						jQuery.each(data.errors, function( key, value ) {
							//$('#'+key).addClass('text-danger');
							$('#'+key).closest('.form-group').addClass('has-error');
							// let varSlid = "validation_error";
							// $('#'+key).after('<span class="' + varSlid  + '">'+
							//     value+'</span>');
						});

					}else{
						//Show toastr message
						toastr.error("Error Saving Data");
					}
				}else{
                    //jonas: hide processing image here
					toastr.success(data.message, 'Success');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/interview/detail/' + data.interview_id;
					}, 1000);
				}

			}
		});

	});

	$(document).on('click', '.preview-interview', function (e) {
		e.preventDefault();

		if ($(this).hasClass('previewed')) {
			$('.preview-list').css('display', 'none');
			$('.hide-on-preview').css('display', 'block');

			$('.col-md-4.expand-on-preview').removeClass('col-md-4').addClass('col-md-3');
			$('.col-md-7.expand-on-preview').removeClass('col-md-7').addClass('col-md-6');

			$('.hide-on-preview').css('display', 'block');
			$(this).addClass('previewed');
			$(this).text('Preview');
		}
		else {
			$('.preview-list').css('display', 'block');
			$('.hide-on-preview').css('display', 'none');

			$('.col-md-3.expand-on-preview').removeClass('col-md-3').addClass('col-md-4');
			$('.col-md-6.expand-on-preview').removeClass('col-md-6').addClass('col-md-7');

			$('.hide-on-preview').css('display', 'none');
			$(this).addClass('previewed');
			$(this).text('<< Previous Step');
		}

	});

	$(document).on('click', '.go-back', function (e) {
		e.preventDefault();
		window.history.back();
	});

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

	$('.chosen-select').chosen({width: "100%"});

});
</script>
@endsection

@php
$_ids = explode(',', $data['ids']);
@endphp

@section('content')
<div class="ibox">
	<div class="ibox-title">
		<h5>Schedule Interview Meetings</h5>
	</div>
</div>

<form id="interview-form" action="{{ url('admin/save_interview') }}" class="ibox-content p-0 border-0">
	<div class="sk-spinner sk-spinner-three-bounce">
		<div class="sk-bounce1"></div>
		<div class="sk-bounce2"></div>
		<div class="sk-bounce3"></div>
	</div>

	<input type="hidden" name="start">
	<input type="hidden" name="ids" value="{{ $data['ids'] }}">
    <input type="hidden" name="plan_id" value="{{$data['plan_id']}}">
    <input type="hidden" name="position_id" value="{{$data['position_id']}}">
	<div class="row mb-3">
		<div class="col-md-3 expand-on-preview">
			<h5>Schedule Planning:</h5>

			<div class="ibox mb-0 hide-on-preview">
				<div class="ibox-content">
					<h5 class="mb-4 mt-0 font-weight-bold"><span class="text-warning number-of-candidates">{{ count($_ids) }}</span> persons selected</h5>

					<!-- <form action="" class="form-inline"> -->
						<div class="form-group form-inline d-flex flex-nowrap w-100 mb-1">
							<label for="" class=" justify-content-end pr-2">Date:</label>
							<!-- <input type="text" class="form-control-sm form-control" id="interview_date" name="interview_date" /> -->
							<div class="input-daterange input-group" id="datepicker">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								<input type="text" class="form-control-sm form-control interview-params" id="interview_date" name="interview_date" />
							</div>
						</div>

						<div class="form-group form-inline d-flex flex-nowrap w-100 mb-1">
							<label for="" class=" justify-content-end pr-2">Start Time:</label>
							<div class="input-group clockpicker" data-autoclose="true">
								<input type="text" class="form-control form-control-sm interview-params" id="start_time" name="start_time">
							</div>
						</div>

						<div class="form-group form-inline d-flex flex-nowrap w-100 mb-1">
							<label for="" class=" justify-content-end pr-2">End Time:</label>
							<div class="input-group clockpicker" data-autoclose="true">
								<input type="text" class="form-control form-control-sm interview-params" id="end_time" name="end_time">
							</div>
						</div>

						<div class="form-group form-inline d-flex flex-nowrap w-100 mb-1">
							<label for="" class=" justify-content-end pr-2">Interval:</label>
							<input type="text" class="form-control-sm form-control" id="interval" name="interval" readonly />
							<span class="ml-2">mins</span>
						</div>
					<!-- </form> -->

					<h5 class="mt-5 font-weight-bold">How schedule works:</h5>
					<ul class="list-unstyled how-it-works">
						<li class="pl-4 pr-3 mb-2">Auto skip non-working day</li>
						<li class="pl-4 pr-3 mb-2">Schedule interview time by order</li>
						<li class="pl-4 pr-3 mb-2">Interview invitation letter content will be created by template and sent in background</li>
						<li class="pl-4 pr-3 mb-2">Interviewee can access link by interview detail by link in the email</li>
					</ul>
				</div>
			</div>

			<div class="preview-list">
				<div class="ibox mb-0">
					<div class="ibox-content">
						<h5 class="font-weight-bold"><i class="fa fa-clock-o" style="font-size: 18px"></i> Schedule List</h5>

						<ul class="list-unstyled schedule-list mt-4">
							<li class="d-flex flex-nowrap mb-2">
								<span class="schedule font-weight-bold">Date & Time</span>
								<span class="name font-weight-bold">Name</span>
							</li>
							@if ($data['candidates'])
								@foreach($data['candidates'] as $candidate)
								<li class="d-flex flex-nowrap mb-2" data-id="{{ $candidate->id }}">
									<span class="schedule"></span>
									<span class="name">{{ $candidate->name }}</span>
								</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6 d-flex flex-column expand-on-preview">
			<h5>Subject:</h5>
			<div class="form-group">
				<input type="text" name="subject" id="subject" class="form-control form-control-sm">
			</div>

			<h5>Letter Content:</h5>
			<input type="hidden" name="notes">

			<div class="summernote">
				<p>Dear {name}</p>
				<p>Thank you for your application for job position {position}.</p>
				<p>We scheduled an interview meeting with you. Please arrive 15 minutes before your schedule.</p>
				<p>Meeting details:</p>
				<p>
					Interview date: {interviewdate}<br>
					Interview time: {interviewtime}<br>
					Location: {location}<br><br>
                    <p> For more details please logon our POB pro system. <br>
                    <a href="{view_link}" target="_blank">Open in POBPro</a></p><br>
                    <p> For Quick Communication, Use our wechat work <br>
                        <a href="{wechat_link}" target="_blank">WeChat Work</a></p>
				</p>
				<p>Thanks,</p>
				<p>
					{company_name}
				</p>
			</div>

			<div class="form-group mt-3">
				<label class="font-weight-bold">Interviewers</label>
				<select data-placeholder=" " class="chosen-select form-control form-control-sm" multiple tabindex="2" id="interviewer_id" name="interviewer_id[]">
					@if ($data['interviewers'])
						@foreach($data['interviewers'] as $interviewer)
						<option value="{{ $interviewer->id }}"><span class="text-primary font-weight-bold">{{ $interviewer->name . ' ' . $interviewer->last_name }}</span></option>
						@endforeach
					@endif
				</select>
			</div>

			<div class="actions d-flex align-items-center justify-content-center mt-3">
				<a href="" class="btn sm btn-success btn-outline ml-1 mr-1 preview-interview">Preview</a>
				<a href="" class="btn sm btn-success ml-1 mr-1 save-interview ladda-button" data-style="zoom-out">Schedule</a>
				<a href="" class="btn sm btn-white ml-1 mr-1 go-back">Cancel</a>
			</div>
		</div>

		<div class="col-md-3 hide-on-preview">
			<h5>Variables:</h5>
			<p>You can use these variables in the content of the letter. It will be replaced by real data of candidates when sending the email.</p>

			<p>
				{name} - First Name + Last Name<br>
				{position} - Job position<br>
				{interviewdate} - Interview date<br>
				{interviewtime} - Interview time<br>
				{wechat_link} - Wechat link<br>
                {view_link} - Link for URL<br>
                {location} - Location <br>
                {company_name} - Company name
			</p>
		</div>
	</div>
</form>

<div class="modal inmodal fade" id="interview-schedule-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header p-3 rounded-0 bg-danger">
				<h4 class="m-0 d-flex flex-nowrap">
					<i class="fa fa-exclamation-triangle text-white mr-2"></i> Error

					<a href="" class="ml-auto" data-dismiss="modal" aria-label="Close">
						<i class="fa fa-times text-white"></i>
					</a>
				</h4>

			</div>
			<div class="modal-body pt-3 pl-3 pr-3 pb-0">
				<p>End time can not be before start time.</p>
			</div>
		</div>
	</div>
</div>
@endsection