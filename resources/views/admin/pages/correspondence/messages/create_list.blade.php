@extends('admin.layouts.default')

@section('title')
	Correspondence Create
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function(){
	$('#correspondence_message_list').DataTable({
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
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function ( e, dt, node, config ) {
					window.location.href = '';
				}
			}
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

		<h2 class="d-flex align-items-center">Correspondence Create</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/division-management/create') }}">Messages</h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="correspondence_message_list" style="width: 100%;">
							<thead>
								<tr>
									<th>No.</th>
									<th>Reference No.</th>
									<th>Subject</th>
									<th>Date</th>
									<th>To</th>
									<th>Attachment File</th>
									<th>Dept.</th>
									<th>Relative</th>
									<th>Status</th>
									<th></th>
								</tr>
							</thead>

							<tbody>
							@if (count($messages) > 0)
								@foreach ($messages as $message)
								<tr>
									<td>{{ $message->id }}</td>
									<td>{{ $message->reference_no }}</td>
									<td>{{ $message->subject }}</td>
									<td>{{ date('Y-m-d', strtotime($message->msg_date)) }}</td>
									<td>{{ $message->msg_to_id }}</td>
									<td>{{ $message->attachment_files }}</td>
									<td>{{ $message->assign_dept_id }}</td>
									<td>{{ $message->msg_related_to }}</td>
									<td>{{ $message->status }}</td>

									<td class="text-nowrap text-center action-column">
										<a href="" title="View">
											<i class="fa fa-eye text-info"></i>
										</a>

										<a href="" title="Download">
											<i class="fas fa-file-download text-muted"></i>
										</a>
									</td>
								</tr>
								@endforeach
							@endif
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection