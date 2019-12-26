<li>
	<input type="hidden" name="comments[]" value="{{ $remark && $remark['comments'] ? $remark['comments'] : '' }}">

	<small class="text-muted">
		<span class="name">{{ $remark && $remark['user'] ? $remark['user']->getName() : '' }}</span> - <i class="far-fa-clock"></i> <span class="date">{{ date('l, d M Y, h:i a' ) }}</span>
	</small>
	<p>{{ $remark && $remark['comments'] ? $remark['comments'] : '' }}</p>
</li>