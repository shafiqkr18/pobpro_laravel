@extends('admin.layouts.default')

@section('title')
	Position Management
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/jsTree/style.min.css') }}" rel="stylesheet">
<style>
.jstree-default .jstree-node > .jstree-ocl {
	margin-right: 15px;
}

.jstree-default .jstree-anchor {
	margin-bottom: 5px;
}

/* .jstree-default .jstree-open>.jstree-ocl,
.jstree-default .jstree-closed>.jstree-ocl {
	background-position: -68px -4px;
} */

.jstree-default .jstree-clicked,
.jstree-default .jstree-hovered {
	background: none;
	border-radius: 0;
	box-shadow: none;
	color: #1ab394;
	font-weight: bold;
}

table.dataTable {
	border-collapse: collapse !important;
}

table.table-bordered.dataTable td {
	border-top: 0;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/jsTree/jstree.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(11,66)}}"></script>

<script>
$(document).ready(function() {

	console.log(@php echo json_encode($tree); @endphp);

	$('#using_json').jstree({
		'core' : {
			'themes': {
				'icons': false
			},
			'data': @php echo json_encode($tree); @endphp
		} 
	});

	$('.data-table').DataTable({
		pageLength: 25,
		responsive: true,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{extend: 'copy'},
			{extend: 'csv'},
			{extend: 'excel', title: 'ExampleFile'},
			{extend: 'pdf', title: 'ExampleFile'},

			{
				extend: 'print',
				customize: function (win){
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');
					$(win.document.body).find('table').addClass('compact').css('font-size', 'inherit');
				}
			}
		]

	});

	$(document).on('click', '.jstree-anchor', function (e) {
		e.preventDefault();
		$(this).parents('.jstree-anchor').addClass('active');
		$('#address_book_employees_list').DataTable().ajax.url(baseUrl + '/admin/address_book_filter?type=' + $(this).attr('id')).load();
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
				<strong>Address Book</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Address Book</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-4">
			<div class="ibox">
				
				<div class="ibox-content">
					<div id="using_json"></div>
				</div>
			</div>
		</div>

		<div class="col-lg-8">
			<div class="ibox">
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-bordered table-striped" id="address_book_employees_list">
							<thead>
								<tr>
									<th>Ref No</th>
									<th>Badge ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Nationality</th>
									<th>Department</th>
									<th>Position</th>
									<th>View</th>
								</tr>
							</thead>

							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

@endsection