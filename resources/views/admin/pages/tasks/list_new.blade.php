@extends('admin.layouts.default')

@section('title')
	Tasks
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<style>
/* table.dataTable {
	table-layout: fixed;
} */

.issue-info p {
	margin: 0;
}

.project-people img {
	object-fit: cover;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/tasks.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Tasks</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">

		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Tasks</h5>
				</div>

				<div class="ibox-content">
					<div class="m-b-lg">
						<form action="{{ url('admin/tasks') }}" id="search_tasks">
							<div class="input-group input-group-sm">
								<input type="text" class="form-control" name="search" placeholder="Search task" >
								<div class="input-group-append">
									<button class="btn btn-white" type="submit">Search</button>
								</div>
							</div>
						</form>

						<div class="m-t-md">
							<div class="float-right">
								<button type="button" class="btn btn-sm btn-white"> <i class="fas fa-comments"></i> </button>
								<button type="button" class="btn btn-sm btn-white"> <i class="fas fa-user"></i> </button>
								<button type="button" class="btn btn-sm btn-white"> <i class="fas fa-list"></i> </button>
								<button type="button" class="btn btn-sm btn-white"> <i class="fas fa-pencil-alt"></i> </button>
								<button type="button" class="btn btn-sm btn-white"> <i class="fas fa-print"></i> </button>
								<button type="button" class="btn btn-sm btn-white"> <i class="fas fa-cogs"></i> </button>
							</div>
							<strong class="tasks_count">Found {{ count($tasks) }} task{{ count($tasks) > 1 ? 's' : '' }}.</strong>
						</div>
					</div>

					<div class="table-responsive">
						<table class="table table-hover issue-tracker tasks-list">
							<thead>
								<tr>
									<th>STATUS</th>
									<th class="issue-info">TASKS</th>
									<!-- <th>FROM</th> -->
									<th>DUE TIME</th>
									<th>DAYS</th> 
									<th class="project-people" nowrap>TEAM</th> 
									<th class="text-right" >SOURCE</th>
								</tr>

							</thead>
							<tbody>  
								@if ($tasks)
									@foreach ($tasks as $task)
										@include('admin/pages/tasks/_list', [
											'task' => $task
										])
									@endforeach
								@endif
							</tbody>

						</table>
					</div>

				</div>
			</div>
		</div>

	</div>
</div>

@endsection