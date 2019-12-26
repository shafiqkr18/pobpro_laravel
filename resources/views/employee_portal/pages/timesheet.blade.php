@extends('employee_portal.layouts.inner')

@section('title')
Timesheet
@endsection

@section('content')
<div class="timesheet">
	<h2 class="section-title">
		Timesheet
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered mt-4">
					<thead>
						<tr>
							<th>Name</th>
							<th colspan="2">16/07/2019</th>
							<th colspan="2">17/07/2019</th>
							<th colspan="2">18/07/2019</th>
							<th colspan="2">19/07/2019</th>
							<th colspan="2">20/07/2019</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td></td>
							<td class="text-center text-light bg-success font-weight-bold">In</td>
							<td class="text-center text-light bg-danger font-weight-bold">Out</td>
							<td class="text-center text-light bg-success font-weight-bold">In</td>
							<td class="text-center text-light bg-danger font-weight-bold">Out</td>
							<td class="text-center text-light bg-success font-weight-bold">In</td>
							<td class="text-center text-light bg-danger font-weight-bold">Out</td>
							<td class="text-center text-light bg-success font-weight-bold">In</td>
							<td class="text-center text-light bg-danger font-weight-bold">Out</td>
							<td class="text-center text-light bg-success font-weight-bold">In</td>
							<td class="text-center text-light bg-danger font-weight-bold">Out</td>
						</tr>

						<tr>
							<td>Iama</td>
							<td>08:00:00</td>
							<td>05:00:00</td>
							<td>08:00:00</td>
							<td>05:00:00</td>
							<td>08:00:00</td>
							<td>05:00:00</td>
							<td>08:00:00</td>
							<td>05:00:00</td>
							<td>08:00:00</td>
							<td>05:00:00</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection