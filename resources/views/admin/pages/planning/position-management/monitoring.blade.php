@extends('admin.layouts.default')

@section('title')
	Dashboard
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
  <link rel="stylesheet" href="{{ URL::asset('css/plugins/c3/c3.min.css') }}">
<style>
table.table {
	border-collapse: collapse !important;
}

table th {
	border: 0 !important;
}
</style>
@endsection

@section('scripts')
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

  <script src="{{ URL::asset('js/plugins/chartJs/Chart.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/flot/jquery.flot.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/flot/jquery.flot.time.js') }}"></script>



  <!-- Page-Level Scripts -->
	<script>
	$(document).ready(function(){
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
				}
			]

		});
	});
	</script>
  <script>
	  $(function() {

		  var data = [{
			  label: "IT Manager",
			  data: 21,
			  color: "#d3d3d3",
		  }, {
			  label: "HR",
			  data: 3,
			  color: "#bababa",
		  }];

		  var plotObj = $.plot($("#flot-pie-chart"), data, {
			  series: {
				  pie: {
					  show: true
				  }
			  },
			  grid: {
				  hoverable: true
			  },
			  tooltip: true,
			  tooltipOpts: {
				  content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
				  shifts: {
					  x: 20,
					  y: 0
				  },
				  defaultTheme: false
			  }
		  });

	  });
	  $(document).ready(function () {
		  var barData = {
			  labels: [
			  		@foreach($data['positions'] as $position)
				 	 '{{$position->title}}',
			  		@endforeach
			  ],
			  datasets: [
				  {
					  label: "Total Position",
					  backgroundColor: 'rgba(220, 220, 220, 0.5)',
					  pointBorderColor: "#fff",
					  data: [
						  @foreach($data['positions'] as $position)
								  '{{$position->total_positions}}',
						  @endforeach
					  ]
				  },
				  {
					  label: "Filled Position",
					  backgroundColor: 'rgba(26,179,148,0.5)',
					  borderColor: "rgba(26,179,148,0.7)",
					  pointBackgroundColor: "rgba(26,179,148,1)",
					  pointBorderColor: "#fff",
					  data: [
						  @foreach($data['positions'] as $position)
								  '{{$position->positions_filled}}',
						  @endforeach
					  ]
				  }
			  ]
		  };

		  var barOptions = {
			  responsive: true
		  };


		  var ctx2 = document.getElementById("barChart").getContext("2d");
		  new Chart(ctx2, {type: 'bar', data: barData, options:barOptions});
		});
  </script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Dashboard</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a>HR</a>
			</li>
			<!-- <li class="breadcrumb-item active">
				<strong>Monitoring</strong>
			</li> -->
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
			<div class="col-lg-6">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Position Chart</h5>
					</div>
					<div class="ibox-content">
						<div>
							<canvas id="barChart" height="140"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Position Chart</h5>
					</div>
				<div class="ibox-content">
					<div class="flot-chart">
						<div class="flot-chart-pie-content" id="flot-pie-chart"></div>
					</div>
				</div>
				</div>
			</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/position-management/create') }}">Positions List</h5>

					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						    <i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li>
								<a href="#" class="dropdown-item">Config option 1</a>
							</li>
							<li>
								<a href="#" class="dropdown-item">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped dataTables-example" >
							<thead>
								<tr>
									{{--<th>Department</th>--}}
									<th>RefNo</th>
									<th>Position</th>
									<th>Required No.</th>
									<th>Finished No.</th>
									{{--<th>Pending No.</th>
									<th>Missing No.</th>--}}
								</tr>
							</thead>
							<tbody>
							@foreach($data['positions'] as $position)
								<tr>
									<td>{{$position->reference_no}}</td>
									<td>{{$position->title}}</td>
									<td>{{$position->total_positions}}</td>
									<td>{{$position->position_filled}}</td>
{{--									<td>0</td>--}}
{{--									<td>0</td>--}}
								</tr>
							@endforeach

							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection