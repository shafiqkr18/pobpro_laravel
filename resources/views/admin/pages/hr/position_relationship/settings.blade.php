@extends('admin.layouts.default')

@section('title')
	Edit Organization Mapping
@endsection

@section('styles')
<link href="{{ URL::asset('css/position-relationship.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/position-relationship.js') }}"></script>
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
			<li class="breadcrumb-item">
				<a href="{{ url('admin/organization-mapping') }}">
					Organization Mapping
				</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Settings
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<form action="{{ url('admin/organization-mapping/save') }}">
		<input type="hidden" name="position_id">

		<div class="row mb-4">
			<div class="col-lg-3">
				<div class="form-group">
					<select name="div_id" id="div_id" class="form-control form-control-sm">
						<option value="">Select Division</option>
						@if ($divisions)
							@foreach ($divisions as $division)
							<option value="{{ $division->id }}" {{ $active_division && $division->id == $active_division->id ? 'selected' : '' }}>{{ $division->short_name }}</option>
							@endforeach
						@endif
					</select>
				</div>
			</div>

			<div class="col-lg-3">
				<div class="form-group">
					<select name="dept_id" id="dept_id" class="form-control form-control-sm">
						<option value="">Select Department</option>
						@if ($active_division)
							@foreach ($active_division->departments as $dept)
							<option value="{{ $dept->id }}" {{ $department && $department->id == $dept->id ? 'selected' : '' }}>{{ $dept->department_short_name }}</option>
							@endforeach
						@endif
					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="ibox new">
					<div class="ibox-title">
						<h5>New</h5>
					</div>

					<div class="ibox-content">
						<div class="division">
							<!-- <h3>A &amp; S</h3> -->

							@if ($department)
							<ul class="departments list-unstyled">
								<li>
									<h4 class="mt-3 mb-2 pb-2 border-bottom">{{ $department->department_short_name }}</h4>
									@if (count($department->positions) > 0)
									<ul class="positions list-unstyled">
										@foreach ($department->positions as $position)
										<li class="position mb-2 pb-2 border-bottom" data-id="{{ $position->id }}">
											<div class="d-flex align-items-center flex-nowrap btn-wrap">
												<span>{{ $position->title }}</span>

												<div class="ml-auto">
													<a href="" class="{{ count($position->positionRelationships) > 0 ? '' : 'hide' }}" data-type="remove" title="Remove positions">
														<i class="fas fa-minus-circle text-danger"></i>
													</a>

													<a href="" class="ml-2" data-type="add" title="Add positions">
														<i class="fas fa-plus-circle text-navy"></i>
													</a>
												</div>
											</div>

											@if (count($position->positionRelationships) > 0)
											<div class="positions-moved pb-2 d-flex justify-content-start">
												@foreach ($position->positionRelationships as $relationship)
												<span class="badge badge-white border mt-2 mr-2" data-id="{{ $relationship->id }}">{{ $relationship->exPosition->title }} <i class="fa fa-times-circle text-danger hide"></i></span>
												@endforeach
											</div>
											@endif
										</li>
										@endforeach
									</ul>
									@endif
								</li>
							</ul>
							@endif

						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-6">
				<div class="ibox old">
					<div class="ibox-title">
						<h5>Old</h5>
					</div>

					<div class="ibox-content inactive">
						<div class="division">

							<p class="mb-4 select-label">Select positions to move:</p>

							@if ($ex_departments)
							<ul class="departments list-unstyled">
								@foreach ($ex_departments as $department)
								<li>
									<h4 class="mt-3 mb-2 pb-2 border-bottom">{{ $department->title }}</h4>

									@if ($department->positions)
									<ul class="positions list-unstyled">
										@foreach ($department->positions as $position)
										<li class="d-flex align-items-center flex-nowrap mb-2 pb-2 border-bottom">

											<div class="i-checks {{ $position->positionRelationship && $position->positionRelationship->count() > 0 ? 'moved' : '' }}">
												<input type="checkbox" name="ex_position_id[]" id="pos_{{ $position->id }}" value="{{ $position->id }}">
												<label for="pos_{{ $position->id }}" class="mb-0">{{ $position->title }}</label>
											</div>
										</li>
										@endforeach
									</ul>
									@endif
								</li>
								@endforeach


								<!-- <li>
									<h4 class="mt-3 mb-2 pb-2 border-bottom">HR</h4>

									<ul class="positions list-unstyled">
										<li class="d-flex align-items-center flex-nowrap mb-2 pb-2 border-bottom">
											<div class="i-checks">
												<input type="checkbox" id="check_2">
												<label for="check_2" class="mb-0">HR Admin</label>
											</div>
										</li>

										<li class="d-flex align-items-center flex-nowrap mb-2 pb-2 border-bottom">
											<div class="i-checks">
												<input type="checkbox" id="check_2">
												<label for="check_2" class="mb-0">HR Manager</label>
											</div>
										</li>
									</ul>
								</li> -->

							</ul>
							@endif

						</div>

						<div class="row mt-4">
							<div class="col-lg-12 d-flex justify-content-end">
								<a href="" class="btn btn-sm btn-white cancel-move">Cancel</a>
								<a href="" class="btn btn-sm btn-primary ml-3 move-positions">Move</a>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</form>

</div>

@endsection