@extends('employee_portal.layouts.inner')

@section('title')
My Accommodation
@endsection

@section('content')
<div class="my-accommodation">
	<h2 class="section-title">
		My Accommodation
		<a href="{{ url('employee-portal/accommodation-form') }}">
			Create
		</a>
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Ref No.</th>
							<th>Name</th>
							<th>Accommodation Location</th>
							<th>Room No.</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Status</th>
							<th>Finish Date</th>
							<th>Remark</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td class="text-nowrap">ACR-ROOM-10001</td>
							<td>Nick</td>
							<td>Base Camp</td>
							<td>K12</td>
							<td>07/08/2019</td>
							<td>22/08/2019</td>
							<td>Finished</td>
							<td>07/08/2019</td>
							<td></td>
						</tr>

						<tr>
							<td>2</td>
							<td class="text-nowrap">ACR-ROOM-10002</td>
							<td>Ricky</td>
							<td>Base Camp</td>
							<td>K12</td>
							<td>07/08/2019</td>
							<td>22/08/2019</td>
							<td>Finished</td>
							<td>07/08/2019</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection