@if ($task_history)
	@foreach ($task_history as $history)
	<li>
		<small class="text-muted">
			<span class="name">{{ $history->createdBy ? $history->createdBy->getName() : '' }}</span> - <i class="far-fa-clock"></i> <span class="date">{{ $history->created_at ? date('l, j M Y, h:i a', strtotime($history->created_at)) : '' }}</span>
		</small>
		<p>{{ $history->contents }}</p>
	</li>
	@endforeach
@endif