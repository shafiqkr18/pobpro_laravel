@extends($modal == 0 ? 'admin.layouts.default' : 'admin.layouts.modal_regular')

@section('title')
	Create Meeting
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
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

.topics > a:not(.assigned),
.tasks > a:not(.assigned) {
	background: #fff;
	color: #676a6c;
}

.select2-container.select2-container--open {
	z-index: 99999 !important;
}

.select2-container {
	width: 100% !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/admin/meetings.js?v=') }}{{rand(111,999)}}"></script>
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
});
</script>
@endsection

@section('content')
@if ($modal == 0)
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
			<a href="{{ url('admin/minutes-of-meeting') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			Create
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
@endif
	<form role="form" id="frm_meeting" enctype="multipart/form-data">
		@if ($modal == 1)
		<input type="hidden" name="is_modal" value="1">
		@endif
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Meeting Details</h5>
					</div>

					<div class="ibox-content">

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Date</label>
										<div class="input-daterange input-group" id="datepicker">
											<input type="text" class="form-control-sm form-control text-left" id="meeting_date" name="meeting_date" />
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label>Time</label>
										<div class="input-group clockpicker" data-autoclose="true">
											<input type="text" class="form-control form-control-sm" id="meeting_time" name="meeting_time">
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12">
									<div class="form-group">
										<label>Location</label>
										<input type="text" class="form-control form-control-sm" name="location" id="location">
									</div>

									<div class="form-group">
										<label>Department</label>
										<select name="dept_id" id="dept_id" class="form-control form-control-sm" size>
											<option value="" selected></option>
											@foreach ($departments as $department)
											<option value="{{ $department->id }}">{{ $department->department_short_name }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label>Host</label>
										<select name="host_id" id="host_id" class="form-control form-control-sm" size>
											<option value="" selected></option>
											@foreach ($users as $user)
											<option value="{{ $user->id }}">{{ $user->getName() }}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label>Attendants</label>
										<select data-placeholder="Select users" class="chosen-select form-control form-control-sm" size multiple tabindex="2" id="attendants" name="attendants[]">
											@foreach ($users as $user)
											<option value="{{ $user->id }}"><span class="text-primary font-weight-bold">{{ $user->getName() }}</span></option>
											@endforeach
										</select>
										<!-- <div class="attendants"></div>
										<div class="d-flex flex-nowrap justify-content-center">
											<a href="" class="btn btn-primary mr-1">Add</a>
											<a href="" class="btn btn-danger ml-1">Remove</a>
										</div> -->
									</div>

									<div class="form-group">
										<label>Subject</label>
										<input type="text" class="form-control form-control-sm" name="subject" id="subject">
									</div>

									<div class="form-group">
										<label>Objective Summary</label>
										<textarea name="summary" id="summary" rows="10" class="form-control"></textarea>
									</div>
								</div>
							</div>

					</div>

				</div>

				<!-- <div class="row d-flex align-items-center justify-content-center mt-4">
					<input type="hidden" id="meeting_id" name="meeting_id" value="0">
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
						<h5 class="d-flex align-items-center flex-nowrap">
							<em class="fab fa-slack-hash text-warning mr-1"></em> Assigned Topics

							<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#topics_modal">
								Assign
							</a>
						</h5>

						<ul class="folder-list mb-3" style="padding: 0">
							<li class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="ellipsis pr-2"># Huawei Data Center Implementation</span>
								<span class="ml-auto font-normal"><i class="fa fa-share-alt-square text-warning m-0"></i></span>
							</li>

							<li class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="ellipsis pr-2"># IT Infrastructure</span>
								<span class="ml-auto font-normal"><i class="fa fa-share-alt-square text-warning m-0"></i></span>
							</li>

							<li class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="ellipsis pr-2"># Majnoon Field IT Project</span>
								<span class="ml-auto font-normal"><i class="fa fa-share-alt-square text-warning m-0"></i></span>
							</li>
						</ul>

						<h5 class="d-flex align-items-center flex-nowrap">
							<em class="fab fa-slack-hash text-warning mr-1"></em> Assigned Tasks

							<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#tasks_modal">
								Assign
							</a>
						</h5>

						<ul class="folder-list mb-3" style="padding: 0">
							<li class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="font-normal mr-1"><i class="far fa-check-square text-muted m-0"></i></span>
								<span class="ellipsis pr-2">Contact Huawei Technical Team</span>
								<span class="font-normal text-warning ml-auto text-nowrap"><!--IT--> <i class="far fa-dot-circle text-warning mr-1"></i>25-10-2019</span>
							</li>

							<li class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="font-normal mr-1"><i class="far fa-check-square text-muted m-0"></i></span>
								<span class="ellipsis pr-2">Prepare proposal</span>
								<span class="font-normal text-warning ml-auto text-nowrap"><!--IT--> <i class="far fa-dot-circle text-warning mr-1"></i>25-10-2019</span>
							</li>

							<li class="d-flex align-items-center flex-nowrap pt-1 pb-1">
								<span class="font-normal mr-1"><i class="far fa-check-square text-muted m-0"></i></span>
								<span class="ellipsis pr-2">Reply letter</span>
								<span class="font-normal text-warning ml-auto text-nowrap"><!--IT--> <i class="far fa-dot-circle text-warning mr-1"></i>25-10-2019</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
			--}}

		</div>

		<div class="row mt-4 mb-4">
			<div class="col-lg-12 d-flex">
				<a href="javascript:void(0)" id="save_meeting" class="btn btn-sm btn-primary btn-save ml-auto">Create</a>
				<!-- <a href="javascript:void(0)" id="save_meeting_record1" class="btn btn-success ml-2" data-start="1" data-toggle="modal" data-target="#mom-recording" btn-type="1" >Create &amp; Start to Record</a> -->
			</div>
		</div>
	</form>

@if ($modal == 0)
</div>

<div class="modal inmodal fade" id="topics_modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Assign Topics</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body pt-3 pl-3 pr-3 pb-3 bg-white">
				<label>Select topics:</label>
				<div class="topics d-flex align-items-start flex-wrap">
					@if ($topics)
						@foreach ($topics as $topic)
						<a href="" class="btn btn-xs btn-secondary mr-2 mb-2" data-id="{{ $topic->id }}">{{ $topic->title }}</a>
						@endforeach
					@endif
				</div>

				<a href="" class="text-success create-trigger d-inline-block mt-2">
					<i class="fas fa-plus mr-1"></i> Create topic
				</a>

				<div class="d-flex align-items-center flex-nowrap new-topic-task mt-3 hide">
					<input type="text" name="new_topic" id="new_topic" class="form-control form-control-sm mr-2" placeholder="Title">
					<a href="" class="btn btn-sm btn-success create-new-topic">
						Create
					</a>
				</div>

				<div class="d-flex mt-3">
					<a href="" class="btn btn-primary btn-sm ml-auto btn-assign-topics">Assign Topics</a>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="tasks_modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Assign Tasks</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body pt-3 pl-3 pr-3 pb-3 bg-white">
				<label>Select tasks:</label>
				<div class="tasks d-flex align-items-start flex-wrap">
					@if ($tasks)
						@foreach ($tasks as $task)
						<a href="" class="btn btn-xs btn-secondary mr-2 mb-2" data-id="{{ $task->id }}">{{ $task->title }}</a>
						@endforeach
					@endif
				</div>

				<a href="" class="text-success create-trigger d-inline-block mt-2">
					<i class="fas fa-plus mr-1"></i> Create task
				</a>

				<div class="d-flex align-items-center flex-nowrap new-topic-task mt-3 hide">
					<input type="text" name="new_task" id="new_task" class="form-control form-control-sm mr-2" placeholder="Title">
					<div class="input-daterange input-group mr-2">
						<input type="text" class="form-control-sm form-control text-left" id="new_task_due_date" placeholder="Due Date">
					</div>
					<a href="" class="btn btn-sm btn-success create-new-task">
						Create
					</a>
				</div>

				<div class="d-flex mt-3">
					<a href="" class="btn btn-primary btn-sm ml-auto btn-assign-tasks">Assign Tasks</a>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Recording modal -->
<div class="modal inmodal fade" id="mom-recording" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header d-flex align-items-center">
				<h4>MOM Recording</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>
			<div class="modal-body bg-white p-4">

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
												<p class="form-control-static font-weight-bold mb-0">15/08/2019</p>
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
								{{--
								<div class="topic border mb-3">
									<div class="p-2">
										<h5 class="m-0">Topic 1</h5>
									</div>

									<div class="ibox-content p-3">
										<div class="form-row">
											<div class="col-md-12">
												<div class="form-group form-inline p-0">
													<label>Title</label>
													<input type="text" class="form-control form-control-sm" name="title[]" id="title">
												</div>
											</div>

											<div class="col-md-12">
												<div class="form-group form-inline p-0">
													<label>Contents</label>
													<textarea class="form-control" rows="3" name="contents[]"></textarea>
												</div>
											</div>

											<!-- <div class="col-md-6">
												<div class="form-group">
													<label>Conclusion</label>
													<textarea class="form-control" rows="3"></textarea>
												</div>
											</div> -->
										</div>

										<div class="actions">
											<label>Actions and Plans</label>
											<div class="action">
												<div class="table-responsive">
													<table class="table table-bordered">
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
												<a href="" class="btn btn-success btn-xs"><i class="fas fa-plus mr-1"></i> Actions</a>
											</div>
										</div>
									</div>
								</div>
								--}}
							</div>

							<div>
								<a href="" class="btn btn-xs btn-success btn-add-topic"><i class="fas fa-plus mr-1"></i> Topic</a>
							</div>

						</div>
					</div>
				</form>

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
		<!-- <div class="p-2">
			<h5 class="m-0">Topic 1</h5>
		</div> -->

		<div class="ibox-content p-3">
			<div class="">
				Select from <a href="" class="text-success topic-add" data-type="existing">existing</a> or <a href="" class="text-navy topic-add" data-type="new">create new</a> topic.
			</div>

			<div class="existing-topic hide">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group form-inline p-0">
							<label>Title</label>
							<select name="topic_id[]" id="topic_id" class="select2 form-control-form-control-sm">
								<option value="0">Topic A</option>
								<option value="1">Lorem ipsum</option>
								<option value="2">Topic B</option>
								<option value="3">Another option here</option>
							</select>
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group form-inline p-0">
							<label class="align-self-start mt-1">Contents</label>
							<div>
								Lorem ipsum, dolor sit amet consectetur adipisicing elit. Doloremque, accusantium quis quos nisi numquam veritatis eius sunt, ipsum, tenetur assumenda rem facilis distinctio. Commodi adipisci a ipsum esse quo quaerat.
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="new-topic hide">
				<div class="form-row">
					<div class="col-md-12">
						<div class="form-group form-inline p-0">
							<label>Title</label>
							<input type="text" class="form-control form-control-sm" name="title[]" id="title">
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group form-inline p-0">
							<label class="align-self-start mt-1">Contents</label>
							<textarea class="form-control" rows="3" name="contents[]"></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="tasks hide">
				<label>Tasks</label>
				<div class="action">
					<div class="table-responsive">
						<table class="table tasks-table table-bordered">
							<thead>
								<tr>
									<th></th>
									<th>Title</th>
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
					<a href="" class="btn btn-success btn-xs btn-add-task"><i class="fa fa-plus mr-1"></i> Tasks</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@endsection