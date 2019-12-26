@extends('employee_portal.layouts.inner')

@section('title')
Access Application
@endsection

@section('content')
<div class="access-application">
	<h2 class="section-title">
		Access Application
		<a href="{{ url('employee-portal/access-application-form') }}">New</a>
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Ref No.</th>
							<th>Category</th>
							<th>Create Date</th>
							<th>Justification</th>
							<th>Status</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>AC-SET-201907001</td>
							<td>Authorization</td>
							<td>21-07-2019</td>
							<td>...</td>
							<td>Pending</td>
						</tr>

						<tr>
							<td>2</td>
							<td>AC-SET-201907002</td>
							<td>Authorization</td>
							<td>21-07-2019</td>
							<td>...</td>
							<td>Pending</td>
						</tr>

						<tr>
							<td>3</td>
							<td>AC-SET-201907003</td>
							<td>Authorization</td>
							<td>21-07-2019</td>
							<td>...</td>
							<td>Pending</td>
						</tr>

						<tr>
							<td>4</td>
							<td>AC-SET-201907004</td>
							<td>Authorization</td>
							<td>21-07-2019</td>
							<td>...</td>
							<td>Finish</td>
						</tr>

						<tr>
							<td>5</td>
							<td>AC-SET-201907005</td>
							<td>New</td>
							<td>21-07-2019</td>
							<td>...</td>
							<td>Finish</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection