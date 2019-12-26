@extends('employee_portal.layouts.inner')

@section('title')
Training
@endsection

@section('content')
<div class="training">
	<h2 class="section-title">
		Training
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
							<th>Course/Training</th>
							<th>Vendor</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>CA201110014</td>
								<td>Xin</td>
							<td>It Management</td>
							<td>XGH</td>
							<td>31/10/2011</td>
							<td>31/12/2011</td>
							<td>Active</td>
							<td class="text-center">
								<a href="" class="text-dark" title="View/Print"><i class="far fa-eye"></i> </a>
								<a href="" class="text-dark ml-2" title="Unpaid"><i class="fas fa-file-invoice-dollar"></i> </a>
								<a href="" class="text-dark ml-2" title="Delete"><i class="fas fa-trash-alt"></i></i> </a>
							</td>
						</tr>
						<tr>
							<td>2</td>
								<td>CA234567</td>
								<td>Xin</td>
							<td>It Management</td>
							<td>XGH</td>
							<td>31/10/2011</td>
							<td>31/12/2011</td>
							<td>Active</td>
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