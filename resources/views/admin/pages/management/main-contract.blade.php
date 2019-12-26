@extends('admin.layouts.default')

@section('title')
	Main Contract
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
table.dataTable {
	border-collapse: collapse !important;
}
</style>
@endsection

@section('scripts')
<!-- Jvectormap -->
<script src="{{ URL::asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js') }}"></script>
<script>
$(document).ready(function(){
	var hash = window.location.hash;
	hash && $('ul.nav a[href="' + hash + '"]').tab('show');

	$('.dataTables-example').DataTable({
		pageLength: 10,
		responsive: true,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy'},
			{extend: 'csv'},
			{extend: 'excel', title: 'ExampleFile'},
			{extend: 'pdf', title: 'ExampleFile'},

			{extend: 'print',
				customize: function (win){
							$(win.document.body).addClass('white-bg');
							$(win.document.body).css('font-size', '10px');

							$(win.document.body).find('table')
											.addClass('compact')
											.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function ( e, dt, node, config ) {
					window.location.href = $('.ibox-title h5').attr('data-url');
				}
			}
		]

	});
	
	var mapData = {
		"US": 498,
		"SA": 200,
		"CA": 1300,
		"DE": 220,
		"FR": 540,
		"CN": 120,
		"AU": 760,
		"BR": 550,
		"IN": 200,
		"GB": 120,
		"RU": 2000
	};

	$('#world-map').vectorMap({
		map: 'world_mill_en',
		backgroundColor: "transparent",
		regionStyle: {
				initial: {
						fill: '#e4e4e4',
						"fill-opacity": 1,
						stroke: 'none',
						"stroke-width": 0,
						"stroke-opacity": 0
				}
		},
		series: {
				regions: [{
						values: mapData,
						scale: ["#1ab394", "#22d6b1"],
						normalizeFunction: 'polynomial'
				}]
		}
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Management
			</li>
			<li class="breadcrumb-item active">
				<strong>Main Contract</strong>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">Main Contract</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="row">
	<div class="col-lg-3">
		<div class="widget style1">
			<div class="row">
				<div class="col-4 text-center">
					<i class="fa fa-trophy fa-5x"></i>
				</div>
				<div class="col-8 text-right">
					<span> Total Award </span>
					<h2 class="font-bold">$ 8,894,232</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="widget style1 navy-bg">
			<div class="row">
				<div class="col-4">
					<i class="fa fa-group fa-5x"></i>
				</div>
				<div class="col-8 text-right">
					<span> Total Employees </span>
					<h2 class="font-bold">1,200</h2>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="widget style1 lazur-bg">
			<div class="row">
				<div class="col-4">
					<i class="fa fa-handshake-o fa-5x"></i>
				</div>
				<div class="col-8 text-right">
					<span> Project Acceptance Date </span>
					<h3 class="font-bold">30-12-2019</h3>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-3">
		<div class="widget style1 yellow-bg">
			<div class="row">
				<div class="col-4">
					<i class="fa fa-drivers-license-o fa-5x"></i>
				</div>
				<div class="col-8 text-right">
					<span> Contract Term </span>
					<h2 class="font-bold">3 Years</h2>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-4">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Project Launch milestone</h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="fa fa-wrench"></i>
					</a>
					<ul class="dropdown-menu dropdown-user">
						<li><a href="#" class="dropdown-item">Config option 1</a>
						</li>
						<li><a href="#" class="dropdown-item">Config option 2</a>
						</li>
					</ul>
					<a class="close-link">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="ibox-content inspinia-timeline">

				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-briefcase"></i>
							6:00 am
							<br/>
							<small class="text-navy">2 hour ago</small>
						</div>
						<div class="col-7 content no-top-border">
							<p class="m-b-xs"><strong>Meeting</strong></p>

							<p>Conference on the sales results for the previous year. Monica please examine sales trends in marketing and products. Below please find the current status of the
								sale.</p>


						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-file-text"></i>
							7:00 am
							<br/>
							<small class="text-navy">3 hour ago</small>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Send documents to Mike</strong></p>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-coffee"></i>
							8:00 am
							<br/>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Coffee Break</strong></p>
							<p>
								Go to shop and find some products.
								Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.
							</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-phone"></i>
							11:00 am
							<br/>
							<small class="text-navy">21 hour ago</small>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Phone with Jeronimo</strong></p>
							<p>
								Lorem Ipsum has been the industry's standard dummy text ever since.
							</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-user-md"></i>
							09:00 pm
							<br/>
							<small>21 hour ago</small>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Go to the doctor dr Smith</strong></p>
							<p>
								Find some issue and go to doctor.
							</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-user-md"></i>
							11:10 pm
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Chat with Sandra</strong></p>
							<p>
								Lorem Ipsum has been the industry's standard dummy text ever since.
							</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-comments"></i>
							12:50 pm
							<br/>
							<small class="text-navy">48 hour ago</small>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Chat with Monica and Sandra</strong></p>
							<p>
								Web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
							</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-phone"></i>
							08:50 pm
							<br/>
							<small class="text-navy">68 hour ago</small>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Phone to James</strong></p>
							<p>
								Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
							</p>
						</div>
					</div>
				</div>
				<div class="timeline-item">
					<div class="row">
						<div class="col-3 date">
							<i class="fa fa-file-text"></i>
							7:00 am
							<br/>
							<small class="text-navy">3 hour ago</small>
						</div>
						<div class="col-7 content">
							<p class="m-b-xs"><strong>Send documents to Mike</strong></p>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
						</div>
					</div>
				</div>

			</div>
		</div>


	</div>
	<div class="col-lg-8">
		<div class="ibox ">
<!-- </div> -->
			<div class="tabs-container">
				<ul class="nav nav-tabs">
					<li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Contract Master Info</a></li>
					<li><a class="nav-link" data-toggle="tab" href="#tab-budgets"> Budgets</a></li>
					<li><a class="nav-link" data-toggle="tab" href="#tab-2"> Terms</a></li>
					<li><a class="nav-link" data-toggle="tab" href="#tab-3"> SOW</a></li>
					<li><a class="nav-link" data-toggle="tab" href="#tab-4"> Schedule</a></li>
				</ul>
				<div class="tab-content">
					<div id="tab-1" class="tab-pane active">
						<div class="panel-body">

							<fieldset>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Title:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="Majnoon Oilfield Sevices"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">No.:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="CON-8835345-234"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Active Date:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="07-09-2019"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Award:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="$160.00"></div>
								</div>



								<div class="form-group row"><label class="col-sm-2 col-form-label">ID:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="543"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Model:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="..."></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Location:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="location"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Tax Class:</label>
									<div class="col-sm-10">
										<select class="form-control" >
											<option>option 1</option>
											<option>option 2</option>
										</select>
									</div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Quantity:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="Quantity"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Minimum quantity:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="2"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Sort order:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="0"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Status:</label>
									<div class="col-sm-10">
										<select class="form-control" >
											<option>option 1</option>
											<option>option 2</option>
										</select>
									</div>
								</div>


								<div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Title:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="..."></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Description:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="Sheets containing Lorem"></div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Meta Tag Keywords:</label>
									<div class="col-sm-10"><input type="text" class="form-control" placeholder="Lorem, Ipsum, has, been"></div>
								</div>
							</fieldset>

						</div>
					</div>

					<div id="tab-budgets" class="tab-pane">
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped" id="budget_list" style="width: 100%">
									<thead>
										<tr>
											<th>ID</th>
											<th>Title</th>
											<th>Amount (USD)</th>
											<th>Created By</th>
											<th>Created At</th>
											<!-- <th></th> -->
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>

					<div id="tab-2" class="tab-pane">
						<div class="panel-body">

							<fieldset>


								<div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
									<div class="col-sm-10">
										<div class="summernote">
											<h3>Lorem Ipsum is simply</h3>
											dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
											<br/>

										</div>
									</div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
									<div class="col-sm-10">
										<div class="summernote">
											<h3>Lorem Ipsum is simply</h3>
											dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
											<br/>

										</div>
									</div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
									<div class="col-sm-10">
										<div class="summernote">
											<h3>Lorem Ipsum is simply</h3>
											dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
											<br/>

										</div>
									</div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
									<div class="col-sm-10">
										<div class="summernote">
											<h3>Lorem Ipsum is simply</h3>
											dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
											<br/>

										</div>
									</div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
									<div class="col-sm-10">
										<div class="summernote">
											<h3>Lorem Ipsum is simply</h3>
											dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
											<br/>

										</div>
									</div>
								</div>
								<div class="form-group row"><label class="col-sm-2 col-form-label">Description:</label>
									<div class="col-sm-10">
										<div class="summernote">
											<h3>Lorem Ipsum is simply</h3>
											dummy text of the printing and typesetting industry. <strong>Lorem Ipsum has been the industry's</strong> standard dummy text ever since the 1500s,
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic
											typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with
											<br/>

										</div>
									</div>
								</div>
							</fieldset>


						</div>
					</div>
					<div id="tab-3" class="tab-pane">
						<div class="panel-body">

							<div class="table-responsive">
								<table class="table table-stripped table-bordered">

									<thead>
									<tr>
										<th>
											Group
										</th>
										<th>
											Quantity
										</th>
										<th>
											Discount
										</th>
										<th style="width: 20%">
											Date start
										</th>
										<th style="width: 20%">
											Date end
										</th>
										<th>
											Actions
										</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<select class="form-control" >
												<option selected>Group 1</option>
												<option>Group 2</option>
												<option>Group 3</option>
												<option>Group 4</option>
											</select>
										</td>
										<td>
											<input type="text" class="form-control" placeholder="10">
										</td>
										<td>
											<input type="text" class="form-control" placeholder="$10.00">
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<div class="input-group date">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" value="07/01/2014">
											</div>
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>

									</tbody>

								</table>
							</div>

						</div>
					</div>
					<div id="tab-4" class="tab-pane">
						<div class="panel-body">

							<div class="table-responsive">
								<table class="table table-bordered table-stripped">
									<thead>
									<tr>
										<th>
											Image preview
										</th>
										<th>
											Image url
										</th>
										<th>
											Sort order
										</th>
										<th>
											Actions
										</th>
									</tr>
									</thead>
									<tbody>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/2s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image1.png">
										</td>
										<td>
											<input type="text" class="form-control" value="1">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/2s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image2.png">
										</td>
										<td>
											<input type="text" class="form-control" value="2">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/3s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image3.png">
										</td>
										<td>
											<input type="text" class="form-control" value="3">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/2s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image4.png">
										</td>
										<td>
											<input type="text" class="form-control" value="4">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/4s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image5.png">
										</td>
										<td>
											<input type="text" class="form-control" value="5">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/2s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image6.png">
										</td>
										<td>
											<input type="text" class="form-control" value="6">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									<tr>
										<td>
											<img src="http://pobpro.itforce-tech.com/admin/img/gallery/7s.jpg">
										</td>
										<td>
											<input type="text" class="form-control" disabled value="http://mydomain.com/images/image7.png">
										</td>
										<td>
											<input type="text" class="form-control" value="7">
										</td>
										<td>
											<button class="btn btn-white"><i class="fa fa-trash"></i> </button>
										</td>
									</tr>
									</tbody>
								</table>
							</div>

						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>
<div class="row m-t-lg mb-4">
	<div class="col-lg-12">
		<div class="ibox-content">
			<h2>Download</h2>
			<small class="d-block">Download main contract file.</small>
			<a href="{{ URL::asset('img/pdf-sample.pdf') }}" target="_blank" class="btn btn-large btn-success mt-3">Download</a>
		</div>
	</div>

</div>
@endsection