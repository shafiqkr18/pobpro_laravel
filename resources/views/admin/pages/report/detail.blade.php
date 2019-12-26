@extends('admin.layouts.default')

@section('title')
	Reports
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<style>
.fh-column {
	min-width: 240px;
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
			View
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="report-detail-{{ $report->id }}" data-report="{{ $report->id }}">
				<div class="panel panel-info">
					<div class="panel-heading">
						@php $type = ['Daily', 'Weekly', 'Monthly']; @endphp
						<h4>
							<i class="fas fa-info-circle mr-1"></i> {{ $type[$report->report_type] }}: {{ date('d-m-Y', strtotime($report->report_date)) }}
						</h4>
					</div>

					<div class="panel-body">
						<small class="text-muted">
							<i class="far fa-clock mr-1"></i> {{ date('F j, Y, g:i a', strtotime($report->report_date)) }}
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
								@if(count($pending_tasks) > 0)
									@foreach($pending_tasks as $pending_task)
									<tr>
										<td><i class="far fa-check{{ $pending_task->status == 2 ? '-square' : '' }} text-navy"></i></td>
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
										<td>{{$pending_task->contents}}</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>

						<h4><i class="far fa-file mr-1"></i> Report Details</h4>
						<p>{!! $report->contents !!}</p>

						<h4 class="mt-5 text-warning"><i class="fas fa-tags mr-1"></i> Assigned Topics</h4>
						<div class="d-flex align-items-start flex-wrap">
							@if (count($report->topicRelationships)>0)
								@foreach ($report->topicRelationships as $letter_topic)
								<a href="{{ url('admin/topic/detail/' . $letter_topic->topic->id) }}" class="btn btn-xs btn-primary mr-2 mb-2">{{ $letter_topic->topic?$letter_topic->topic->title:'' }}</a>
								@endforeach
							@endif
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
						<p>{!! $report->next_actions !!}</p>

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
								@if (count($report->taskRelationships) > 0)
									@foreach ($report->taskRelationships as $letter_task)
									<tr>
										<td><i class="far fa-check{{ $letter_task->status == 2 ? '-square' : '' }} text-navy"></i></td>
										<td>{{ $letter_task->task ? $letter_task->task->title : '' }}</td>
										<td>{{ date('m/d/Y', strtotime($letter_task->task->due_date)) }}</td>
										<td class="project-people text-left">
											@if ($letter_task->task->users)
												@foreach ($letter_task->task->users as $user)
													@php $avatar = $user->avatar ? json_decode($user->avatar, true) : null; @endphp
													<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
														<img src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}" class="rounded-circle">
													</a>
												@endforeach
											@endif
										</td>
										<td>{{$letter_task->task_history ? $letter_task->task_history->first()->contents : '' }}</td>
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
							@if($report->remarks && $report->remarks->count())
								@foreach($report->remarks as $rem)
								<li>
									<small class="text-muted">
										<span class="name">{{ $rem->createdBy->name }}</span> - <i class="far-fa-clock"></i> <span class="date">{{ date('F j, Y, g:i a', strtotime($rem->created_at)) }}</span>
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