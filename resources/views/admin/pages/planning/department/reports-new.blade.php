@extends('admin.layouts.default') 

@section('title') 
Create Department Report
@endsection 

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/admin/reports.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">

<!-- <span class="float-right"><a href="{{ url('admin/management-reports-compose') }}"> <small class="label label-primary">+ New Report</small></a> </span> -->

		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Management
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/department-reports') }}">Department Reports</a>
			</li>
		</ol>
			
		<h2 class="d-flex align-items-center">
			Compose Report
		</h2>
	</div>
</div>
						
<div class="wrapper wrapper-content animated fadeInRight">
	
	<form id="frm_report">
		<div class="row mb-4">
			<div class="col-lg-3">
				<div class="input-group input-daterange">
					<span class="input-group-addon pr-2 pl-2"><small class="far fa-calendar-alt"></small></span>
					<input type="text" class="form-control form-control-sm text-left">
				</div>
			</div>

			<!-- <div class="col-lg-3"> -->
				<div class="btn-group" >
					<button class="btn btn-sm btn-success" type="button">Daily</button>
					<button class="btn btn-sm btn-white" type="button">Weekly</button>
					<button class="btn btn-sm btn-white" type="button">Monthly</button>
				</div>
			<!-- </div> -->

			<div class="col-lg-3">
				<select name="" id="" class="form-control form-control-sm" size>
					<option value="">Production</option>
				</select>
			</div>
		</div>
		
		<div class="panel bg-secondary mt-4 mb-4">
			<div class="panel-heading">Contents:</div>
			<div class="panel-body p-0">
				<div class="summernote contents"></div>
			</div>
		</div>

		<div class="panel panel-primary mt-4 mb-4">
			<div class="panel-heading">Next Action:</div>
			<div class="panel-body p-0">
				<div class="summernote next-action"></div>
			</div>
		</div>

		<div class="panel panel-info mb-4">
			<div class="panel-heading">Remarks:</div>
			<div class="panel-body p-0">
				<div class="summernote remarks"></div>
			</div>
		</div>

		<div class="panel panel-warning mb-4">
			<div class="panel-heading">Management Comments:</div>
			<div class="panel-body p-0">
				<div class="summernote management-comments"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12 d-flex">
				<a href="" class="btn btn-primary btn-sm btn-save ml-auto">Save</a>
			</div>
		</div>
	
	</form>
	
</div>
@endsection