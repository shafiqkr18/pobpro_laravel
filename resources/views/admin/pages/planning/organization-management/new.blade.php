@extends('admin.layouts.default')

@section('title')
	Create Organization
@endsection

@section('styles')
<!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
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
<!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Create Organization</h2>

	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-8">
			<form role="form" id="frm_org" enctype="multipart/form-data">
				<div class="ibox ">
					<div class="ibox-title">
						<h5>Organization Details</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">
									<i class="fa fa-wrench"></i>
							</a>
							<ul class="dropdown-menu dropdown-user">
								<li>
									<a href="#" class="dropdown-item">Config option 1</a>
								</li>
								<li>
									<a href="#" class="dropdown-item">Config option 2</a>
								</li>
							</ul>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<div class="row">
							<div class="col-sm-12 ">

								<div class="form-group">
									<label>Organization Code</label>
									<input type="text" class="form-control form-control-sm" id="org_refno" name="org_refno" value="{{ $data['org_no'] }}">
								</div>

								<div class="form-group">
									<label>Organization Name</label>
									<input type="text" class="form-control form-control-sm" id="org_title" name="org_title">
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group">
									<label>Parent Organization</label>
									<input type="text" class="form-control form-control-sm" id="org_parent" name="org_parent">
								</div>

								<div class="form-group">
									<label>Remarks</label>
									<textarea name="notes" id="notes" rows="4" class="form-control"></textarea>
								</div>
							</div>
						</div>

					</div>

				</div>

				<div class="row">
					<div class="col-md-12">
						<a href="javascript:void(0)" id="save_org" role-type="1" class="btn btn-success btn-sm pull-right">Save</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection