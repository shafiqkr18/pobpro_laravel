@extends('admin.layouts.default')

@section('title')
	View Division
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/division-management') }}">Division Management</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">{{ $division->division_code }}</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<a href="{{ url('admin/division-management/update/' . $division->id) }}" class="btn btn-success btn-sm pull-right ml-2">
			<i class="fas fa-pen-square mr-1"></i>
			Edit
		</a>
		<a href="{{ url('admin/modal/delete') }}" class="btn btn-danger btn-sm pull-right ml-2" confirmation-modal="delete" data-view="settings" data-url="{{ url('admin/division-management/delete/' . $division->id) }}">
			<i class="far fa-trash-alt mr-1"></i>
			Delete
		</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title indented">
					<h5>Division Details</h5>
				</div>

				<div class="ibox-content">
					<form role="form" id="frm_division" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-6 b-r">

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Division Code</label>
									<p class="form-control-static font-weight-bold">{{ $division->division_code }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Organization </label>
									<p class="form-control-static font-weight-bold">{{ $division->organization->org_title }}</p>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label class="text-muted mb-0">Short Name</label>
									<p class="form-control-static font-weight-bold">{{ $division->short_name }}</p>
								</div>

								<div class="form-group form-inline">
									<label class="text-muted mb-0">Full Name</label>
									<p class="form-control-static font-weight-bold">{{ $division->full_name }}</p>
								</div>
							</div>
						</div>
					</form>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection