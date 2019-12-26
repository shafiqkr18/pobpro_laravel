@extends('frontend.layouts.candidate')

@section('title')
	Ask a question
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
	height: 31px;
	display: flex;
	align-items: center;
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
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script>
$(document).ready(function(){
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

@section('content')
<div class="card candidate">
	<h6 class="card-header pt-2 pb-2">
		Ask a question
	</h6>

	<form role="form" id="frm_question" enctype="multipart/form-data">
		<div class="card-body p-3 bg-white">

			<div class="form-row">
				<div class="col-lg-12">
					<!-- <form role="form" id="frm_question" enctype="multipart/form-data"> -->
						@csrf
						<input type="hidden" name="status_id">
						<input type="hidden" name="content">
						<input type="hidden" name="question_type" value="private">

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
									<div class="col-lg-12">
										<div class="form-group">
											<label>The question in one sentence</label>
											<input type="text" class="form-control form-control-sm" name="title" id="title">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Category</label>
											<select name="category_id" id="category_id" class="form-control form-control-sm">
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
											<label>More information about the question</label>
											<div class="summernote" id="content">

											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Attachments</label>
											<div class="custom-file">
												<input id="attachment" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
												<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>

					<!-- </form> -->
				</div>

			</div>

		</div>
	</form>

	<div class="row mt-3">
		<div class="col-md-12">
			<a href="javascript:void(0)" id="save_question" class="btn btn-info rounded btn-sm pull-right" data-status="1">Submit</a>
			<a href="javascript:void(0)" id="save_question_draft" class="btn btn-secondary rounded btn-outline btn-sm pull-right mr-2" data-status="2">Save as draft</a>
		</div>
	</div>
</div>
@endsection