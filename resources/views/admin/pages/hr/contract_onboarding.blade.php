@extends('admin.layouts.default')

@section('title')
  Contract &amp; Onboarding
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
table.dataTable {
	border-collapse: collapse !important;
}
</style>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(000000,999999)}}"></script>


	<script>
	$(document).ready(function () {
		$(document).on('click', '#todo li', function (e) {
			e.preventDefault();

			window.location = $(this).attr('data-url');
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
									<strong>Contract &amp; Onboarding </strong>
							</li>
					</ol>
					<h2 class="d-flex align-items-center">Contract &amp; Onboarding</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
			<ul class="nav nav-tabs border-0">
				<li class="nav-item">
					<a class="nav-link border-0" href="{{url('admin/vacancy/shortlisted_by_position/')}}/{{$position_id}}/{{$plan_id}}">Shortlist</a>
				</li>
				<li class="nav-item">
					<a class="nav-link border-0" href="{{url('admin/vacancy/interviewee_list/')}}/{{$position_id}}/{{$plan_id}}">Qualified</a>
				</li>
				<li class="nav-item">
					<a class="nav-link border-0 active text-success" href="{{ url('admin/contract-onboarding') }}/{{$position_id}}/{{$plan_id}}">Contract &amp; Onboarding</a>
				</li>
			</ul>

        <div class="form-row">
            <div class="col-lg-9">
                <div class="ibox ">
                    <!-- <div class="ibox-title">
                        <h5 data-url="#">Contract &amp; Onboarding</h5>

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
                    </div> -->
                    <div class="ibox-content">
                        {{--                        <button  id="bulk_delete_btn"type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal4">--}}
                        {{--                          Short List--}}
                        {{--                        </button>--}}
												{{--                        <a class="btn btn-default btn-create" id="bulk_delete_btn"><i class="fa fa-plus mr-1"></i> <span>Bulk Delete</span></a>--}}

												<h5 data-url="#">Contract &amp; Onboarding</h5>

                        <input type="hidden" id="position_id" name="position_id" value="{{$position_id}}">
                        <input type="hidden" id="plan_id" name="plan_id" value="{{$plan_id}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover " id="contract_onboarding_list" >
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="select_all"></th>
                                    <th></th>
                                    <th>Name</th>
                                    <!-- <th>Email</th>
                                    <th>Phone</th> -->
                                    <th>Nationality</th>
                                    <th>Location</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Education Level</th>
                                    <!-- <th>Position Applied</th> -->
                                    <!-- <th>Interview</th>
                                    <th>Offer</th>
                                    <th>Contract</th> -->
                                    <th></th>
                                </tr>
                                </thead>

                            </table>
												</div>

                    </div>
                </div>
						</div>

						<div class="col-lg-3">
							@include('admin.partials.interviews_list')
						</div>
        </div>
    </div>




@endsection
