@extends('admin.layouts.default')

@section('title')
	Create Employee
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/company-contracts.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/company-contracts.js') }}"></script>
<script src="{{ URL::asset('js/operations/contract_create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	

});
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Contracts Mgt.
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/contracts-mgt/contractor/employees/' . ($contractor ? $contractor->id : '')) }}">
					Contractor Employees
				</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Create
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Employee Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_contractor_employee" enctype="multipart/form-data">
						<input type="hidden" name="employee_ref" value="{{ $ref_no }}">

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>First Name</label>
									<input type="text" class="form-control form-control-sm" name="first_name" id="first_name">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Last Name</label>
									<input type="text" class="form-control form-control-sm" name="last_name" id="last_name">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Email</label>
									<input type="email" class="form-control form-control-sm" name="email" id="email">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Phone</label>
									<input type="number" class="form-control form-control-sm" name="phone" id="phone">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Contractor</label>
									<select name="contractor_id" id="contractor_id" class="form-control form-control-sm" value="{{ $contractor->id }}">
										@if ($contractor)
										<option value="{{ $contractor->id }}" selected>{{ $contractor->title }}</option>
										@else
											@foreach ($contractors as $_contractor)
											<option value="{{ $_contractor->id }}">{{ $_contractor->title }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Position</label>
									<input type="text" class="form-control form-control-sm" name="position" id="position">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Avatar</label>
									<div class="custom-file">
										<input id="logo" name="file" type="file" accept="image/x-png,image/jpeg" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
									</div>
								</div>
							</div>
						</div>

					</form>
					
				</div>

			</div>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col-md-12">
			<a href="javascript:void(0)" id="btn_contractor_employee_new" class="btn btn-success btn-sm pull-right">Save</a>
		</div>
	</div>
</div>

@endsection