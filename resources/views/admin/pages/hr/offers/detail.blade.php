@extends('admin.layouts.default')

@section('title')
	View Offer
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
						'<div class="feed-element border-0">' +
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

			// if (!$(this).hasClass('disabled')) {
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
			// }
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
$status = ['Awaiting Response', 'Accepted'];
$status_class = ['plain', 'success'];
$expected_salary = ['', '0 - 1,999', '2,000 - 3,999', '4,000 - 5,999', '6,000 - 7,999', '8,000 - 11,999', '12,000 - 19,999', '20,000 - 29,999', '30,000 - 49,999', '50,000 - 99,999', '100,000+'];
$work_type = ['FT' => 'Full Time', 'PT' => 'Part Time', 'CO' => 'Contract', 'TP' => 'Temporary', 'OT' => 'Other'];
$file = json_decode($offer->candidate->resume, true);
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
				<a href="javascript:void(0);">HR</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/offers') }}">Offers</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/offers') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			{{ $offer->reference_no }}
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight min-detail">

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
					<span class="text-muted">Create Date: </span> <span>{{ date('Y-m-d', strtotime($offer->created_at)) }}</span>
				</li>

				<li>
					<span class="text-muted">Submit Date: </span> <span>{{ date('Y-m-d', strtotime($offer->created_at)) }}</span>
				</li>

				<li>
					<span class="text-muted">Create By: </span> {{ ($offer->createdBy->name ? $offer->createdBy->name : '') . ' ' . ($offer->createdBy->last_name ? $offer->createdBy->last_name : '') }}
				</li>
			</ul>
		</div>

		<div class="col-md-3">
			<h5 class="text-center">DM Approval</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row">
				<span class="status text-white bg-{{ $color[$offer->dm_approved] }} d-flex align-items-center justify-content-center">
					<i class="fa fa-{{ $fa[$offer->dm_approved] }}"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Arrive Date: </span> <span>{{ date('Y-m-d', strtotime($offer->created_at)) }}</span>
				</li>

				<li>
					<span class="text-muted">Approve Date: </span> <span>{{ $offer->getDMApproval() ? date('Y-m-d', strtotime($offer->getDMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">{{ $offer->dm_approved == 1 ? 'Approved' : ($offer->dm_approved == 2 ? 'Rejected' : '') }} By: </span> {{ $offer->getDMApproval() ? $offer->getDMApproval()->createdBy->name . ($offer->getDMApproval()->createdBy->last_name ? $offer->getDMApproval()->createdBy->last_name : '') : '-' }}
				</li>

				<li>
					<span class="text-muted">Status: </span> <span>{{ $offer->dm_approved == 1 ? 'Approved' : ($offer->dm_approved == 2 ? 'Rejected' : 'Pending') }}</span>
				</li>

				@if ($offer->dm_approved == 0)
				<li>
					<span class="text-muted">Pending Time: </span>{{ time_ago($offer->created_at) . ' ago' }}
				</li>
				@endif
			</ul>
		</div>

		<div class="col-md-3">
			<h5 class="text-center">HRM Approval</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row">
				<span class="status text-white bg-{{ $color[$offer->hrm_approved] }} d-flex align-items-center justify-content-center">
					<i class="fa fa-{{ $fa[$offer->hrm_approved] }}"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Arrive Date: </span> <span>{{ $offer->dm_approved == 1 && $offer->getDMApproval() ? date('Y-m-d', strtotime($offer->getDMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">Approve Date: </span> <span>{{ $offer->hrm_approved == 1 && $offer->getHRMApproval() ? date('Y-m-d', strtotime($offer->getHRMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">{{ $offer->hrm_approved == 1 ? 'Approved' : ($offer->hrm_approved == 2 ? 'Rejected' : '') }} By: </span> {{ $offer->hrm_approved == 1 && $offer->getHRMApproval() ? $offer->getHRMApproval()->createdBy->name . ($offer->getHRMApproval()->createdBy->last_name ? $offer->getHRMApproval()->createdBy->last_name : '') : '-' }}
				</li>

				<li>
					<span class="text-muted">Status: </span> <span>{{ $offer->hrm_approved == 1 ? 'Approved' : ($offer->hrm_approved == 2 ? 'Rejected' : 'Pending') }}</span>
				</li>

				@if ($offer->dm_approved == 1 && $offer->hrm_approved == 0)
				<li>
					<span class="text-muted">Pending Time: </span>{{ $offer->getDMApproval() ? time_ago($offer->getDMApproval()->created_at) . ' ago' : '' }}
				</li>
				@endif
			</ul>
		</div>

		<div class="col-md-3">
			<h5 class="text-center">GM Approval</h5>

			<div class="d-flex justify-content-center mt-4 pt-2 pb-2 status-row last">
				<span class="status text-white bg-{{ $color[$offer->gm_approved] }} d-flex align-items-center justify-content-center">
					<i class="fa fa-{{ $fa[$offer->gm_approved] }}"></i>
				</span>
			</div>

			<ul class="list-unstyled pl-3 pr-3 mt-4 mb-0">
				<li>
					<span class="text-muted">Arrive Date: </span> <span>{{ $offer->hrm_approved == 1 && $offer->getHRMApproval() ? date('Y-m-d', strtotime($offer->getHRMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">Approve Date: </span> <span>{{ $offer->gm_approved == 1 && $offer->getGMApproval() ? date('Y-m-d', strtotime($offer->getGMApproval()->created_at)) : '-' }}</span>
				</li>

				<li>
					<span class="text-muted">{{ $offer->gm_approved == 1 ? 'Approved' : ($offer->gm_approved == 2 ? 'Rejected' : '') }} By: </span> {{ $offer->gm_approved == 1 && $offer->getGMApproval() ? $offer->getGMApproval()->createdBy->name . ($offer->getGMApproval()->createdBy->last_name ? $offer->getGMApproval()->createdBy->last_name : '') : '-' }}
				</li>

				<li>
					<span class="text-muted">Status: </span> <span>{{ $offer->gm_approved == 1 ? 'Approved' : ($offer->gm_approved == 2 ? 'Rejected' : 'Pending') }}</span>
				</li>

				@if ($offer->hrm_approved == 1 && $offer->gm_approved == 0)
				<li>
					<span class="text-muted">Pending Time: </span>{{ $offer->getHRMApproval() ? time_ago($offer->getHRMApproval()->created_at) . ' ago' : '' }}
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
						<div class="ibox-title indented">
							<h5>Candidate Details</h5>
						</div>

						<div class="ibox-content">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Name</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->name." ".$offer->candidate->last_name }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Gender</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->gender }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Age</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->age ? $offer->candidate->age : '-' }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Position</label>
										<p class="form-control-static font-weight-bold">
                                            {{ $offer->candidate->position?$offer->candidate->position->title:'' }}</p>
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
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->phone }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Email</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->email }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Skype</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->skype ? $offer->candidate->skype : '-' }}</p>
									</div>

									<div class="form-group form-inline">
										<label class="text-muted mb-0">Other Contact</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->other_contact ? $offer->candidate->other_contact : '-' }}</p>
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
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->nationality }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Location</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->location }}</p>
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
										<p class="form-control-static font-weight-bold">{{
										$offer->candidate->fixed_salary?$offer->candidate->fixed_salary:'' }}</p>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Expected Work Type</label>
										<p class="form-control-static font-weight-bold">{{
										($offer->candidate->workType && $offer->candidate->work_type)?$offer->candidate->workType->full_name : ''}}</p>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-inline">
										<label class="text-muted mb-0">Expected Benefits</label>
										<p class="form-control-static font-weight-bold">{{ $offer->candidate->other_benefits ? $offer->candidate->other_benefits : '-' }}</p>
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
										@if ($offer->candidate->resume)
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
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-12">
								<div class="m-b-md">
									<h3>
										<!-- <img src="{{ URL::asset('img/certification.svg') }}" height="24" alt=""> -->
										<i class="fas fa-award text-navy mr-1"></i>
										Offer for {{ $offer->candidate->name . ' ' . $offer->candidate->last_name }} 
										<!-- <a href="{{ url('admin/pdf-template/generate/?ids=' . $offer->id) }}" title="Download PDF">
											<img src="{{ URL::asset('img/icon-pdf.jpg') }}" class="ml-2" width="16">
										</a> -->
									</h3>

								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Name:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1"><a href="{{ url('admin/candidate/detail/' . $offer->candidate->id) }}" class="text-primary" target="_blank">{{ $offer->candidate->name." ".$offer->candidate->last_name }}</a></dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Status:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-{{ $status_class[$offer->accepted] }}">{{ $status[$offer->accepted] }}</span></dd></div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Original Position:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $offer->candidate->old_position?$offer->candidate->old_position->title:'' }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>New Position:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $offer->position? $offer->position->title: '' }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Position Type:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $work_type[$offer->position_type] }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Salary:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $offer->candidate->fixed_salary ? '$' . $offer->candidate->fixed_salary : '' }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Report To:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $offer->reportTo ? $offer->reportTo->title : '' }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Rotation Type:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $offer->rotationType ? $offer->rotationType->title : '' }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Start Date:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ date('Y-m-d', strtotime($offer->work_start_date)) }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Contract Duration:</dt> </div>
									<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{ $offer->contractDuration ? $offer->contractDuration->title : '' }}</dd> </div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>Download PDF:</dt> </div>
									<div class="col-sm-8 text-sm-left">
										<dd class="mb-1">
											<a href="{{ url('admin/pdf-template/generate/?ids=' . $offer->id) }}" title="Download PDF">
												<img src="{{ URL::asset('img/icon-pdf.jpg') }}" width="16">
											</a>
										</dd> 
									</div>
								</dl>
							</div>

							{{--
							<div class="col-lg-12 mt-3">
								<dl class="row mb-1">
									<div class="col-sm-4"><dt>DM Approved:</dt> </div>
									<div class="col-sm-8 text-sm-left">
										<dd class="mb-1"><i class="fa fa-{{ $approval_icon[$offer->dm_approved] }} text-{{ $approval_class[$offer->dm_approved] }}"></i></dd>
									</div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>HRM Approved:</dt> </div>
									<div class="col-sm-8 text-sm-left">
										<dd class="mb-1"><i class="fa fa-{{ $approval_icon[$offer->hrm_approved] }} text-{{ $approval_class[$offer->hrm_approved] }}"></i></dd>
									</div>
								</dl>

								<dl class="row mb-1">
									<div class="col-sm-4"><dt>GM Approved:</dt> </div>
									<div class="col-sm-8 text-sm-left">
										<dd class="mb-1"><i class="fa fa-{{ $approval_icon[$offer->gm_approved] }} text-{{ $approval_class[$offer->gm_approved] }}"></i></dd>
									</div>
								</dl>
							</div>
							--}}
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
												@if ($offer->comments)
													<div class="feed-element border-0 pb-0">
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
															<small class="text-muted">{{ $offer->updated_at }}</small>
															<div class="well">
																{{ $offer->comments }}
															</div>
														</div>
													</div>
												@else
													@if (($user->hasRole('DM') && $offer->dm_approved != 0) 
														|| ($user->hasRole('HRM') && $offer->hrm_approved != 0)
														|| ($user->hasRole('GM') && $offer->gm_approved != 0) 
														|| ($user->hasRole('itfpobadmin')))
														<p>No comments.</p>
													@endif
												@endif

												@if (($user->hasRole('DM') && $offer->dm_approved == 0) 
													|| ($user->hasRole('HRM') && $offer->hrm_approved == 0)
													|| ($user->hasRole('GM') && $offer->gm_approved == 0))
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
														<form action="{{ url('admin/offer/comment/save') }}">
															<input type="hidden" name="offer_id" value="{{ $offer->id }}">
															<div class="form-group mb-2 mt-2">
																<textarea name="status_details" id="status_details" rows="4" class="form-control"></textarea>
															</div>
															<span class="text-danger hide">Please add a comment.</span>
															<!-- <a href="" class="btn btn-sm btn-white float-right add-comment">Add Comment</a> -->
														</form>
													</div>
												</div>

												{!! $returnHTML !!}
												@endif

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