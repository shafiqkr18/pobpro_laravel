@extends('admin.layouts.default')

@section('title')
	Reply
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>

</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/correspondence_create_forms.js?v=') }}{{rand(11,99)}}"></script>
<script>
$(document).ready(function(){
	$('.summernote').summernote({
		height: 200,
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
				Correspondence Mgt.
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/correspondence') }}">Letters</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/correspondence') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			Reply
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<div class="ibox border-bottom">
				<div class="ibox-title">
					<h5>Compose Reply</h5>
				</div>
			</div>

			<div class="ibox">
				<div class="ibox-content">

					<form role="form" id="frm_crspndnc_compose" enctype="multipart/form-data">
                        <input type="hidden" id="msg_parent_id" name="msg_parent_id" value="{{$letter->id}}">
                        <input type="hidden" id="msg_from_id" name="msg_from_id" value="{{$letter->msg_from_id}}">
                        <input type="hidden" id="msg_to_id" name="msg_to_id" value="{{$letter->msg_to_id}}">
                        <input type="hidden" id="direction" name="direction" value="OUT">
                        <input type="hidden" id="reference_no" name="reference_no" value="{{$letter->reference_no}}">
                        <input type="hidden" id="assign_dept_id" name="assign_dept_id" value="{{$letter->assign_dept_id}}">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>To:</label>
                                    <p class="form-control-static font-weight-bold">@if($letter->direction == 'OUT')
                                            {{$letter->to?$letter->to->company:''}}
                                        @else
                                            {{$letter->to?$letter->to->name:''}}
                                        @endif</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label>Subject:</label>
									<input type="text" class="form-control form-control-sm" id="subject" name="subject" value="Re: {{$letter->subject}}">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="align-self-start mt-2">Content:</label>
									<input type="hidden" name="contents">
									<div class="summernote"></div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Attachments:</label>
									<div class="custom-file">
										<input id="attachment" name="attachment_files" type="file" class="custom-file-input form-control-sm">
										<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
									</div>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Original Files:</label>
									<div class="custom-file">
										<input id="original_files" name="original_files" type="file" class="custom-file-input form-control-sm">
										<label for="original_files" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
									</div>
								</div>
							</div>
						</div>

					</form>

				</div>
			</div>

			<div class="row mt-3">
				<div class="col-lg-12 d-flex align-items-center">
					<a href="javascript:void(0)" id="save_crspndnc_compose" class="btn btn-sm btn-primary ml-auto mr-2">
						<i class="fas fa-mail-forward"></i> Send
					</a>

					<a href="" class="btn btn-sm btn-white mr-2">
						<i class="fas fa-pencil-alt"></i> Draft
					</a>

					<a href="" class="btn btn-sm btn-danger">
						<i class="fas fa-times"></i> Discard
					</a>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection
