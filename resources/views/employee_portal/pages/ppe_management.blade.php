@extends('employee_portal.layouts.inner')

@section('title')
PPE Management
@endsection

@section('content')
<div class="ppe">
	<h2 class="section-title">
		PPE Management
		<a href="{{ url('employee-portal/ppe-form') }}">New Request</a>
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Ref No.</th>
							<th>Request Date</th>
							<th>Quantity</th>
							<th>Category</th>
							<th>Remarks</th>
							
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>CA201110014</td>
								<td>31/10/2011</td>
							<td>2</td>
							<td>Shoes</td>
							
							<td>Need Shoes</td>
							<td class="text-center">
								<a href="" class="text-dark" title="View/Print"><i class="far fa-eye"></i> </a>
								<a href="" class="text-dark ml-2" title="Unpaid"><i class="fas fa-file-invoice-dollar"></i> </a>
								<a href="" class="text-dark ml-2" title="Delete"><i class="fas fa-trash-alt"></i></i> </a>
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>CA2011143</td>
								<td>31/10/2011</td>
							<td>5</td>
							<td>Hats</td>
							
							<td>Need Hats</td>
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