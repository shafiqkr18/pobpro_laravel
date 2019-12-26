@extends('admin.layouts.default')

@section('title')
	Topics
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<style>
table.dataTable {
	table-layout: fixed;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Topics

			<a href="{{ url('admin/topic/create') }}" class="btn btn-sm btn-success ml-auto"><i class="fas fa-plus mr-1"></i> Create</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		
		<ul class="notes">
			@if ($topics)
				@foreach ($topics as $topic)
				<li>
					<div>
						<small>{{ date('H:i:s Y-m-d', strtotime($topic->created_at)) }}</small>
						<h4 class="" title="{{ $topic->title }}">
							<a href="{{ url('admin/topic/detail/' . $topic->id) }}" class="text-dark"># {{ strlen($topic->title) > 40 ? substr($topic->title, 0, 40) . '...' : $topic->title }}</a>
						</h4>

						{!! strlen($topic->contents) > 100 ? substr($topic->contents, 0, 100) . '...</p>' : $topic->contents !!}

						<span>
							@if (count($topic->tasks) > 0)
							<a href="{{ url('admin/topic/detail/' . $topic->id) }}">
								<i class="fas fa-tasks text-dark"></i> 
							</a>
							@endif

							@if (count($topic->tasks) > 0)
							<a href="{{ url('admin/topic/detail/' . $topic->id) }}">
								<i class="fas fa-envelope text-dark"></i> 
							</a>
							@endif

							<a href="{{ url('admin/topic/detail/' . $topic->id) }}">
								<i class="fab fa-meetup text-dark"></i>
							</a>

							<a href="{{ url('admin/topic/detail/' . $topic->id) }}">
								<i class="far fa-chart-bar text-dark"></i>
							</a>
						</span>

						<a href="{{ url('admin/topic/detail/' . $topic->id) }}"><i class="fa fa-share-alt-square text-dark"></i></a>
					</div>
				</li>
				@endforeach
			@endif
		</ul>

	</div>
</div>

@endsection