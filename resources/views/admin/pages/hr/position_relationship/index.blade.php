@extends('admin.layouts.default')

@section('title')
	Organization Mapping
@endsection

@section('styles')
<style>
.relation-arrow {
	font-size: 20px;
	opacity: 0.7;
	float: right;
}

.previous-dept-pos span {
	padding: .25em .4em;
	line-height: 1;
	font-size: 12px;
}

.separator {
	border-top: 1px solid #f1f1f1;
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
	

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
				HR
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Organization Mapping

			<a href="{{ url('admin/organization-mapping/settings') }}" class="btn btn-success btn-sm ml-auto">
				<i class="fas fa-pen-square mr-1"></i>
				Edit
			</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-lg-12">

			@if ($divisions)
				@foreach ($divisions as $division)

					<h3 class="font-weight-bold text-center">{{ $division->short_name }}</h3>
					@if (count($division->departments) > 0)
						@foreach ($division->departments as $department)
			<div class="ibox mb-4">
				<div class="ibox-title">
								<h5>{{ $department->department_short_name }}</h5>
				</div>

				<div class="ibox-content">
								@if (count($department->positions) > 0)
									@foreach ($department->positions as $position)
					<div class="row mt-3">
						<div class="col-sm-6 pr-0">
											<label class="mb-0">{{ $position->title }}</label>
							<i class="fas fa-long-arrow-alt-left relation-arrow ml-auto text-muted"></i>
						</div>

						<div class="col-sm-6 d-flex justify-content-end flex-wrap">
											@if (count($position->positionRelationships) > 0)
												@foreach ($position->positionRelationships as $relationship)
							<span class="d-flex flex-nowrap mb-2 bg-light border align-items-stretch ml-3 rounded previous-dept-pos">
													<span class="bg-secondary text-white rounded-left">{{ $relationship->exDepartment->title }}</span>
													<span class="rounded-right">{{ $relationship->exPosition->title }}</span>
							</span>
												@endforeach
											@endif
						</div>
					</div>
									@endforeach
								@endif
								

						</div>
						</div>
						@endforeach
					@endif

				@endforeach
			@endif

		</div>
	</div>	

</div>

@endsection