@extends('admin.layouts.default')

@section('title')
	Create Report
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<style>
.select2-container.select2-container--open {
	z-index: 99999 !important;
}

.select2-container {
	width: 100% !important;
}

.table td {
	vertical-align: middle !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/reports.js?v=') }}{{rand(111,666)}}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>

			<li class="breadcrumb-item">
				<a href="{{ url('admin/reports') }}">Reports</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/reports') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Create
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-9">
            <form role="form" id="frm_new_report" enctype="multipart/form-data">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Create Report</h5>
				</div>

				<div class="ibox-content">

					<div class="panel panel-info">
						<div class="panel-heading">
							<h4>
								<i class="fas fa-info-circle"></i> Report Contents
							</h4>
						</div>

						<div class="panel-body">
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group form-inline p-0">
										<label for="">Title</label>
										<input type="text" class="form-control form-control-sm" name="title" id="title" value="Daily report for {{ date('d/m/Y') }}">
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group form-inline p-0">
										<input type="hidden" name="type" id="rpt_type" value="0">
										<label for="">Type</label>
										<div>
											<div class="btn-group type">
												<button class="btn btn-sm btn-primary" report_type="0" type="button">Daily</button>
												<button class="btn btn-sm btn-white" report_type="1" type="button">Weekly</button>
												<button class="btn btn-sm btn-white" report_type="3" type="button">Monthly</button>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group form-inline p-0">
										<input type="hidden" name="dept_id" value="{{ $department ? $department->id : 0 }}">
										<label class="mt-1">Department</label>
										<p class="form-control-static font-weight-bold mt-1">{{ $department ? $department->department_short_name : '' }}</p>
									</div>
								</div>

								<!-- <div class="col-lg-6">
									<div class="form-group form-inline p-0">
										<label class="justify-content-center">Date</label>
										<div class="input-group date input-daterange">
											<span class="input-group-addon">
												<i class="far fa-calendar-alt"></i>
											</span>
											<input type="text" class="form-control form-control-sm text-left">
										</div>
									</div>
								</div> -->
							</div>

							<h4 class="d-flex align-items-center">
								<i class="fas fa-history mr-1"></i> Last Task Updates
							</h4>

							<table class="table mb-4 previous-tasks">
								<thead>
									<tr>
										<th>Task</th>
										<th>Due</th>
										<th>Owners</th>
										<th>Status</th>
										<th>Updates</th>
										<th></th>
									</tr>
								</thead>

								<tbody>
                                @foreach($pending_tasks as $pending_task)
									<tr>
										<td>{{$pending_task->title}}</td>
										<td>{{$pending_task->due_date}}</td>
										<td class="project-people text-left">
											@if ($pending_task->users)
												@foreach ($pending_task->users as $user)
													@php $avatar = $user->avatar ? json_decode($user->avatar, true) : null; @endphp
													<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
														<img src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}" class="rounded-circle">
													</a>
												@endforeach
											@endif
										</td>
										<td>
											<input type="hidden" name="p_task_id[]" value="{{$pending_task->id}}">
											<select name="status[]" id="status" class="form-control form-control-sm select2" size>
												<option value="0" {{$pending_task->status == 0? 'selected' : ''}}>Open</option>
												<option value="2" {{$pending_task->status == 2? 'selected' : ''}}>Closed</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control form-control-sm" name="task_updates[]">
										</td>
										<td>
											<a href="" class="text-success btn-view-history" data-id="{{ $pending_task->id }}">
												View history
											</a>
										</td>
									</tr>
                                @endforeach

								</tbody>
							</table>

							<h4><i class="far fa-file mr-1"></i> Report Details</h4>
							<div class="summernote"></div>
                            <input type="hidden" name="report_details">

							<h4 class="mt-5 d-flex align-items-center">
								<i class="fas fa-tags mr-1"></i> Assigned Topics

								<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#create_topic">
									<i class="fas fa-plus mr-1"></i> New Topic
								</a>
							</h4>

							<div class="form-group">
								<select class="select2 form-control form-control-sm" name="topics[]" multiple="multiple">
                                    @foreach($topics as $topic)
									<option value="{{$topic->id}}">{{$topic->title}}</option>
									@endforeach
								</select>
							</div>
						</div>
					</div>

					<div class="panel panel-success">
						<div class="panel-heading">
							<h4>
								<i class="fas fa-rocket"></i> Next Actions &amp; Tasks
							</h4>
						</div>

						<div class="panel-body">
							<h4>Action Summary</h4>
							<div class="summernote summernote1" id="summernote1"></div>
                            <input type="hidden" name="next_actions">

							<h4 class="mt-4 d-flex align-items-center">
								Tasks
								<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#add_task">
									<i class="fas fa-plus mr-1"></i> Add task
								</a>
							</h4>

							<table class="table" id="next_tasks">
								<thead>
									<tr>
										<th>Status</th>
										<th>Task</th>
										<th>Due</th>
										<th>Owners</th>
									</tr>
								</thead>

								<tbody>

								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>

			<div class="d-flex mt-3 justify-content-end">
				<a href="" class="btn btn-sm btn-white ml-2"><i class="fas fa-pencil-alt mr-1"></i> Draft</a>
				<a href="javascript:void(0)" id="btn_new_report" class="btn btn-sm btn-primary ml-2"><i class="fas fa-save mr-1"></i> Save</a>
			</div>
			</form>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="add_task" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Create task</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body p-3 bg-white">
				<form action="{{ url('admin/report/add-next-task') }}" id="frm_add_next_task">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group form-inline">
								<label>Title: </label>
								<input type="text" class="form-control form-control-sm" name="title" id="title">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group form-inline">
								<label>Due Date: </label>
								<div class="input-daterange input-group">
									<input type="text" class="form-control-sm form-control text-left" name="due_date" id="due_date">
								</div>
							</div>
						</div>

						<div class="col-lg-6">
							<div class="form-group form-inline">
								<label>Owners: </label>
								<select class="select2 form-control form-control-sm" name="users[]" multiple="multiple">
								@if ($users)
									@foreach ($users as $user)
									<option value="{{ $user->id }}">{{ $user->getName() }}</option>
									@endforeach
								@endif
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="form-group form-inline">
								<label class="align-self-start mt-2">Contents: </label>
								<div class="summernote"></div>
								<input type="hidden" name="contents">
							</div>
						</div>
					</div>

					<div class="d-flex">
						<a href="" class="btn btn-xs btn-primary ml-auto btn-add-task"><i class="fas fa-plus mr-1"></i> Add</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="add_remark" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Add remark</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body p-3 bg-white">
				<form action="{{ url('admin/report/add-remark') }}" id="frm_add_remark">
					<div class="row">
						<div class="col-lg-12">
							<div class="form-group">
								<textarea name="comments" id="comments" rows="5" class="form-control"></textarea>
							</div>
						</div>
					</div>

					<div class="d-flex">
						<a href="" class="btn btn-xs btn-primary ml-auto btn-add-remark"><i class="fas fa-plus mr-1"></i> Add</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="update_history" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Task: <span class="task-title"></span></h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body p-3 bg-white">
				<h5 class="mb-3">Updates history:</h5>
				<ul class="history list-unstyled mt-2 mb-0">
					
				</ul>

				<!-- <div class="d-flex">
					<a href="" class="btn btn-xs btn-primary ml-auto"><i class="fas fa-save mr-1"></i> Save</a>
				</div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="create_topic" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Create topic</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body p-3 bg-white">
				<form action="{{ url('admin/topic/save') }}">
					<div class="form-group">
						<label for="">Title</label>
						<input type="text" class="form-control form-control-sm" name="title" id="title">
					</div>	

					<div class="form-group">
						<label for="">Contents</label>
						<div class="summernote new-title-contents"></div>
						<input type="hidden" name="contents">
					</div>	

					<div class="d-flex">
						<a href="" class="btn btn-xs btn-primary ml-auto btn-create-topic"><i class="fas fa-save mr-1"></i> Save</a>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection