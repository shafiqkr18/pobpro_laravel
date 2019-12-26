@extends('employee_portal.layouts.inner')

@section('title')
My Visa
@endsection

@section('content')
<div class="my-visa">
	<h2 class="section-title">
		My Current Visa
		<a href="">
			<img src="{{ URL::asset('employee_portal/img/icon-edit.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-edit.png') }} 1x, {{ URL::asset('employee_portal/img/icon-edit@2x.png') }} 2x" class="img-fluid">
			Update Info
		</a>
	</h2>

	<div class="card mb-4">
		<div class="card-body m-4">
			<div class="row">
				<div class="text-center mr-4">
					<img src="{{ URL::asset('employee_portal/img/visa-pic.png') }}" srcset="{{ URL::asset('employee_portal/img/visa-pic.png') }} 1x, {{ URL::asset('employee_portal/img/visa-pic@2x.png') }} 2x" class="img-fluid">
				</div>

				<div class="passport-details">
					<span class="label mt-3">Name</span>
					<span class="value">Hong Wang</span>

					<span class="label mt-4 pt-2">Passport Name</span>
					<span class="value">Ricky Wang</span>
				</div>

				<div class="passport-details">
					<span class="label mt-3">Passport No:</span>
					<span class="value">PE339240</span>

					<span class="label mt-4 pt-2">Reference No:</span>
					<span class="value">Visa-1344-1344</span>
				</div>

				<div class="passport-details">
					<span class="label mt-3">Issue Date</span>
					<span class="value">07/06/2019</span>

					<span class="label mt-4 pt-2">Expiry Date</span>
					<span class="value">07/06/2019</span>
				</div>

				<div class="passport-details">
					<span class="label mt-3">Status</span>
					<span class="value">Active</span>
				</div>
			</div>
		</div>
	</div>

	<h2 class="section-title mt-5">
		My Visa History
	</h2>

	<div class="card mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered">
					<thead>
						<thead>
							<tr>
								<th>No.</th>
								<th>Ref No.</th>
								<th>Name</th>
								<th>Passport Name</th>
								<th>Passport No.</th>
								<th>Issue Date</th>
								<th>Expiry Date</th>
								<th>Status</th>
								<th>Visa Issue Date</th>
								<th>Visa Expiry Date</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>1</td>
								<td>VISA-2019-003</td>
								<td>Ricky Wang</td>
								<td>Hong Wang</td>
								<td>PE07835383</td>
								<td>07/08/2010</td>
								<td>06/08/2015</td>
								<td>Released</td>
								<td>21/07/2019</td>
								<td>20/07/2022</td>
							</tr>

							<tr>
								<td>1</td>
								<td>VISA-2019-003</td>
								<td>Ricky Wang</td>
								<td>Hong Wang</td>
								<td>PE07835383</td>
								<td>07/08/2010</td>
								<td>06/08/2015</td>
								<td>Released</td>
								<td>21/07/2019</td>
								<td>20/07/2022</td>
							</tr>

							<tr>
								<td>1</td>
								<td>VISA-2019-003</td>
								<td>Ricky Wang</td>
								<td>Hong Wang</td>
								<td>PE07835383</td>
								<td>07/08/2010</td>
								<td>06/08/2015</td>
								<td>Released</td>
								<td>21/07/2019</td>
								<td>20/07/2022</td>
							</tr>
						</tbody>
					</thead>
				</table>
			</div>
		</div>
	</div>
	</div>
@endsection