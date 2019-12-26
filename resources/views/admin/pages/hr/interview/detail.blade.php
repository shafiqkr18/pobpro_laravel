@extends('admin.layouts.default')

@section('title')
	View Interview
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
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

h2 > a {
	color: inherit;
}

[type="radio"]:checked,
[type="radio"]:not(:checked) {
	position: absolute;
	left: -9999px;
}

[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label {
	position: relative;
	padding-left: 24px;
	cursor: pointer;
	line-height: 20px;
	display: inline-block;
	color: #666;
}

[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
	content: '';
	position: absolute;
	left: 0;
	top: 0;
	width: 18px;
	height: 18px;
	border: 1px solid #ddd;
	border-radius: 100%;
	background: #fff;
}

[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
	content: '';
	width: 18px;
	height: 18px;
	position: absolute;
	top: 0;
	left: 0;
	border-radius: 100%;
	-webkit-transition: all 0.2s ease;
	transition: all 0.2s ease;
}

[type="radio"]:not(:checked) + label:after {
	opacity: 0;
	-webkit-transform: scale(0);
	transform: scale(0);
}

#optionsRadios2[type="radio"]:checked + label:after,
#optionsRadios2[type="radio"]:not(:checked) + label:after {
	content: '\f00c';
	font-size: 11px;
	font-family: 'FontAwesome';
	color: #fff;
	position: absolute;
	left: 0;
	top: 0;
	text-align: center;
}

#optionsRadios1[type="radio"]:checked + label:after,
#optionsRadios1[type="radio"]:not(:checked) + label:after {
	content: '\f00d';
	font-size: 11px;
	font-family: 'FontAwesome';
	color: #fff;
	position: absolute;
	left: 0;
	top: 0;
	text-align: center;
}

#optionsRadios2[type="radio"]:checked + label:before {
	background: #1ab394;
	border-color: #1ab394;
}

#optionsRadios1[type="radio"]:checked + label:before {
	background: #ed5565;
	border-color: #ed5565;
}

[type="radio"]:checked + label:after {
	opacity: 1;
	-webkit-transform: scale(1);
	transform: scale(1);
}

.hide {
	display: none;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
$(document).ready(function () {
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
    $(document).on('click', '.add_intv_status', function (e) {
        e.preventDefault();

        let formData = new FormData($(this).closest('form')[0]);
        $.ajax({
            type: 'POST',
            url: $(this).closest('form').attr('action'),
            dataType: 'JSON',
            data: formData,
            processData: false,
            contentType: false,
            data: formData,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                }

            }
            });
    });
	$(document).on('click', '.add-comment', function (e) {
		e.preventDefault();

		let formData = new FormData($(this).closest('form')[0]);

		$.ajax({
			type: 'POST',
			url: $(this).closest('form').attr('action'),
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			data: formData,
			success: function (response) {
				if (response.success) {
					toastr.success(response.message);

					$('#status_details').val('');

					var avatar = '<i class="fas fa-user-circle float-left text-muted" style="font-size: 38px; margin-right: 10px;"></i>';
					if (response.avatar) {
						avatar = '<a href="#" class="float-left"><img alt="image" class="rounded-circle" src="' + response.avatar + '"></a>'
					}

					$('.feed-activity-list').prepend(
						'<div class="feed-element">' +
							avatar +
							'<div class="media-body">' +
								'<strong>' + response.createdBy + '</strong> <br>' +
								'<small class="text-muted">' + response.comment.created_at + '</small>' +
								'<div class="well">' +
									response.comment.status_details +
								'</div>' +
							'</div>' +
						'</div>'
					);
				}
				else {
					jQuery.each(response.errors, function (key, value) {
						toastr.error('Please fill in the comments field.');
						$('#' + key).closest('.form-group').addClass('has-error');
					});
				}

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	$(document).on('click', '.set-interview-status', function (e) {
		e.preventDefault();

		var $this = $(this);

		$('.has-error').next('.text-danger').addClass('hide');
		$('.has-error').removeClass('has-error');

		var proceed = false;

		if ($(this).attr('data-value') == 1) {
			proceed = true;
		}
		else {
			if ($('#status_details').val() != '') {
				proceed = true;
			}
		}

		if (proceed) {
			$('[name="rdbtn"]').val($(this).attr('data-value'));
			$('[name="comments"]').val($('#status_details').val());

			let formData = new FormData($(this).closest('form')[0]);

			$.ajax({
				type: 'POST',
				url: $(this).closest('form').attr('action'),
				dataType: 'JSON',
				data: formData,
				processData: false,
				contentType: false,
				data: formData,
				success: function (response) {
					if (response.success) {
						toastr.success(response.message);

						setTimeout(function () {
							location.reload();
						}, 1000)
					}
					else {
						toastr.error(response.message);
					}

				}, error: function (err) {
					console.log(err);
				}
			});
		}
		else {
			$('#status_details').closest('.form-group').addClass('has-error');
			$('#status_details').closest('.form-group').next('.text-danger').removeClass('hide');
		}

	});

});
</script>
@endsection

@php
$status = ['Pending Response', 'Confirmed', 'Requested to reschedule', 'Declined'];
$status_class = ['warning', 'success', 'info', 'danger'];
$expected_salary = ['', '0 - 1,999', '2,000 - 3,999', '4,000 - 5,999', '6,000 - 7,999', '8,000 - 11,999', '12,000 - 19,999', '20,000 - 29,999', '30,000 - 49,999', '50,000 - 99,999', '100,000+'];
$work_type = ['FT' => 'Full Time', 'PT' => 'Part Time', 'CO' => 'Contract', 'TP' => 'Temporary', 'OT' => 'Other'];
$file = json_decode($interview->candidate->resume, true);
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/interviews') }}">Interviews</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/interviews') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $interview->reference_no }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight min-detail">
	<div class="form-row">

		<div class="col-lg-7">
			<div class="form-row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title indented">
							<h5>Candidate Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Name</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate ? $interview->candidate->name." ".$interview->candidate->last_name : '' }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Gender</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate ? $interview->candidate->gender : '' }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Age</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate && $interview->candidate->age ? $interview->candidate->age : '-' }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Position</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate && $interview->candidate->position ? $interview->candidate->position->title : '' }}</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title indented">
							<h5>Contact Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Phone</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->phone }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Email</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->email }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Skype</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->skype ? $interview->candidate->skype : '-' }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Other Contact</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->other_contact ? $interview->candidate->other_contact : '-' }}</p>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title indented">
							<h5>Location Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Nationality</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->nationality }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Location</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->location }}</p>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title indented">
							<h5>Expected Package</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Expected Salary</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->expected_salary ? $expected_salary[$interview->candidate->expected_salary] : '' }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Expected Work Type</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->work_type ? $work_type[$interview->candidate->work_type] : '' }}</p>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Expected Benefits</label>
										<p class="form-control-static font-weight-bold">{{ $interview->candidate->other_benefits ? $interview->candidate->other_benefits : '-' }}</p>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title indented">
							<h5>CV Attachment</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<!-- <label class="text-muted mb-0">Upload CV</label> -->
										@if ($interview->candidate->resume)
										<a href="{{ asset('/storage/' . $file[0]['download_link']) }}" target="_blank" class="text-success"><p class="form-control-static font-weight-bold">{{ $file[0]['original_name'] }}</p></a>
										@else
										<p class="form-control-static font-weight-bold">No CV uploaded.</p>
										@endif
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

		<div class="col-lg-5">
			<div class="ibox">
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-12">
							<div class="m-b-md">
								<h3>Interview with {{ $interview->candidate->name." ".$interview->candidate->last_name }}</h3>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Name:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1"><a href="{{ url('admin/candidate/detail/' . $interview->candidate->id) }}" class="text-primary" target="_blank">{{ $interview->candidate->name." ".$interview->candidate->last_name }}</a></dd> </div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Status:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-{{ $status_class[$interview->is_confirmed] }}">{{ $status[$interview->is_confirmed] }}</span></dd></div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Position:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $interview->candidate && $interview->candidate->position ? $interview->candidate->position->title : '' }}</dd> </div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Created by:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $interview->createdBy ? $interview->createdBy->name." ".$interview->createdBy->last_name : '' }}</dd> </div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Subject:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ str_replace('{position}', ($interview->position ? $interview->position->title : ''), $interview->subject) }}</dd> </div>
							</dl>
						</div>

						<div class="col-lg-12 mt-3">
							<dl class="row mb-1">
								<div class="col-sm-4">
									<dt>Date:</dt>
								</div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">{{ date('Y-m-d', strtotime($interview->interview_date)) }}</dd>
								</div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4">
									<dt>Time:</dt>
								</div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">{{ date('H:i', strtotime($interview->interview_date)) }}</dd>
								</div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Location:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1 text-navy">{{ $interview->location }}</dd> </div>
							</dl>

							<!-- <dl class="row mb-1">
								<div class="col-sm-4"><dt>Candidate Status:</dt> </div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">
										<select name="candidate_status" id="candidate_status" class="form-control" size>
											<option value=""></option>
											<option value="accepted">Accepted</option>
											<option value="declined">Declined</option>
											<option value="qualified">Qualified</option>
											<option value="denied">Denied</option>
										</select>
									</dd>
								</div>
							</dl> -->

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Interviewer:</dt> </div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">
										@if ($interview->attendees)
											@foreach ($interview->attendees as $attendee)
											<span class="font-weight-bold mr-2">{{ $attendee->interviewer ? $attendee->interviewer->getName() : '' }}</span>
											@endforeach
										@endif
									</dd>
								</div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Remarks:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{!! $template_data !!}</dd> </div>
							</dl>

							<dl class="row mb-1">
								<div class="col-sm-4"><dt>Download PDF:</dt> </div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">
										<a href="{{ url('admin/interview/pdf/' . $interview->id) }}" title="Download PDF">
											<img src="{{ URL::asset('img/icon-pdf.jpg') }}" width="16">
										</a>
									</dd> 
								</div>
							</dl>
						</div>
					</div>
{{--                    if status is pending or rejected then no need to show below--}}
                    @if($interview->is_confirmed != 0 && $interview->is_confirmed != 3)
					<div class="row m-t-sm">
						<div class="col-lg-12">
							<div class="panel blank-panel">
								<div class="panel-heading">
										<div class="panel-options">
												<ul class="nav nav-tabs">
														<li><a class="nav-link p-2 active" href="#tab-1" data-toggle="tab">Comments</a></li>
												</ul>
										</div>
								</div>

								<div class="panel-body">

									<div class="tab-content">
										<div class="tab-pane active" id="tab-1">
											<div class="feed-activity-list">
												@if ($interview->comments)
													<div class="feed-element pb-0 border-0">
														@php
														$avatar = $user->avatar ? json_decode($user->avatar, true) : null;
														@endphp

														@if ($avatar)
														<a href="#" class="float-left">
															<img alt="image" class="rounded-circle" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}">
														</a>
														@else
														<i class="fas fa-user-circle float-left text-muted" style="font-size: 38px; margin-right: 10px;"></i>
														@endif

														<div class="media-body ">
															<!-- <small class="float-right">2019-08-07 07:00</small> -->
															<strong>{{ $user->getName() }}</strong> <br>
															<small class="text-muted">{{ $interview->updated_at }}</small>
															<div class="well">
																{{ $interview->comments }}
															</div>
														</div>
													</div>
												@else
													@if ($interview->is_qualified != 0)
														<p>No comments.</p>
													@endif
												@endif

												@if ($interview->is_qualified == 0)
												<div class="feed-element border-0">
													@php
													$avatar = $user->avatar ? json_decode($user->avatar, true) : null;
													@endphp

													@if ($avatar)
													<a href="#" class="float-left">
														<img alt="image" class="rounded-circle" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}">
													</a>
													@else
													<i class="fas fa-user-circle float-left text-muted" style="font-size: 38px; margin-right: 10px;"></i>
													@endif

													<div class="media-body ">
														<strong>{{ $user->getName() }}</strong> <br>
														<form action="{{ url('admin/interview/comment/save') }}">
															<input type="hidden" name="interview_id" value="{{ $interview->id }}">
															<div class="form-group mb-2 mt-2">
																<textarea name="status_details" id="status_details" rows="4" class="form-control"></textarea>
															</div>
															<span class="text-danger hide">Please add a comment.</span>

															<!-- <a href="" class="btn btn-sm btn-white float-right add-comment">Add Comment</a> -->
														</form>
													</div>
												</div>
												@endif

												@role('HRM|HR')
													@if($interview->is_confirmed == 1 && $interview->is_qualified == 0)
													<div class="media-body">
														<form action="{{ url('admin/candidate_status') }}">
															<div class="row">
																<input type="hidden" name="candidate_id" value="{{ $interview->candidate->id }}">
																<input type="hidden" name="intv_id" value="{{ $interview->id }}">
																<input type="hidden" name="rdbtn">
																<input type="hidden" name="comments">

																<div class="col-sm-12 d-flex align-items-center justify-content-end">

																	<a href="" class="btn btn-danger btn-sm set-interview-status" data-value="2">
																		<i class="fa fa-times"></i> Unqualified
																	</a>

																	<a href="" class="btn btn-primary btn-sm ml-2 set-interview-status" data-value="1">
																		<i class="fa fa-check"></i> Qualified
																	</a>

																</div>
															</div>
														</form>
													</div>
													@endif
												@endrole

											</div>
										</div>
									</div><!-- .tab-content -->

								</div><!-- .panel-body -->
							</div><!-- .panel -->

					</div>
					</div>
                    @endif
				</div>
			</div>
		</div>

	</div>
</div>
@endsection