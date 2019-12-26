<tr>
	<input type="hidden" name="task_status[]" value="0">
	<input type="hidden" name="task_title[]" value="{{ $task && $task['title'] ? $task['title'] : '' }}">
	<input type="hidden" name="task_due_date[]" value="{{ $task && $task['due_date'] ? date('Y-m-d', strtotime($task['due_date'])) : '' }}">
	<input type="hidden" name="task_users" value="{{ $task && $task['users'] ? json_encode($task['users']) : '' }}">
	<input type="hidden" name="task_contents[]" value="{{ $task && $task['contents'] ? $task['contents'] : '' }}">

	<td>Open</td>
	<td>{{ $task && $task['title'] ? $task['title'] : '' }}</td>
	<td>{{ $task && $task['due_date'] ? date('m/d/Y', strtotime($task['due_date'])) : '' }}</td>
	<td class="project-people text-left">
		@if ($task['users'])
			@foreach ($task['users'] as $user)
				@php $avatar = $user->avatar ? json_decode($user->avatar, true) : null; @endphp
				<a href="{{ url('admin/user-management/detail/' . $user->id) }}">
					<img src="{{ $avatar ? asset('/storage/' . $avatar[0]['download_link']) : URL::asset('img/avatar-default.jpg') }}" class="rounded-circle">
				</a>
			@endforeach
		@endif
	</td>
</tr>