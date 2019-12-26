@php
$status = ['Pending Response', 'Confirmed', 'Requested to reschedule', 'Declined'];
$status_class = ['warning', 'success', 'info', 'danger'];
@endphp

<div class="ibox">
	<div class="ibox-title">
		<h5>Scheduled Interview
        @if($data['position'])
            {{" For ".$data['position']->title}}
            @endif
        </h5>
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
						<a href="#" class="btn btn-xs btn-{{ $status_class[$interview->is_confirmed] }} ml-auto">{{ $status[$interview->is_confirmed] }}</a>	
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
		</ul>
	</div>
</div>