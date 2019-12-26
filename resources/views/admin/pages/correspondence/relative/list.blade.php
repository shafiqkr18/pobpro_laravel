@extends('admin.layouts.default')

@section('title')
	Correspondence Relative
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function(){
	$('#correspondence_relative_list').DataTable({
		pageLength: 10,
		responsive: true,
		lengthChange: false,
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
			// {
			// 	className: 'btn-create',
			// 	text: '<i class="fa fa-plus mr-1"></i> Create',
			// 	action: function ( e, dt, node, config ) {
			// 		window.location.href = '';
			// 	}
			// }
		]

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
				Correspondence Mgt.
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Correspondence Relative</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/division-management/create') }}">List</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="correspondence_relative_list" style="width: 100%;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Reference No.</th>
									<th>Subject</th>
									<th>Source</th>
									<th>Attachment File</th>
									<th>Dept.</th>
									<th>Status</th>
									<th>Relative</th>
								</tr>
							</thead>

							<tbody>
								<tr>
									<td>1</td>
									<td>IFMS-IT-Sept-961</td>
									<td>Requesting Temporary Visitor Access</td>
									<td>Hassan Mohammed</td>
									<td>
										<a href="" class="text-success" target="_blank">IFMS-961.doc</a>
									</td>
									<td>IT</td>
									<td>Open</td>
									<td></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection