@extends('employee_portal.layouts.inner')

@section('title')
Certfication &amp; Training
@endsection

@section('content')
<div class="ppe">
	<h2 class="section-title">
		Certification &amp; Training
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Ref No.</th>
							<th>Title</th>
							<th>Start Date</th>
							<th>End Date</th>
							<th>No Of Trainee</th>
							<th>Action</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>RE201111001</td>
							<td>IT Management</td>
							<td>03/11/2011</td>
							<td>03/11/2012</td>
							<td>5</td>
							<td class="text-center">
								<a href="" class="text-dark" title="View/Print"><i class="far fa-eye"></i> </a>
								<a href="" class="text-dark ml-2" title="Unpaid"><i class="fas fa-file-invoice-dollar"></i> </a>
								<a href="" class="text-dark ml-2" title="Delete"><i class="fas fa-trash-alt"></i></i> </a>
							</td>
						</tr>
							<tr>
							<td>2</td>
							<td>RE20143333</td>
							<td>IT Management</td>
							<td>03/11/2017</td>
							<td>03/11/2018</td>
							<td>5</td>
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