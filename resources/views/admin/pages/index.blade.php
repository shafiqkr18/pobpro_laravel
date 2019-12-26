@extends('admin.layouts.default')

@section('title')
Dashboard
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
.list-group-item a,
.feed-element {
	color: #676a6c;
}

.list-group-item a:hover,
.feed-element:hover {
	color: #0056b3;
}

.feed-activity-list {
	padding: 10px 0;
}

.feed-activity-list .feed-element .label {
	margin-right: 10px;
	height: 23px;
	display: flex;
	align-items: center;
	justify-content: center;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
	@php
	if ($show_welcome_message) { @endphp
	setTimeout(function() {
			toastr.options = {
					closeButton: true,
					progressBar: true,
					showMethod: 'slideDown',
					timeOut: 4000
			};
			toastr.success('ITForce POBPro', 'Welcome to @php echo Auth::user() && Auth::user()->company ? Auth::user()->company->company_name : ''; @endphp');

	}, 1300);
	@php
	}
	@endphp


	// employee hire
	var ctx = document.getElementById('chart');
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['Total Positions', 'Total Expat', 'Total Local'],
			datasets: [
				{
					label: 'Assigned',
					data: [@php echo $total_assigned_positions @endphp, @php echo $expat_assigned_positions @endphp, @php echo $local_assigned_positions @endphp],
					backgroundColor: '#e2efee',
				},
				{
					label: 'Vacant',
					data: [@php echo $total_vacant_positions @endphp, @php echo $expat_vacant_positions @endphp,  @php echo $local_vacant_positions @endphp],
					backgroundColor: '#FAEBCC',
				}
			]
		},
		options: {
			scales: {
				xAxes: [{
					stacked: true,
					categoryPercentage: 0.3,
					// barPercentage: 0.5,
					// barThickness: 20,
					// maxBarThickness: 20
				}],
				yAxes: [{
					stacked: true,
					// barPercentage: 0.5,
					// barThickness: 20
				}]
			},
		}
	});

});
</script>
@endsection

@section('content')
<div class="row  border-bottom white-bg dashboard-header">
	<div class="col-md-3 {{ $notification_tasks_count == 0 ? 'no-tasks' : '' }}">
		<h5 class="section-title">Pending Tasks</h5>

		<ul class="list-group clear-list" style="margin-top: 26px;">
			@if ($notification_tasks_count == 0)
			<div class="text-center">
				<i class="far fa-calendar-check" style="font-size: 20px;"></i>
				<p class="font-weight-bold mt-2">No pending tasks.</p>
			</div>
			@else
				@include('admin/pages/partials/_tasks', [
					'offers' => $notification_offers, 
					'contracts' => $notification_contracts, 
					'plans' => $notification_plans,
					'department_approvals' => $notification_department_approvals,
					'li_classes' => 'list-group-item'
				])
			@endif
		</ul>

	</div>
	<div class="col-md-6">
		<h5 class="section-title">Employee Hire Summary</h5>
		<div class="dashboard-chart">
			<canvas id="chart" height="100" style="width: 100%"></canvas>
		</div>
		<div class="row text-left m-t">
			<div class="col text-center border pl-1 pr-1 pt-2 pb-2 border-right-0">
				<small class="text-muted block">Total Positions</small>
				<span class="h6 font-bold mt-0 mb-0 block">{{ $total_positions }}</span>
			</div>
			<div class="col text-center border pl-1 pr-1 pt-2 pb-2 border-right-0">
				<small class="text-muted block">Total Expat</small>
				<span class="h6 font-bold mt-0 mb-0 block">{{ $expat_positions }}</span>
			</div>
			<div class="col text-center border pl-1 pr-1 pt-2 pb-2 border-right-0">
				<small class="text-muted block">Total Local</small>
				<span class="h6 font-bold mt-0 mb-0 block">{{ $local_positions }}</span>
			</div>
			<div class="col text-center border pl-1 pr-1 pt-2 pb-2 border-right-0">
				<small class="text-muted block">Total Assigned</small>
				<span class="h6 font-bold mt-0 mb-0 block">{{ $total_assigned_positions }}</span>
			</div>
			<div class="col text-center border pl-1 pr-1 pt-2 pb-2 border-right-0">
				<small class="text-muted block">Vacancy Local</small>
				<span class="h6 font-bold mt-0 mb-0 block">{{ $local_vacant_positions }}</span>
			</div>
			<div class="col text-center border pl-1 pr-1 pt-2 pb-2">
				<small class="text-muted block">Vacancy Expat</small>
				<span class="h6 font-bold mt-0 mb-0 block">{{ $expat_vacant_positions }}</span>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<h5 class="section-title">Onsite Employees</h5>
		<div class="statistic-box">
			<div class="row text-center">
				<div class="col-lg-12">
					<img alt="image" class="img-fluid" style="min-height: 180px; object-fit: cover;" src="{{ URL::asset('img/dashboard-map.png') }}">
				</div>
			</div>

		</div>
	</div>

</div>
<div class="wrapper wrapper-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">

				<div class="col-lg-4">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>{{$user->company ? $user->company->company_name : ''}} Interviews</h5>
						</div>

						<div class="ibox-content inspinia-timeline">
                            @foreach($activities_interviews as $interview)
                                @php
                                    $candidate_name = '';
                                    if($interview->interview->candidate)
                                    {
                                    $candidate_name = $interview->interview->candidate->name." ".$interview->interview->candidate->last_name;
                                    }
                                    if($interview->interview->is_qualified == 1)
                                    {
                                    continue;
                                    }
                                @endphp
							<div class="timeline-item">
								<div class="row">
									<div class="col-4 date">
										<i class="fa fa-briefcase"></i> {{date('d M, h:i A',strtotime($interview->interview->interview_date))}}
										<br/>
										<small class="text-navy">{{time_ago($interview->created_at)}} ago</small>
									</div>
									<div class="col content no-top-border">
										<p class="m-b-xs"><strong>
                                                <a href="{{url('admin/interview/detail/')}}/{{$interview->listing_id}}" class="text-success">
                                                {{$interview->interview ? $interview->interview->subject. ' '.$candidate_name: ''}}
                                                </a>
                                            </strong></p>


										<p>
                                            {{$interview->activity_details}}
										</p>
                                        <dd class="mb-1 text-navy">
                                            @if ($interview->interview->attendees)
                                                @foreach ($interview->interview->attendees as $attendee)
                                                    <span class="badge mr-2">{{ $attendee->interviewer ? ($attendee->interviewer->name ? $attendee->interviewer->name : '') . ' ' . ($attendee->interviewer->last_name ? $attendee->interviewer->last_name : '') : '' }}</span>
                                                @endforeach
                                            @endif
                                        </dd>


									</div>
								</div>
							</div>
                            @endforeach

						</div>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Your feeds</h5>

						</div>
						<div class="ibox-content">

							<div>
								<div class="feed-activity-list">
                                    @foreach($activities as $activity)
									<div class="feed-element">
{{--										<a class="float-left" href="#">--}}
{{--											<img alt="image" class="rounded-circle" src="{{ URL::asset('img/profile.jpg') }}">--}}
{{--										</a>--}}
										<div class="media-body ">
											<small class="float-right">{{time_ago($activity->created_at)}} ago</small>
											<strong>({{count($activities)}})</strong> Offer(s) has been approved!
{{--                                            {{$activity->activity_title}}--}}
											<br>
											<small class="text-muted">{{date('l jS \of F Y h:i:s A',strtotime($activity->created_at))}}</small>
											<div class="actions">
                                                <a href="{{url('admin/offers?gm_app=1')}}" class="btn btn-xs btn-white"><i class="fa fa-list"></i> View all </a>
{{--                                                <a href="" class="btn btn-xs btn-white"><i class="fa fa-heart"></i> Love</a>--}}
											</div>
										</div>
									</div>
                                    @endforeach

								</div>

{{--								<button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button>--}}

							</div>

						</div>
					</div>

				</div>

				<div class="col-lg-4">
					<div class="ibox ">
						<div class="ibox-title">
							<h5>Quick Links</span>
						</div>
						<div class="ibox-content">
							@if (count(Auth::user()->quickLinks) > 0)
							<ul class="list-unstyled p-0">
								@foreach (Auth::user()->quickLinks as $quick_link)
								<li class="pt-1 pb-1 mb-2">
									<a href="{{ $quick_link->permission->route_name ? route($quick_link->permission->route_name) : '' }}" class="d-flex align-items-center flex-nowrap text-primary">
										{{ $quick_link->permission->display_name }} <small class="fas fa-chevron-right text-navy ml-2"></small>
									</a>
								</li>
								@endforeach
							</ul>
							@else
							<p>You do not have any quick links saved.</p>
							@endif

							<a href="{{ url('admin/quick-links') }}" class="d-flex align-items-center p-2 bg-muted text-primary">
								<small class="fas fa-plus bg-primary text-white pl-2 pr-2 pt-1 pb-1 mr-2 rounded"></small> <h4 class="m-0 font-weight-normal">Add quick access links</h4>
							</a>
						</div>
					</div>

				</div>

			</div>
		</div>

	</div>
</div>
@endsection
