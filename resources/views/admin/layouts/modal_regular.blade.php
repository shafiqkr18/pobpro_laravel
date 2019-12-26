<div class="modal-dialog {{ $modal_size ? $modal_size : '' }}">
	<div class="modal-content">
		@if (!$hide_header)
		<div class="modal-header p-3 d-flex flex-nowrap">
			<h4 class="m-0">@yield('title')</h4>
			<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
		</div>
		@endif
		
		<div class="modal-body pt-3 pl-3 pr-3 pb-0 gray-bg">
			@yield('content')
		</div>
	</div>
</div>