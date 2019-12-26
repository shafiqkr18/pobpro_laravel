@extends('admin.layouts.default')

@section('title')
	View Contract
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
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

.status-wrap span.status {
	position: relative;
	z-index: 2;
	width: 20px;
	height: 20px;
	-webkit-border-radius: 50%;
	border-radius: 50%;
}

.status-row {
	position: relative;
}

.status-row:after {
	content: '';
	height: 6px;
	background: #fff;
	position: absolute;
	left: -15px;
	right: -15px;
	top: 50%;
	margin-top: -3px;
}

.status-row.first:after {
	left: 0;
}

.status-row.last:after {
	right: 0;
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

	$(document).on('click', '.radio-label', function (e) {
		if ($('.btn-approve').hasClass('disabled')) {
			$('.btn-approve').removeClass('disabled');
		}
	});

	$(document).on('click', '.btn-approve', function (e) {
		e.preventDefault();

		if (!$(this).hasClass('disabled')) {
			let formData = new FormData($(this).closest('form')[0]);

			$.ajax({
				type: 'POST',
				url: $(this).closest('form').attr('action'),
				dataType: 'JSON',
				data: formData,
				processData: false,
				contentType: false,
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
	});

});
</script>
@endsection

@php
$status = ['Awaiting Response', 'Accepted'];
$status_class = ['plain', 'success'];
$expected_salary = ['', '0 - 1,999', '2,000 - 3,999', '4,000 - 5,999', '6,000 - 7,999', '8,000 - 11,999', '12,000 - 19,999', '20,000 - 29,999', '30,000 - 49,999', '50,000 - 99,999', '100,000+'];
$work_type = ['FT' => 'Full Time', 'PT' => 'Part Time', 'CO' => 'Contract', 'TP' => 'Temporary', 'OT' => 'Other'];
$file = json_decode($contract->candidate->resume, true);
$approval_class = ['muted', 'navy'];
$approval_icon = ['times', 'check'];
$fa = ['exclamation', 'check', 'times'];
$color = ['warning', 'primary', 'danger'];
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>HR</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/contracts') }}">Contracts</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
			</li>
		</ol>
		
		<h2 class="d-flex align-items-center">
		<a href="{{ url('admin/contracts') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $contract->reference_no }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row status-wrap mt-4 mb-5">
		<div class="col-md-3">
			<h5 class="text-center">Prepare Offer</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row first">
				<span class="status text-white bg-primary d-flex align-items-center justify-content-center">
					<i class="fa fa-check"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Create Date: </span> <span>{{ date('Y-m-d', strtotime($contract->created_at)) }}</span>
				</li>

				<li>
					<span class="text-muted">Submit Date: </span> <span>{{ date('Y-m-d', strtotime($contract->created_at)) }}</span>
				</li>

				<li>
					<span class="text-muted">Create By: </span> {{ ($contract->createdBy->name ? $contract->createdBy->name : '') . ' ' . ($contract->createdBy->last_name ? $contract->createdBy->last_name : '') }}
				</li>
			</ul>
		</div>

		<div class="col-md-3">
			<h5 class="text-center">DM Approval</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row">
				<span class="status text-white bg-{{ $color[$contract->dm_approved] }} d-flex align-items-center justify-content-center">
					<i class="fa fa-{{ $fa[$contract->dm_approved] }}"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Arrive Date: </span> <span>{{ date('Y-m-d', strtotime($contract->created_at)) }}</span>
				</li>

				<li>
					<span class="text-muted">Approve Date: </span> <span>{{ $contract->getDMApproval() ? date('Y-m-d', strtotime($contract->getDMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">{{ $contract->dm_approved == 1 ? 'Approved' : ($contract->dm_approved == 2 ? 'Rejected' : '') }} By: </span> {{ $contract->getDMApproval() ? $contract->getDMApproval()->createdBy->name . ($contract->getDMApproval()->createdBy->last_name ? $contract->getDMApproval()->createdBy->last_name : '') : '-' }}
				</li>

				<li>
					<span class="text-muted">Status: </span> <span>{{ $contract->dm_approved == 1 ? 'Approved' : ($contract->dm_approved == 2 ? 'Rejected' : 'Pending') }}</span>
				</li>

				@if ($contract->dm_approved == 0)
				<li>
					<span class="text-muted">Pending Time: </span>{{ time_ago($contract->created_at) . ' ago' }}
				</li>
				@endif
			</ul>
		</div>

		<div class="col-md-3">
			<h5 class="text-center">HRM Approval</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row">
				<span class="status text-white bg-{{ $color[$contract->hrm_approved] }} d-flex align-items-center justify-content-center">
					<i class="fa fa-{{ $fa[$contract->hrm_approved] }}"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Arrive Date: </span> <span>{{ $contract->dm_approved == 1 && $contract->getDMApproval() ? date('Y-m-d', strtotime($contract->getDMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">Approve Date: </span> <span>{{ $contract->hrm_approved == 1 && $contract->getHRMApproval() ? date('Y-m-d', strtotime($contract->getHRMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">{{ $contract->hrm_approved == 1 ? 'Approved' : ($contract->hrm_approved == 2 ? 'Rejected' : '') }} By: </span> {{ $contract->hrm_approved == 1 && $contract->getHRMApproval() ? $contract->getHRMApproval()->createdBy->name . ($contract->getHRMApproval()->createdBy->last_name ? $contract->getHRMApproval()->createdBy->last_name : '') : '-' }}
				</li>

				<li>
					<span class="text-muted">Status: </span> <span>{{ $contract->hrm_approved == 1 ? 'Approved' : ($contract->hrm_approved == 2 ? 'Rejected' : 'Pending') }}</span>
				</li>

				@if ($contract->dm_approved == 1 && $contract->hrm_approved == 0)
				<li>
					<span class="text-muted">Pending Time: </span>{{ $contract->getHRMApproval() ? time_ago($contract->getHRMApproval()->created_at) . ' ago' : '' }}
				</li>
				@endif
			</ul>
		</div>

		<div class="col-md-3">
			<h5 class="text-center">GM Approval</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row last">
				<span class="status text-white bg-{{ $color[$contract->gm_approved] }} d-flex align-items-center justify-content-center">
					<i class="fa fa-{{ $fa[$contract->gm_approved] }}"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Arrive Date: </span> <span>{{ $contract->hrm_approved == 1 && $contract->getHRMApproval() ? date('Y-m-d', strtotime($contract->getHRMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">Approve Date: </span> <span>{{ $contract->gm_approved == 1 && $contract->getGMApproval() ? date('Y-m-d', strtotime($contract->getGMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">{{ $contract->gm_approved == 1 ? 'Approved' : ($contract->gm_approved == 2 ? 'Rejected' : '') }} By: </span> {{ $contract->gm_approved == 1 && $contract->getGMApproval() ? $contract->getGMApproval()->createdBy->name . ($contract->getGMApproval()->createdBy->last_name ? $contract->getGMApproval()->createdBy->last_name : '') : '-' }}
				</li>

				<li>
					<span class="text-muted">Status: </span> <span>{{ $contract->gm_approved == 1 ? 'Approved' : ($contract->gm_approved == 2 ? 'Rejected' : 'Pending') }}</span>
				</li>

				@if ($contract->hrm_approved == 1 && $contract->gm_approved == 0)
				<li>
					<span class="text-muted">Pending Time: </span>{{ $contract->getGMApproval() ? time_ago($contract->getGMApproval()->created_at) . ' ago' : '' }}
				</li>
				@endif
			</ul>
		</div>
	</div>

	<div class="form-row">

		<div class="col-lg-7">
			<div class="form-row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title">
							<h5>Candidate Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group">
										<label class="text-muted mb-0">Name</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->name }}</p>
									</div>

									<div class="form-group">
										<label class="text-muted mb-0">Gender</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->gender }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="text-muted mb-0">Age</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->age ? $contract->candidate->age : '-' }}</p>
									</div>

									<div class="form-group">
										<label class="text-muted mb-0">Position</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->position ? $contract->candidate->position->title : '' }}</p>
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
						<div class="ibox-title">
							<h5>Contact Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group">
										<label class="text-muted mb-0">Phone</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->phone }}</p>
									</div>

									<div class="form-group">
										<label class="text-muted mb-0">Email</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->email }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="text-muted mb-0">Skype</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->skype ? $contract->candidate->skype : '-' }}</p>
									</div>

									<div class="form-group">
										<label class="text-muted mb-0">Other Contact</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->other_contact ? $contract->candidate->other_contact : '-' }}</p>
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
						<div class="ibox-title">
							<h5>Location Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group">
										<label class="text-muted mb-0">Nationality</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->nationality }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="text-muted mb-0">Location</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->location }}</p>
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
						<div class="ibox-title">
							<h5>Expected Package</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group">
										<label class="text-muted mb-0">Expected Salary</label>
										<p class="form-control-static font-weight-bold">{{
										$contract->candidate->fixed_salary?$contract->candidate->fixed_salary:'' }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label class="text-muted mb-0">Expected Work Type</label>
										<p class="form-control-static font-weight-bold">{{
										$contract->candidate->work_type?$work_type[$contract->candidate->work_type] :''}}</p>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<label class="text-muted mb-0">Expected Benefits</label>
										<p class="form-control-static font-weight-bold">{{ $contract->candidate->other_benefits ? $contract->candidate->other_benefits : '-' }}</p>
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
						<div class="ibox-title">
							<h5>CV Attachment</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group">
										<!-- <label class="text-muted mb-0">Upload CV</label> -->
										@if ($contract->candidate->resume)
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
								<h2>Contract for {{ $contract->candidate->name . ' ' . $contract->candidate->last_name }}</h2>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Name:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1"><a href="{{ url('admin/candidate/detail/' . $contract->candidate->id) }}" class="text-primary" target="_blank">{{ $contract->candidate->name }}</a></dd> </div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-{{ $status_class[$contract->accepted] }}">{{ $status[$contract->accepted] }}</span></dd></div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Current Position:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $contract->candidate->position ? $contract->candidate->position->title : '' }}</dd> </div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>New Position:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $contract->position ? $contract->position->title : '' }}</dd> </div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Position Type:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $work_type[$contract->position_type] }}</dd> </div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Salary:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $contract->candidate->fixed_salary ? '$' . $contract->candidate->fixed_salary : '' }}</dd> </div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Report To:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $contract->report_to }}</dd> </div>
							</dl>

							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Start Date:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ date('Y-m-d', strtotime($contract->work_start_date)) }}</dd> </div>
							</dl>
						</div>
					</div>

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
												@if ($contract->comments)
													@foreach ($contract->comments as $comment)
													<div class="feed-element">
														@php
														$avatar = $comment->createdBy->avatar ? json_decode($comment->createdBy->avatar, true) : null;
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
															<strong>{{ $comment->createdBy->name }}</strong> <br>
															<small class="text-muted">{{ $comment->created_at }}</small>
															<div class="well">
																{{ $comment->status_details }}
															</div>
														</div>
													</div>
													@endforeach
												@endif

												<div class="feed-element">
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
														<strong>{{ $user->name }}</strong> <br>
														<form action="{{ url('admin/offer/comment/save') }}">
															<input type="hidden" name="offer_id" value="{{ $contract->id }}">
															<div class="form-group mb-2 mt-2">
																<textarea name="status_details" id="status_details" rows="4" class="form-control"></textarea>
															</div>

															<a href="" class="btn btn-sm btn-white float-right add-comment">Add Comment</a>
														</form>
													</div>
												</div>

												@role('DM|HRM|GM|itfpobadmin')
													@if(($contract->gm_approved != 1) || ($contract->hrm_approved != 1) || ($contract->dm_approved != 1))
														{!! $returnHTML !!}
													@endif
												@endrole

											</div>
										</div>
									</div><!-- .tab-content -->

								</div><!-- .panel-body -->
							</div><!-- .panel -->

					</div>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>
@endsection