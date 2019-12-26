@php
$color = [
	'delete' => 'danger',
	'plan' => 'muted'
];
@endphp

<div class="modal-dialog modal-sm">
	<div class="modal-content">
		<div class="modal-header p-3">
			<h4 class="m-0"><i class="fa fa-exclamation-triangle text-{{ $color[$type] }}"></i> @yield('title')</h4>
		</div>
		<div class="modal-body pt-3 pl-3 pr-3 pb-0">
			@yield('content')
		</div>
		<div class="modal-footer p-2">
			@yield('footer')
		</div>
	</div>
</div>