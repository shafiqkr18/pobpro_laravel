@extends('admin.layouts.default')

@section('title')
	Update Meeting
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.chosen-container {
	padding-bottom: 1px;
}

.chosen-container-multi .chosen-choices {
	/* min-height: 224px; */
	max-height: 224px;
	overflow-y: scroll;
	display: flex;
	flex-direction: column;
	padding: 0 7px;
}

.chosen-container-multi .chosen-choices li.search-choice {
	background: none;
	font-weight: bold;
	color: #1c84c6;
	margin: 0;
	border: 0;
	padding-top: 5px;
	padding-bottom: 5px;
}

.topic-placeholder {
	display: none;
}

.new-topic-task > input {
	height: 24px;
}

.topics > a:not(.assigned),
.tasks > a:not(.assigned) {
	background: transparent;
	color: #1c84c6;
}

.select2-container {
	z-index: 99999 !important;
	width: 100% !important;
}

.form-group.form-inline {
	padding: 0;
}

.form-group.form-inline > label {
	width: 70px;
	min-width: 70px;
	justify-content: center;
}

.note-editor {
	z-index: 99999 !important;
}

.note-btn-group > .note-btn {
	padding: 2px 6px;
}

.note-editing-area {
	padding-top: 40px;
}

.select2-container {
	z-index: 99999 !important;
	width: 100% !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/admin/meetings.js?v=') }}{{rand(11,99)}}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.clockpicker').clockpicker();

	$('.chosen-select').chosen({
		width: '100%'
	});

	$('.summernote').summernote({
		height: 200,
		toolbar: [
			// [groupName, [list of button]]
			['style', ['bold', 'italic', 'underline']],
			// ['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['insert', ['link']],
			// ['view', ['codeview']],
		]
	});

	if ($('.select2').length) {
		$('.select2').select2();
	}
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
				Management
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/minutes-of-meeting') }}">Minutes of Meeting</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/minutes-of-meeting/detail/' . $mom->id) }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			Update
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<form role="form" id="frm_meeting" enctype="multipart/form-data">
        <input type="hidden" id="meeting_id" name="meeting_id" value="{{$mom->id}}">
        <input type="hidden" id="listing_id" name="listing_id" value="{{$mom->id}}">
        <input type="hidden" name="is_update" value="1">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Meeting Details</h5>
					</div>

					<div class="ibox-content">

							<div class="form-row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Subject</label>
										<input type="text" class="form-control form-control-sm" name="subject" id="subject" value="{{$mom->subject}}">
									</div>

									<div class="form-row">
										<div class="col-md-6">
											<div class="form-row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Date</label>
														<div class="input-daterange input-group" id="datepicker">
															<input type="text" class="form-control-sm form-control text-left" id="meeting_date" name="meeting_date" value="{{$mom->meeting_date? date('m/d/Y',strtotime($mom->meeting_date)) : ''}}">
														</div>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Time</label>
														<div class="input-group clockpicker" data-autoclose="true">
															<input type="text" class="form-control form-control-sm" id="meeting_time" name="meeting_time" value="{{$mom->meeting_time}}">
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>Location</label>
												<input type="text" class="form-control form-control-sm" name="location" id="location" value="{{$mom->location}}">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>Objective Summary</label>
										<textarea name="summary" id="summary" rows="10" class="form-control">{{$mom->summary}}</textarea>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Department</label>
										<select name="dept_id" id="dept_id" class="form-control form-control-sm" size>
											<option value="" selected></option>
											@foreach ($departments as $department)
											<option value="{{ $department->id }}" {{ $mom->dept_id ==$department->id ? 'selected' : ''  }}>{{ $department->department_short_name }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label>Host</label>
										<select name="host_id" id="host_id" class="form-control form-control-sm" size>
											<option value="" ></option>
											@foreach ($users as $user)
											<option value="{{ $user->id }}" {{ $mom->host_id ==$user->id ? 'selected' : ''  }}>{{ $user->getName() }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label>Attendants</label>
										<select data-placeholder="Select users" class="chosen-select form-control form-control-sm" size multiple tabindex="2" id="attendants" name="attendants[]">
											@foreach ($users as $user)
											<option value="{{ $user->id }}" {{ (in_array($user->id,$meeting_attendants)) ? 'selected' : ''  }}><span class="text-primary font-weight-bold">{{ $user->getName() }}</span></option>
											@endforeach
										</select>
										<!-- <div class="attendants"></div>
										<div class="d-flex flex-nowrap justify-content-center">
											<a href="" class="btn btn-primary mr-1">Add</a>
											<a href="" class="btn btn-danger ml-1">Remove</a>
										</div> -->
									</div>
								</div>
							</div>

					</div>

				</div>

				<!-- <div class="row d-flex align-items-center justify-content-center mt-4">

					<a href="javascript:void(0)" id="save_meeting" class="btn btn-success mr-2 ml-2" data-start="0" btn-type="0">Create</a>
					<a href="javascript:void(0)" id="save_meeting_record1" class="btn btn-success mr-2 ml-2" data-start="1" data-toggle="modal" data-target="#mom-recording" btn-type="1" >Create &amp; Start to Record</a>
					<a href="{{ route('meeting-list') }}" class="btn btn-success mr-2 ml-2">Cancel</a>
				</div> -->
			</div>

			{{--
			<div class="col-lg-4">
				<div class="ibox h-100 d-flex flex-column">
					<div class="ibox-title">
						<h5>Topics &amp; Tasks</h5>
					</div>

					<div class="ibox-content flex-fill">
						<div class="d-flex mb-3">
							<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#tasks_modal">
								Assign
							</a>
						</div>

						<h5 class="d-flex align-items-center flex-nowrap">
							<em class="fab fa-slack-hash text-warning mr-1"></em> Assigned Topics

							<!-- <a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#topics_modal">
								Assign
							</a> -->
						</h5>

						<ul class="folder-list mb-3" style="padding: 0">
                            @if (count($mom->topicRelationships) > 0)
                                @foreach ($mom->topicRelationships as $mom_topic)
                                    <li>
                                        <a href="{{ url('admin/topic/detail/' . $mom_topic->topic->id) }}" class="d-flex align-items-center flex-nowrap pt-1 pb-1">
                                            <span class="ellipsis pr-2"># {{ $mom_topic->topic?$mom_topic->topic->title:'' }}</span>
								<span class="ml-auto font-normal"><i class="fa fa-share-alt-square text-warning m-0"></i></span>
                                        </a>
							</li>
                                @endforeach
                            @else
                                <li class="d-flex align-items-center flex-nowrap pt-1 pb-1 pl-3 border-0">
                                    No topics assigned.
							</li>
                            @endif
						</ul>

						<h5 class="d-flex align-items-center flex-nowrap">
							<em class="fab fa-slack-hash text-warning mr-1"></em> Assigned Tasks

							<!-- <a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#tasks_modal">
								Assign
							</a> -->
						</h5>

						<ul class="folder-list mb-3" style="padding: 0">
                            @if (count($mom->taskRelationships) > 0)
                                @foreach ($mom->taskRelationships as $mom_task)
                                    <li>
                                        <a href="{{ url('admin/task/detail/' . $mom_task->task->id) }}" class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="font-normal mr-1"><i class="far fa-check-square text-muted m-0"></i></span>
                                            <span class="ellipsis pr-2">{{ $mom_task->task->title }}</span>
                                            @if ($mom_task->task->due_date)
                                                <span class="font-normal text-warning ml-auto text-nowrap"><!--IT--> <i class="far fa-dot-circle text-warning mr-1"></i>{{ date('m/d/Y', strtotime($mom_task->task->due_date)) }}</span>
                                            @endif
                                        </a>
							</li>
                                @endforeach
                            @else
                                <li class="d-flex align-items-center flex-nowrap pt-1 pb-1 pl-3 border-0">
                                    No tasks assigned.
							</li>
                            @endif
						</ul>
					</div>
				</div>
			</div>
			--}}

		</div>

		<div class="row mt-4">
			<div class="col-lg-12 d-flex">
				<a href="javascript:void(0)" id="save_meeting" class="btn btn-sm btn-primary btn-save ml-auto">Save</a>
			</div>
		</div>
	</form>
</div>

{{--<div class="modal inmodal fade" id="topics_modal" tabindex="-1" role="dialog"  aria-hidden="true">--}}
{{--	<div class="modal-dialog">--}}
{{--		<div class="modal-content">--}}
{{--			<div class="modal-header p-3 d-flex flex-nowrap">--}}
{{--				<h4 class="m-0">Assign Topics</h4>--}}
{{--				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>--}}
{{--			</div>--}}

{{--			<div class="modal-body pt-3 pl-3 pr-3 pb-3 bg-white">--}}
{{--				<div class="d-flex align-items-center flex-nowrap new-topic-task mb-3">--}}
{{--					<input type="text" name="new_topic" id="new_topic" class="form-control form-control-sm mr-2">--}}
{{--					<a href="" class="btn btn-xs btn-success create-new-topic">--}}
{{--						<i class="fas fa-plus mr-1"></i> Create topic--}}
{{--					</a>--}}
{{--				</div>--}}

{{--				<label>Select topics:</label>--}}
{{--				<div class="topics d-flex align-items-start flex-wrap">--}}
{{--					@if ($topics)--}}
{{--						@foreach ($topics as $topic)--}}
{{--						<a href="" class="btn btn-xs btn-secondary mr-2 mb-2" data-id="{{ $topic->id }}">{{ $topic->title }}</a>--}}
{{--						@endforeach--}}
{{--					@endif--}}
{{--				</div>--}}

{{--				<div class="d-flex mt-3">--}}
{{--					<a href="" class="btn btn-primary btn-xs ml-auto btn-assign-topics">Assign Topics</a>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</div>--}}

<div class="modal inmodal fade" id="tasks_modal" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- <div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Assign Tasks</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div> -->

			<div class="modal-body p-4 bg-white">
				<h4 class="d-flex align-items-center m-0">
					<span>Assigned Tasks: </span>
					<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
				</h4>

				<ul class="assigned-tasks list-unstyled mt-3 mb-0 pl-3">
                    @foreach($mom_tasks_idss as $tasks)
					<li class="mb-2">
						<a href="" class="d-flex align-items-center">
							<div>
								<input type="checkbox" class="i-checks check-all">
							</div>

                                <span class="text-primary-color ellipsis pl-2">{{$tasks->task->title}}</span>
						</a>
					</li>
                    @endforeach
				</ul>

				<div class="border p-3 mt-4 bg-muted">
					<h4 class="d-flex align-items-center m-0">
						<span>Assign Task: </span>
					</h4>

					<div class="row mt-3">
						<div class="col-lg-7">
							<div class="form-row">
								<div class="col-lg-6">
									<div class="form-group form-inline">
										<label>@</label>
										<div class="flex-fill">
											<select class="select2 form-control form-control-sm w-100" name="user_id" id="user_id" multiple>
												@foreach($users as $user)
												<option value="{{$user->id}}">{{$user->name}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group form-inline">
										<label>Due</label>
										<div class="input-daterange input-group">
											<input type="text" class="form-control-sm form-control text-left" name="due_date" id="due_date">
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-lg-12">
									<div class="form-group form-inline">
										<label>Task</label>
										<input type="text" class="form-control form-control-sm" name="title" id="title">
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-lg-12">
									<div class="form-group form-inline">
										<label class="align-self-start mt-2">Summary</label>
										<div class="summernote"></div>
                                        <input type="hidden" name="hdn_summary" id="hdn_summary" value="">
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-5 d-flex flex-column">
							<div class="form-group">
								<label>Topics</label>
								<div class="topics d-flex align-items-start flex-wrap">


                                    @if ($topics)
                                        @foreach ($topics as $topic)
                                            <a href="" class="btn btn-xs btn-success mr-2 mb-2 ellipsis" data-id="{{ $topic->id }}">{{ $topic->title }}</a>
                                        @endforeach
                                    @endif
								</div>
							</div>

							<div class="form-group">
								<input type="text" id="new_topic" name="new_topic" class="form-control form-control-sm create-new-topicc" placeholder="New topic">
							</div>

							<div class="form-group mt-auto d-flex justify-content-center">
								<a href="javascript:void(0)" class="btn btn-sm btn-primary btn-assign-tasks" data-mom="{{ $mom->id }}">Assign Task</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-lg-12 d-flex">
						<a href="" class="btn btn-success btn-sm ml-auto">Done</a>
						<a href="" class="btn btn-sm btn-danger ml-3">Remove selected</a>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>


<!-- Recording modal -->
<div class="modal inmodal fade" id="mom-recording" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title mt-0">MOM Recording</h4>
				<!-- <small class="font-bold">Fill below information to Create Division</small> -->
			</div>
			<div class="modal-body">
				<div class="ibox-content">
					<form role="form" id="frm_recording" enctype="multipart/form-data">
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label class="text-muted mb-0">Subject</label>
									<p class="form-control-static font-weight-bold">Budget Review of 2019 - 2020</p>
								</div>

								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="text-muted mb-0">Date</label>
													<p class="form-control-static font-weight-bold mb-0 text">15/08/2019</p>
												</div>
											</div>

											<div class="col-md-6">
												<div class="form-group">
													<label class="text-muted mb-0">Time</label>
													<div class="input-group clockpicker" data-autoclose="true">
														<p class="form-control-static font-weight-bold mb-0">13:00</p>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="text-muted mb-0">Location</label>
											<p class="form-control-static font-weight-bold mb-0">HDS Tower Office 2202</p>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Objective Summary</label>
									<p class="form-control-static font-weight-bold">
										ITforce report currently completed works for the KPI system;<br>
										Planning team review and give feedback and suggestions for current works;
									</p>
								</div>
							</div>

							<div class="col-md-4">
								<div class="form-group">
									<label class="text-muted mb-0">Department</label>
									<p class="form-control-static font-weight-bold">IT</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Host</label>
									<p class="form-control-static font-weight-bold">Trent Gu</p>
								</div>

								<div class="form-group">
									<label class="text-muted mb-0">Attendants</label>
									<p class="form-control-static font-weight-bold">
										Trent Gu <br>
										Nick Chen <br>
										Ricky Wang
									</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<h5>Topics</h5>

								<div class="topics">
									<div class="topic border mb-3">
										<div class="p-2">
											<h5 class="m-0">Topic 1</h5>
										</div>

										<div class="ibox-content p-3">
											<div class="form-row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Contents</label>
														<textarea class="form-control" rows="3"></textarea>
													</div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Conclusion</label>
														<textarea class="form-control" rows="3"></textarea>
													</div>
												</div>
											</div>

											<div class="actions">
												<label>Actions and Plans</label>
												<div class="action">
													<div class="table-responsive">
														<table class="table table-bordered table-hover">
															<thead>
																<tr>
																	<th></th>
																	<th>Action and Plan</th>
																	<th>Owner</th>
																	<th class="text-nowrap">Due Date</th>
																</tr>
															</thead>

															<tbody>
																<tr>
																	<td>1</td>
																	<td>Milestone. The project milestone of initial acceptance is set to "All department complete the KPI of Q4 input". IT department should confirm the initial acceptance for the KPI works if meet this milestone</td>
																	<td>Nick Chen</td>
																	<td>Aug 31</td>
																</tr>

																<tr>
																	<td>2</td>
																	<td>Milestone. The project milestone of initial acceptance is set to "All department complete the KPI of Q4 input". IT department should confirm the initial acceptance for the KPI works if meet this milestone</td>
																	<td>Trent Gu</td>
																	<td>Dec 31</td>
																</tr>

																<tr>
																	<td>3</td>
																	<td>IT department should confirm the initial acceptance for the KPI works if meet this milestone</td>
																	<td>Ricky Wang</td>
																	<td>Dec 31</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>

												<div class="d-flex justify-content-end">
													<a href="" class="btn btn-primary btn-sm"><i class="fa fa-plus mr-1"></i> Actions</a>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div>
									<a href="" class="btn btn-sm btn-primary btn-add-topic"><i class="fa fa-plus mr-1"></i> Topic</a>
								</div>

							</div>
						</div>
					</form>

				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" role-type="0" id="save_division">Save changes</button>
			</div>
		</div>
	</div>
</div>

<div class="topic-placeholder">
	<div class="topic border mb-3">
		<div class="p-2">
			<h5 class="m-0">Topic 1</h5>
		</div>

		<div class="ibox-content p-3">
			<div class="form-row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Contents</label>
						<textarea class="form-control" rows="3"></textarea>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Conclusion</label>
						<textarea class="form-control" rows="3"></textarea>
					</div>
				</div>
			</div>

			<div class="actions">
				<label>Actions and Plans</label>
				<div class="action">
					<div class="table-responsive">
						<table class="table table-bordered table-hover">
							<thead>
								<tr>
									<th></th>
									<th>Action and Plan</th>
									<th>Owner</th>
									<th class="text-nowrap">Due Date</th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
					</div>
				</div>

				<div class="d-flex justify-content-end">
					<a href="" class="btn btn-primary btn-sm"><i class="fa fa-plus mr-1"></i> Actions</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection