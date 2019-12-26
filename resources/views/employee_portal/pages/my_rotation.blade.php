@extends('employee_portal.layouts.inner')

@section('title')
My Rotation
@endsection

@section('content')
<div class="ppe">
	<h2 class="section-title">
		My Rotation
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Rotation Plan</th>
							<th>Location</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Status</th>
							<th>DOA</th>
							<th>Handover</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>Plan A</td>
							<td>Iraq</td>
							<td>12/12/2019</td>
							<td>12/12/2019</td>
							<td><i title="Working" class="fas fa-tools"></i></td>
							<td><i title="Yes" class="fas fa-check"></i></td>
							<td><i title="Done" class="fas fa-check"></i></td>
						</tr>

						<tr>
							<td>Plan B</td>
							<td>Dubai</td>
							<td>12/12/2019</td>
							<td>12/12/2019</td>
							<td><i title="Working" class="fas fa-tools"></i></td>
							<td><i title="Yes" class="fas fa-check"></i></td>
							<td><i title="Done" class="fas fa-check"></i></td>
						</tr>

						<tr>
							<td>Plan C</td>
							<td>China</td>
							<td>12/12/2019</td>
							<td>12/12/2019</td>
							<td><i title="Working" class="fas fa-tools"></i></td>
							<td><i title="Yes" class="fas fa-check"></i></td>
							<td><i title="Done" class="fas fa-check"></i></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection