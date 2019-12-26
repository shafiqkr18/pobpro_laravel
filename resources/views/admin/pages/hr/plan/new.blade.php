@extends('admin.layouts.default')

@section('title')
	Create Plan
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
	display: flex;
	align-items: center;
}

.plan-position-placeholder {
	display: none;
}

#positions .form-row:nth-child(even) {
	background: #f8f9fa;
}

select[name="position_holder[]"] {
	-webkit-appearance: none;
	appearance: none;
	padding: 0;
	background-color: transparent !important;
	font-weight: bold;
	border: 0;
}

label {
	font-size: 11px !important;
}

input,
select {
	font-size: 12px !important;
	padding: 0 5px !important;
}

select {
	padding-left: 0 !important;
}

input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
	/* display: none; <- Crashes Chrome on hover */
	-webkit-appearance: none;
	margin: 0; /* <-- Apparently some margin are still there even though it's hidden */
}

input[type=number] {
	-moz-appearance:textfield; /* Firefox */
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true,
		todayHighlight: true,
		startDate: 'today'
	});

	$(document).on('click', '.add-position', function (e) {
		e.preventDefault();
		let div_contains = $("#positions").find(".addme").length;

		console.log('count='+div_contains);

        if(div_contains == 0)
        {
		var $positionContents = $('.plan-position-placeholder').html();
		$('#positions').append($positionContents);

        }else{
            var $positionContents = $('#newD').html();
            $('#positions').append($positionContents);
        }

		$('#positions .input-daterange').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true
		});
	});

	$(document).on('click', '.delete-position', function (e) {
		e.preventDefault();
        console.log('delete clicked');
		$(this).closest('.form-row').remove();
	});

	$(document).on('keyup', '[name="plan_position_expat[]"], [name="plan_position_local[]"]', function (e) {
		e.preventDefault();

		var row = $(this).closest('.form-row.addme'),
				expat = row.find('[name="plan_position_expat[]"]').val() ? row.find('[name="plan_position_expat[]"]').val() : 0,
				local = row.find('[name="plan_position_local[]"]').val() ? row.find('[name="plan_position_local[]"]').val() : 0,
				headCount = row.find('[name="plan_position_head_count[]"]');

		headCount.val(parseInt(expat) + parseInt(local));
	});

});
</script>
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
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/hr-plan') }}">HR Plan</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Create Plan</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="form-row">
		<div class="col-lg-12">
			<form role="form" id="frm_plan" enctype="multipart/form-data">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Plan Details</h5>
				</div>

				<div class="ibox-content">
						@csrf
						<input type="hidden" name="is_draft" value="0">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group form-inline">
									<label>Subject</label>
									<input type="text" class="form-control form-control-sm" name="subject" id="subject">
								</div>

								<div class="form-group form-inline">
									<label class="align-self-start">Details</label>
									<textarea name="details" id="details" rows="4" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 b-r">
								<div class="form-group form-inline">
									<label>Attachments</label>
									<div class="custom-file">
										<input id="attachments" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
										<label for="attachments" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group form-inline">
									<label>Recruitment Type</label>
									<select name="recruitment_type_id" id="recruitment_type_id" class="form-control form-control-sm" size>
									@if ($recruitment_types)
										@foreach ($recruitment_types as $type)
										<option value="{{ $type->id }}">{{ $type->title }}</option>
										@endforeach
									@endif
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 b-r">
								<div class="form-group form-inline">
									<label>Start Date</label>
									<div class="input-daterange input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control-sm form-control text-left" name="start_date" id="start_date" />
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group form-inline">
									<label>Due Date</label>
									<div class="input-daterange input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control-sm form-control text-left" name="end_date" id="end_date" />
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 b-r">
								<div class="form-group form-inline">
									<label>Budget (USD)</label>
									<input type="number" class="form-control form-control-sm" name="budget" id="budget" placeholder="" >
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group form-inline">
									<label>Budget Plan</label>
									<select name="plan_budget" id="plan_budget" class="form-control form-control-sm" size>
									@if ($budgets)
										@foreach ($budgets as $budget)
										<option value="{{ $budget->id }}">{{ $budget->title }}</option>
										@endforeach
									@endif
									</select>
								</div>
							</div>
						</div>


				</div>

			</div>

			<div class="ibox">
				<div class="ibox-title">
					<h5>Positions</h5>
				</div>

				<div class="ibox-content mb-3">
					<div id="plan-positions">
						<div class="form-row">
							<div class="col-md-2">
								<!-- <label class="mb-1">Position</label> -->
							</div>

							<div class="col-md-2">
								<label class="mb-1">Rotation Type</label>
							</div>

							<div class="col-md-2">
								<label class="mb-1">Nationality</label>
							</div>

							<div class="col-md-1">
								<label class="mb-1">Expat</label>
							</div>

							<div class="col-md-1">
								<label class="mb-1">Local</label>
							</div>

							<div class="col-md-1">
								<label class="mb-1">Head Count</label>
							</div>

							<div class="col-md-2">
								<label class="mb-1">Budget (USD)</label>
							</div>
						</div>

						<div id="positions">
							@if ($positions)
								@foreach ($positions as $position)
								<div class="form-row addme">
									<input type="hidden" name="plan_position_due_date[]" value="{{ $position->due_date }}">
									<input type="hidden" name="plan_position[]" value="{{ $position->id }}">
									<div class="col-md-2">
										<div class="form-group mt-2 mb-2">
											<!-- <label class="mb-0">Position</label> -->
											<select name="position_holder[]" class="form-control form-control-sm" size disabled>
												@php
												$dept = $position->department ? $position->department->department_short_name: '';
												@endphp
												<option value="{{ $position->id }}">{{ $position->title }}</option>
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group mt-2 mb-2">
											<select name="plan_position_rotation_type[]" id="plan_position_rotation_type" class="form-control form-control-sm" size>
											@if ($rotation_types)
												@foreach ($rotation_types as $type)
												<option value="{{ $type->id }}">{{ $type->title }}</option>
												@endforeach
											@endif
											</select>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group mt-2 mb-2">
											<select name="plan_position_plan_nationality[]" id="plan_position_plan_nationality" class="form-control form-control-sm" size>
											@if ($plan_nationalities)
												@foreach ($plan_nationalities as $type)
												<option value="{{ $type->id }}">{{ $type->title }}</option>
												@endforeach
											@endif
											</select>
										</div>
									</div>

									<div class="col-md-1">
										<div class="form-group mt-2 mb-2">
											<input type="number" class="form-control form-control-sm" name="plan_position_expat[]" value="{{ $position->expat_positions }}" >
										</div>
									</div>

									<div class="col-md-1">
										<div class="form-group mt-2 mb-2">
											<input type="number" class="form-control form-control-sm" name="plan_position_local[]" value="{{ $position->local_positions }}" >
										</div>
									</div>

									<div class="col-md-1">
										<div class="form-group mt-2 mb-2">
											<input type="number" class="form-control form-control-sm" name="plan_position_head_count[]" value="{{ $position->expat_positions + $position->local_positions }}" readonly>
										</div>
									</div>

									<div class="col-md-2">
										<div class="form-group mt-2 mb-2">
											<input type="number" class="form-control form-control-sm" name="plan_position_budget[]" value="{{ $position->budget }}" >
										</div>
									</div>

									<div class="col-md-1">
										<div class="form-group mt-2 mb-2">
											<!-- <label class="mb-0">&nbsp;</label> -->
											<a href="" class="text-danger d-block delete-position"><i class="fa fa-trash"></i> </a>
										</div>
									</div>
								</div>
								@endforeach
							@endif
						</div>

						<!-- <a href="" class="btn btn-primary btn-sm add-position mt-2"><i class="fa fa-plus"></i> Add Position</a> -->
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<a href="javascript:void(0)" class="save_plan btn btn-success btn-sm pull-right" data-draft="0">Save</a>
					<a href="javascript:void(0)" class="save_plan btn btn-secondary btn-outline btn-sm pull-right mr-2" data-draft="1">Save as draft</a>
				</div>
			</div>
			</form>
		</div>

	</div>
</div>




@endsection