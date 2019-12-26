@extends('admin.layouts.default')

@section('title')
	Create Employee
@endsection

@section('styles')

<style>
.custom-file-input {
	position: absolute;
}

.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.wizard > .content > .body {
	position: initial;
}

.custom-file-label {
	width: auto;
	position: initial;
	background: none;
	height: auto;
	border: 0;
	font-size: 12px;
	cursor: pointer;
}

.custom-file-label:after {
	display: none;
}

.wizard > .content > .body {
	width: 100% !important;
}
</style>
@endsection

@section('scripts')

<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>

@endsection



@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Create Employee</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/employees') }}">Employees</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Employee Details</h5>

				</div>

				<div class="ibox-content">
					<form enctype="multipart/form-data" class="wizard-big frm_enrollment" id="frm_enrollment">
                        <input type="hidden" name="candidate_idd" id="candidate_idd" value="{{$candidate->id}}">
                        <input type="hidden" name="candidate_id" id="candidate_id" value="{{$candidate->id}}">
                        <input type="hidden" id="step_number" name="step_number" value="1">
                        <input type="hidden" name="user_uuid" value="{{$user_uuid}}">
                        @csrf
                        <div class="col-lg-8">
                            <div class="form-group">
                                <label>Employee Id *</label>
                                <input id="user_name" name="user_name" type="text" class="form-control required" value="{{ $initial_user_name ? $initial_user_name : $candidate->name }}">
                            </div>
                            <div class="form-group">
                                <label>Company Email *</label>
                                <input id="email" name="email" type="text" class="form-control form-control-sm required email" value="{{ $initial_user_email }}">
                            </div>

                            <div class="form-group">
                                <label>Default Password *</label>
                                <input id="password" name="password" type="password" class="form-control form-control-sm required" value="">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a href="javascript:void(0)" id="save_my_enrollment" class="btn btn-success btn-sm pull-right">Save</a>
                            </div>
                        </div>



					</form>

				</div>

			</div>
		</div>
	</div>
</div>
@endsection
