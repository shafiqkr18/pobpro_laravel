@extends('frontend.layouts.candidate')

@section('title')
	My Contracts
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});
});
</script>
@endsection

@php
$status = ['Awaiting feedback', 'Accepted', 'Declined'];
@endphp

@section('content')
<div class="card candidate">
	<h6 class="card-header mb-2 pt-0 {{ count($contracts) == 0 ? 'pl-0' : '' }}">
		My Contracts
	</h6>

	<div class="card-body p-0">
		@if (count($contracts) > 0)
		<div class="table-responsive">
			<table class="table table-striped table-bordered m-0">
				<thead>
					<tr>
						<th>No.</th>
						<th>Job Position</th>
						<th>Subject</th>
						<th>Status</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>

				<tbody>
					@foreach ($contracts as $contract)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $contract->position ? $contract->position->title : '' }}</td>
						<td>{{ $contract->subject }}</td>
						<td>{{ $status[$contract->accepted] }}</td>
						<td class="text-center">
							<div class="d-flex justify-content-center">
								<a href="{{ url('candidate/contract/detail/' . $contract->id) }}" class="btn btn-sm rounded btn-info font-weight-bold">View</a>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
		<p class="m-0 pt-3 pb-3 pt-3 pl-0"><small>You currently do not have any contracts.</small></p>
		@endif
	</div>
</div>
@endsection