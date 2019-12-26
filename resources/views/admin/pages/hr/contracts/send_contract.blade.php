@extends('admin.layouts.default')

@section('title')
    Prepare Contract
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
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
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>
$(document).ready(function(){
		$('.custom-file-input').on('change', function() {
				let fileName = $(this).val().split('\\').pop();
				$(this).next('.custom-file-label').addClass('selected').html(fileName);
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

		$('.input-daterange').datepicker({
				keyboardNavigation: false,
				forceParse: false,
				autoclose: true,
				todayHighlight: true,
				startDate: 'today'
		});

	$(document).on('change', '#template_id', function (e) {
		if ($(this).val()) {
			var templates = @php echo $data['templates'] @endphp,
					template_id = $(this).val();

			var template = templates.filter(_template => {
				return _template.id == template_id;
			});

			$('.summernote').summernote('reset');
			var content = template[0].contents;
			$('.summernote').summernote('code', content);
		}
	});

});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
            <h2>Prepare Contract</h2>
				<ol class="breadcrumb">
						<li class="breadcrumb-item">
								<a href="{{ url('admin') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
								HR
						</li>
						<li class="breadcrumb-item active">
                    <strong>Prepare Contract</strong>
						</li>
				</ol>
		</div>
		<div class="col-lg-2 d-flex align-items-center justify-content-end">
				<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
		</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_send_contract" enctype="multipart/form-data">
		<div class="row">
				<div class="col-lg-12">
						<div class="ibox mb-3">
								<div class="ibox-title">
										<h5>Contract Details for {{ $data['position']->title }}</h5>
										<div class="ibox-tools">
												<a class="collapse-link">
														<i class="fa fa-chevron-up"></i>
												</a>
										</div>
								</div>


								<div class="ibox-content">
									<div class="sk-spinner sk-spinner-three-bounce">
										<div class="sk-bounce1"></div>
										<div class="sk-bounce2"></div>
										<div class="sk-bounce3"></div>
									</div>
										<!-- <form role="form" id="frm_send_contract" enctype="multipart/form-data"> -->
												<input type="hidden" name="contents">
												<input type="hidden" name="ids" value="{{ $data['ids'] }}">
												<input type="hidden" name="position_id" value="{{$data['position']->id}}">
												<input type="hidden" name="plan_id" value="{{ $data['plan_id'] }}">
												<div class="row">
														{{--
														<div class="col-sm-6">
																<div class="form-group">
																		<label>Applied Job Position   : </label></br>
																		<strong>{{$data['position']->title}}</strong>
																</div>
														</div>
														--}}

														<div class="col-sm-6">
															<div class="form-group">
																	<label>Position Type</label>
																	<select name="position_type" id="position_type" class="form-control form-control-sm" size="">
																			<option value="FT" selected="selected">Full Time</option>
																			<option value="PT">Part Time</option>
																			<option value="CO">Contract</option>
																			<option value="TP">Temporary</option>
																			<option value="OT">Other</option>
																	</select>
															</div>
														</div>

														<div class="col-sm-6">
															<div class="form-group">
																	<label>Report To</label>
																	<select name="report_to" id="report_to" class="form-control form-control-sm" size>
																			<option value="" selected></option>
																			<option value="GM">General Manager</option>
																			<option value="IT Manager">IT Manager</option>
																			<option value="HR Manager">HR Manager</option>

																	</select>
															</div>
														</div>
												</div>

												<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																<label>Offer Amount</label>
																<input type="number" class="form-control form-control-sm" name="offer_amount" id="offer_amount">
															</div>
														</div>

														<div class="col-sm-6">
																<div class="form-group">
																		<label>Start Work Date</label>
																		<div class="input-daterange input-group" id="datepicker">
																			<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
																				<input type="text" class="form-control-sm form-control text-left" id="work_start_date" name="work_start_date"/>
																		</div>
																</div>
														</div>
												</div>

												<div class="row">
														<div class="col-sm-6">
															<div class="form-group">
																	<label>Base Location</label>
																	<input type="text" class="form-control form-control-sm" name="location" id="location">
															</div>
														</div>
												</div>
										<!-- </form> -->

								</div>

						</div>

						<div class="ibox">
								<div class="ibox-title">
									<h5>Message Details</h5>
									<div class="ibox-tools">
											<a class="collapse-link">
													<i class="fa fa-chevron-up"></i>
											</a>
									</div>
								</div>

								<div class="ibox-content">
									<div class="sk-spinner sk-spinner-three-bounce">
										<div class="sk-bounce1"></div>
										<div class="sk-bounce2"></div>
										<div class="sk-bounce3"></div>
									</div>

									<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
														<label>Template</label>
														<select name="template_id" id="template_id" class="form-control form-control-sm" size>
															<option value=""></option>
															@foreach ($data['templates'] as $template)
															<option value="{{ $template->id }}" data-index="{{ $loop->index }}">{{ $template->template_name }}</option>
															@endforeach
														</select>
												</div>
											</div>

											<div class="col-sm-6">
												<div class="form-group">
														<label>Subject</label>
														<input type="text" class="form-control form-control-sm" name="subject" id="subject">
												</div>
											</div>
									</div>

									<div class="row">
											<div class="col-sm-12">
												<div class="form-group">
														<label>Message</label>
														<div class="summernote">
																<p>An employment contract have been issued to you. Please logon POB pro system to process.</p>

																<p>You need to process it with in One Week.</p>

														</div>
												</div>
											</div>

											<div class="col-sm-6">
													<div class="form-group">
															<label>Attachments</label>
															<div class="custom-file">
																	<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
																	<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
															</div>
													</div>
											</div>
									</div>
								</div>
						</div>

						<div class="row">
								<div class="col-md-12">
												<a href="javascript:void(0)" id="btn_send_contract" class="btn btn-success btn-sm pull-right">Prepare Contract</a>
								</div>
						</div>
				</div>
		</div>
	</form>
</div>
@endsection
