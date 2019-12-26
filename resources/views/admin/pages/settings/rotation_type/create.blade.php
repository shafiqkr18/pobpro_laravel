@extends('admin.layouts.default')

@section('title')
	Create Rotation Type
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
<script src="{{ URL::asset('js/operations/create_forms.js?v=') }}{{rand(11,99)}}"></script>
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
				<a href="{{ url('admin/rotation-types') }}">Rotation Types</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/rotation-types') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Rotation Type
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_template" enctype="multipart/form-data">
		@if (!Auth::user()->hasRole('itfpobadmin'))
		<input type="hidden" name="company_id" value="{{ Auth::user()->company_id }}">
		@endif

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<div class="ibox-title indented">
						<h5>Rotation Details</h5>
					</div>

					<div class="ibox-content">

							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label>Title</label>
										<input type="text" class="form-control form-control-sm" name="title" id="title">
									</div>
								</div>

								@if (Auth::user()->hasRole('itfpobadmin'))
								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Company</label>
										<select name="company_id" id="company_id" class="form-control form-control-sm">
											@if ($companies)
												@foreach ($companies as $company)
												<option value="{{ $company->id }}">{{ $company->company_name }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
								@endif
							</div>

					</div>

				</div>
			</div>
		</div>

		<div class="row mt-3">
			<div class="col-md-12">
				<a href="javascript:void(0)" id="save_pdftemplate" class="btn btn-success btn-sm float-right">Save</a>
			</div>
		</div>
	</form>
</div>
@endsection