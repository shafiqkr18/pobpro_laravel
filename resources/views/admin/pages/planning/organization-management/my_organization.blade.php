@extends('admin.layouts.default')

@section('title')
	My Organization
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/nestable/jquery.nestable.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});
});
</script>
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
	var my_org_id = '{{ $organization ? $organization->id : 0 }}';
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
	function loadDynamicHTML(list_id=0)
	{
		var queryString = 'dept_id='+list_id+'&_token='+$('meta[name=csrf-token]').attr('content');
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
			let list_id = $(this).attr('id');
			let mydivid = $(this).attr('mydivid');
			$("#div_id_for_section").val(mydivid);
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

			loadDynamicHTML(list_id);
		});

		$("#nestable").delegate(".view_position_section", "click", function(event){
			event.stopPropagation();
			event.stopImmediatePropagation();
			let list_id = $(this).attr('id');
			console.log('section list clicked '+list_id);
			loadDynamicHTMLPositions(list_id);
		});
		$(".division-pos-lst").on('click', function(event){
			event.stopPropagation();
			event.stopImmediatePropagation();
			let list_id = $(this).attr('id');
			console.log('division list clicked '+list_id);
			loadDynamicHTMLPositionsTable(list_id);
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
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>My Organization</h2>

	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div id="my_organization" class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		@if ($organization)
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
							<li class="dd-item" data-id="{{$division->id}}">
								<div class="dd-handle">
									<a href="javascript:void(0);" class="float-right division-pos-lst" id="{{$division->id}}" style="margin-left: 5px;">
										<small class="label label-secondary">
											<i class="fa fa-users"></i>
										</small>
									</a>
									<a href="#" data-toggle="modal" data-target="#myDepartments" class="float-right">
										<small class="label label-primary">+</small>
									</a>
									<a class="float-right" href="{{url('/admin/modal/delete')}}" id="{{$division->id}}"  title="Delete" confirmation-modal="delete" data-view="table" data-url="{{url('/admin/division-management/delete/')}}/{{$division->id}}">
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
										<div class="dd-handle">
											<span class="float-right font-weight-normal"> {{$department->sections->count()}} Sections </span>
											<span class="label label-info">
												<i class="fa fa-cog"></i>
											</span> {{$department->department_short_name}}

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
					<div class="dd" id="nestable">
						<ol class="dd-list" id="srvcBody">

						</ol>
					</div>
				</div>
			</div>
		</div>

		@else
		<div class="col-lg-12">
			<div class="alert alert-warning text-center">You currently do not have an organization. </div>
		</div>

		<div class="col-lg-12 text-center">
			<a href="{{ url('admin/organization/create') }}" class="btn btn-primary mt-4">Create Organization</a>
			<p class="mt-4 mb-4">OR</p>
			<a href="{{ url('admin/organization/use_template') }}" class="btn btn-success">Use Existing Template</a>
		</div>
		@endif
	</div>
</div>

@if ($organization)
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
										<option value="{{ $organization->id}}" >{{$organization->org_title}}</option>
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
				<button type="button" class="btn btn-primary" role-type="1" id="save_division">Save changes</button>
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
										<option value="{{ $organization->id}}" >{{$organization->org_title}}</option>
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
				<button type="button" class="btn btn-primary" role-type="1" id="save_dept">Save changes</button>
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
										<option value="{{ $organization->id}}" >{{$organization->org_title}}</option>
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
				<button type="button" class="btn btn-primary" role-type="1" id="save_section">Save changes</button>
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
				<h5 class="mb-0">Create Position</h5>
			</div>
			<div class="modal-body p-0">
				<div class="ibox mb-0">
					<div class="ibox-content pb-0">
						<form role="form" id="frm_position" enctype="multipart/form-data">
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
									<div class="form-group">
										<label class="mb-1 float-right">RefNo: {{ $data['position_reference_no'] }}</label>
										<input type="text" class="form-control form-control-sm" id="reference_no" name="reference_no" value="{{$data['position_reference_no']}}" style="visibility: hidden; opacity: 0; z-index: -1;" readonly>
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
								<div class="col-sm-3">
									<div class="form-group">
										<label class="mb-1"> Local:</label>
										<input type="number" class="form-control form-control-sm qty1" id="local_positions" name="local_positions" >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label class="mb-1"> Expat: </label>
										<input type="number" class="form-control form-control-sm qty1" id="expat_positions" name="expat_positions" >
									</div>
									</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label class="mb-1"> Others:</label>
										<input type="number" class="form-control form-control-sm qty1" id="other_positions" name="other_positions" >
									</div>
								</div>
								<div class="col-sm-3">
									<div class="form-group">
										<label class="mb-1"> Total:</label>
										<input type="number" class="form-control form-control-sm total_all" id="total_positions" name="total_positions" readonly>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label class="mb-1">Job Description/Remarks</label>
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
@endif
@endsection