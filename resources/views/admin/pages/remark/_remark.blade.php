<li>
	<small class="text-muted">
		<span class="name">{{ $remark->createdBy ? $remark->createdBy->getName() : '' }}</span> - <i class="far-fa-clock"></i> <span class="date">{{ $remark->created_at ? date('l, j M Y, h:i a', strtotime($remark->created_at)) : '' }}</span>
	</small>
	
	<p>{{ $remark->comments }}</p>
</li>