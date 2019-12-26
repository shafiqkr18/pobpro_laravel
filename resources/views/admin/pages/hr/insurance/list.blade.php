@extends('admin.layouts.default')

@section('title')
	Insurance Management
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

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
				<a>HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Insurance</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Insurance Management</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/insurance/create') }}">Insurance</h5>

				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" width="100%;">
							<thead>
								<tr>
									<th>Insurance Type</th>
									<th>Insurer</th>
									<th>Policy No.</th>
									<th>Policy Holder</th>
									<th>Entity</th>
									<th>Card No.</th>
									<th>Issue Date</th>
									<th>Expiry Date</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>By Person</td>
									<td>MetLife</td>
									<td>987456321</td>
									<td>ITF</td>
									<td>NA</td>
									<td>PE0783573</td>
									<td>09/05/2019</td>
									<td>08/05/2021</td>
									<td class="text-right">
										<a href="{{ url('admin/insurance/detail/1') }}" title="View"><i class="fa fa-eye text-info"></i></a>
										<a href="{{ url('admin/insurance/update/1') }}" title="Edit"><i class="fas fa-pen text-success"></i></a>
										<a href="" title="Delete"><i class="fa fa-trash text-danger"></i></a>
									</td>
								</tr>
							</tbody>
							<!-- <tfoot>
								<tr>
									<th>Rendering engine</th>
									<th>Browser</th>
									<th>Platform(s)</th>
									<th>Engine version</th>
									<th>CSS grade</th>
								</tr>
							</tfoot> -->
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection