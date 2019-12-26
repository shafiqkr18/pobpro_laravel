@extends('admin.layouts.default')

@section('title')
	Division View
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/jsTree/style.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/company-view.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/jsTree/jstree.min.js') }}"></script>

<script>
$(document).ready(function() {
	const depts = Object.values(@php echo json_encode($tree); @endphp);
	console.log(depts);

	for (const dept of depts) {
		$('.section-tree[data-department="' + dept.id +'"]').jstree({
			'core' : {
				'themes': {
					'icons': false
				},
				'data': dept.children
			}
		});
	}

	$(document).on('click', '.jstree-anchor', function (e) {
		e.preventDefault();

		$(this).prev('.jstree-icon').trigger('click');
	});

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
				<a href="{{ url('admin/organization-plan') }}">Organization Chart</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Division View

			<!-- <a href="{{ url('admin/organization-plan') }}" class="btn btn-white btn-sm ml-auto">Organization Chart</a>
			<a href="{{ url('admin/organization/company-view') }}" class="btn btn-white btn-sm ml-2">Company View</a> -->
			<a href="{{ url('admin/organization/company-view') }}" class="btn btn-white btn-sm ml-auto">Company View</a>

			<div class="dropdown ml-2">
				<a href="#" id="division_view" class="btn btn-white btn-sm dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Division View</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="division_view">
					@if (count($divisions) > 0)
						@foreach ($divisions as $_division)
						<a href="{{ url('admin/organization/division-view/' . $_division->id) }}" class="dropdown-item text-center">{{ $_division->short_name }}</a>
						@endforeach
					@endif
				</div>
			</div>

			<div class="dropdown ml-2">
				<a href="#" id="department_view" class="btn btn-white btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Department View</a>

				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="department_view">
    			@if (count($departments) > 0)
						@foreach ($departments as $_department)
						<a href="{{ url('admin/organization/department-view/' . $_department->id) }}" class="dropdown-item text-center">{{ $_department->department_short_name }}</a>
						@endforeach
					@endif
  			</div>
			</div>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<div class="form-row mb-4">
		<div class="col-sm-4 pb-2">
			<div class="row ml-0 mr-0 bg-white">
				<div class="col-sm-6 b-r pt-3 pb-3">
					<h5 class="text-center text-muted mb-2 mt-0 font-weight-normal d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('img/icon-total-positions.png') }}" srcset="{{ URL::asset('img/icon-total-positions.png') }} 1x, {{ URL::asset('img/icon-total-positions@2x.png') }} 2x" class="img-fluid mr-1">
						Total positions
					</h5>

					<div class="d-flex align-items-center justify-content-center pt-1">
						<h3 class="m-0 number-value total-positions">{{ $division->getPositionsCountDirect() }}</h3>
					</div>
				</div>

				<div class="col-sm-6 d-flex flex-nowrap p-0 total-breakdown">
					<div class="d-flex flex-column align-items-center justify-content-center b-r">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-assigned.png') }}" srcset="{{ URL::asset('img/icon-assigned.png') }} 1x, {{ URL::asset('img/icon-assigned@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Assigned</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $division->getFilledPositionsCountDirect() }}</h3>
					</div>

					<div class="d-flex flex-column align-items-center justify-content-center">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-vacant.png') }}" srcset="{{ URL::asset('img/icon-vacant.png') }} 1x, {{ URL::asset('img/icon-vacant@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Vacant</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $division->getPositionsCountDirect() - $division->getFilledPositionsCountDirect() }}</h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="row ml-0 mr-0 bg-white">
				<div class="col-sm-6 b-r pt-3 pb-3">
					<h5 class="text-center text-muted mb-2 mt-0 font-weight-normal text-nowrap d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('img/icon-local-positions.png') }}" srcset="{{ URL::asset('img/icon-local-positions.png') }} 1x, {{ URL::asset('img/icon-local-positions@2x.png') }} 2x" class="img-fluid mr-1">
						Total Local positions
					</h5>

					<div class="d-flex align-items-center justify-content-center pt-1">
						<h3 class="m-0 number-value local-positions">{{ $division ? $division->localPositionsCountDirect() : 0 }}</h3>
					</div>
				</div>

				<div class="col-sm-6 d-flex flex-nowrap p-0 total-breakdown">
					<div class="d-flex flex-column align-items-center justify-content-center b-r">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-assigned.png') }}" srcset="{{ URL::asset('img/icon-assigned.png') }} 1x, {{ URL::asset('img/icon-assigned@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Assigned</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $division? $division->getFilledLocalPositionsCountDirect() : 0 }}</h3>
					</div>

					<div class="d-flex flex-column align-items-center justify-content-center">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-vacant.png') }}" srcset="{{ URL::asset('img/icon-vacant.png') }} 1x, {{ URL::asset('img/icon-vacant@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Vacant</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $division ? ($division->localPositionsCountDirect() - $division->getFilledLocalPositionsCountDirect()) : 0 }}</h3>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="row ml-0 mr-0 bg-white">
				<div class="col-sm-6 b-r pt-3 pb-3">
					<h5 class="text-center text-muted mb-2 mt-0 font-weight-normal text-nowrap d-flex align-items-center justify-content-center">
						<img src="{{ URL::asset('img/icon-expat-positions.png') }}" srcset="{{ URL::asset('img/icon-expat-positions.png') }} 1x, {{ URL::asset('img/icon-expat-positions@2x.png') }} 2x" class="img-fluid mr-2">
						Total Expat positions
					</h5>

					<div class="d-flex align-items-center justify-content-center pt-1">
						<h3 class="m-0 number-value expat-positions">{{ $division ? $division->expatPositionsCountDirect() : 0 }}</h3>
					</div>
				</div>

				<div class="col-sm-6 d-flex flex-nowrap p-0 total-breakdown">
					<div class="d-flex flex-column align-items-center justify-content-center b-r">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-assigned.png') }}" srcset="{{ URL::asset('img/icon-assigned.png') }} 1x, {{ URL::asset('img/icon-assigned@2x.png') }} 2x" class="img-fluid mr-1">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Assigned</h5>
						</div>

						<h3 class="m-0 number-value pt-1">{{ $division ? $division->getFilledExpatPositionsCount() : 0 }}</h3>
					</div>

					<div class="d-flex flex-column align-items-center justify-content-center">
						<div class="d-flex align-items-center justify-content-center mb-2">
							<img src="{{ URL::asset('img/icon-vacant.png') }}" srcset="{{ URL::asset('img/icon-vacant.png') }} 1x, {{ URL::asset('img/icon-vacant@2x.png') }} 2x" class="img-fluid mr-2">
							<h5 class="m-0 text-muted position-label total-positions font-weight-normal">Vacant</h5>
						</div>

						<h3 class="m-0 number-value total-positions">{{ $division->expatPositionsCountDirect() - $division->getFilledExpatPositionsCountDirect() }}</h3>
					</div>

				</div>
			</div>
		</div>
	</div>

	@if ($division)
	<div class="divisions-wrap d-flex flex-nowrap align-items-stretch mb-4 pt-2 pb-4">

		<div class="division d-flex flex-column">
			<div class="division-name d-flex align-items-stretch justify-content-center mb-4 {{ count($division->departments) > 0 || count($division->positions) > 0 ? 'with-depts' : '' }}">
				<span>{{ $division->short_name }}</span>
				<span>({{ $division->getFilledPositionsCountDirect() . '/' . $division->getPositionsCountDirect() }})</span>
			</div>

			@if (count($division->departments) > 0 || count($division->positions) > 0)
			<div class="department-wrap d-flex flex-nowrap align-items-stretch flex-fill {{ count($division->departments) == 1 ? 'single-dept' : (count($division->positions) > 0 ? 'single-dept' : '') }}">
				@if (count($division->departments) > 0)
					@foreach ($division->departments as $department)
					<div class="department">
						<div class="ibox h-100 mb-0 bg-white">
							<div class="ibox-title pl-3 pr-3 text-center">
								<h5>{{ $department->department_short_name }} @if ($department->getPositionsCount() > 0)<small class="text-muted font-weight-normal">({{ $department->getFilledPositionsCount() . '/' . $department->getPositionsCount() }})</small>@endif</h5>
							</div>

							<div class="ibox-content pt-3 pb-3 pr-2 pl-2">
								<div class="section-tree" data-department="{{ $department->id }}"></div>
							</div>
						</div>
					</div>
					@endforeach
				@endif

				@if (count($division->positions) > 0)
				<div class="department">
					<div class="ibox h-100 mb-0 bg-white">
						<div class="ibox-title pl-3 pr-3 text-center">
							<h5></h5>
						</div>

						<div class="ibox-content pt-3 pb-3 pr-2 pl-2">
							<div class="section-tree" data-department="{{ $division->id }}"></div>
						</div>
					</div>
				</div>
				@endif
			</div>
			@endif
		</div>

	</div>
	@endif
</div>

@endsection