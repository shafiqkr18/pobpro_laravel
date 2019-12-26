@extends('employee_portal.layouts.inner')

@section('title')
Remibursement
@endsection

@section('content')
<div class="cash-advance">
	<h2 class="section-title">
		Reimbursement Management
		<a href="{{ url('employee-portal/reimbursement-form') }}">New Request</a>
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
							<th>Department</th>
							<th>Apply Date</th>
							<th>Pay Status</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>RE201111001</td>
							<td>Iama</td>
							<td>IT</td>
							<td>03/11/2011</td>
							<td>Unpaid</td>
							<td class="text-center">
								<a href="" class="text-dark" title="View/Print"><i class="far fa-eye"></i> </a>
								<a href="" class="text-dark ml-2" title="Unpaid"><i class="fas fa-file-invoice-dollar"></i> </a>
								<a href="" class="text-dark ml-2" title="Delete"><i class="fas fa-trash-alt"></i></i> </a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	</div>
@endsection