@extends('admin.layouts.default')

@section('title')
	Create Budget
@endsection

@section('styles')
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.plan-position-placeholder {
	display: none;
}

#positions .form-row:nth-child(even) {
	background: #f8f9fa;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script>
$(document).ready(function(){


});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Create Budget</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/budgets') }}">Budget</a>
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
	<div class="form-row">
		<div class="col-lg-12">
			<form role="form" id="frm_budget" enctype="multipart/form-data">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Budget Details</h5>
					<div class="ibox-tools">

					</div>
				</div>

				<div class="ibox-content">
					@csrf

					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control form-control-sm" name="title" id="title">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label>Amount (USD)</label>
								<input type="number" class="form-control form-control-sm" name="budget_amount" id="budget_amount" >
							</div>
						</div>
					</div>

					@if (Auth::user()->hasRole('itfpobadmin'))
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Company</label>
								<select name="company_id" id="company_id" class="form-control">
									@if ($companies)
										@foreach ($companies as $company)
										<option value="{{ $company->id }}">{{ $company->company_name }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>
					</div>
					@endif

					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>Remarks</label>
								<textarea name="remarks" id="remarks" rows="6" class="form-control"></textarea>
							</div>
						</div>
					</div>

				</div>

			</div>


			<div class="row">
				<div class="col-md-12">
					<a href="{{ url('admin/budget/save') }}" class="save_budget btn btn-success btn-sm pull-right" data-draft="0">Save</a>
				</div>
			</div>
			</form>
		</div>

		<!-- <div class="col-lg-4">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Tips when creating a plan</h5>
					<div class="ibox-tools">

					</div>
				</div>

				<div class="ibox-content">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis tenetur mollitia non similique! Quos, nemo? Repudiandae, modi. Fugiat, ducimus maiores rem corrupti delectus, consequuntur quisquam dolores, magnam eius autem labore.</p>
					<ul>
						<li>Example 1</li>
						<li>Example 2</li>
					</ul>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias soluta at doloremque. </p>
				</div>
			</div>
		</div> -->
	</div>
</div>


@endsection