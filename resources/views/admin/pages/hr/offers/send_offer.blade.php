@extends('admin.layouts.default')

@section('title')
	Prepare Offer
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
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

	$('[name="template_id"]').trigger('change');

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
				HR
			</li>
			<li class="breadcrumb-item active">
				<strong>Prepare Offer</strong>
			</li>
		</ol>

		<h2>Prepare Offer</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_send_offer" enctype="multipart/form-data">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-content">
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>No.</th>
										<th>Name</th>
										<th>Position</th>
										<th>Level</th>
										<th>Salary (USD)</th>
                                        <th>Pay Type</th>
										<th>Rotation Type</th>
										<th>Contract Duration</th>
                                        <th>Hire Type</th>
									</tr>
								</thead>

								<tbody>
									@if ($data['candidates'])
										@foreach ($data['candidates'] as $candidate)
										<tr>
											<td>{{ $loop->iteration }}
                                            <input type="hidden" name="c_id[]" value="{{$candidate->id}}">
                                            </td>
											<td>
												<a href="{{ url('admin/candidate/detail/' . $candidate->id . '/1') }}" info-modal="candidate" class="text-success">{{ $candidate->name . ' ' . $candidate->last_name }}</a>
											</td>
											<td>{{ $candidate->position ? $candidate->position->title : '' }}</td>
											<td>{{ $candidate->level }}</td>
											<td>
												<input type="number" name="salary[]" class="form-control form-control-sm" value="{{$candidate->fixed_salary}}">
											</td>
											<td>
                                                <select name="pay_type[]" id="pay_type" class="form-control form-control-sm" size>
                                                    <option value="1">Monthly</option>
                                                    <option value="2">Daily Rate</option>
                                                </select>
                                            </td>
											<td>
												<select name="rotation_type[]" id="rotation_type" class="form-control form-control-sm" size>
													@if ($data['rotation_types'])
														@foreach ($data['rotation_types'] as $type)
														<option value="{{ $type->id }}">{{ $type->title }}</option>
														@endforeach
													@endif
												</select>
											</td>
											<td>
												<select name="contract_duration[]" id="contract_duration" class="form-control form-control-sm" size>
													@if ($data['contract_durations'])
														@foreach ($data['contract_durations'] as $contract_duration)
														<option value="{{ $contract_duration->id }}">{{ $contract_duration->title }}</option>
														@endforeach
													@endif
												</select>
											</td>
                                            <td>
                                                <select name="hire_type[]" id="hire_type" class="form-control form-control-sm" size>
                                                    <option value="1">Local</option>
                                                    <option value="2">Expat</option>
                                                </select>
                                            </td>
										</tr>
										@endforeach
									@endif
								</tbody>
							</table>
						</div>
						</div>
					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Offer Details for {{ $data['position']->title }}</h5>
					</div>

					<div class="ibox-content">
						<div class="sk-spinner sk-spinner-three-bounce">
							<div class="sk-bounce1"></div>
							<div class="sk-bounce2"></div>
							<div class="sk-bounce3"></div>
						</div>

						<!-- <form role="form" id="frm_send_offer" enctype="multipart/form-data"> -->
							<input type="hidden" name="contents">
							<input type="hidden" name="ids" value="{{ $data['ids'] }}">
							<input type="hidden" name="position_id" value="{{$data['position']->id}}">
							<input type="hidden" name="plan_id" value="{{ $data['plan_id'] }}">
							<div class="row">
								{{--
								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label>Applied Job Position   : </label></br>
										<strong>{{$data['position']->title}}</strong>
									</div>
								</div>
								--}}

								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
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
									<div class="form-group form-inline">
										<label>Report To</label>
										<!-- <input type="text" name="report_to" id="report_to" class="form-control form-control-sm" value="{{ $data['position']->vacancy ? $data['position']->vacancy->report_to : '' }}" readonly> -->
										<select name="report_to" id="report_to" class="form-control form-control-sm" size>
												<option value=""></option>
												@if ($data['dept_positions'])
													@foreach ($data['dept_positions'] as $pos)
													<option value="{{ $pos->id }}" {{ $data['position']->vacancy && $data['position']->vacancy->report_to == $pos->id ? 'selected' : '' }}>{{ $pos->title }}</option>
													@endforeach
												@endif
											</select>
									</div>
								</div>
							</div>

							<div class="row">
{{--							<div class="col-sm-6">--}}
{{--								<div class="form-group form-inline">--}}
{{--									<label>Offer Amount</label>--}}
{{--									<input type="number" class="form-control form-control-sm" name="offer_amount" id="offer_amount" value="{{ $data['position']->vacancy ? $data['position']->vacancy->salary : '' }}">--}}
{{--								</div>--}}
{{--							</div>--}}

								<div class="col-sm-6 b-r">
									<div class="form-group form-inline mb-0">
										<label>Start Work Date</label>
										<div class="input-daterange input-group" id="datepicker">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
											<input type="text" class="form-control-sm form-control text-left" id="work_start_date" name="work_start_date"/>
										</div>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group form-inline mb-0">
										<label>Base Location</label>
										<input type="text" class="form-control form-control-sm" name="location" id="location" value="{{ $data['position']->location }}">
									</div>
								</div>
							</div>


						<!-- </form> -->

					</div>

				</div>

				<div class="ibox">
					<div class="ibox-title">
						<h5>Message Details</h5>
					</div>

					<div class="ibox-content">
						<div class="sk-spinner sk-spinner-three-bounce">
							<div class="sk-bounce1"></div>
							<div class="sk-bounce2"></div>
							<div class="sk-bounce3"></div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
																			<label>Subject</label>
																			<input type="text" class="form-control form-control-sm" name="subject" id="subject">
																	</div>

								</div>

							<div class="col-sm-6">
															<div class="form-group form-inline">
										<label>Template</label>
										<select name="template_id" id="template_id" class="form-control form-control-sm" size>
											@foreach ($data['templates'] as $template)
											<option value="{{ $template->id }}" data-index="{{ $loop->index }}" selected>{{ $template->template_name }}</option>
											@endforeach
										</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">

								<div class="form-group form-inline">
									<label>Message</label>
									<div class="summernote">
											<p>Thanks for your application to our job position {{$data['position']->title}}.
											We issued an offer letter to you. Please logon our POB pro system to check and process it.</p>

											<p>You need to confirm it with in One Month.</p>

									</div>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
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

				<div class="row mt-3">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="btn_send_offer" class="btn btn-success btn-sm pull-right">Prepare Offer</a>
					</div>
				</div>

			</div>
		</div>
	</form>
</div>
@endsection
