@extends('admin.layouts.default')

@section('title')
	Department Requests
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/department-requests.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/department-requests.js') }}"></script>
<script>
$( document ).ready(function() {
	$('.input-group.date').datepicker({
		todayBtn: 'linked',
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
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
				Management
			</li>
			<li class="breadcrumb-item">
				Department Requests
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			{{ $department ? $department->department_short_name : '' }}

			<a href="{{url('admin/department-requests/submit-for-approval')}}" class="btn btn-sm btn-success ml-auto {{($dept_approval_last && $dept_approval_last->status == 0) ? 'disabled' : ''}}">Submit for approval</a>
			<a href="{{ url('admin/department-requests/quick-view') }}" class="btn btn-sm btn-white ml-2">Quick view</a>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content  animated fadeInRight">
	<div class="row">
		<div class="col-md-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Sections</h5>
				</div>

				<div class="ibox-content">

					<h5 class="alert-warning p-2">Requested</h5>

					@if ($requested_sections)
					<ul class="list-unstyled mb-0 requested sections">
						@foreach ($requested_sections as $section)
						<li class="section d-flex align-items-center rounded mb-2" data-id="{{ $section->id }}" data-fullname="{{ $section->full_name }}">
							<span class="name">{{ $section->short_name }}</span>

							<a href="" class="action edit-section ml-auto">
								<i class="fas fa-pen-square text-success"></i>
							</a>

							<a href="{{ url('admin/modal/delete') }}" id="{{ $section->id }}" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/department-requests/delete-section/' . $section->id) }}" class="action delete-section ml-2">
								<i class="fa fa-trash text-danger"></i>
							</a>

							<a href="" class="ml-3 text-primary show-positions">
								<span class="positions-qty"><span>{{ count($section->positions) }}</span> Position{{ count($section->positions) == 1 ? ''  : 's'}}</span>
								<i class="fas fa-chevron-right ml-1"></i>
							</a>
						</li>
						@endforeach
					</ul>
					@endif

					<h5 class="mt-5 alert-success p-2">Existing</h5>

					@if ($existing_sections || $existing_sections_updates)
					<ul class="list-unstyled mb-0 existing sections">
						@if ($existing_sections_updates)
							@foreach ($existing_sections_updates as $section)
							<li class="section d-flex align-items-center rounded mb-2" data-id="{{ $section->id }}" data-existing="{{ $section->sectionUpdateRequest ? $section->sectionUpdateRequest->id : 0 }}" data-positionrequests="{{ count($section->positionRequests) }}" data-fullname="{{ $section->full_name }}">
								<span class="name">{{ $section->sectionUpdateRequest->short_name }}</span>

								<a href="" class="action edit-section ml-auto">
									<i class="fas fa-pen-square text-success"></i>
								</a>

								<a href="{{ url('admin/modal/delete') }}" id="{{ $section->sectionUpdateRequest->id }}" confirmation-modal="delete" data-view="department_request" data-url="{{ url('admin/department-requests/delete-section/' . $section->sectionUpdateRequest->id) . '/existing-update' }}" class="action delete-section ml-2">
									<i class="fa fa-trash text-danger"></i>
								</a>

								<a href="" class="ml-3 text-primary show-positions">
									<span class="positions-qty"><span>{{ count($section->positions) + count($section->positionRequests) }}</span> Position{{ count($section->positions) + count($section->positionRequests) == 1 ? ''  : 's'}}</span>
									<i class="fas fa-chevron-right ml-1"></i>
								</a>
							</li>
							@endforeach
						@endif

						@foreach ($existing_sections as $section)
						<li class="section d-flex align-items-center rounded mb-2" data-id="{{ $section->id }}" data-existing="{{ $section->sectionUpdateRequest ? $section->sectionUpdateRequest->id : 0 }}" data-positionrequests="{{ count($section->positionRequests) }}" data-fullname="{{ $section->full_name }}">
							<span class="name">{{ $section->short_name }}</span>

							<a href="" class="action edit-section update-existing ml-auto">
								<i class="fas fa-pen-square text-success"></i>
							</a>

							<a href="{{ url('admin/modal/delete') }}" id="{{ $section->id }}" confirmation-modal="delete" data-view="department_request" data-url="{{ url('admin/department-requests/delete-section/' . $section->id) . '/existing' }}" class="action delete-section ml-2">
								<i class="fa fa-trash text-danger"></i>
							</a>

							<a href="" class="ml-3 text-primary show-positions">
								<span class="positions-qty"><span>{{ (count($section->positions) + count($section->positionRequests) - $section->positionDeleteRequestsCount()) }}</span> Position{{ (count($section->positions) + count($section->positionRequests) - $section->positionDeleteRequestsCount()) == 1 ? ''  : 's'}}</span>
								<i class="fas fa-chevron-right ml-1"></i>
							</a>
						</li>
						@endforeach
					</ul>
					@endif

					<div class="d-flex justify-content-end mt-3">
						<a href="#" class="btn btn-xs btn-primary d-flex align-items-center" data-toggle="modal" data-target="#new_section">
							<i class="fas fa-plus mr-2"></i> New section
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Positions</h5>
				</div>

				<div class="ibox-content">

					<table class="table positions-table w-100 requested">
						<thead>
							<tr class="alert-warning">
								<th><span class="section-label">Requested</span> Positions</th>
								<th class="text-center" style="width: 62px;">Local</th>
								<th class="text-center" style="width: 62px;">Expat</th>
								<th class="text-center" style="width: 62px;">Total</th>
								<th class="text-center" style="width: 50px;"></th>
							</tr>
						</thead>

						<tbody>
							@if ($all_requested_positions)
								@foreach ($all_requested_positions as $position)
								<tr>
									<td>{{ $position->title }}</td>
									<td>{{ $position->local_positions }}</td>
									<td>{{ $position->expat_positions }}</td>
									<td>{{ $position->total_positions }}</td>
									<td>
										<div class="d-flex flex-nowrap align-items-center justify-content-center">
											<a href="" class="mr-1 edit-position" data-section="{{ $position->section_id }}" data-id="{{ $position->id }}" data-location="{{ $position->location ? $position->location : '' }}" data-duedate="{{ $position->due_date ? date('m/d/Y', strtotime($position->due_date)) : '' }}" data-notes="{{ $position->notes ? $position->notes : '' }}">
												<i class="fas fa-pen-square text-success" title="Edit"></i>
											</a>

											<a href="{{ url('admin/modal/delete') }}" confirmation-modal="delete" data-view="detail" data-url="{{ url('admin/department-requests/delete-position/' . $position->id) }}" class="ml-1">
												<i class="fa fa-trash text-danger" title="Delete"></i>
											</a>
										</div>
									</td>
								</tr>
								@endforeach
							@else
								<tr>
									<td>No positions.</td>
								</tr>
							@endif
						</tbody>
					</table>

					<table class="table positions-table existing w-100 mt-5">
						<thead>
							<tr class="alert-success">
								<th><span class="section-label">Existing</span> Positions</th>
								<th class="text-center" style="width: 62px;">Local</th>
								<th class="text-center" style="width: 62px;">Expat</th>
								<th class="text-center" style="width: 62px;">Total</th>
								<th class="text-center" style="width: 50px;"></th>
							</tr>
						</thead>

						<tbody>
							@if ($existing_positions_updates)
								@foreach ($existing_positions_updates as $position)
								<tr>
									<td>{{ $position->positionUpdateRequest->title }}</td>
									<td>{{ $position->positionUpdateRequest->local_positions }}</td>
									<td>{{ $position->positionUpdateRequest->expat_positions }}</td>
									<td>{{ $position->positionUpdateRequest->total_positions }}</td>
									<td>
										<div class="d-flex flex-nowrap align-items-center justify-content-center">
											<a href="" class="mr-1 edit-position" data-section="{{ $position->section_id }}" data-id="{{ $position->positionUpdateRequest->id }}" data-location="{{ $position->positionUpdateRequest->location ? $position->positionUpdateRequest->location : '' }}" data-duedate="{{ $position->positionUpdateRequest->due_date ? date('m/d/Y', strtotime($position->positionUpdateRequest->due_date)) : '' }}" data-notes="{{ $position->positionUpdateRequest->notes ? $position->positionUpdateRequest->notes : '' }}">
												<i class="fas fa-pen-square text-success" title="Edit"></i>
											</a>

											<a href="{{ url('admin/modal/delete') }}" confirmation-modal="delete" data-view="department_request" data-url="{{ url('admin/department-requests/delete-position/' . $position->id . '/existing') }}" class="ml-1">
												<i class="fa fa-trash text-danger" title="Delete"></i>
											</a>
										</div>
									</td>
								</tr>
								@endforeach
							@endif

							@if ($all_existing_positions)
								@foreach ($all_existing_positions as $position)
								<tr>
									<td>{{ $position->title }}</td>
									<td>{{ $position->local_positions }}</td>
									<td>{{ $position->expat_positions }}</td>
									<td>{{ $position->total_positions }}</td>
									<td>
										<div class="d-flex flex-nowrap align-items-center justify-content-center">
											<a href="" class="mr-1 edit-position update-existing" data-section="{{ $position->section? $position->section->id: 0 }}" data-id="{{ $position->id }}" data-location="{{ $position->location ? $position->location : '' }}" data-duedate="{{ $position->due_date ? date('m/d/Y', strtotime($position->due_date)) : '' }}" data-notes="{{ $position->notes ? $position->notes : '' }}" data-lock="{{ $position->is_lock }}">
												<i class="fas fa-pen-square text-success" title="Edit"></i>
											</a>

											<a href="{{ url('admin/modal/delete') }}" confirmation-modal="delete" data-view="department_request" data-url="{{ url('admin/department-requests/delete-position/' . $position->id . '/existing') }}" class="ml-1">
												<i class="fa fa-trash text-danger" title="Delete"></i>
											</a>
										</div>
									</td>
								</tr>
								@endforeach
							@endif
						</tbody>
					</table>

					<div class="d-flex justify-content-end mt-3 d-flex align-items-center">
						<a href="#" class="btn btn-xs btn-primary d-flex align-items-center new-position" data-toggle="modal" data-target="#new_position">
							<i class="fas fa-plus mr-2"></i> New position
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="modal inmodal fade" id="new_section" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Create new section</h4>

				<a href="" data-dismiss="modal" class="ml-auto">
					<i class="fa fa-times text-muted"></i>
				</a>
			</div>

			<div class="modal-body p-3 gray-bg min-detail">
				<form action="{{ url('admin/department-requests/save-section') }}">
					<input type="hidden" name="action_type" value="0">

					<div class="ibox">
						<div class="ibox-title">
							<h5>Section Details</h5>
						</div>

						<div class="ibox-content">

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-inline p-0">
										<label>Short Name</label>
										<input type="text" class="form-control form-control-sm" name="short_name" id="short_name">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group form-inline p-0">
										<label>Full Name</label>
										<input type="text" class="form-control form-control-sm" name="full_name" id="full_name">
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-3">
							<div class="col-md-12 d-flex align-items-center">
								<a href="#" class="btn btn-sm btn-white ml-auto" data-dismiss="modal">Cancel</a>
								<a href="" class="btn btn-sm btn-primary ml-2 save-section">Create</a>
							</div>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>

<div class="modal inmodal fade" id="new_position" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Create new position</h4>

				<a href="" data-dismiss="modal" class="ml-auto">
					<i class="fa fa-times text-muted"></i>
				</a>
			</div>

			<div class="modal-body p-3 gray-bg min-detail">
				<form action="{{ url('admin/department-requests/save-position') }}">
					<input type="hidden" name="section_id">
					<input type="hidden" name="position_type" value="requested">
					<input type="hidden" name="action_type" value="0">

					<div class="ibox">
						<div class="ibox-title">
							<h5>Position Details</h5>
						</div>

						<div class="ibox-content">

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-inline p-0">
										<label>Title</label>
										<input type="text" class="form-control form-control-sm" name="title" id="title">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group form-inline p-0">
										<label>Location</label>
										<input type="text" class="form-control form-control-sm" name="location" id="location">
									</div>
								</div>

								<div class="col-md-12">
									<div class="form-group form-inline p-0">
										<label>Due Date</label>
										<div class="input-group date">
											<span class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</span>
											<input type="text" class="form-control form-control-sm" id="due_date" name="due_date">
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-12">
									<div class="form-group form-inline p-0">
										<label class="align-self-start mt-1">Remarks</label>
										<textarea class="form-control" name="remarks" id="remarks" rows="4"></textarea>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-sm-4">
									<div class="form-group p-0">
										<label>Local positions</label>
										<input type="number" class="form-control form-control-sm" name="local_positions" id="local_positions">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form-group p-0">
										<label>Expat positions</label>
										<input type="number" class="form-control form-control-sm" name="expat_positions" id="expat_positions">
									</div>
								</div>

								<div class="col-sm-4">
									<div class="form-group p-0">
										<label>Total positions</label>
										<input type="number" class="form-control form-control-sm" name="total_positions" id="total_positions" value="0" readonly>
									</div>
								</div>
							</div>

						</div>

						<div class="row mt-3">
							<div class="col-md-12 d-flex align-items-center">
								<a href="#" class="btn btn-sm btn-white ml-auto" data-dismiss="modal">Cancel</a>
								<a href="" class="btn btn-sm btn-primary ml-2 save-position">Create</a>
							</div>
						</div>
					</div>
				</form>
			</div>

		</div>
	</div>
</div>
@endsection