@extends('frontend.layouts.candidate')

@section('title')
	My Onboarding
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
	<div class="welcome-message background-white p-3 mb-5">
		<p>Dear Mr. Nick Chen,</p>
		<p>Welcome to ITforce Technology DMCC!</p>
		<p>ITfore Technology DMCC is an IT professional service company with branches in Beijing, Hong Kong, and Dubai.</p>
		<p>ITforce Technology DMCC is a Dubai registered company location in JLT, Dubai UAE. ITforce Technology DMCC's business cover the Middle East and Africa (MENA) region. Our target customers are Oil/Oil services companies, large corporate, financial services, and legal services.</p>
		<br>
		<p>HR Department</p>
	</div>

	<h6 class="card-header mb-2 pt-0">
		Onboarding Checklist:
	</h6>

	<div class="card-body p-0">
		<div class="table-responsive">
			<table class="table table-striped table-bordered m-0">
				<thead>
					<tr>
						<th>No.</th>
						<th>Item</th>
						<th>Content</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td>1</td>
						<td>Personal Documents</td>
						<td>Bring your original passport, educational certificate</td>
						<td class="text-center">
							<a href="{{ url('candidate/interview/detail/1') }}" class="text-info">Done</a>
						</td>
					</tr>

					<tr>
						<td>2</td>
						<td>Travel &amp; Visa</td>
						<td>Apply your visa and book your flight tickets</td>
						<td class="text-center">
							<a href="{{ url('candidate/interview/detail/1') }}" class="text-info">In progress</a>
						</td>
					</tr>

					<tr>
						<td>3</td>
						<td>Others</td>
						<td>HSE PPE</td>
						<td class="text-center">
							<a href="{{ url('candidate/interview/detail/1') }}" class="text-info">Pending</a>
						</td>
					</tr>

					<tr>
						<td>4</td>
						<td>IT Assets</td>
						<td>Apply IT assets</td>
						<td class="text-center">
							<a href="{{ url('candidate/interview/detail/1') }}" class="text-info">Pending</a>
						</td>
					</tr>

					<tr>
						<td>5</td>
						<td>IT System Account</td>
						<td>Apply IT account including email address</td>
						<td class="text-center">
							<a href="{{ url('candidate/interview/detail/1') }}" class="text-info">Pending</a>
						</td>
					</tr>

					<tr>
						<td>6</td>
						<td>Onboarding</td>
						<td>After onboarding process, you can get full POB access to your employee account</td>
						<td class="text-center">
							<a href="{{ url('candidate/interview/detail/1') }}" class="text-info">Pending</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection