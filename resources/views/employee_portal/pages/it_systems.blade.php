@extends('employee_portal.layouts.inner')

@section('title')
IT Systems
@endsection

@section('content')
<div class="it-systems">
	<h2 class="section-title">
		IT Systems
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No.</th>
							<th>Ticket No.</th>
							<th>Subject</th>
							<th>Handled By</th>
							<th>Priority</th>
							<th>Status</th>
							<th>Date In</th>
							<th>Date Out</th>
							<th>Feedback File</th>
						</tr>
					</thead>

					<tbody>
						<tr>
							<td>1</td>
							<td>IT20190721001</td>
							<td>Computer</td>
							<td>Nick</td>
							<td class="text-danger">Critical</td>
							<td>Close</td>
							<td>21/07/2019</td>
							<td>22/07/2019</td>
							<td class="text-center">
								<a href="">Feedback File</a>
							</td>
						</tr>

						<tr>
							<td>2</td>
							<td>IT20190721002</td>
							<td>Printer</td>
							<td>Ricky</td>
							<td class="text-warning">High</td>
							<td>Pending</td>
							<td>21/07/2019</td>
							<td></td>
							<td class="text-center">
								<a href="">Feedback File</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection