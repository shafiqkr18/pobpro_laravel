@extends('admin.layouts.default')

@section('title')
	Task Details
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/clockpicker/clockpicker.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<style>
.detail-preview label {
	width: 80px;
	text-align: center;
	font-weight: bold;
	margin-right: 10px;
}

.detail-preview .value {
	flex: 1;
}

.priority {
	width: 12px;
	height: 12px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js') }}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.clockpicker').clockpicker();

	$('.chosen-select').chosen({width: "100%"});
});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Task Details</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Management
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/minutes-of-meeting') }}">Minutes of Meeting</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Task Details</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<a href="" class="btn btn-white btn-sm pull-right">Back to MoM</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="form-row">
		<div class="col-md-8">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Task Timeline</h5>
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
					<div class="inspinia-timeline">
						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-briefcase"></i>
									6:00 am
									<br/>
									<small class="text-navy">2 hour ago</small>
								</div>
								<div class="col-7 content no-top-border">
									<p class="m-b-xs"><strong>Meeting</strong></p>
									<p>Conference on the sales results for the previous year. Monica please examine sales trends in marketing and products. Below please find the current status of the sale.</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-file-text"></i>
									7:00 am
									<br/>
									<small class="text-navy">3 hour ago</small>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Send documents to Mike</strong></p>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-coffee"></i>
									8:00 am
									<br/>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Coffee Break</strong></p>
									<p>
										Go to shop and find some products. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's.
									</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-phone"></i>
									11:00 am
									<br/>
									<small class="text-navy">21 hour ago</small>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Phone with Jeronimo</strong></p>
									<p>
									Lorem Ipsum has been the industry's standard dummy text ever since.
									</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-user-md"></i>
									09:00 pm
									<br/>
									<small>21 hour ago</small>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Go to the doctor dr Smith</strong></p>
									<p>
											Find some issue and go to doctor.
									</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-user-md"></i>
									11:10 pm
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Chat with Sandra</strong></p>
									<p>
											Lorem Ipsum has been the industry's standard dummy text ever since.
									</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-comments"></i>
									12:50 pm
									<br/>
									<small class="text-navy">48 hour ago</small>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Chat with Monica and Sandra</strong></p>
									<p>
										Web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
									</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-phone"></i>
									08:50 pm
									<br/>
									<small class="text-navy">68 hour ago</small>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Phone to James</strong></p>
									<p>
											Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
									</p>
								</div>
							</div>
						</div>

						<div class="timeline-item">
							<div class="row">
								<div class="col-3 date">
									<i class="fa fa-file-text"></i>
									7:00 am
									<br/>
									<small class="text-navy">3 hour ago</small>
								</div>
								<div class="col-7 content">
									<p class="m-b-xs"><strong>Send documents to Mike</strong></p>
									<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</div>

		<div class="col-md-4">
			<div class="ibox">
				<div class="ibox-content detail-preview p-3">
					<div class="form-row">
						<div class="col-md-12">
							<h3 class="mt-0 mb-3 font-weight-normal">Task: Technical Proposal Preparation</h3>
						</div>
					</div>

					<div class="form-row mb-2">
						<div class="col-md-12 d-flex flex-nowrap">
							<label>MoM:</label>
							<div class="value">There are many variations of passages of lorem ipsum</div>
						</div>
					</div>

					<div class="form-row mb-2">
						<div class="col-md-6 d-flex flex-nowrap">
							<label>Status:</label>
							<div class="value"><span class="badge badge-primary">Open</span></div>
						</div>

						<div class="col-md-6 d-flex flex-nowrap">
							<label class="text-right">Date:</label>
							<div class="value">16.08.2019</div>
						</div>
					</div>

					<div class="form-row mb-2">
						<div class="col-md-12 d-flex flex-nowrap">
							<label>Participants:</label>
							<div class="value d-flex">
								<img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/profile_small.jpg') }}" alt="">
								<img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/a4.jpg') }}" alt="">
								<img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/a1.jpg') }}" alt="">
							</div>
						</div>
					</div>

					<div class="form-row mb-2">
						<div class="col-md-12 d-flex flex-nowrap">
							<label>Task Information:</label>
							<div class="value">
								<p class="mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum quae dicta ad et aperiam vel asperiores labore ducimus perspiciatis veritatis corrupti impedit recusandae, quod, ipsam saepe consequatur. Ab, culpa expedita.</p>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-md-12 d-flex flex-nowrap">
							<label>Task Detail:</label>
							<div class="value">
								<p class="mb-2">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nostrum quae dicta ad et aperiam vel asperiores labore ducimus perspiciatis veritatis corrupti impedit recusandae, quod, ipsam saepe consequatur. Ab, culpa expedita.</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection