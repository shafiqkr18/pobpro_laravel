@extends('admin.layouts.default')

@section('title')
	HR Plans
@endsection

@section('styles')
	<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
	<link href="{{ URL::asset('css/new-pages.css') }}" rel="stylesheet">
@endsection

@section('scripts')
  <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
  <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ URL::asset('js/operations/listings.js') }}"></script>
    <script>
        @if(Session::has('message'))

        // TODO: change Controllers to use AlertsMessages trait... then remove this
        var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
        var alertMessage = {!! json_encode(Session::get('message')) !!};
        var alerter = toastr[alertType];

        if (alerter) {
            alerter(alertMessage);
        } else {
            toastr.error("toastr alert-type " + alertType + " is unknown");
        }
        @endif
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
				<a href="javascript:void(0);">HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>HR Plan</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">HR Plans</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="{{ url('admin/hr-plan/add-position') }}">Plans</h5>
				</div>
				<div class="ibox-content">
                    <input type="hidden" id="pending" value="{{$pending}}">
                    <input type="hidden" id="ur" value="{{$pending}}">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="plan_list" style="width: 100%">
							<thead>
								<tr>
{{--									<th></th>--}}
									<th>ID</th>
									<th>Subject</th>
									<th>Budget</th>
									<th>Details</th>
									<th>Start Date</th>
									<th>End Date</th>
									<th>Status</th>
									<th></th>
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