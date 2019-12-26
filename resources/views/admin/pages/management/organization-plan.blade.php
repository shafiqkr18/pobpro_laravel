@extends('admin.layouts.default')

@section('title')
	Organization Chart
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
.dropdown-toggle::after {
	display: none !important;
}

.checkbox-switch {
	height: 0;
	width: 0;
	visibility: hidden;
}

.checkbox-switch + label {
	cursor: pointer;
	text-indent: -9999px;
	width: 33px;
	height: 20px;
	background: #d6d6d6;
	display: block;
	border-radius: 20px;
	position: relative;
}

.checkbox-switch + label:after {
	content: '';
	position: absolute;
	top: 2px;
	left: 2px;
	width: 16px;
	height: 16px;
	background: #fff;
	border-radius: 16px;
	transition: 0.3s;
}

.checkbox-switch:checked + label {
	background: #18a689;
}

.checkbox-switch:checked + label:after {
	left: calc(100% - 2px);
	transform: translateX(-100%);
}

.checkbox-switch + label:active:after {
	width: 33px;
}
</style>
@endsection

@section('scripts')
<!-- Nestable List -->
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/nestable/jquery.nestable.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(11111,99999)}}"></script>
<script src="{{ URL::asset('js/operations/dropdowns.js?version=') }}{{rand(11111,99999)}}"></script>
<script>
$('#nestable').nestable({
	group: 1,
	handleClass: 'lorem'
});

$('#nestable2').nestable({
	group: 1,
	handleClass: 'lorem'
});
$('.input-group.date').datepicker({
	todayBtn: 'linked',
	keyboardNavigation: false,
	forceParse: false,
	calendarWeeks: true,
	autoclose: true
});
$( document ).ready(function() {

    //$('#s_anc').on('click', function (e) {
        $("#mid_sec_list").delegate("#s_anc", "click", function(event){
            event.stopPropagation();
            event.stopImmediatePropagation();
            $('#mySections').modal('toggle');
        console.log('hereee');
    });
	$('#nestable-menu').on('click', function (e) {
		var target = $(e.target),
				action = target.data('action');
		if (action === 'expand-all') {
			$('.dd').nestable('expandAll');
		}
		if (action === 'collapse-all') {
			$('.dd').nestable('collapseAll');
		}
	});
});
</script>
<script>
	var my_org_id = '{{count($data['organizations'])?$data['organizations'][0]->id:0}}';
	console.log(my_org_id+" is my org_id");
	//set login user data
    var login_org_id = '{{Auth::user()->org_id}}';
    var login_div_id = '{{Auth::user()->div_id}}';
    if(login_org_id > 0)
    {

        $("#org_id_for_div").val(my_org_id);
        $('#org_id_for_div').trigger('change');
        let interval = setInterval(function() {
            if (document.querySelectorAll('#div_id option').length > 0) {
                $("#div_id").val(login_div_id);
                clearInterval(interval);
            }
        }, 1000);
    }
	function loadDynamicHTML(list_id=0 , type = 0)
	{
		var queryString = 'dept_id='+list_id+'&_token='+$('meta[name=csrf-token]').attr('content')+'&type='+type;
		jQuery.ajax({
			url: baseUrl+'/admin/getServiceData',
			data:queryString,
			type: "POST",
			success:function(data){
				$("#srvcBody").html(data['list_data']);

			},
			error:function (){}
		});
	}
	function loadDynamicHTMLPositions(list_id=0)
	{
		var queryString = 'section_id='+list_id+'&_token='+$('meta[name=csrf-token]').attr('content');
		jQuery.ajax({
			url: baseUrl+'/admin/getPositionHTMLData',
			data:queryString,
			type: "POST",
			success:function(data){
				$("#show_position_list_"+list_id).html(data['list_data']);

			},
			error:function (){}
		});
	}

	function loadDynamicHTMLPositionsTable(list_id=0)
	{
		var queryString = 'div_id='+list_id+'&_token='+$('meta[name=csrf-token]').attr('content');
		jQuery.ajax({
			url: baseUrl+'/admin/getPositionHTMLDataTable',
			data:queryString,
			type: "POST",
			success:function(data){
				$("#showDivPosTable").html(data['list_data']);
			},
			error:function (){}
		});
	}
	function loadDynamicHTMLPositionsTableService(type , list_id=0)
	{
		var queryString = 'type='+type+'&list_id='+list_id+'&_token='+$('meta[name=csrf-token]').attr('content');
		jQuery.ajax({
			url: baseUrl+'/admin/getPositionHTMLDataTableService',
			data:queryString,
			type: "POST",
			success:function(data){
				$("#showDivPosTable").html(data['list_data']);

			},
			error:function (){}
		});
	}
	$(function() {
		$("#mid_sec_list").delegate(".sec-dept-lst", "click", function(event){
			event.stopPropagation();
			event.stopImmediatePropagation();
			let list_id = $(this).attr('id');
			loadDynamicHTMLPositionsTableService('sec-dept-lst',list_id);
			$("#department_id").val(list_id);
			$('#department_id').trigger('change');
			console.log('department =' + list_id);
			$('#frm_position #department_id').val(list_id);
			$('#frm_position #department_id').trigger('change');
			console.log('sec-dept-lst with id='+list_id);
		});
		$("#mid_sec_list").delegate(".sec-sec-lst", "click", function(event){
			event.stopPropagation();
			event.stopImmediatePropagation();
			let list_id = $(this).attr('id');
			let dept_id = $(this).attr('data-dept');
			$('.sec-sec-lst').removeClass('text-navy');
			$(this).addClass('text-navy');
			console.log('sec-sec-lst with id='+list_id);
			loadDynamicHTMLPositionsTableService('sec-sec-lst',list_id);
			console.log('department = ' + dept_id);
			$('#frm_position #department_id').val(dept_id);
			$('#frm_position #department_id').trigger('change');
			let interval = setInterval(function() {
				if (document.querySelectorAll('#section_id option').length > 0) {
					$("#section_id").val(list_id);
					clearInterval(interval);
				}
			}, 1000);
		});

		$(".dept_list").on('click', function(event){
			event.stopPropagation();
			event.stopImmediatePropagation();
			console.log('dept list clicked');
			$('.dept_list').removeClass('text-navy');
			$(this).addClass('text-navy');
			let list_id = $(this).attr('id');
			let mydivid = $(this).attr('mydivid');
			$("#div_id_for_section").val(mydivid);
            $("#div_for_position").val(mydivid);
			$('#div_id_for_section').trigger('change');
			console.log('div='+mydivid+" dept_id="+list_id);
			//setInterval(function(){$("#dept_id").val(list_id); }, 2000);
			let interval = setInterval(function() {
				if (document.querySelectorAll('#dept_id option').length > 0) {
					console.log('List is definitely populated!');
					$("#dept_id").val(list_id);
					clearInterval(interval);
				}
			}, 1000);

			//$('#dept_id').trigger('change');
			$("#showDivPosTable table.table").remove();

			loadDynamicHTML(list_id,0);
			//show positions from here also
            loadDynamicHTMLPositionsTableService('sec-dept-lst',list_id);

            $('#frm_position #department_id').val(list_id);
            $('#frm_position #department_id').trigger('change');
		});

		$("#nestable").delegate(".view_position_section", "click", function(event){
			event.stopPropagation();
			event.stopImmediatePropagation();
			let list_id = $(this).attr('id');
			console.log('section list clicked '+list_id);
			loadDynamicHTMLPositions(list_id);
		});
		$(".division-pos-lst").on('click', function(event){
			var $this = $(this),
					classes = event.target.className,
					classList = classes.split(' ');
			if (classList.includes('get-positions')) {
				var anchor = $this.closest('a').attr('class');
				classList = anchor.split(' ');
			}
			if (classList.includes('division-pos-lst')) {
				event.stopPropagation();
				event.stopImmediatePropagation();
				let list_id = $(this).attr('id');
				console.log('division list clicked '+list_id);
				//show section also
							loadDynamicHTML(list_id,1);
				//set div_id in position
							$('#div_for_position').val(list_id);
							$('#frm_position #department_id').val(0);
							$('#frm_position #department_id').trigger('change');
				loadDynamicHTMLPositionsTable(list_id);
			}
		});

		$('#org_id_for_div,#org_id_for_section').change(function() {
			let org = { 'org_id': $(this).val() };
			$.get(baseUrl +'/admin/org-divisions', org, function (data) {
				let divisions = $('#div_id');
				let div_id_for_section = $('#div_id_for_section');
				divisions.empty();
				divisions.append("<option value=''>Select Division</option>");
				div_id_for_section.empty();
				div_id_for_section.append("<option value=''>Select Division</option>");
				$.each(data, function(key, value) {

					divisions.append("<option value='"+ value.id +"'>" + value.short_name + "</option>");
					div_id_for_section.append("<option value='"+ value.id +"'>" + value.short_name + "</option>");
				});
			});
		});

		/*get departments based on division*/
		$('#div_id_for_section').change(function() {

			let division = { 'div_id': $(this).val() };
			$.get(baseUrl +'/admin/division-department', division, function (data) {
				let departments = $('#dept_id');
				departments.empty();
				$.each(data, function(key, value) {
					departments.append("<option value='"+ value.id +"'>" + value.department_short_name + "</option>");
				});
			});
		});


		$("#org_id_for_section").val(my_org_id);
		$('#org_id_for_section').trigger('change');
	});
	$(document).on("change", ".qty1", function() {
		var sum = 0;
		$(".qty1").each(function(){
			sum += +$(this).val();
		});
		$(".total_all").val(sum);
	});

	$(document).on('click', '.edit-position', function (e) {
		e.preventDefault();

		$.ajax({
			url: baseUrl + '/admin/position-management/get-position/' + $(this).attr('data-id'),
			type: 'POST',
			dataType: 'json',
			data: {

			},
			processData: false,
			contentType: false,
			success: function (response) {

				if (response.position) {
					var position = response.position;
					var d = new Date(position.due_date);

					$('.pos-ref').attr('data-original', $('.pos-ref').text());
					$('.pos-ref').text(position.reference_no);

					$('#frm_position').prepend('<input type="hidden" name="is_update" value="1">');
					$('#frm_position').prepend('<input type="hidden" name="listing_id" value="' + position.id + '">');
					$('#frm_position [name="is_lock"]').prop('checked', (position.is_lock ? true : false));

					if (position.is_lock) {
						$('#frm_position [name="title"]').attr('readonly', true);
					}

					$('#frm_position [name="reference_no"]').val(position.reference_no);
					$('#frm_position [name="div_id"]').val(position.div_id);
					$('#frm_position [name="department_id"]').val(position.department_id);
					$('#frm_position [name="location"]').val(position.location);
					$('#frm_position [name="title"]').val(position.title);
					$('#frm_position [name="due_date"]').val((d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear());
					$('#frm_position [name="local_positions"]').val(position.local_positions);
					$('#frm_position [name="expat_positions"]').val(position.expat_positions);
					$('#frm_position [name="total_positions"]').val(position.total_positions);

					$('#save_position').text('Update');

					$('#myPositions').modal('show');
				}
			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// clear fields
	$('#myPositions.modal').on('hide.bs.modal', function (e) {
		if (e.namespace == 'bs.modal') {
			$('.pos-ref').text($('.pos-ref').attr('data-original'));
			$('#frm_position [name="is_update"]').remove();
			$('#frm_position [name="listing_id"]').remove();
			$('#frm_position [name="is_lock"]').prop('checked', true);
			$('#frm_position [name="title"]').removeAttr('readonly');
			$('#frm_position [name="reference_no"]').val('');
			$('#frm_position [name="div_id"]').val('');
			$('#frm_position [name="department_id"]').val($('.dept_list.text-navy').attr('id'));
			$('#frm_position [name="location"]').val('');
			$('#frm_position [name="title"]').val('');
			$('#frm_position [name="due_date"]').val('');
			$('#frm_position [name="local_positions"]').val('');
			$('#frm_position [name="expat_positions"]').val('');
			$('#frm_position [name="total_positions"]').val('');
			$('#save_position').text('Create');
		}
	});

	// lock change
	$(document).on('change', '[name="is_lock"]', function (e) {
		$('#frm_position [name="title"]').attr('readonly', $('#frm_position [name="is_lock"]').prop('checked'));
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
				<strong>Organization Chart</strong>
			</li>
		</ol>
		<h2 class="d-flex align-items-center">Organization Chart</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row">
		<div class="col-md-4">
			<div id="nestable-menu">
				<button type="button" data-action="expand-all" class="btn btn-white btn-sm">Expand All</button>
				<button type="button" data-action="collapse-all" class="btn btn-white btn-sm">Collapse All</button>
			</div>
		</div>

		<div class="col-md-8" style="margin-top: 10px;">
			<div class="dropdown float-right ml-2">
				<a href="#" id="department_view" class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Department View</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="department_view">
    			@if ($data['depts'])
						@foreach ($data['depts'] as $department)
						<a href="{{ url('admin/organization/department-view/' . $department->id) }}" class="dropdown-item text-center">{{ $department->department_short_name }}</a>
						@endforeach
					@endif
  			</div>
			</div>

			<div class="dropdown float-right ml-2">
				<a href="#" id="division_view" class="btn btn-white btn-sm dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Division View</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="division_view">
					@if ($data['divisions'])
						@foreach ($data['divisions'] as $division)
						<a href="{{ url('admin/organization/division-view/' . $division->id) }}" class="dropdown-item text-center">{{ $division->short_name }}</a>
						@endforeach
					@endif
				</div>
			</div>

			<a href="{{ url('admin/organization/company-view') }}" class="btn btn-white btn-sm float-right">Company View</a>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-4">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Organization Chart</h5>
				</div>
				<div class="ibox-content">
					<span class="float-right">

						<a href="#" data-toggle="modal" data-target="#myDivisions">
						<small class="label label-primary">+</small>
						</a>
					</span>
					<p class="m-b-lg">
						Organization Chart
					</p>

					<div class="dd" id="nestable2">
						@foreach($data['divisions'] as $division)
						<ol class="dd-list">
							<li class="dd-item " >
								<div class="dd-handle division-pos-lst" data-id="{{$division->id}}" id="{{$division->id}}">
									<a href="javascript:void(0);" class="float-right division-pos-lst" id="{{$division->id}}" style="margin-left: 5px;">
										<small class="label label-secondary get-positions">
											<i class="fa fa-users get-positions"></i>
										</small>
									</a>
									<a href="#" data-toggle="modal" data-target="#myDepartments" class="float-right">
										<small class="label label-primary">+</small>
									</a>
									<a class="float-right" href="{{url('/admin/modal/delete')}}" id="{{$division->id}}"  title="Delete" confirmation-modal="delete"
									   data-view="detail" data-url="{{url('/admin/division-management/delete/')}}/{{$division->id}}">
{{--									<a href="" class="float-right">--}}
										<small class="label label-danger mr-1">x</small>
									</a>
									<span class="label label-info">
										<i class="fa fa-users"></i>
									</span> {{$division->short_name}}

								</div>
								@if($division->departments->count()>0)
									@foreach($division->departments as $department)
								<ol class="dd-list">
									<li class="dd-item dept_list" mydivid="{{$division->id}}" data-id="{{$department->id}}" id="{{$department->id}}">
										<div class="dd-handle pl-4">
											<span class="float-right font-weight-normal"> {{$department->sections->count()}} Sections </span>
											<span class="ml-3">{{$department->department_short_name}}</span>

										</div>
									</li>

								</ol>
									@endforeach
								@endif
							</li>

						</ol>
							@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="ibox " id="mid_sec_list">
				<div class="ibox-title">
					<h5>Section List </h5>
				</div>
				<div class="ibox-content">
					<p  class="m-b-lg">
											Click Department to see its sections
									</p>
					<div class="dd" id="nestable2">
						<ol class="dd-list" id="srvcBody">
{{--							<li class="dd-item" data-id="2">--}}
{{--								<div class="dd-handle">--}}
{{--						--}}
{{--									<a href="#" data-toggle="modal" data-target="#mySections" class="float-right">--}}
{{--										<small class="label label-primary">+</small>--}}
{{--									</a>--}}
{{--									{{$department->department_short_name}}--}}
{{--								</div>--}}
{{--								<ol class="dd-list">--}}
{{--									@if($department->sections->count()>0)--}}
{{--										@foreach($department->sections as $section)--}}
{{--									<li class="dd-item" data-id="{{$section->id}}" id="{{$section->id}}">--}}
{{--										<div class="dd-handle">--}}
{{--											<a href="javascript:void(0)" id="{{$section->id}}" class="float-right view_position_section" title="view positions" >--}}
{{--												<small class="label label-primary">--}}
{{--													<i class="fas fa-pen"></i></small>--}}
{{--											</a>--}}

{{--											<a href="#" data-toggle="modal" data-target="#myPositions" class="float-right" title="add position" style="margin-right:5px">--}}
{{--												<small class="label label-primary">+</small>--}}
{{--											</a>--}}
{{--											{{$section->short_name}}--}}
{{--										</div>--}}
{{--										<div id="show_position_list_{{$section->id}}"></div>--}}

{{--									</li>--}}
{{--										@endforeach--}}
{{--									@endif--}}
{{--								</ol>--}}
{{--							</li>--}}
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4" id="showDivPosTable">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Positions</h5>
				</div>
				<div class="ibox-content">
					<p  class="m-b-lg">
						Select one organization unit to list its positions
					</p>
					{{--<table class="table">
						<thead>
						<tr>

							<th>Position</th>
							<th>Expat</th>
							<th>Local</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($data['positions'] as $position)
						<tr>
							<td>{{$position->title}}</td>
							<td>{{$position->expat_positions}}</td>
							<td>{{$position->local_positions}}</td>
							<td><i class="fa fa-edit"></i></td>
						</tr>
						@endforeach

						</tbody>
						<tfoot><tr><td></td><td></td><td></td><td>

								<a href="#" data-toggle="modal" data-target="#myPositions" class="btn btn-primary btn-xs" title="add position">
									 New Position
								</a>
							</td></tr></tfoot>
					</table>--}}


				</div>
			</div>
		</div>
	</div>
</div>
	{{--models area--}}
	{{--divisions model--}}
<div class="modal inmodal fade" id="myDivisions" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Create Division</h4>
				<small class="font-bold">Fill below information to Create Division</small>
			</div>
			<div class="modal-body">
				<div class="ibox-content">
					<form role="form" id="frm_division" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group">
									<label>Division Code</label>
									<input type="text" class="form-control form-control-sm" id="division_code" name="division_code" value="{{ $data['division_code'] }}">
								</div>

								<div class="form-group">
									<label>Organization </label>
									<select name="org_id" id="org_id" class="form-control form-control-sm b-r-xs">
										@foreach($data['organizations'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->org_title}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Short Name</label>
									<input type="text" class="form-control form-control-sm" id="short_name" name="short_name">
								</div>

								<div class="form-group">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name">
								</div>
							</div>
						</div>


					</form>

				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" role-type="0" id="save_division">Save changes</button>
			</div>
		</div>
	</div>
</div>


{{--	departments--}}
<div class="modal inmodal fade" id="myDepartments" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Create Department</h4>
				<small class="font-bold">Fill below information to Create Department</small>
			</div>
			<div class="modal-body">
				<div class="ibox-content">
					<form role="form" id="frm_dept" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group">
									<label>Department Code</label>
									<input type="text" class="form-control form-control-sm" id="dept_code" name="dept_code" value="{{ $data['dept_code'] }}">
								</div>

								<div class="form-group">
									<label>Organization </label>
									<select name="org_id" id="org_id_for_div" class="form-control form-control-sm b-r-xs">
										<option value="">Select Organization</option>
										@foreach($data['organizations'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->org_title}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Division </label>
									<select name="div_id" id="div_id" class="form-control form-control-sm b-r-xs">
										<option value="">Select Division</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Short Name</label>
									<input type="text" class="form-control form-control-sm" id="short_name" name="short_name">
								</div>

								<div class="form-group">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name">
								</div>
							</div>
						</div>


					</form>

				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="save_dept">Save changes</button>
			</div>
		</div>
	</div>
</div>


{{--	sections--}}

<div class="modal inmodal fade" id="mySections" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Create Section</h4>
				<small class="font-bold">Fill below information to Create Section</small>
			</div>
			<div class="modal-body">
				<div class="ibox-content">
					<form role="form" id="frm_section" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">



								<div class="form-group">
									<label>Organization </label>
									<select name="org_id" id="org_id_for_section" class="form-control form-control-sm b-r-xs">
										<option value="">Select Organization</option>
										@foreach($data['organizations'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->org_title}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group">
									<label>Division </label>
									<select name="div_id" id="div_id_for_section" class="form-control form-control-sm b-r-xs">
										<option value="">Select Division</option>
									</select>
								</div>
								<div class="form-group">
									<label>Department </label>
									<select name="dept_id" id="dept_id" class="form-control form-control-sm b-r-xs">
										<option value="">Select Department</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label>Section Code</label>
									<input type="text" class="form-control form-control-sm" id="section_code" name="section_code" value="{{ $data['section_code'] }}">
								</div>
								<div class="form-group">
									<label>Short Name</label>
									<input type="text" class="form-control form-control-sm" id="short_name" name="short_name">
								</div>

								<div class="form-group">
									<label>Full Name</label>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name">
								</div>
							</div>
						</div>


					</form>

				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="save_section">Save changes</button>
			</div>
		</div>
	</div>
</div>

	{{--positions--}}
<div class="modal inmodal fade" id="myPositions" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h5 class="mb-0 d-flex align-items-center">
					Create Position
					<span class="ml-auto">RefNo: <span class="pos-ref">{{ $data['position_reference_no'] }}</span></span>
				</h5>
			</div>
			<div class="modal-body p-0">
				<div class="ibox mb-0">
					<div class="ibox-content pb-0">
						<form role="form" id="frm_position" enctype="multipart/form-data">
							<input type="hidden" name="reference_no" value="{{ $data['position_reference_no'] }}">
                            <input type="hidden" id="div_for_position" name="div_id" value="0">
							<div class="row">
								<div class="col-sm-6 b-r">
									<div class="form-group">
										<label class="mb-1">Department </label>
										<select name="department_id" id="department_id" class="form-control form-control-sm b-r-xs" size>
											<option value="">Select Department</option>
											@foreach($data['depts'] as $key=>$val)
												<option value="{{ $val->id}}" >{{$val->department_name}}</option>
											@endforeach
										</select>
									</div>

									<div class="form-group">
										<label class="mb-1">Section </label>
										<select name="section_id" id="section_id" class="form-control form-control-sm b-r-xs" size>

										</select>
									</div>

									<div class="form-group">
										<label class="mb-1">Position Name </label>
										<input type="text" class="form-control form-control-sm" id="title" name="title">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group d-flex flex-column">
										<label class="mb-1 ml-auto">Lock</label>
										<div class="d-flex align-items-center justify-content-end">
											<input type="checkbox" class="checkbox-switch" id="is_lock" name="is_lock" checked />
											<label for="is_lock"></label>
										</div>
									</div>
									<div class="form-group">
										<label class="mb-1">Location</label>
										<input type="text" class="form-control form-control-sm" id="location" name="location">
									</div>

									<div class="form-group">
										<label class="mb-1">Due Date</label>
										<div class="input-group date">
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control form-control-sm" id="due_date" name="due_date">
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3">
								<div class="form-group mb-0">
								<label class="mb-1"> Head Count:</label>
								</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-sm-4">
									<div class="form-group">
										<label class="mb-1"> Expat: </label>
									<input type="number" class="form-control form-control-sm qty1" id="expat_positions" name="expat_positions" >
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="mb-1"> Local:</label>
										<input type="number" class="form-control form-control-sm qty1" id="local_positions" name="local_positions" >
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<label class="mb-1"> Total:</label>
										<input type="number" class="form-control form-control-sm total_all" id="total_positions" name="total_positions" readonly>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="mb-1">Remarks</label>
										<textarea name="notes" rows="3" class="form-control" id="notes"></textarea>
									</div>
								</div>
							</div>


						</form>

					</div>
				</div>
			</div>

			<div class="modal-footer border-0 pt-0">
				<button type="button" class="btn btn-white btn-sm" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-success btn-sm" id="save_position">Create</button>
			</div>
		</div>
	</div>
</div>
@endsection
