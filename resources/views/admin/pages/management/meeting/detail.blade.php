@extends('admin.layouts.default')

@section('title')
	View Meeting
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
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
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/admin/meetings.js') }}"></script>
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

	$('.select2').select2();

	$('.summernote').summernote({
		height: 200,
		toolbar: [
			// [groupName, [list of button]]
			['style', ['bold', 'italic', 'underline', 'clear']],
			// ['font', ['strikethrough', 'superscript', 'subscript']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['insert', ['link']],
			// ['view', ['codeview']],
		]
	});

	// create new topic
	$(document).on('click', '.btn-create-topic', function (e) {
		e.preventDefault();

		$('#create_topic form [name="contents"]').val($('#create_topic form .summernote').summernote('code'));
		let formData = new FormData($(this).closest('form')[0]);

		$.ajax({
			url: $(this).closest('form').attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				console.log(data);

				if (data.success) {
					var newOption = new Option(data.topic.title, data.topic.id, false, false);
					toastr.success(data.message);
					$('[name="topics[]"]').append(newOption).trigger('change');
					$('#create_topic').modal('hide');
				}
			},
			error: function (err) {
				console.log(err);
			}
		});
	});

	// add task to next tasks table
	$(document).on('click', '.btn-add-task', function (e) {
		e.preventDefault();

		$('#frm_add_next_task input[name="contents"]').val($('#frm_add_next_task .summernote').summernote('code'));
		let formData = new FormData($('#frm_add_next_task')[0]);

		$.ajax({
			url: $('#frm_add_next_task').attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.view) {
					$('#add_task').modal('hide');
					$('#next_tasks tbody').append(data.view);
				}
			},
			error: function (err) {
				console.log(err);
			}
		});

	});

	// reset form on modal hide
	$('#add_task').on('hide.bs.modal', function (e) {
		$('#frm_add_next_task')[0].reset();
		$('#frm_add_next_task .select2').select2().val(null).trigger('change');
		$('#frm_add_next_task .summernote').summernote('reset');
	});

	// fix scrolling issue when closing second modal
	$(document).on('hidden.bs.modal', '.modal', function () {
		$('.modal:visible').length && $(document.body).addClass('modal-open');
	});

	$('.input-daterange').datepicker().on('hide.bs.modal', function (event) {
		// prevent datepicker from firing bootstrap modal "show.bs.modal"
		event.stopPropagation();
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

			View
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInUp">
	<div class="row">

	<div class="col-lg-4 d-flex flex-column">

<div class="ibox-title pr-3">
							<h5 class="d-flex align-items-center">
								Meeting Actions Timeline
							</h5>

					</div>

					<div class="ibox-content inspinia-timeline flex-fill">
                        @if(count($all_tasks) > 0)
                            @foreach($all_tasks as $all_task)
							<div class="timeline-item">
									<div class="row">
											<div class="col-3 date">
													<i class="fa fa-briefcase"></i>
                                                {{date('d M, h:i A',strtotime($all_task->due_date))}}
													<br/>
													<small class="text-navy">{{time_ago($all_task->created_at)}} ago</small>
											</div>
											<div class="col-9 content no-top-border">
													<p class="m-b-xs"><strong>{{$all_task->title}}</strong></p>

												<p>{!! $all_task->contents !!}</p>


											</div>
									</div>
							</div>
                            @endforeach
					@else
					<h5 class="no-tasks">There are no actions to display.</h5>
                        @endif

					</div>


	</div>
	<div class="col-lg-8 d-flex flex-column">
					<div class="ibox flex-fill">
							<div class="ibox-content h-100">
									<div class="row">
											<div class="col-lg-12">
													<div class="m-b-md">
															<a href="{{ url('admin/minutes-of-meeting/update/' . $mom->id) }}" class="btn btn-white btn-xs float-right">Edit meeting</a>
															<h2>{{$mom->subject}}</h2>
													</div>

											</div>
									</div>
									<div class="row">
											<div class="col-lg-6">
{{--													<dl class="row mb-0">--}}
{{--															<div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>--}}
{{--															<div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-primary">Active</span></dd></div>--}}
{{--													</dl>--}}
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Created by:</dt> </div>
															<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{$mom->createdBy->name}}</dd> </div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Location:</dt> </div>
															<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{$mom->location}}</dd></div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"><dt>Host:</dt> </div>
															<div class="col-sm-8 text-sm-left"> <dd class="mb-1"><a href="#" class="text-navy"> {{$mom->host->name}}</a> </dd></div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right"> <dt>Department:</dt></div>
															<div class="col-sm-8 text-sm-left"> <dd class="mb-1"> {{$mom->department? $mom->department->department_short_name:''}} </dd></div>
													</dl>

											</div>
											<div class="col-lg-6" id="cluster_info">

													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right">
																	<dt>Meeting Date:</dt>
															</div>
															<div class="col-sm-8 text-sm-left">
																	<dd class="mb-1">{{$mom->meeting_date}} {{$mom->meeting_time}}</dd>
															</div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right">
																	<dt>Created:</dt>
															</div>
															<div class="col-sm-8 text-sm-left">
																	<dd class="mb-1"> {{$mom->created_at}}</dd>
															</div>
													</dl>
													<dl class="row mb-0">
															<div class="col-sm-4 text-sm-right">
																	<dt>Participants:</dt>
															</div>
															<div class="col-sm-8 text-sm-left">
																	<dd class="project-people mb-1">
                                                                        @if($mom->attendants)
                                                                            @foreach($mom->attendants as $att)
                                                                                @if($att->attendant)

                                                                                        @php
                                                                                        //print_r($att->attendant);exit();
                                                                                         $avatar = $att->attendant->avatar?  json_decode($att->attendant->avarat, true) : null;
                                                                                        @endphp
                                                                                    @if($avatar)
                                                                                            <a href=""><img alt="image" title="{{$att->attendant->name}}" class="rounded-circle" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}"></a>
                                                                                        @else
                                                                                            <a href=""><img alt="image" title="{{$att->attendant->name}}" class="rounded-circle" src="{{ URL::asset('img/avatar-default.jpg') }}"></a>
                                                                                        @endif


                                                                                @endif

                                                                            @endforeach
                                                                        @endif


																	</dd>
															</div>
													</dl>
											</div>

											<div class="col-lg-12">
												<dl class="row mb-0">
													<div class="col-sm-2 text-sm-right"><dt>Summary:</dt> </div>
													<div class="col-sm-10 text-sm-left"> <dd class="mb-1">  {{$mom->summary}}</dd></div>
												</dl>
											</div>
									</div>

		<div class="row mt-4">
			<div class="col-lg-12">
			<div class="panel panel-default">
						<div class="panel-heading d-flex align-items-center">
							Minutes of Meeting Contents
							<a href="" class="btn btn-white btn-xs ml-auto" data-toggle="modal" data-target="#create_meeting">Edit MoM</a>
						</div>
						<div class="panel-body">



			<div class="wrapper wrapper-content project-manager">


					<p> {!! $mom->mom_contents !!}</p>

                <h4 class="text-warning"><i class="fas fa-tags mr-1"></i> Assigned Topics</h4>
					<div class="text-center m-t-md">
                        @if (count($mom->topicRelationships)>0)
                            @foreach ($mom->topicRelationships as $letter_topic)
							<a href="{{ url('admin/topic/detail/' . $letter_topic->topic->id) }}" class="btn btn-xs btn-primary">{{ $letter_topic->topic?$letter_topic->topic->title:'' }}</a>

                            @endforeach
                            @endif

					</div>

</div>

				</div>



			</div>

			<!-- <h4><i class="far fa-file mr-1"></i> Minutes</h4>
			<div class="summernote">{!! $mom->summary !!}</div>
			<input type="hidden" name="contents">

			<h4 class="mt-5 d-flex align-items-center">
				<i class="fas fa-tags mr-1"></i> Assigned Topics

				<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#create_topic">
					<i class="fas fa-plus mr-1"></i> New Topic
				</a>
			</h4>

			<div class="form-group">
				<select class="select2 form-control form-control-sm" name="topics[]" multiple="multiple">
					<option value="0">static data</option>
				</select>
			</div> -->
		</div>

							</div>

					</div>

			</div>
    </div>

	</div>
</div>

<div class="modal inmodal fade" id="create_meeting" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content b-r-md">

			<div class="modal-body p-0 bg-white b-r-md">
                <form role="form" id="frm_meeting_mom" enctype="multipart/form-data">
                    <input type="hidden" name="meeting_id" id="meeting_id" value="{{$mom->id}}">
					<div class="panel panel-info m-0">
						<div class="panel-heading">
							<h4 class="d-flex align-items-center">
								<i class="fas fa-info-circle mr-1"></i> Meeting Details
								<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-white"></i></a>
							</h4>
						</div>

						<div class="panel-body">

							<div class="form-row">
								<div class="col-md-8">
									<div class="form-group">
										<label>Subject</label>
										<p class="form-control-static font-weight-bold">{{ $mom->subject }}</p>
									</div>

									<div class="form-row">
										<div class="col-md-6">
											<div class="form-row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Date</label>
														<p class="form-control-static font-weight-bold">{{ date('d M Y', strtotime($mom->meeting_date)) }}</p>
			</div>
		</div>

												<div class="col-md-6">
													<div class="form-group">
														<label>Time</label>
														<p class="form-control-static font-weight-bold">{{ date('h:i a', strtotime($mom->meeting_time)) }}</p>
													</div>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>Location</label>
												<p class="form-control-static font-weight-bold">{{ $mom->location }}</p>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>Objective Summary</label>
										<p class="form-control-static font-weight-bold">{{ $mom->summary }}</p>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Department</label>
										<p class="form-control-static font-weight-bold">{{ $mom->department ? $mom->department->department_short_name : '' }}</p>
									</div>

									<div class="form-group">
										<label>Host</label>
										<p class="form-control-static font-weight-bold">{{ $mom->host ? $mom->host->getName() : '' }}</p>
									</div>

									<div class="form-group">
										<label>Attendants</label>
										<p class="form-control-static">
										@if ($mom->attendants)
											@foreach ($mom->attendants as $attendant)
											<span class="label mr-1 mb-1">{{ $attendant->attendant ? $attendant->attendant->getName() : '' }}</span>
											@endforeach
										@endif
										</p>
							</div>
								</div>
							</div>

							<h4><i class="far fa-file mr-1"></i> Minutes</h4>
							<div class="summernote">{!! $mom->mom_contents !!}</div>
							<input type="hidden" name="mom_contents">

							<h4 class="mt-5 d-flex align-items-center">
								<i class="fas fa-tags mr-1"></i> Assigned Topics

								<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#create_topic">
									<i class="fas fa-plus mr-1"></i> New Topic
								</a>
							</h4>

							<div class="form-group">
								<select class="select2 form-control form-control-sm" name="topics[]" multiple="multiple">
								@foreach($topics as $topic)
								<option value="{{$topic->id}}" {{ in_array($topic->id, $mom_topics) ? 'selected' : '' }}>{{$topic->title}}</option>
								@endforeach
								</select>
							</div>

							<h4 class="mt-5 d-flex align-items-center">
								<i class="fab fa-slack-hash mr-1"></i> Tasks
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
								@if ($all_tasks)
									@foreach ($all_tasks as $task)
									<tr>
										<td>Open</td>
										<td>{{ $task && $task->title ? $task->title : '' }}</td>
										<td>{{ $task && $task->due_date ? date('m/d/Y', strtotime($task->due_date)) : '' }}</td>
										<td class="project-people text-left">
											@if ($task->users)
												@foreach ($task->users as $user)
													@php $avatar = $user->avatar ? json_decode($user->avatar, true) : null; @endphp
													<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
														<img src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}" class="rounded-circle">
													</a>
												@endforeach
											@endif
										</td>
									</tr>
									@endforeach
								@endif
								</tbody>
							</table>

						</div>

						<div class="d-flex mt-4 p-4">
							<a href="javascript:void(0)" id="btn_meeting_mom" class="btn btn-sm btn-primary ml-auto btn-save-minutes">
								<i class="fas fa-save mr-1"></i> Save</a>
						</div>
					</div>

				</form>
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
@endsection
