@extends('employee_portal.layouts.inner')

@section('title')
My Travel
@endsection

@section('content')
<div class="my-visa">
	<h2 class="section-title">
		My Travel
		<a href="{{ url('employee-portal/create-ticket') }}">Create Ticket</a>
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Ref No.</th>
							<th>Name</th>
							<th>Submit Date</th>
							<th>Approved Date</th>
							<th>Release Date</th>
							<th>Departure Date</th>
							<th>Return Date</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>ANTON-TR-2019-003</td>
							<td>Nick</td>
							<td>07/08/2019</td>
							<td>07/08/2019</td>
							<td>07/08/2019</td>
							<td>21/08/2019</td>
							<td>22/08/2019</td>
							<td class="text-center">
								<a href="" class="text-danger mr-1" title="Cancel"><i class="fas fa-times"></i> </a>
								<a href="" class="text-dark" title="Print"><i class="fas fa-print"></i> </a>
							</td>
						</tr>

						<tr>
							<td>ANTON-TR-2019-004</td>
							<td>Ricky</td>
							<td>07/08/2019</td>
							<td>07/08/2019</td>
							<td>07/08/2019</td>
							<td>21/08/2019</td>
							<td>22/08/2019</td>
							<td class="text-center">
								<a href="" class="text-danger mr-1" title="Cancel"><i class="fas fa-times"></i> </a>
								<a href="" class="text-dark" title="Print"><i class="fas fa-print"></i> </a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection