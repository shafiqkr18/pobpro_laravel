@php $badge = ['primary', 'info', 'muted']; @endphp
<tr>
	<td><span class="label label-{{ $badge[$task->status] }}">{{ $task->getStatus() }}</span></td>
	<td class="issue-info">
		<a href="{{ url('admin/task/detail/' . $task->id) }}" class="text-primary font-weight-bold">{{ $task->title }}</a>
		<small class="ellipsis">{!! strlen($task->contents) > 100 ? substr($task->contents, 0, 100) . '...</p>' : $task->contents !!}</small>
		<small>
			@if ($task->topics)
				@foreach ($task->topics as $topic)
				<a href="{{ url('admin/topic/detail/' . $topic->topic->id) }}" class="mr-2 text-primary"> #{{ $topic->topic->title }}</a>
				@endforeach
			@endif
		</small>
	</td>
	<!-- <td>Adrian Novak</td> -->
	<td>{{ $task->due_date ? date('d.m.Y H:i a', strtotime($task->due_date)) : '' }}</td>
	<td class="text-center">
		@if ($task->due_date)
		<span class="pie">{{ $task->daysPassed() }},{{ $task->daysRemaining() }}</span>
		<span class="d-block">{{ $task->daysRemaining() }}d</span>
		@endif
	</td> 
	<td class="project-people" nowrap>
		@if ($task->users)
			@foreach ($task->users as $user)
			<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
				@php $avatar = $user ? $user->avatar : null; @endphp
				<img alt="image" class="rounded-circle" src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}">
			</a>
			@endforeach
		@endif
	</td> 
	<td class="text-right" style="font-size: 14px">
		@if (count($task->letters) > 0)
		<i class="fas fa-envelope text-dark" title="Letters"></i> 
		@endif

		<i class="fab fa-meetup text-dark" title="Meetings"></i>
		<i class="far fa-chart-bar text-dark" title="Reports"></i>
	</td>
</tr>