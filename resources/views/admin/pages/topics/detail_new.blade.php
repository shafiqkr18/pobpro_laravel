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

ul.notes li div {
	min-height: 210px;
	height: auto;
}

.agile-list li:hover {
	cursor: default;
}

.agile-list li.info-element a:hover {
	color: inherit;
}

.agile-list li.info-element {
	border-left-color: #23c6c8;
}

.agile-list li.mom {
    border-left-color: #DE864F;
}

.agile-list li.letter {
    border-left-color: #2C8F7B;
}

.agile-list li.report {
    border-left-color: #2389C5;
}

.agile-list li.primary-element {
	border-left-color: #1ab394;
}

.agile-list li.warning-element {
	border-left-color: #f8ac59;
}

.agile-list li.success-element {
	border-left-color: #1c84c6;
}

.agile-list li.secondary-element {
	border-left-color: #d1dade;
}

li.task-element {
    border-left-color: rgb(220, 53, 69);
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

			{{ $topic->title }}

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
	<div class="row">

		<div class="col-lg-4">
			<ul class="notes">
				<li>
					<div>
						<small>{{ date('H:i:s Y-m-d', strtotime($topic->created_at)) }}</small>
						<h4 class="" title="{{ $topic->title }}">
							<a href="{{ url('admin/topic/detail/' . $topic->id) }}" class="text-dark"># {{ strlen($topic->title) > 40 ? substr($topic->title, 0, 40) . '...' : $topic->title }}</a>
						</h4>

						{!! $topic->contents !!}
					</div>
				</li>

				</ul>
			</div>

			<div class="col-lg-8">
				<div class="ibox">
					<div class="ibox-content">
						<h3><em class="fa fa-tasks"></em> Related Tasks</h3>

						<ul class="todo-list m-t">
							@if ($topic->allTasks)
								@php $badge = ['primary', 'info', 'muted']; @endphp
								@foreach ($topic->allTasks as $task)
								<li class="task-element">
									<input type="checkbox" value="" name="" class="i-checks"/>
									<a href="{{ url('admin/task/detail/' . $task->task->id) }}" class="text-primary-color">
										<span class="m-l-xs">{{ $task->task->title }}</span>
									</a>
									<small class="label label-{{ $badge[$task->task->status] }}">{{ $task->task->getStatus() }}</small>
								</li>
								@endforeach
							@endif
						</ul>
				</div>
			</div>
		</div>

	</div>

	<div class="row">

		<div class="col-lg-4">
			<div class="ibox">
				<div class="ibox-content">
					<h3> <em class="fas fa-envelope"></em> Related Letters</h3>

					<ul class="sortable-list connectList agile-list">
						@if ($topic->allLetters)
							@php $badge = ['info', 'primary', 'warning', 'success', 'secondary']; @endphp
							@foreach ($topic->allLetters as $letter)
							<li class="{{ $badge[$letter->letter->status] }}-element letter">
								<a href="{{ url('admin/correspondence/letter/detail/' . $letter->letter->id) }}" class="d-block text-primary-color">
									{!! $letter->letter->subject ? $letter->letter->subject : '<br>' !!}
									<div class="agile-detail d-flex align-items-center">
										<i class="far fa-clock-o mr-1"></i> {!! $letter->letter->created_at ? date('m/d/Y', strtotime($letter->letter->created_at)) : '' !!}
										<small class="label label-{{ $badge[$letter->letter->status] }} ml-auto">{{ $letter->letter->getStatus() }}</small>
									</div>
								</a>
							</li>
							@endforeach
						@endif
					</ul>
				</div>
			</div>
		</div>

		<div class="col-lg-4">
			<div class="ibox">
				<div class="ibox-content">
					<h3> <em class="fas fa-file"></em> Related Work Reports</h3>

					<ul class="sortable-list connectList agile-list">
                        @if ($topic->allReports)
                            @foreach ($topic->allReports as $letter)
						<li class="info-element report" id="task{{$letter->report->id}}">
								{!! $letter->report->contents !!}
								<div class="agile-detail">
										<a href="#" class="float-right btn btn-xs btn-white">{{getReportType($letter->report->report_type)}}</a>
										<i class="fa fa-clock-o"></i> {!! $letter->report->created_at ? date('m/d/Y', strtotime($letter->report->created_at)) : '' !!}
								</div>
						</li>
                            @endforeach
                        @endif
					</ul>
				</div>
			</div>
		</div>

        <div class="col-lg-4">
			<div class="ibox">
				<div class="ibox-content">
					<h3> <em class="fab fa-meetup"></em> Related Minutes of Meeting</h3>

					<ul class="sortable-list connectList agile-list">
                        @if ($topic->allMOM)
                            @foreach ($topic->allMOM as $letter)
						<li class="info-element mom" id="task{{$letter->mom->id}}">
                            {{$letter->mom->subject}}
								<div class="agile-detail">
										<a href="#" class="float-right btn btn-xs btn-white">{{$letter->mom->host? $letter->mom->host->name : ''}}</a>
										<i class="fa fa-clock-o"></i> {!! $letter->mom->created_at ? date('m/d/Y', strtotime($letter->mom->created_at)) : '' !!}
								</div>
						</li>
                            @endforeach
                        @endif

					</ul>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection
