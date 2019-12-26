@extends('frontend.layouts.candidate')

@section('title')
	Vacancies
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

@section('content')
<div class="card candidate">
	<h6 class="card-header mb-2 pt-0 {{ count($vacancies) == 0 ? 'pl-0' : '' }}">
		{{ count($vacancies) > 0 ? 'We are hiring' : 'Vacancies' }}
	</h6>

	<div class="card-body p-0">
		@if (count($vacancies) > 0)
		<div class="table-responsive">
			<table class="table table-striped table-bordered m-0">
				<thead>
					<tr>
						<th></th>
						<th>Job Title</th>
						<th>Department</th>
						<th>Working Location</th>
						<th class="text-center"></th>
					</tr>
				</thead>

				<tbody>
					@foreach ($vacancies as $vacancy)
					<tr>
						<td>{{ $loop->iteration }}</td>
						<td>{{ $vacancy->position ? $vacancy->position->title : '' }}</td>
						<td>{{ $vacancy->position ? $vacancy->position->department->department_name : '' }}</td>
						<td>{{ $vacancy->location }}</td>
						<td class="text-center">
							<div class="d-flex justify-content-center">
								<a href="{{ url('candidate/vacancy/detail/' . $vacancy->id) }}" class="btn btn-sm rounded btn-info font-weight-bold">Apply</a>
							</div>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
		<p class="m-0 pt-3 pb-3 pt-3 pl-0"><small>There are currently no vacancies.</small></p>
		@endif
	</div>
</div>
@endsection