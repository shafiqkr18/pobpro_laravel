@extends('admin.layouts.default')

@section('title')
	Letters
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<style>
.file-manager h5 {
	text-transform: none;
}

.ibox-title {
	padding: 10px;
	min-height: auto;
}

.ibox-title h5 {
	/* color: #676a6c; */
	font-size: 12px;
	margin: 0;
}

.ibox-content {
	padding: 6px 14px 1px;
}

.html5buttons {
	float: left;
	margin-left: 20px;
	margin-bottom: 20px;
}

.html5buttons .dt-buttons .btn {
	width: 32px;
}

.dataTables_info,
.dataTables_paginate {
	padding: 20px;
}

.dataTables_filter {
	padding: 0 20px;
}

.icheckbox_square-green,
.iradio_square-green {
	width: 16px;
	height: 16px;
	background-size: cover;
	margin-top: 2px;
}

.icheckbox_square-green.checked,
.icheckbox_square-green.checked.hover {
	background-position: -32px 0;
}

.icheckbox_square-green.hover {
	background-position: -16px 1px;
}

.nav-tabs .nav-link.active {
	font-weight: bold;
}

.nav-tabs .nav-link.active i {
	color: #1ab394;
}

.tooltip-inner {
	font-size: 11px;
	background: #fff;
	border: 1px solid #e7eaec;
	color: #676a6c;
}

.arrow:before {
	border-bottom-color: white !important;
	margin-bottom: -1px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/correspondence.js?v=') }}{{rand(11,99)}}"></script>
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
		</ol>

		<h2 class="d-flex align-items-center">
			Letters
			<a class="btn btn-primary btn-sm ml-auto mr-3" href="{{ url('admin/correspondence/letter/create') }}">Compose New Letter</a>
			<a href="{{ url('admin/correspondence/letter/create_for_received') }}" class="btn btn-success btn-sm">Receive Incoming Letter</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-3">
			<div class="">
				<div class="">
					<div class="file-manager">
						<input type="hidden" name="hdn_directions" id="hdn_id_directions">
						<input type="hidden" name="hdn_contacts" id="hdn_id_contacts">
						<input type="hidden" name="hdn_tasks" id="hdn_tasks">
						<input type="hidden" name="hdn_topics" id="hdn_topics">

						<div class="ibox-title">
							<h5><i class="fa fa-search mr-2"></i> Search</h5>
						</div>

						<div class="ibox-content">

								<div class="form-group">
									<label>From</label>
									<select  name="from" id="id_from" class="form-control form-control-sm">
                                        <option value="" >Select an option</option>
										@if (count($contacts) > 0)
											@foreach ($contacts as $contact)
											<option value="{{ $contact->id }}">{{ $contact->company }}</option>
											@endforeach
										@endif
									</select>
								</div>

								<div class="form-group">
									<label>To</label>
									<select  name="to" id="id_to" class="form-control form-control-sm">
                                        <option value="" >Select an option</option>
										@if (count($contacts_users) > 0)
											@foreach ($contacts_users as $contacts_user)
											<option value="{{ $contacts_user->id }}">{{ $contacts_user->name }}</option>
											@endforeach
										@endif
									</select>
								</div>

								<div class="form-group">
									<label>Date</label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" name="start_date" id="start_date">
										<span class="input-group-addon border-0">to</span>
										<input type="text" class="form-control-sm form-control text-left" name="end_date" id="end_date">
									</div>
								</div>

								<div class="form-group">
									<label>Keyword</label>
									<input type="text" class="form-control form-control-sm" name="keyword" id="id_keyword">
								</div>

								<a href="javascript:void(0)" class="btn btn-sm btn-success search-filter mb-2" id="btn_search">Search</a>

						</div>

						<div class="space-15"></div>

						<!--<div class="ibox-title">
							<h5><i class="fas fa-exchange-alt mr-2"></i> By Direction</h5>
						</div>
						<div class="ibox-content">
							<ul class="folder-list" style="padding: 0">
								<li class="d-flex align-items-center pt-2 pb-2">
									<input type="checkbox" class="i-checks checkbox-filter" name="direction[]" value="IN"> <span class="ml-2">Oriented IN</span>
									<span class="label label-warning ml-auto">{{ $messages_in ? $messages_in->count() : '0' }}</span>
								</li>
								<li class="d-flex align-items-center pt-2 pb-2">
									<input type="checkbox" class="i-checks checkbox-filter" name="direction[]" value="OUT"> <span class="ml-2">Oriented OUT</span>
									<span class="label label-warning ml-auto">{{ $messages_out ? $messages_out->count() : '0' }}</span>
								</li>
								<li class="d-flex align-items-center pt-2 pb-2">
										<input type="checkbox" class="i-checks checkbox-filter" name="" value=""> <span class="ml-2">Preparing</span>
										<span class="label label-danger ml-auto">0</span>
								</li>

							</ul>
						</div>

						<div class="space-15"></div>-->

						<div class="ibox-title">
							<h5><i class="fas fa-address-book mr-2"></i> By Contact</h5>
						</div>
						<div class="ibox-content">
							<div class="form-group pt-2">
								<select name="contact" id="contact" class="form-control form-control-sm">
									<option value="0">Select any record</option>
									@if (count($contacts) > 0)
										@foreach ($contacts as $contact)
										<option value="{{ $contact->id }}">{{ $contact->company }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="space-15"></div>

						<div class="ibox-title">
							<h5><i class="fas fa-comments mr-2"></i> By Topic</h5>
						</div>
						<div class="ibox-content">
							<ul class="category-list" style="padding: 0">
								@if (count($topics) > 0)
									@foreach ($topics as $topic)
									<li class="d-flex align-items-start pt-2 pb-2">
										<input type="checkbox" class="i-checks checkbox-filter" name="topic[]" value="{{ $topic->id }}">
                                        <span class="ml-2" style="flex: 1;">
                                            <a class="text-primary p-0" href="{{ url('admin/topic/detail/' . $topic->id) }}">
                                            {{ $topic->title }}
                                            </a>
                                        </span>
									</li>
									@endforeach
								@endif
							</ul>
						</div>

						<div class="space-15"></div>

						<!--<div class="ibox-title bg-white border-bottom">
							<h5><i class="fas fa-crosshairs mr-2"></i> By Tasks</h5>
						</div>
						<div class="ibox-content bg-white">
							<ul class="category-list" style="padding: 0">
								@if (count($tasks) > 0)
									@foreach ($tasks as $task)
									<li class="d-flex align-items-center pt-2 pb-2">
										<input type="checkbox" class="i-checks checkbox-filter" name="task[]" value="{{ $task->id }}"> <span class="ml-2">{{ $task->title }} </span>
									</li>
									@endforeach
								@endif
								<div style="clear: both;"></div>
							</ul>
						</div>-->
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-9 animated fadeInRight">

			<!-- <div class="form-row mb-4">
				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title bg-white border-bottom">
							<span class="label label-success float-right">Total</span>
							<h5>RECEIVED</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">40 6,200</h1>
							<div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
							<small>Letters</small>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title bg-white border-bottom">
							<span class="label label-info float-right">Total</span>
							<h5>SENT</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">5,800</h1>
							<div class="stat-percent font-bold text-info">20% <i class="fas fa-level-up-alt"></i></div>
							<small>Letters</small>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title bg-white border-bottom">
							<span class="label label-primary float-right">Today</span>
							<h5>New</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">5</h1>
							<div class="stat-percent font-bold text-navy">44% <i class="fas fa-level-up-alt"></i></div>
							<small>Letters</small>
						</div>
					</div>
				</div>

				<div class="col-lg-3">
					<div class="ibox ">
						<div class="ibox-title bg-white border-bottom">
							<span class="label label-danger float-right">Preparing</span>
							<h5>Ltters</h5>
						</div>
						<div class="ibox-content">
							<h1 class="no-margins">2</h1>
							<div class="stat-percent font-bold text-danger">38% <i class="fas fa-level-down-alt"></i></div>
							<small>In Progress</small>
						</div>
					</div>
				</div>
			</div> -->

			<!-- <div class="row mb-3">
				<div class="col-lg-12 d-flex">
					<a class="btn btn-primary btn-sm ml-auto mr-3" href="{{ url('admin/correspondence/letter/create') }}">Compose New Letter</a>
					<a href="{{ url('admin/correspondence/letter/create_for_received') }}" class="btn btn-success btn-sm">Receive Incoming Letter</a>
				</div>
			</div> -->

			<!-- <div class="mail-box-header">
				<h2 class="d-flex align-items-center">
					<span class="text-capitalize">Letters</span> <span class="ml-1">({{ $messages ? $messages->count() : '0' }})</span>
				</h2>
			</div> -->

			<ul class="nav nav-tabs" id="letters-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="inbox-tab" data-toggle="tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="true">
						<i class="fas fa-inbox mr-1"></i>
						Inbox @if (count($messages_in) > 0) <span class="inbox-count">({{ count($messages_in) }})</span> @endif
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="sent-tab" data-toggle="tab" href="#sent" role="tab" aria-controls="sent" aria-selected="false">
						<i class="far fa-paper-plane mr-1"></i>
						Sent @if (count($messages_out) > 0) <span class="sent-count">({{ count($messages_out) }})</span> @endif
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="drafts-tab" data-toggle="tab" href="#drafts" role="tab" aria-controls="drafts" aria-selected="false">
						<i class="fas fa-file mr-1"></i>
						Drafts
					</a>
				</li>
			</ul>

			<div class="mail-box pt-4">
				<div class="tab-content" id="letters-tab-content">
					<div class="tab-pane fade show active" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
						<table class="table table-hover table-mail" id="messages_table" style="width: 100%;">
							<thead>
								<tr>
									<th class="check-mail">
										<input type="checkbox" class="i-checks check-all">
									</th>
									<th>RefNo</th>
									<th>To</th>
									<th>From</th>
									<th>Subject</th>
									<th>Status</th>
									<th>Topics</th>
									<th><i class="fa fa-paperclip"></i></th>
									<th>Time</th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
					</div>

					<div class="tab-pane fade" id="sent" role="tabpanel" aria-labelledby="sent-tab">
						<table class="table table-hover table-mail" id="messages_sent_table" style="width: 100%;">
							<thead>
								<tr>
									<th class="check-mail">
										<input type="checkbox" class="i-checks check-all">
									</th>
									<th>RefNo</th>
									<th>To</th>
									<th>From</th>
									<th>Subject</th>
									<th>Status</th>
									<th>Topics</th>
									<th><i class="fa fa-paperclip"></i></th>
									<th>Time</th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
					</div>

					<div class="tab-pane fade" id="drafts" role="tabpanel" aria-labelledby="drafts-tab">

					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection