@extends('employee_portal.layouts.dashboard')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="widget">
			<h2>Dashboard</h2>
			
			<div class="widget-wrap d-flex flex-nowrap justify-content-between">
				<a href="" class="info-widget d-flex flex-nowrap">
					<div class="icon d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('employee_portal/img/icon-document.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-document.png') }} 1x, {{ URL::asset('employee_portal/img/icon-document@2x.png') }} 2x" class="img-fluid">
					</div>

					<div class="info d-flex flex-column justify-content-center">
						<span class="label">Visa Expiry</span>
						<span class="value">12 June 2019</span>
					</div>
				</a>

				<a href="" class="info-widget d-flex flex-nowrap">
					<div class="icon d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('employee_portal/img/icon-repair.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-repair.png') }} 1x, {{ URL::asset('employee_portal/img/icon-repair@2x.png') }} 2x" class="img-fluid">
					</div>

					<div class="info d-flex flex-column justify-content-center">
						<span class="label">Training Completion</span>
						<span class="value">3/5</span>
					</div>
				</a>

				<a href="" class="info-widget d-flex flex-nowrap">
					<div class="icon d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('employee_portal/img/icon-plane.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-plane.png') }} 1x, {{ URL::asset('employee_portal/img/icon-plane@2x.png') }} 2x" class="img-fluid">
					</div>

					<div class="info d-flex flex-column justify-content-center">
						<span class="label">Recent Travel</span>
						<span class="value">Dubai - 20.7.19</span>
					</div>
				</a>

				<a href="" class="info-widget d-flex flex-nowrap">
					<div class="icon d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('employee_portal/img/icon-travel-bag.png') }}" srcset="{{ URL::asset('employee_portal/img/icon-travel-bag.png') }} 1x, {{ URL::asset('employee_portal/img/icon-travel-bag@2x.png') }} 2x" class="img-fluid">
					</div>

					<div class="info d-flex flex-column justify-content-center">
						<span class="label">Next Vacation</span>
						<span class="value">03 Jan 2020</span>
					</div>
				</a>
			</div>
		</div>
		<!-- info widgets -->
	</div>
</div>

<div class="row">
	<div class="col-md-8 pr-2">
		<div class="widget">
			<h2>Training Report</h2>

			<div class="widget-wrap background-white p-4">
				<img src="{{ URL::asset('employee_portal/img/graph.png') }}" srcset="{{ URL::asset('employee_portal/img/graph.png') }} 1x, {{ URL::asset('employee_portal/img/graph@2x.png') }} 2x" class="img-fluid">
			</div>
		</div>
		<!-- Training Report -->
	</div>

	<div class="col-md-4 pl-1">
		<div class="widget h-100">
			<h2>HR Process</h2>

			<div class="widget-wrap background-white p-3">
				<div class="progress d-flex flex-column">
					<div class="d-flex justify-content-between align-items-center">
						<span class="label">Accommodation</span>
						<span class="value">12/34</span>
					</div>

					<div class="bar">
						<div class="percentage"></div>
					</div>
				</div>

				<div class="progress d-flex flex-column">
					<div class="d-flex justify-content-between align-items-center">
						<span class="label">Insurance</span>
						<span class="value">02/14</span>
					</div>

					<div class="bar">
						<div class="percentage"></div>
					</div>
				</div>

				<div class="progress d-flex flex-column">
					<div class="d-flex justify-content-between align-items-center">
						<span class="label">Mobilization</span>
						<span class="value">14/30</span>
					</div>

					<div class="bar">
						<div class="percentage"></div>
					</div>
				</div>

				<div class="progress d-flex flex-column">
					<div class="d-flex justify-content-between align-items-center">
						<span class="label">Catering</span>
						<span class="value">10/20</span>
					</div>

					<div class="bar">
						<div class="percentage"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-4">
		<div class="widget">
			<h2 class="d-flex flex-nowrap align-items-center justify-content-between">Messages <a href="" class="view-all">View All</a></h2>

			<div class="widget-wrap background-white">
				<!-- <ul class="notifications list-unstyled">
					<li>
						<a href="">CPECC donates equipment to educational institution in Iraq's Basra</a>
					</li>

					<li>
						<a href="">CPECC donates equipment to educational institution in Iraq's Basra</a>
					</li>

					<li>
						<a href="">CPECC donates equipment to educational institution in Iraq's Basra</a>
					</li>

					<li>
						<a href="">CPECC donates equipment to educational institution in Iraq's Basra</a>
					</li>

					<li>
						<a href="">CPECC donates equipment to educational institution in Iraq's Basra</a>
					</li>
				</ul> -->

				<ul class="messages list-unstyled">
					<li class="pl-3 pr-3 pt-2 pb-2 mb-0">
						<a href="">
							<p>Certification process to be held on 12th April at Iran.</p>
							<span class="date">12 Apr</span>
						</a>
					</li>

					<li class="pl-3 pr-3 pt-2 pb-2 mb-0">
						<a href="">
							<p>Huwei donates equipment to educational institution in Iraq's Basra</p>
							<span class="date">15 Apr</span>
						</a>
					</li>

					<li class="pl-3 pr-3 pt-2 pb-2 mb-0">
						<a href="">
							<p>Pertochina donates equipment to educational institution in Iraq's Basra</p>
							<span class="date">16 Apr</span>
						</a>
					</li>
			</div>
		</div>
	</div>
	<!-- Notifications -->

	<div class="col-md-8">
		<div class="widget">
			<h2 class="d-flex flex-nowrap align-items-center justify-content-between">Pending Tasks <a href="" class="view-all">View All</a></h2>

			<div class="widget-wrap background-white">
				<div class="table-responsive">
					<table class="table-bordered">
						<thead>
							<tr>
								<th>Ref No</th>
								<th>Title</th>
								<th>Due Date</th>
								<th>Dept</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td>1</td>
								<td><span class="font-weight-bold">Visa Application : Submit passport scanned copy</span> Your visa appliation pending</td>
								<td>25-07-2019</td>
								<td>IT</td>
							</tr>

							<tr>
								<td>2</td>
								<td><span class="font-weight-bold">Leave Application : Submit leave form</span> Your leave appliation awaiting</td>
								<td>25-07-2019</td>
								<td>HR</td>
							</tr>

							<tr>
								<td>3</td>
								<td><span class="font-weight-bold">Visa Application : Submit passport scanned copy</span> Your visa appliation completed</td>
								<td>25-07-2019</td>
								<td>Camp</td>
							</tr>
						</tbody>
					</table>
				</div>

			</div>
		</div>
		<!-- Pending Tasks -->
	</div>
</div>
@endsection
