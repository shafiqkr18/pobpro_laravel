@extends('admin.layouts.default')

@section('title')
	Create Letter
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.letter-format {
	display: flex;
	flex-wrap: nowrap;
	align-items: center;
}

.letter-format label {
	min-width: 66px;
	max-width: 66px;
	margin-bottom: 0;
	margin-right: 10px;
}

.letter-format input,
.letter-format select {
	border-top: 0;
	border-left: 0;
	border-right: 0;
	border-radius: 0;
}

.ar {
	direction: rtl;
	text-align: right;
}

.ar .letter-format label {
	margin-right: 0;
	margin-left: 10px;
}

.note-editor {
	width: 100%;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/correspondence_create_forms.js?v=') }}{{rand(11,99)}}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.summernote,.ar_summernote').summernote({
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

			Create
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">

			<div class="ibox border-bottom">
				<div class="ibox-title">
					<h5>Compose Letter</h5>
				</div>
			</div>

			<div class="ibox">
				<div class="ibox-content">

					<div class="row">
						<div class="col-lg-4 text-center font-weight-bold">
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->company_name : '' }}</span>
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->address : '' }}</span>
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->city : '' }}</span>
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->country : '' }}</span>
						</div>

						<div class="col-lg-4 text-center">
							@php
							$company_logo = Auth::user()->company && Auth::user()->company->logo ? json_decode(Auth::user()->company->logo, true) : null;
							@endphp

							@if ($company_logo)
							<img alt="image" class="img-fluid" src="{{ asset('/storage/' . $company_logo[0]['download_link']) }}">
							@endif
						</div>

						<div class="col-lg-4 text-center font-weight-bold">
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->company_name : '' }}</span>
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->address : '' }}</span>
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->city : '' }}</span>
							<span class="d-block">{{ Auth::user()->company ? Auth::user()->company->country : '' }}</span>
						</div>
					</div>

					<hr>

                    <form role="form" id="frm_crspndnc_compose" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="direction" value="OUT">
                        <input type="hidden" name="ar_contents">
                        <input type="hidden" name="contents">

						<div class="row">
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group letter-format">
											<label>Reference: </label>
											<input type="text" class="form-control form-control-sm" id="reference_no" name="reference_no">
										</div>

										<div class="form-group letter-format">
											<label>Date: </label>
											<div class="input-daterange input-group">
												<input type="text" class="form-control-sm form-control text-left" name="msg_date" id="msg_date">
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group letter-format">
											<label>To: </label>
											<select name="msg_to_id" id="msg_to_id" class="form-control form-control-sm">
												@foreach($contacts_to as $c)
												<option value="{{ $c->id }}">{{ $c->getName() . ' - ' . $c->company }}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group letter-format">
											<label>Subject:</label>
											<input type="text" class="form-control form-control-sm" id="subject" name="subject">
										</div>

										<div class="form-group letter-format">
											<!-- <label class="align-self-start mt-2">Content:</label> -->
											<div class="summernote w-100"></div>
										</div>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-lg-12">
										<div class="form-group letter-format">
											<span class="font-weight-bold">Best Regards</span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group letter-format">
											<!-- <label>From: </label> -->
											<select name="msg_from_id" id="msg_from_id" class="form-control form-control-sm">
												@foreach($contacts_from as $c)
												<option value="{{ $c->id }}">{{ $c->getName() . ' - ' . $c->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-6 ar">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group letter-format ar">
											<label>رقم المرج</label>
											<input type="text" class="form-control form-control-sm" id="ar_reference_no" name="ar_reference_no">
										</div>

										<div class="form-group letter-format ar">
											<div class="input-daterange input-group">
												<label>تاريخ</label>
												<input type="text" class="form-control-sm form-control text-right" name="ar_msg_date" id="ar_msg_date">
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12">
										<div class="form-group letter-format">
											<label>إلى</label>
											<select name="ar_msg_to_id" id="ar_msg_to_id" class="form-control form-control-sm">
												@foreach($contacts_to as $c)
												<option value="{{ $c->id }}">{{ $c->getName() . ' - ' . $c->company }}</option>
												@endforeach
											</select>
										</div>

										<div class="form-group letter-format">
											<label>موضوع</label>
											<input type="text" class="form-control form-control-sm" id="ar_subject" name="ar_subject">
										</div>

										<div class="form-group letter-format">
											<!-- <label class="align-self-start mt-2">Content:</label> -->
											<div class="ar_summernote w-100"></div>
										</div>
									</div>
								</div>

								<div class="row mt-4">
									<div class="col-lg-12">
										<div class="form-group letter-format">
											<span class="font-weight-bold">تحياتي الحارة</span>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-6">
										<div class="form-group letter-format">
											<!-- <label>From: </label> -->
											<select name="ar_msg_from_id" id="ar_msg_from_id" class="form-control form-control-sm">
												@foreach($contacts_from as $c)
												<option value="{{ $c->id }}">{{ $c->getName() . ' - ' . $c->name }}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>

						{{--
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>To:</label>
									<select name="msg_to_id" id="msg_to_id" class="form-control form-control-sm">
										@foreach($contacts_to as $c)
                                            <option value="{{$c->id}}">{{$c->company}}</option>
                                        @endforeach
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Message Code:</label>
									<input type="text" class="form-control form-control-sm" id="msg_code" name="msg_code">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>From:</label>
									<select name="msg_from_id" id="msg_from_id" class="form-control form-control-sm">
                                        @foreach($contacts_from as $c)
                                            <option value="{{$c->id}}">{{$c->name}}</option>
                                        @endforeach
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Reference No:</label>
									<input type="text" class="form-control form-control-sm" id="reference_no" name="reference_no">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Department:</label>
									<select name="assign_dept_id" id="assign_dept_id" class="form-control form-control-sm">
                                        @foreach($depts as $d)
                                            <option value="{{$d->id}}">{{$d->department_short_name}}</option>
                                        @endforeach
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label>Subject:</label>
									<input type="text" class="form-control form-control-sm" id="subject" name="subject">
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
						--}}

						<div class="row mt-5">
							<div class="col-lg-6">
								<div class="form-group form-inline p-0">
									<label>Attachments:</label>
									<div class="custom-file">
										<input id="attachment" name="attachment_files" type="file" class="custom-file-input form-control-sm">
										<label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
									</div>
								</div>
							</div>
						</div>

					</form>

				</div>
			</div>

			<div class="row mt-3">
				<div class="col-lg-12 d-flex align-items-center">
					<a href="" class="btn btn-sm btn-info ml-auto mr-2">
						<i class="fas fa-eye mr-1"></i> Preview
					</a>

					<a href="javascript:void(0)" id="save_crspndnc_compose" class="btn btn-sm btn-primary mr-2">
						<i class="fas fa-save mr-1"></i> Save
					</a>

					<a href="" class="btn btn-sm btn-white mr-2">
						<i class="fas fa-pencil-alt mr-1"></i> Draft
					</a>

					<a href="" class="btn btn-sm btn-danger">
						<i class="fas fa-times mr-1"></i> Discard
					</a>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection
