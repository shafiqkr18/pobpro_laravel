@extends('admin.layouts.default')

@section('title')
	Organization Chart
@endsection

@section('styles')

@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/nestable/jquery.nestable.js') }}"></script>
<script>
// activate Nestable
// $('#nestable2').nestable({
// 		group: 0
// });
$('.dd').each(function(){
	$(this).nestable({
		maxDepth: 0,
		noDragClass: 'no-drag'
	});
});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Organization Chart</h2>
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				Planning
			</li>
			<li class="breadcrumb-item active">
				<strong>Organization Chart</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
				<div class="ibox-title">
					<!-- <h5>Organization Chart</h5> -->
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
					<div class="dd" id="nestable2">
						@foreach($data['divisions'] as $division)
						<ol class="dd-list">
								<li class="dd-item no-drag" data-id="1">
										<div class="dd-handle">
												<span class="label label-info"><i class="fa fa-users"></i></span>{{$division->short_name}}
										</div>
									@if($division->departments->count()>0)
										@foreach($division->departments as $department)
									<ol class="dd-list">
												<li class="dd-item no-drag" data-id="2">
														<div class="dd-handle">
																<span class="float-right"> {{--12:00 pm--}} </span>
																<span class="label label-info"><i class="fa fa-cog"></i></span>
															{{$department->department_short_name}}
														</div>

													@if($department->sections->count()>0)
														@foreach($department->sections as $section)
														<ol class="dd-list">
															<li class="dd-item no-drag" data-id="2">
																	<div class="dd-handle">
																			<span class="float-right"> {{--12:00 pm --}}</span>
																			<span class="label label-danger"><i class="fa fa-cog"></i></span>
																		{{$section->short_name}}
																	</div>
															</li>

														</ol>
														@endforeach
													@endif
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
	</div>
</div>
@endsection