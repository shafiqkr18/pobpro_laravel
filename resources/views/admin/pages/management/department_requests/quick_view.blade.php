@extends('admin.layouts.default')

@section('title')
	Department Requests Quick View
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/jsTree/style.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/company-view.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/department-requests.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/jsTree/jstree.min.js') }}"></script>
<script src="{{ URL::asset('js/department-requests.js') }}"></script>
<script>
$( document ).ready(function() {
	$('.input-group.date').datepicker({
		todayBtn: 'linked',
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});
	
	const sections = Object.values(@php echo json_encode($tree); @endphp);
	console.log(sections);

	for (const sec of sections) {
		$('.section-tree[data-section="' + sec.id +'"]').jstree({
			'core' : {
				'themes': {
					'icons': false
				},
				'data': sec.children
			}
		});
	}
	
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
				Management
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/department-requests') }}">Department Requests</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			{{ $department ? $department->department_short_name : '' }} Quick View

			@if($show_buttons)
			<a href="{{ url('admin/department-requests/approve-request/?id=' . $approval_id) }}" class="btn btn-sm btn-success ml-auto">Approve</a>
			<a href="{{ url('admin/department-requests/reject-request/?id=' . $approval_id) }}" class="btn btn-sm btn-danger ml-2">Reject</a>
			@endrole
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row mb-4">
		<div class="col-sm-6 pb-2">
			<div class="alert-success text-center p-2">
				<h5 class="m-0">Now</h5>
			</div>

			<div class="row ml-0 mr-0 bg-white">
				<div class="col-sm-6 b-r pt-3 pb-3">
					<h5 class="text-center text-muted mb-2 mt-0 font-weight-normal d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('img/icon-total-positions.png') }}" srcset="{{ URL::asset('img/icon-total-positions.png') }} 1x, {{ URL::asset('img/icon-total-positions@2x.png') }} 2x" class="img-fluid mr-1">
						Total positions
					</h5>

					<div class="d-flex align-items-center justify-content-center pt-1">
						<h3 class="m-0 number-value total-positions">{{ $department ? $department->getPositionsCountNew() + $total_requested_positions : '' }}</h3>
					</div>
				</div>

				<div class="col-sm-6 d-flex flex-nowrap p-0 total-breakdown">
					<div class="d-flex flex-column align-items-center justify-content-center b-r">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-local-positions.png') }}" srcset="{{ URL::asset('img/icon-local-positions.png') }} 1x, {{ URL::asset('img/icon-local-positions@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Local</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $department ? $department->localPositionsCount() + $requested_local_positions : '' }}</h3>
					</div>

					<div class="d-flex flex-column align-items-center justify-content-center">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-expat-positions.png') }}" srcset="{{ URL::asset('img/icon-expat-positions.png') }} 1x, {{ URL::asset('img/icon-expat-positions@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Expat</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $department ? $department->expatPositionsCount() + $requested_expat_positions : '' }}</h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 pb-2">
			<div class="alert-warning text-center p-2">
				<h5 class="m-0">Before</h5>
			</div>

			<div class="row ml-0 mr-0 bg-white">
				<div class="col-sm-6 b-r pt-3 pb-3">
					<h5 class="text-center text-muted mb-2 mt-0 font-weight-normal d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('img/icon-total-positions.png') }}" srcset="{{ URL::asset('img/icon-total-positions.png') }} 1x, {{ URL::asset('img/icon-total-positions@2x.png') }} 2x" class="img-fluid mr-1">
						Total positions
					</h5>

					<div class="d-flex align-items-center justify-content-center pt-1">
						<h3 class="m-0 number-value total-positions">{{ $department ? $department->getPositionsCountNew() : '' }}</h3>
					</div>
				</div>

				<div class="col-sm-6 d-flex flex-nowrap p-0 total-breakdown">
					<div class="d-flex flex-column align-items-center justify-content-center b-r">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-local-positions.png') }}" srcset="{{ URL::asset('img/icon-local-positions.png') }} 1x, {{ URL::asset('img/icon-local-positions@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Local</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $department ? $department->localPositionsCount() : '' }}</h3>
					</div>

					<div class="d-flex flex-column align-items-center justify-content-center">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-expat-positions.png') }}" srcset="{{ URL::asset('img/icon-expat-positions.png') }} 1x, {{ URL::asset('img/icon-expat-positions@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Expat</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $department ? $department->expatPositionsCount() : '' }}</h3>
					</div>
				</div>
			</div>
		</div>

	</div>

	@if ($department)
	<div class="divisions-wrap d-flex flex-nowrap align-items-stretch mb-4 pt-2 pb-4">
		<div class="division mr-5 d-flex flex-column">
			<div class="department-wrap d-flex flex-nowrap align-items-stretch flex-fill department-view">

			@if (count($department->sections) > 0)
				@foreach ($department->sections as $section)
					@if (!$section->sectionDeleteRequest)
				<div class="department department-view">
					<div class="ibox h-100 mb-0 bg-white">
						<div class="ibox-title pl-3 pr-3 text-center">
							<h5>{{ $section->sectionUpdateRequest && $section->sectionUpdateRequest->action_type == 1 && $section->sectionUpdateRequest->status != 1 ? $section->sectionUpdateRequest->short_name : $section->short_name }}</h5>
						</div>

						<div class="ibox-content pt-3 pb-3 pr-2 pl-2">
							<div class="section-tree" data-section="{{ $section->id }}"></div>
						</div>
					</div>
				</div>
					@endif
				@endforeach
			@endif

			@if ($department->requestedSections)
				@foreach ($department->requestedSections as $section)
					@if ($section->status != 1 && $section->action_type == 0)
					<div class="department department-view">
						<div class="ibox h-100 mb-0 bg-white">
							<div class="ibox-title pl-3 pr-3 text-center">
								<h5>{{ $section->short_name }}</h5>
							</div>

							<div class="ibox-content pt-3 pb-3 pr-2 pl-2">
								<div class="section-tree" data-section="requested_{{ $section->id }}"></div>
							</div>
						</div>
					</div>
					@endif
				@endforeach
			@endif

			@if (count($department->requestedPositionsDirect) > 0)
			<div class="department department-view">
				<div class="ibox h-100 mb-0 bg-white">
					<div class="ibox-title pl-3 pr-3 text-center">
						<h5></h5>
					</div>

					<div class="ibox-content pt-3 pb-3 pr-2 pl-2">
						<div class="section-tree" data-section="positions_without_section"></div>
					</div>
				</div>
			</div>
			@endif

			</div>
		</div>
	</div>
	@endif
</div>
@endsection