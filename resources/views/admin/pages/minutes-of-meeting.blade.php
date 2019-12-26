@extends('admin.layouts.default')

@section('title')
Minutes of Meeting
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/fullcalendar/fullcalendar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/fullcalendar/fullcalendar.print.css') }}" rel="stylesheet" media="print">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/new-pages.css') }}" rel="stylesheet">
<style>
.fc-event, .fc-agenda .fc-event-time, .fc-event a {
	padding: 4px 6px;
	background-color: #1ab394;
	border-color: #1ab394;
}

.detail-preview label {
	width: 90px;
	/* text-align: right; */
	font-weight: bold;
	margin-right: 10px;
}

.detail-preview .value {
	flex: 1;
}

.priority {
	width: 12px;
	height: 12px;
}

body table.dataTable {
	table-layout: fixed;
}

.select2-container.select2-container--open {
	z-index: 99999 !important;
}

.select2-container {
	width: 100% !important;
}

.clockpicker-popover {
	z-index: 99999 !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js?v=') }}{{rand(11111,99999)}}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script>
    let mymeetings = {!! json_encode($meetings->toArray()) !!};
    let cData = [];
    for (let i = 0; i < mymeetings.length; i++) {
        //console.log(i + '=' + mymeetings[i].subject);
        cData.push({id:mymeetings[i].id,title:mymeetings[i].subject,start: mymeetings[i].meeting_date+' '+ mymeetings[i].meeting_time, allDay: false});
    }

$(document).ready(function() {
// filter checkbox change
    $('.i-checks.checkbox-filter').on('ifToggled', function (event) {
        let topics = $('.i-checks[name="topic[]"]:checked').map(function () {
            return $(this).val();
        }).get();
        console.log('topics='+topics);
        $('#hdn_topiccs').val(topics);
       // window.location.search = "?topics="+$('#hdn_topiccs').val();
        $('#mom_list').DataTable().ajax.reload();
    });
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green'
	});

	/* initialize the external events
		-----------------------------------------------------------------*/


	$('#external-events div.external-event').each(function() {

			// store data so the calendar knows to render an event upon drop
			$(this).data('event', {
					title: $.trim($(this).text()), // use the element's text as the event title
					stick: true // maintain when user navigates (see docs on the renderEvent method)
			});

			// make the event draggable using jQuery UI
			$(this).draggable({
					zIndex: 1111999,
					revert: true,      // will cause the event to go back to its
					revertDuration: 0  //  original position after the drag
			});

	});


	/* initialize the calendar
		-----------------------------------------------------------------*/
	var date = new Date();
	var d = date.getDate();
	var m = date.getMonth();
	var y = date.getFullYear();

	$('#calendar').fullCalendar({
			header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
			},
			editable: false,
			droppable: true, // this allows things to be dropped onto the calendar
			drop: function() {
					// is the "remove after drop" checkbox checked?
					if ($('#drop-remove').is(':checked')) {
							// if so, remove the element from the "Draggable Events" list
							$(this).remove();
					}
			},
			events: cData,
			eventClick: function(info, jsEvent) {
				// https://fullcalendar.io/docs/eventClick
				jsEvent.preventDefault(); // don't let the browser navigate
                //alert('Event: ' + info.id);
                loadPOPUPHTML(info.id);
				$('#details_modal').modal('show');
			}
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

	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		startDate: 'today',
		todayHighlight: true
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

		let formData = new FormData($('#frm_add_next_task')[0]);
		$('#frm_add_next_task input[name="contents"]').val($('#frm_add_next_task .summernote').summernote('code'));

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

	$(document).on('show.bs.modal', function (e) {
		if ($('.input-daterange').length) {
			$('.input-daterange').datepicker({
				keyboardNavigation: false,
				forceParse: false,
				autoclose: true,
				startDate: 'today',
				todayHighlight: true
			});
		}

		// if ($('.clockpicker').length) {
			$('.clockpicker').clockpicker();
		// }

		if ($('.chosen-select').length) {
			$('.chosen-select').chosen({
				width: '100%'
			});
		}
	});

});
function loadPOPUPHTML(pkgId) {
    var queryString = 'pkgId='+pkgId+'&_token='+$('meta[name=csrf-token]').attr('content');
    jQuery.ajax({
        url: baseUrl+'/admin/mom/getMeetingHTMLData',
        data:queryString,
        type: "POST",
        success:function(data){
            $("#mdlbody").html(data['list_data']);


        },
        error:function (){}
    });
}
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
		</ol>
		<h2 class="d-flex align-items-center">
			Minutes of Meeting
			<!-- <a href="" class="btn btn-primary btn-sm ml-auto" data-toggle="modal" data-target="#create_meeting">Create new MoM</a> -->
		</h2>
	</div>
</div>
<div class="wrapper wrapper-content">
	<div class="form-row animated fadeInDown">


		<!-- <div class="col-lg-6">
			<div class="form-row">
				<div class="col-lg-8">
					<div class="ibox mb-3">
						<div class="ibox-content detail-preview p-3">
							<div class="form-row">
								<div class="col-md-12">
									<h3 class="mt-0 mb-3">Meeting with Zender Company</h3>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 d-flex flex-nowrap">
									<label>Host:</label>
									<div class="value">Alex Smith</div>
								</div>

								<div class="col-md-6 d-flex flex-nowrap">
									<label>Meeting Time:</label>
									<div class="value">16.08.2019 10:15</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6 d-flex flex-nowrap">
									<label>Department:</label>
									<div class="value">IT</div>
								</div>

								<div class="col-md-6 d-flex flex-nowrap">
									<label>End Time:</label>
									<div class="value">16.08.2019 11:45</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12 d-flex flex-nowrap">
									<label>Location:</label>
									<div class="value text-navy font-weight-bold">Zender Company</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12 d-flex flex-nowrap">
									<label>Attendants:</label>
									<div class="value d-flex">
										<img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/profile_small.jpg') }}" alt="">
										<img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/a4.jpg') }}" alt="">
										<img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/a1.jpg') }}" alt="">
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-12 d-flex flex-nowrap">
									<label>Objective:</label>
									<div class="value">
										<p class="mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum quae dicta ad et aperiam vel asperiores labore ducimus perspiciatis veritatis corrupti impedit recusandae, quod, ipsam saepe consequatur. Ab, culpa expedita.</p>

										<p class="mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum quae dicta ad et aperiam vel asperiores labore ducimus perspiciatis veritatis corrupti impedit recusandae, quod, ipsam saepe consequatur. Ab, culpa expedita.</p>
									</div>
								</div>
							</div>

							<div class="form-row mt-2">
								<div class="col-md-12">
									<a href="" class="btn btn-sm btn-primary">Edit MoM</a>
								</div>
							</div>

						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="col-md-12">
						<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aut, veniam. Molestiae expedita consectetur cum aut quibusdam quos repellat labore quod vel. Quod, ad.</p>

						<div class="d-flex align-items-center">
							<span class="priority bg-warning rounded-circle">&nbsp;</span>
							<span class="font-weight-bold ml-2">High priority</span>
						</div>

						<p class="mt-4">
							<span class="font-weight-bold">Project Files:</span> <br>
							<a href="" class="d-block text-primary">
								<i class="fa fa-file-word-o"></i> Project_document.docx
							</a>

							<a href="" class="d-block text-primary">
								<i class="fa fa-file-image-o"></i> Logo_zender_company.jpg
							</a>

							<a href="" class="d-block text-primary">
								<i class="fa fa-file-powerpoint-o"></i> reports.xls
							</a>

							<a href="" class="d-block text-primary">
								<i class="fas fa-file-pdf"></i> Contract.pdf
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="form-row">
				<div class="col-md-12">
					<div class="ibox">
						<div class="ibox-title">
							<h5>Topics:</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<i class="fa fa-wrench"></i>
								</a>
								<ul class="dropdown-menu dropdown-user">
									<li><a href="#" class="dropdown-item">Config option 1</a>
									</li>
									<li><a href="#" class="dropdown-item">Config option 2</a>
									</li>
								</ul>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>

						<div class="ibox-content">
							<div class="panel-body p-0">
								<div class="panel-group" id="accordion">
									<div class="panel panel-warning">
										<div class="panel-heading">
											<h5 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Collapsible Group Item #1</a>
											</h5>
										</div>
										<div id="collapseOne" class="panel-collapse collapse in">
											<div class="panel-body">
												Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

												<div class="table-responsive mt-3">
													<table class="table">
                            <thead>
															<tr>
																<th>Status/Due</th>
																<th>Task</th>
																<th class="text-right">Owners</th>
															</tr>
														</thead>

                            <tbody>
															<tr>
																<td>
																	<span class="badge badge-primary">Open</span>
																	<span class="d-block">14.08.2019</span>
																</td>
																<td class="font-weight-bold">
																	Contract with Zender Company
																</td>
																<td class="text-right">
																	<img src="{{ URL::asset('img/a1.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																	<img src="{{ URL::asset('img/a3.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																</td>
															</tr>

															<tr>
																<td>
																	<span class="badge badge-primary">Open</span>
																	<span class="d-block">14.08.2019</span>
																</td>
																<td class="font-weight-bold">
																	Contract with Zender Company
																</td>
																<td class="text-right">
																	<img src="{{ URL::asset('img/a4.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																	<img src="{{ URL::asset('img/a5.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																	<img src="{{ URL::asset('img/a6.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																</td>
															</tr>
                            </tbody>
                        	</table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-info">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Collapsible Group Item #2</a>
											</h4>
										</div>
										<div id="collapseTwo" class="panel-collapse collapse">
											<div class="panel-body">
												Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

												<div class="table-responsive mt-3">
													<table class="table">
                            <thead>
															<tr>
																<th>Status/Due</th>
																<th>Task</th>
																<th class="text-right">Owners</th>
															</tr>
														</thead>

                            <tbody>
															<tr>
																<td>
																	<span class="badge badge-primary">Open</span>
																	<span class="d-block">14.08.2019</span>
																</td>
																<td class="font-weight-bold">
																	Contract with Zender Company
																</td>
																<td class="text-right">
																	<img src="{{ URL::asset('img/a1.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																	<img src="{{ URL::asset('img/a3.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																</td>
															</tr>

															<tr>
																<td>
																	<span class="badge badge-primary">Open</span>
																	<span class="d-block">14.08.2019</span>
																</td>
																<td class="font-weight-bold">
																	Contract with Zender Company
																</td>
																<td class="text-right">
																	<img src="{{ URL::asset('img/a4.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																	<img src="{{ URL::asset('img/a5.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																	<img src="{{ URL::asset('img/a6.jpg') }}" alt="" class="img-sm rounded-circle ml-1">
																</td>
															</tr>
                            </tbody>
                        	</table>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-info">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Collapsible Group Item #3</a>
											</h4>
										</div>
										<div id="collapseThree" class="panel-collapse collapse">
											<div class="panel-body">
												Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div> -->

		<div class="col-lg-4 d-flex flex-column h-100">

			<div class="ibox">
				<div class="ibox-title">
					<h5>Calendar</h5>
				</div>

				<div class="ibox-content">
					<div id="calendar"></div>
				</div>
			</div>

			<div class="space-15"></div>

			<div class="ibox-title">
				<h5><i class="fas fa-comments mr-2"></i> By Topic</h5>
                <input type="hidden" id="hdn_topiccs" value="">
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
		</div>

		<div class="col-lg-8">
			<div class="ibox d-flex flex-column h-100">
				<div class="ibox-title pr-3">
					<h5 class="d-flex align-items-center">
						Meeting List
						<a href="{{ url('admin/minutes-of-meeting/create/1') }}" class="btn btn-success btn-xs ml-auto" info-modal="meeting">
							<i class="fas fa-plus mr-1"></i> New meeting
						</a>
					</h5>
				</div>

				<div class="ibox-content flex-fill">
					<div class="table-responsive">
						<table class="table table-bordered" id="mom_list" style="width: 99.5%;">
							<thead>
								<tr>
									<th>Date</th>
									<th style="max-width: 40% !important;">Subject</th>
									<th>Department</th>
									<th>Host</th>
									<th></th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="details_modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- <div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Assign Tasks</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div> -->

			<div class="modal-body pt-3 pl-3 pr-3 pb-3 bg-white" id="mdlbody">
				<!-- <div class="ibox"> -->

				<!-- </div> -->
			</div>
		</div>
	</div>
</div>

<div class="modal inmodal fade" id="create_meeting" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content b-r-md">

			<div class="modal-body p-0 bg-white b-r-md">
				<form action="">

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
										<input type="text" class="form-control form-control-sm" name="subject" id="subject">
									</div>

									<div class="form-row">
										<div class="col-md-6">
											<div class="form-row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Date</label>
														<div class="input-daterange input-group" id="datepicker">
															<input type="text" class="form-control-sm form-control" id="meeting_date" name="meeting_date" />
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
										</div>

										<div class="col-md-6">
											<div class="form-group">
												<label>Location</label>
												<input type="text" class="form-control form-control-sm" name="location" id="location">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label>Objective Summary</label>
										<textarea name="summary" id="summary" rows="10" class="form-control"></textarea>
									</div>
								</div>

								<div class="col-md-4">
									<div class="form-group">
										<label>Department</label>
										<select name="dept_id" id="dept_id" class="form-control form-control-sm" size>
											<option value="0"></option>
											<option value="1">HR</option>
										</select>
									</div>

									<div class="form-group">
										<label>Host</label>
										<select name="host_id" id="host_id" class="form-control form-control-sm" size>
											<option value=""></option>
										</select>
									</div>

									<div class="form-group">
										<label>Attendants</label>
										<select data-placeholder="Select users" class="chosen-select form-control form-control-sm" size multiple tabindex="2" id="attendants" name="attendants[]">
											<option value=""></option>
										</select>

									</div>
								</div>
							</div>

							<h4><i class="far fa-file mr-1"></i> Minutes</h4>
							<div class="summernote"></div>
							<input type="hidden" name="minutes">

							<h4 class="mt-5 d-flex align-items-center">
								<i class="fas fa-tags mr-1"></i> Assigned Topics

								<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#create_topic">
									<i class="fas fa-plus mr-1"></i> New Topic
								</a>
							</h4>

							<div class="form-group">
								<select class="select2 form-control form-control-sm" name="topics[]" multiple="multiple">
									<option value="0">Lorem</option>
									<option value="1">Topic A</option>
									<option value="2">Topic B</option>
									<option value="3">aasdasdasd asdasdas</option>
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

								</tbody>
							</table>

						</div>
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