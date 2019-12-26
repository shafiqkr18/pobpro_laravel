@extends('employee_portal.layouts.inner')

@section('title')
Timesheet
@endsection

@section('content')
<div class="handover">
	<h2 class="section-title">
		Handover
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Department</th>
							<th>Handover Title</th>
							<th>Handover Date</th>
							<th>Handover Category</th>
							<th>Status</th>
							<th>Reason</th>
							<th>Taken Over By</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>IT</td>
							<td>HO-2019-001</td>
							<td>21/07/2019</td>
							<td>Equipment</td>
							<td>Pending</td>
							<td>Transfer</td>
							<td>Daniel Frost</td>
						</tr>

						<tr>
							<td>2</td>
							<td>IT</td>
							<td>HO-2019-002</td>
							<td>21/07/2019</td>
							<td>Equipment</td>
							<td>Pending</td>
							<td>Transfer</td>
							<td>Daniel Frost</td>
						</tr>

						<tr>
							<td>3</td>
							<td>IT</td>
							<td>HO-2019-003</td>
							<td>21/07/2019</td>
							<td>Equipment</td>
							<td>Pending</td>
							<td>Transfer</td>
							<td>Daniel Frost</td>
						</tr>

						<tr>
							<td>4</td>
							<td>IT</td>
							<td>HO-2019-004</td>
							<td>21/07/2019</td>
							<td>Equipment</td>
							<td>Pending</td>
							<td>Transfer</td>
							<td>Daniel Frost</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection