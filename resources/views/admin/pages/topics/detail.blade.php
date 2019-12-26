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
				<a href="{{ url('admin/topics') }}">Topics</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/topics') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			View

			<a href="{{ url('admin/topic/update/' . $topic->id) }}" class="btn btn-success btn-sm pull-right ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
			<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/topic/delete/' . $topic->id) }}">
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
						<h5>Topic Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="align-self-start">Title: </label>
									<p class="form-control-static font-weight-bold">{{ $topic->title }}</p>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="align-self-start">Contents: </label>
									<div class="form-control-static font-weight-bold">{!! $topic->contents !!}</div>
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
					<i class="fas fa-tasks text-secondary mr-1"></i> Tasks
				</h4>
			</div>

			<ul class="relations tasks list-unstyled">
				@if ($topic->tasks)
					@php $badge = ['primary', 'info', 'muted']; @endphp
					@foreach ($topic->tasks as $task)
					<li class="bg-white border-size-sm border-secondary mb-2 p-1" style="border-left-style: solid;">
						<a href="{{ url('admin/task/detail/' . $task->task->id) }}" class="text-primary-color d-flex align-items-start p-2">
							<h5 class="m-0">
								<span>{{ $task->task->title }}</span>
								<small class="d-flex text-muted mt-1">{!! $task->task->due_date ? date('m/d/Y', strtotime($task->task->due_date)) : '<br>' !!}</small>
							</h5>

							<span class="badge badge-{{ $badge[$task->task->status] }} ml-auto">{{ $task->task->getStatus() }}</span>
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
				@if ($topic->letters)
					@php $badge = ['info', 'primary', 'warning', 'success', 'secondary']; @endphp
					@foreach ($topic->letters as $letter)
					<li class="bg-white border-size-sm border-info mb-2 p-1" style="border-left-style: solid">
						<a href="" class="text-primary-color d-flex align-items-start p-2">
							<h5 class="m-0 ellipsis pr-3">
								<span>{!! $letter->letter && $letter->letter->subject ? $letter->letter->subject : '<br>' !!}</span>
								<small class="d-block text-muted mt-1">{!! $letter->letter && $letter->letter->created_at ? date('m/d/Y', strtotime($letter->letter->created_at)) : '<br>' !!}</small>
							</h5>

							<span class="badge badge-{{ $letter->letter?$badge[$letter->letter->status] : '' }} ml-auto">{{ $letter->letter ? $letter->letter->getStatus() : " "}}</span>
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
				<li class="bg-white border-size-sm border-warning mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-info ml-auto">New</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-warning mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-primary ml-auto">Assigned</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-warning mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-warning ml-auto">Processing</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-warning mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-success ml-auto">Replied</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-warning mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-secondary ml-auto">Closed</span>
					</a>
				</li>
			</ul>
		</div>

		<div class="col-lg-3">
			<div class="d-flex justify-content-center mb-2">
				<h4 class="m-0">
					<i class="far fa-chart-bar text-success mr-1"></i> Reports
				</h4>
			</div>

			<ul class="relations reports list-unstyled">
				<li class="bg-white border-size-sm border-primary mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-info ml-auto">New</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-primary mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-primary ml-auto">Assigned</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-primary mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-warning ml-auto">Processing</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-primary mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-success ml-auto">Replied</span>
					</a>
				</li>

				<li class="bg-white border-size-sm border-primary mb-2 p-1" style="border-left-style: solid;">
					<a href="" class="text-primary-color d-flex align-items-start p-2">
						<h5 class="m-0 ellipsis pr-3">
							<span>Using Huawei Technology</span>
							<small class="d-block text-muted mt-1">11/11/2019</small>
						</h5>

						<span class="badge badge-secondary ml-auto">Closed</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

@endsection