@extends('admin.layouts.default')

@section('title')
	Recruitment
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/new-pages.css') }}" rel="stylesheet">
<style>
div.dataTables_wrapper div.dataTables_filter {
	margin-bottom: 5px;
}

table.dataTable {
	border-collapse: collapse !important;
	margin-top: 15px !important;
}

/*table.dataTable thead {*/
/*	display: none;*/
/*}*/

/*.table > thead > tr > th {*/
/*	color: transparent;*/
/*}*/

table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after {
	display: none;
}

table.dataTable thead>tr>th.sorting_asc,
table.dataTable thead>tr>th.sorting_desc,
table.dataTable thead>tr>th.sorting,
table.dataTable thead>tr>td.sorting_asc,
table.dataTable thead>tr>td.sorting_desc,
table.dataTable thead>tr>td.sorting {
	padding-right: 8px;
}
</style>
@endsection
@php
	$ex =  $positions->sum('expat_positions');
	$local =  $positions->sum('local_positions');
	$others =  $positions->sum('other_positions');
@endphp
@section('scripts')
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- <script src="{{ URL::asset('js/plugins/chartJs/Chart.min.js') }}"></script> -->
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/morris/raphael-2.1.0.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/morris/morris.js') }}"></script>
<script>
$(document).ready(function(){
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green'
	});

	$(document).on('click', '#todo li', function (e) {
		e.preventDefault();

		window.location = $(this).attr('data-url');
	});

	// donut chart
	Morris.Donut({
		element: 'morris-donut-chart',
		data: [{ label: "Expat", value: {{ $ex }} },
				{ label: "Local", value: {{ $local }} },
				{ label: "Others", value: {{ $others }} } ],
		resize: true,
		colors: ['#a3e1d4', '#dedede','#b5b8cf'],
	});

});
</script>
@endsection

@php
$status = ['Pending Response', 'Confirmed', 'Requested to reschedule', 'Declined'];
$status_class = ['warning', 'success', 'info', 'danger'];
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Candidates</strong>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">Recruitment</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="form-row">
		<div class="col-lg-3">

			<div class="ibox">
				<div class="ibox-title">
					<h5>By Categories</h5>
				</div>

				<div class="ibox-content p-2">
					<div class="text-center">
						<!-- <canvas id="polarChart" height="300"></canvas> -->
						<div id="morris-donut-chart"></div>
					</div>
				</div>
			</div>
			@php
			$ex =  $positions->where('expat_positions','>' , 0)->sum('positions_filled');
			$local =  $positions->where('local_positions','>' , 0)->sum('positions_filled');
			$others =  $positions->where('others_positions','>' , 0)->sum('positions_filled');
			$total = $positions->sum('total_positions');
			if ($total > 0) {
				$ep = floor($ex / $total * 100);
				$lp = floor($local / $total * 100);
				$op = floor($others / $total * 100);
				} else {
				$ep = 0;
				$lp = 0;
				$op = 0;
				}
			@endphp

			<div class="ibox">
				<div class="ibox-title">
					<h5>Recruitment Targets</h5>
				</div>
			</div>
			@if($divisions)
			@php
				echo '<div class="form-row">';
			$i = 0;
			@endphp
			@foreach($divisions as $division)
				<div class="col-md-12 mb-3">
						<h5 class="ml-2">{{$division->short_name}}</h5>
					<div class="ibox-content p-3">
						<div>
								@foreach($division->departments as $department)
									@php
									$filled = $department->positions->sum('positions_filled');
									$filled = ($filled<1 || is_null($filled)?0:$filled);
									$total =$department->positions->sum('total_positions');

										if ($total != 0) {
											$percent = $filled / $total * 100;
										} else {
											$percent = 0;
										}
									$graph = '';
									if($percent < 10)  $graph ='progress-bar-danger';
									//echo $total."=".$filled."=".$percent;
									@endphp
							<div>
									<span>{{$department->department_short_name}}</span>
									<small class="float-right">{{$filled}}/{{$total}} </small>
							</div>
							<div class="progress progress-small">
									<div style="width: {{$percent}}%;" class="progress-bar {{$graph}}"></div>
							</div>

								@endforeach
{{--										<div>--}}
{{--											<span>FTP</span>--}}
{{--											<small class="float-right">400 GB</small>--}}
{{--										</div>--}}
{{--										<div class="progress progress-small">--}}
{{--											<div style="width: 20%;" class="progress-bar progress-bar-danger"></div>--}}
{{--										</div>--}}


							</div>
							</div>
							</div>
				@php
					$i++;
								if ($i % 2 == 0 && $i != count($divisions)) {
										echo '</div><div class="form-row">';
								}
				@endphp
			@endforeach
				@php
					echo "</div>"
				@endphp
			@endif
		</div>


		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Plans</h5>
{{--					<a href="{{ url('admin/hr-plan/create/') }}" class="btn btn-primary btn-sm pull-right" style="margin-top: -6px">Add New Plan</a>--}}
				</div>

				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-hover issue-tracker" id="recruitment_plan_list" style="width: 100%;">
							<thead>
								<tr>
									<th>Status</th>
									<th>Details</th>
									<th>Positions</th>
                                    <th>Head Count</th>
									<th>Due Date</th>
									<th>Due In</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>


		<div class="col-lg-3">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Scheduled Interview</h5>
					<a href="{{ url('admin/interviews') }}" class="text-success pull-right">View All</a>
				</div>
			</div>

			<div class="ibox">
				<div class="ibox-content p-2">
					<ul class="sortable-list connectList agile-list pt-0" id="todo">
						@if (count($interviews_today))
							<h5>Today</h5>
							@foreach ($interviews_today as $interview)
							<li class="{{ $status_class[$interview->is_confirmed] }}-element" id="interview_{{ $interview->id }}" data-url="{{ url('admin/interview/detail/' . $interview->id) }}">
								<div class="d-flex flex-nowrap">
									<!-- <i class="fa fa-clock-o"></i> -->
									<span>{{ $interview->interview_date }}</span>
									<span class="font-weight-bold ml-auto">{{ $interview->candidate->name }}</span>
								</div>
								{{ $interview->subject }}

								<div class="agile-detail d-flex flex-nowrap">
									<a href="#" class="btn btn-xs btn-{{ $status_class[$interview->is_confirmed] }} ml-auto btn-outline">{{ $status[$interview->is_confirmed] }}</a>
								</div>
							</li>
							@endforeach
						@endif

						@if (count($interviews_tomorrow))
							<h5>Tomorrow</h5>
							@foreach ($interviews_tomorrow as $interview)
							<li class="{{ $status_class[$interview->is_confirmed] }}-element" id="interview_{{ $interview->id }}" data-url="{{ url('admin/interview/detail/' . $interview->id) }}">
								<div class="d-flex flex-nowrap">
									<!-- <i class="fa fa-clock-o"></i> -->
									<span>{{ $interview->interview_date }}</span>
									<span class="font-weight-bold ml-auto">{{ $interview->candidate->name }}</span>
								</div>
								{{ $interview->subject }}

								<div class="agile-detail d-flex flex-nowrap">
									<a href="#" class="btn btn-xs btn-{{ $status_class[$interview->is_confirmed] }} ml-auto">{{ $status[$interview->is_confirmed] }}</a>
								</div>
							</li>
							@endforeach
						@endif

						@if (count($interviews_this_week))
							<h5>This Week</h5>
							@foreach ($interviews_this_week as $interview)
							<li class="{{ $status_class[$interview->is_confirmed] }}-element" id="interview_{{ $interview->id }}" data-url="{{ url('admin/interview/detail/' . $interview->id) }}">
								<div class="d-flex flex-nowrap">
									<!-- <i class="fa fa-clock-o"></i> -->
									<span>{{ $interview->interview_date }}</span>
									<span class="font-weight-bold ml-auto">{{ $interview->candidate->name }}</span>
								</div>
								{{ $interview->subject }}

								<div class="agile-detail d-flex flex-nowrap">
									<a href="#" class="btn btn-xs btn-{{ $status_class[$interview->is_confirmed] }} ml-auto">{{ $status[$interview->is_confirmed] }}</a>
								</div>
							</li>
							@endforeach
						@endif

						{{--
						@if (count($interviews_later))
							<h5>Later</h5>
							@foreach ($interviews_later as $interview)
							<li class="{{ $status_class[$interview->is_confirmed] }}-element" id="interview_{{ $interview->id }}" data-url="{{ url('admin/interview/detail/' . $interview->id) }}">
								<div class="d-flex flex-nowrap">
									<!-- <i class="fa fa-clock-o"></i> -->
									<span>{{ $interview->interview_date }}</span>
									<span class="font-weight-bold ml-auto">{{ $interview->candidate->name }}</span>
								</div>
								{{ $interview->subject }}

								<div class="agile-detail d-flex flex-nowrap">
									<a href="#" class="btn btn-xs btn-{{ $status_class[$interview->is_confirmed] }} ml-auto">{{ $status[$interview->is_confirmed] }}</a>
								</div>
							</li>
							@endforeach
						@endif
						--}}
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection