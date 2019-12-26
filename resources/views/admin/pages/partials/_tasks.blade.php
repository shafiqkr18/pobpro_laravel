@if ($offers && $offers->count() > 0)
<li class=" {{ $li_classes ? $li_classes : '' }}">
	<a href="{{ url('admin/offers_pending?pending=1&ur=' . Auth::user()->roles->pluck('name')[0]) }}">
		<small class="float-right">{{ time_ago($offers->first()->created_at) }}</small>
		<span class="label label-warning">{{ $offers->count() }}</span> Pending Offer{{ $offers->count() == 1 ? '' : 's' }}
	</a>
</li>
@endif

@if ($contracts && $contracts->count() > 0)
<li class=" {{ $li_classes ? $li_classes : '' }}">
	<a href="{{ url('admin/contracts_pending?pending=1&ur=' . Auth::user()->roles->pluck('name')[0]) }}">
		<small class="float-right">{{ time_ago($contracts->first()->created_at) }}</small>
		<span class="label label-warning">{{ $contracts->count() }}</span> Pending Contract{{ $contracts->count() == 1 ? '' : 's' }}
	</a>
</li>
@endif

@role('HRM|GM|itfpobadmin')
	@if ($plans->count() > 0)
	<li class=" {{ $li_classes ? $li_classes : '' }}">
		<a href="{{ url('admin/hr-plan?pending=1&ur=' . Auth::user()->roles->pluck('name')[0]) }}">
			<small class="float-right">{{ time_ago($plans->first()->created_at) }}</small>
			<span class="label label-warning">{{ $plans->count() }}</span> Pending Plan{{ $plans->count() == 1 ? '' : 's' }}
		</a>
	</li>
	@endif
@endrole

@if ($department_approvals && $department_approvals->count() > 0)
	@foreach ($department_approvals as $department_approval)
	<li class=" {{ $li_classes ? $li_classes : '' }}">
		<a href="{{ url('admin/department-requests/quick-view/' . $department_approval->department_id . '/1/' . $department_approval->id) }}">
			<small class="float-right">{{ time_ago($department_approval->created_at) }}</small>
			<span class="label label-warning">{{ $department_approval->approvalRelationships ? count($department_approval->approvalRelationships) : '' }}</span> {{ $department_approval->department->department_short_name }}
		</a>
	</li>
	@endforeach
@endif