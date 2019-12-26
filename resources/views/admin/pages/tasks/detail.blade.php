@extends('admin.layouts.default')

@section('title')
	View Topic
@endsection

@section('styles')
<style>
.form-control-static p {
	margin: 0;
}

.relations li > a:hover > h5 {
	color: #676a6c;
}
</style>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/tasks') }}">Tasks</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/tasks') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			View

			<a href="{{ url('admin/task/update/' . $task->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/task/delete/' . $task->id) }}">
				<i class="far fa-trash-alt mr-1"></i>
				Delete
			</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form action="">

		<div class="row">
			<div class="col-lg-12">

				<div class="ibox ">
					<div class="ibox-title">
						<h5>Task Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label class="align-self-start">Title: </label>
									<p class="form-control-static font-weight-bold">{{ $task->title }}</p>
								</div>

								<div class="form-group form-inline">
									<label>Status: </label>
									<p class="form-control-static font-weight-bold">{{ $task->getStatus() }}</p>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Due Date: </label>
									<p class="form-control-static font-weight-bold">{{ date('m/d/Y', strtotime($task->due_date)) }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="align-self-start">Contents: </label>
									<div class="form-control-static font-weight-bold">{!! $task->contents !!}</div>
								</div>

								<div class="form-group form-inline m-0">
									<label class="align-self-start">Owners: </label>
									<div class="form-control-static font-weight-bold">
										@foreach ($task->users as $task_user)
										<span class="badge mr-2 mb-2">{{ $task_user->user->getName() }}</span>
										@endforeach
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

	</form>

	<div class="row mt-5">
		<div class="col-lg-3">
			<div class="d-flex justify-content-center mb-2">
				<h4 class="m-0">
					<i class="fas fa-tasks text-secondary mr-1"></i> Topics
				</h4>
			</div>

			<ul class="relations topics list-unstyled">
				@if ($task->allTopics)
					@php $badge = ['primary', 'info', 'muted']; @endphp
					@foreach ($task->allTopics as $topic)
					<li class="bg-white border-size-sm border-secondary mb-2 p-1" style="border-left-style: solid;">
						<a href="{{ url('admin/topic/detail/' . $topic->topic->id) }}" class="text-primary-color d-flex align-items-start p-2">
							<h5 class="m-0">
								<span>{{ $topic->topic->title }}</span>
								<small class="d-flex text-muted mt-1">{!! $topic->topic->created_at ? date('m/d/Y', strtotime($topic->topic->created_at)) : '<br>' !!}</small>
							</h5>
						</a>
					</li>
					@endforeach
				@endif
			</ul>
		</div>

		<div class="col-lg-3">
			<div class="d-flex justify-content-center mb-2">
				<h4 class="m-0">
					<i class="far fa-envelope text-info mr-1"></i> Letters
				</h4>
			</div>

			<ul class="relations letters list-unstyled">
				@if ($task->allLetters)
					@php $badge = ['info', 'primary', 'warning', 'success', 'secondary']; @endphp
					@foreach ($task->allLetters as $letter)
				<li class="bg-white border-size-sm border-info mb-2 p-1" style="border-left-style: solid">
					<a href="{{ url('admin/correspondence/letter/detail/' . $letter->letter->id) }}" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
								<span>{!! $letter->letter->subject ? $letter->letter->subject : '<br>' !!}</span>
								<small class="d-block text-muted mt-1">{!! $letter->letter->created_at ? date('m/d/Y', strtotime($letter->letter->created_at)) : '<br>' !!}</small>
						</h5>

							<span class="badge badge-{{ $badge[$letter->letter->status] }} ml-auto">{{ $letter->letter->getStatus() }}</span>
					</a>
				</li>
					@endforeach
				@endif
			</ul>
		</div>

		<div class="col-lg-3">
			<div class="d-flex justify-content-center mb-2">
				<h4 class="m-0">
					<i class="fas fa-users text-warning mr-1"></i> Meetings
				</h4>
			</div>

			<ul class="relations meetings list-unstyled">
                @if ($task->allMOM)
                    @foreach ($task->allMOM as $letter)
				<li class="bg-white border-size-sm border-warning mb-2 p-1" style="border-left-style: solid;">
					<a href="{{url('admin/minutes-of-meeting/detail/'. $letter->mom->id)}}" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>{{$letter->mom->subject}}</span>
							<small class="d-block text-muted mt-1">{!! $letter->mom->created_at ? date('m/d/Y', strtotime($letter->mom->created_at)) : '' !!}</small>
						</h5>

						<span class="badge badge-info ml-auto">{{$letter->mom->host? $letter->mom->host->name : ''}}</span>
					</a>
				</li>
                    @endforeach
                @endif

			</ul>
		</div>

		<div class="col-lg-3">
			<div class="d-flex justify-content-center mb-2">
				<h4 class="m-0">
					<i class="far fa-chart-bar text-success mr-1"></i> Reports
				</h4>
			</div>

			<ul class="relations reports list-unstyled">

                @if ($task->allReports)
                    @foreach ($task->allReports as $letter)
				<li class="bg-white border-size-sm border-primary mb-2 p-1" style="border-left-style: solid;">
					<a href="{{url('admin/report/detail/'. $letter->report->id)}}" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>{!! $letter->report->contents !!}</span>
							<small class="d-block text-muted mt-1">{!! $letter->report->created_at ? date('m/d/Y', strtotime($letter->report->created_at)) : '' !!}</small>
						</h5>

						<span class="badge badge-info ml-auto">{{getReportType($letter->report->report_type)}}</span>
					</a>
				</li>
                    @endforeach
                @endif

			</ul>
		</div>

	</div>
</div>

@endsection
