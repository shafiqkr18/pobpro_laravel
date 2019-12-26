@extends('admin.layouts.default')

@section('title')
Reports
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<style>
.fh-column {
	width: 25%;
	min-width: 280px;
}

.report-bg-theme {
	background-color: #2389c5 !important;
	border-color: #2389c5 !important;
}

.report-border-theme {
	border-color: #2389c5 !important;
}

.report-new-label {
	line-height: 20px;
	font-weight: bold;
	background: rgb(26, 179, 148);
	display: inline-block;
	border-radius: 3px;
	font-size: 12px;
	padding: 1px 6px;
	color: #fff !important;
}

.ellipsis {
	height: 30px;
}

.ellipsis>p {
	overflow: hidden;
	white-space: nowrap;
	text-overflow: ellipsis;
	margin-bottom: 16px;
}

.topic-theme {
	background: rgb(255, 255, 204);
	border-color: rgb(255, 255, 204);
	color: rgb(79, 79, 79);
}

.topic-theme:hover {
	background: rgb(255, 255, 204);
	border-color: rgb(255, 255, 204);
	color: rgb(79, 79, 79);
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/reports.js?v=') }}{{rand(11,33)}}"></script>

@endsection

@section('content')
@php
$init_reports = $reports;
@endphp
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Reports
			<a class="btn btn-success btn-sm ml-auto rounded {{$report_exists ? 'disabled' : ''}}"
				href="{{ url('admin/report/create') }}">
				<i class="fas fa-plus mr-1"></i> New Report
			</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-3">
			<div class="form-group">
				<div class="input-group date input-daterange">
					<span class="input-group-addon">
						<i class="far fa-calendar-alt"></i>
					</span>
					<input type="text" class="form-control form-control-sm text-left">
				</div>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="btn-group type">
				<button onclick="goto_report(0);" class="btn btn-sm {{$type==0? 'btn-primary':'btn-white'}}"
					report_type="0">Daily</button>
				<button onclick="goto_report(1);" class="btn btn-sm {{$type==1? 'btn-info':'btn-white'}}"
					report_type="1">Weekly</button>
				<button onclick="goto_report(3);" class="btn btn-sm {{$type==3? 'btn-success':'btn-white'}}"
					report_type="3">Monthly</button>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">

			<div class="tabs-container">
				<ul class="nav nav-tabs" role="tablist">
					<li><a class="nav-link active" data-toggle="tab" href="#tab-0"> ALL </a></li>
					@foreach($departments as $department)
					<li><a class="nav-link " data-toggle="tab"
							href="#tab-{{$department->id}}">{{$department->department_short_name}}</a></li>
					@endforeach
				</ul>

				<div class="tab-content">
					<div role="tabpanel" id="tab-0" class="tab-pane fade active show">
						<div class="panel-body p-0">

							<div class="fh-breadcrumb d-flex align-items-stretch m-0">
								<div class="fh-column">
									<div class="full-height-scroll">
										<ul class="list-group elements-list border-right">


											@foreach($init_reports as $rep)
											@php
											$cls_side = "";
											if($loop->index == 0)
											{
											$cls_side = "active";
											}
											$type_label = ['D', 'W', 'M'];
											$type_class = ['navy', 'info', 'success'];
											@endphp
											<li class="list-group-item">
												<a class="nav-link {{$cls_side}}" data-toggle="tab"
													href="#tab-{{$rep->dept_id}}-report-{{$loop->index}}">
													<small class="float-right text-muted"> <i class="fa fa-map-marker"></i>
														{{$rep->department ? $rep->department->department_short_name:''}}</small>
													<strong>
														<span
															class="report-new-label text-{{ $type_class[$rep->report_type] }}">{{ $type_label[$rep->report_type] }}</span>
														{{ date('d/m/Y', strtotime($rep->report_date)) }}</strong>
													<div class="small m-t-xs">
														<div class="ellipsis">
															{!! $rep->contents !!}
														</div>
													</div>
												</a>
											</li>
											@endforeach


										</ul>
									</div>
								</div>

								<div class=" flex-fill">
									<div class="white-bg">
										<div class="element-detail-box">

											<div class="tab-content">
												@foreach($init_reports as $rep)
												@php
												$cls = "";
												if($loop->index == 0)
												{
												$cls = "active show";
												}
												@endphp
												<div id="tab-{{$rep->dept_id}}-report-{{$loop->index}}" class="tab-pane fade {{$cls}}"
													data-report="{{ $rep->id }}">
													<div class="panel panel-info report-border-theme">
														<div class="panel-heading d-flex align-items-center report-bg-theme">
															@php $type = ['Daily', 'Weekly', 'Monthly']; @endphp
															<h4>
																<span class="report-new-label">{{ $type[$rep->report_type][0] }}</span>
																{{ date('d-m-Y', strtotime($rep->report_date)) }}
															</h4>

															<a href="{{ url('admin/report/detail/' . $rep->id) }}"
																class="btn btn-xs ml-auto text-light">
																<i class="far fa-edit mr-1" style="font-size: 16px;"></i>
															</a>
														</div>

														<div class="panel-body">
															<small class="text-muted">
																<i class="far fa-clock mr-1"></i>
																{{date("F j, Y, g:i a",strtotime($rep->report_date))}}
															</small>

															<table class="table mb-5">
																<thead>
																	<tr>
																		<th>Status</th>
																		<th>Task</th>
																		<th>Due</th>
																		<th>Owners</th>
																		<th>Updates</th>
																	</tr>
																</thead>

																<tbody>
																	@if(count($pending_tasks) > 0)
																	@foreach($pending_tasks as $pending_task)
																	<tr>
																		<td>
																			@if($pending_task->status == 2)
																			<i class="far fa-check-square text-navy"></i>
																			@else
																			<i class="far fa-square text-navy"></i>
																			@endif
																		</td>
																		<td>{{$pending_task->title}}</td>
																		<td>{{$pending_task->due_date}}</td>
																		<td class="project-people text-left">
																			@if ($pending_task->users)
																			@foreach ($pending_task->users as $user)
																			@php $avatar = $user->avatar ? json_decode($user->avatar,
																			true) : null; @endphp
																			<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
																				<img
																					src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}"
																					class="rounded-circle">
																			</a>
																			@endforeach
																			@endif
																		</td>
																		<td>{{$pending_task->contents}}</td>
																	</tr>
																	@endforeach
																	@endif
																</tbody>
															</table>
														</div>

														<div class="panel-body">
															<h4>SUMMARY:</h4>
															<p>{!! $rep->contents !!}</p>
														</div>

														<!-- <h4 class="mt-5 text-warning"><i class="fas fa-tags mr-1"></i>
																Assigned Topics</h4> -->
														<div class="panel-body">
															<h4>TOPICS:</h4>
															<div class="d-flex align-items-start flex-wrap">

																@if(count($rep->topicRelationships)>0)
																@foreach($rep->topicRelationships as $letter_topic)
																<a href="{{ url('admin/topic/detail/' . $letter_topic->topic->id) }}"
																	class="btn btn-xs mr-2 mb-2 topic-theme">{{ $letter_topic->topic?$letter_topic->topic->title:'' }}</a>
																@endforeach
																@endif
															</div>
														</div>

														<div class="panel-body">
															<h4>NEXT ACTIONS:</h4>
															<p>{!! $rep->next_actions !!}</p>

															<h4 class="mt-4">Tasks</h4>
															<table class="table">
																<thead>
																	<tr>
																		<th>Status</th>
																		<th>Task</th>
																		<th>Due</th>
																		<th>Owners</th>
																		<th>Updates</th>
																	</tr>
																</thead>

																<tbody>
																	@if (count($rep->taskRelationships) > 0)
																	@foreach ($rep->taskRelationships as $letter_task)
																	<tr>
																		<td>
																			@if($letter_task->status == 2)
																			<i class="far fa-check-square text-navy"></i>
																			@else
																			<i class="far fa-square text-navy"></i>
																			@endif

																		</td>
																		<td>{{ $letter_task->task? $letter_task->task->title:'' }}</td>
																		<td>{{ $letter_task->task && $letter_task->task->due_date ? date('m/d/Y', strtotime($letter_task->task->due_date)): '' }}
																		</td>
																		<td class="project-people text-left">
																			@if ($letter_task->task && $letter_task->task->users)
																			@foreach ($letter_task->task->users as $user)
																			@php $avatar = $user->avatar ? json_decode($user->avatar,
																			true) : null; @endphp
																			<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
																				<img
																					src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}"
																					class="rounded-circle">
																			</a>
																			@endforeach
																			@endif
																		</td>
																		<td>
																			{{$letter_task->task_history?$letter_task->task_history->first()->contents:'' }}
																		</td>
																	</tr>
																	@endforeach
																	@endif

																</tbody>
															</table>
														</div>
													</div>

													<div class="panel panel-warning">
														<div class="panel-heading">
															<h4>
																<i class="far fa-comments"></i> Remarks
															</h4>
														</div>

														<div class="panel-body">
															<ul class="list-unstyled comments mb-0">
																@if($rep->remarks && $rep->remarks->count())
																@foreach($rep->remarks as $rem)
																<li>
																	<small class="text-muted">
																		<span class="name">{{$rem->createdBy->name}}</span> - <i class="far-fa-clock"></i>
																		<span class="date">{{date("F j, Y, g:i a",strtotime($rem->created_at))}}</span>
																	</small>

																	<p>{!! $rem->comments !!}</p>
																</li>
																@endforeach
																@endif

															</ul>
															<a href="" class="btn btn-xs btn-success" data-toggle="modal" data-target="#add_remark">
																<i class="fas fa-plus mr-1"></i> Add remark
															</a>
														</div>
													</div>

												</div>
												@endforeach

											</div>

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					{{--loop for specific departments--}}

					@foreach($departments as $department)
					@php $filtered_dpts = $reports->where('dept_id', $department->id)->all();@endphp
					<div role="tabpanel" id="tab-{{$department->id}}" class="tab-pane fade">
						<div class="panel-body p-0">

							<div class="fh-breadcrumb d-flex align-items-stretch m-0">
								<div class="fh-column">
									<div class="full-height-scroll">
										<ul class="list-group elements-list border-right">

											@foreach($filtered_dpts as $rep)
											@php
											$cls_side = "";
											if($loop->index == 0)
											{
											$cls_side = "active";
											}
											$type_label = ['D', 'W', 'M'];
											$type_class = ['navy', 'info', 'success'];
											@endphp
											<li class="list-group-item">
												<a class="nav-link {{$cls_side}}" data-toggle="tab"
													href="#tab-{{$rep->dept_id}}-report-{{$loop->index}}">
													<small class="float-right text-muted"> <i class="fa fa-map-marker"></i>
														{{$rep->department ? $rep->department->department_short_name:''}}</small>
													<strong>
														<span
															class="report-new-label text-{{ $type_label[$rep->report_type] }}">{{ $type_label[$rep->report_type] }}</span>
														{{ date('d/m/Y', strtotime($rep->report_date)) }}</strong>
													<div class="small m-t-xs">
														<div class="ellipsis">
															{!! $rep->contents !!}
														</div>
														<p class="m-b-none">

														</p>
													</div>
												</a>
											</li>
											@endforeach

										</ul>
									</div>
								</div>

								<div class=" flex-fill">
									<div class="white-bg">
										<div class="element-detail-box">
											@foreach($filtered_dpts as $rep)
											@php
											$cls = "";
											if($loop->index == 0)
											{
											$cls = "active show";
											}
											@endphp
											<div class="tab-content">
												<div id="tab-{{$rep->dept_id}}-report-{{$loop->index}}" class="tab-pane fade {{$cls}}">
													<div class="panel panel-info report-border-theme">
														<div class="panel-heading d-flex align-items-center report-bg-theme">
															@php $type = ['Daily', 'Weekly', 'Monthly']; @endphp
															<h4>
																<span class="report-new-label">{{ $type[$rep->report_type][0] }}</span>
																{{ date('d-m-Y', strtotime($rep->report_date)) }}
															</h4>

															<a href="{{ url('admin/report/detail/' . $rep->id) }}"
																class="btn btn-xs ml-auto text-light">View Details</a>
														</div>

														<div class="panel-body">
															<small class="text-muted">
																<i class="far fa-clock mr-1"></i>
																{{date("F j, Y, g:i a",strtotime($rep->report_date))}}
															</small>

															<h4><i class="fas fa-history mr-1"></i> Last Task Updates</h4>

															<table class="table mb-5">
																<thead>
																	<tr>
																		<th>Status</th>
																		<th>Task</th>
																		<th>Due</th>
																		<th>Owners</th>
																		<th>Updates</th>
																	</tr>
																</thead>

																<tbody>
																	<tr>
																		<td><i class="far fa-check-square text-navy"></i></td>
																		<td>Alpha Project</td>
																		<td>11/14/2019</td>
																		<td class="project-people text-left">
																			<a href="">
																				<img src="{{ URL::asset('img/a3.jpg') }}" class="rounded-circle">
																			</a>

																			<a href="">
																				<img src="{{ URL::asset('img/a2.jpg') }}" class="rounded-circle">
																			</a>

																			<a href="">
																				<img src="{{ URL::asset('img/a1.jpg') }}" class="rounded-circle">
																			</a>
																		</td>
																		<td>Update contents</td>
																	</tr>

																	<tr>
																		<td><i class="far fa-check-square text-navy"></i></td>
																		<td>Beta Project</td>
																		<td>12/21/2019</td>
																		<td class="project-people text-left">
																			<a href="">
																				<img src="{{ URL::asset('img/a4.jpg') }}" class="rounded-circle">
																			</a>
																		</td>
																		<td>Documents Submitted</td>
																	</tr>
																</tbody>
															</table>
														</div>

														<div class="panel-body">
															<h4>SUMMARY:</h4>
															<p>{!! $rep->contents !!}</p>
														</div>

														<div class="panel-body">
															<h4>TOPICS:</h4>
															<div class="d-flex align-items-start flex-wrap">
																<a href="" class="btn btn-xs btn-primary mr-2 mb-2">Lorem ipsum</a>
																<a href="" class="btn btn-xs btn-info mr-2 mb-2">Lorem</a>
																<a href="" class="btn btn-xs btn-success mr-2 mb-2">Huawei
																	Technology</a>
																<a href="" class="btn btn-xs btn-secondary mr-2 mb-2">Topic A</a>
															</div>
														</div>

														<div class="panel-body">
															<h4>NEXT ACTIONS:</h4>
															<p>{!! $rep->next_actions !!}</p>

															<h4 class="mt-4">Tasks</h4>
															<table class="table">
																<thead>
																	<tr>
																		<th>Status</th>
																		<th>Task</th>
																		<th>Due</th>
																		<th>Owners</th>
																		<th>Updates</th>
																	</tr>
																</thead>

																<tbody>
																	<tr>
																		<td><i class="far fa-check-square text-navy"></i></td>
																		<td>Alpha Project</td>
																		<td>11/14/2019</td>
																		<td class="project-people text-left">
																			<a href="">
																				<img src="{{ URL::asset('img/a4.jpg') }}" class="rounded-circle">
																			</a>

																			<a href="">
																				<img src="{{ URL::asset('img/a2.jpg') }}" class="rounded-circle">
																			</a>

																			<a href="">
																				<img src="{{ URL::asset('img/a1.jpg') }}" class="rounded-circle">
																			</a>
																		</td>
																		<td>Update contents</td>
																	</tr>

																	<tr>
																		<td><i class="far fa-check-square text-navy"></i></td>
																		<td>Beta Project</td>
																		<td>12/21/2019</td>
																		<td class="project-people text-left">
																			<a href="">
																				<img src="{{ URL::asset('img/a1.jpg') }}" class="rounded-circle">
																			</a>

																			<a href="">
																				<img src="{{ URL::asset('img/a4.jpg') }}" class="rounded-circle">
																			</a>
																		</td>
																		<td>Documents Submitted</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>



													<div class="panel panel-warning">
														<div class="panel-heading">
															<h4>
																<i class="far fa-comments"></i> Remarks
															</h4>
														</div>

														<div class="panel-body">
															<div class="d-flex mb-2">
																<a href="" class="btn btn-xs btn-success ml-auto">
																	<i class="fas fa-plus mr-1"></i> Add remark
																</a>
															</div>

															<ul class="list-unstyled comments mb-0">
																<li>
																	<small class="text-muted">
																		<span class="name">Trent Gu</span> - <i class="far-fa-clock"></i> <span
																			class="date">Monday, 21 May
																			2014, 10:32 am</span>
																	</small>

																	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
																		Asperiores corrupti deserunt incidunt iusto quae veritatis
																		corporis. Dolore molestiae eligendi vel deleniti! Ex commodi
																		vitae reprehenderit dolorem omnis? Exercitationem, asperiores
																		autem?</p>
																</li>

																<li>
																	<small class="text-muted">
																		<span class="name">Trent Gu</span> - <i class="far-fa-clock"></i> <span
																			class="date">Monday, 21 May
																			2014, 10:32 am</span>
																	</small>

																	<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem
																		suscipit nesciunt mollitia consequuntur, enim repellendus quis
																		molestias perspiciatis culpa sapiente! Perspiciatis recusandae,
																		assumenda eum id expedita temporibus mollitia. Voluptate,
																		adipisci.</p>
																</li>
															</ul>
														</div>
													</div>

												</div>


											</div>
											@endforeach
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>

					@endforeach


				</div>
			</div>

		</div>
	</div>
</div>

<div class="modal inmodal fade" id="add_remark" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Add remark</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body p-3 bg-white">
				<form action="{{ url('admin/remark/save') }}" id="frm_add_remark">
					<!-- TODO: add report id and title -->
					<input type="hidden" name="listing_id" value="">
					<input type="hidden" name="title" value="Remark for report: ">
					<input type="hidden" name="type" value="2">
					<input type="hidden" name="source" value="report_detail">

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
@endsection