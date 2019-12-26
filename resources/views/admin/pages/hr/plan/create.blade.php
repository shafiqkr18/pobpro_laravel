@extends('admin.layouts.default')

@section('title')
	Create Plan
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/new-pages.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.plan-position-placeholder {
	display: none;
}

#positions .form-row:nth-child(even) {
	background: #f8f9fa;
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
		<div class="col-lg-8">
			<form role="form" id="frm_plan" enctype="multipart/form-data">
			<div class="ibox">
				<div class="ibox-title">
					<h5>Plan Details</h5>
					<div class="ibox-tools">

					</div>
				</div>

				<div class="ibox-content">
					<!-- <form role="form" id="frm_plan" enctype="multipart/form-data"> -->
						@csrf
						<input type="hidden" name="is_draft" value="0">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Subject</label>
									<input type="text" class="form-control form-control-sm" name="subject" id="subject">
								</div>

								<div class="form-group">
									<label>Details</label>
									<textarea name="details" id="details" rows="4" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Attachments</label>
									<div class="custom-file">
										<input id="attachments" name="file[]" type="file" class="custom-file-input form-control-sm" multiple>
										<label for="attachments" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>
							</div>
						</div>

						<div class="form-row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Start Date</label>
									<div class="input-daterange input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control-sm form-control text-left" name="start_date" id="start_date" />
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Due Date</label>
									<div class="input-daterange input-group">
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
										<input type="text" class="form-control-sm form-control text-left" name="end_date" id="end_date" />
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label>Budget (USD)</label>
									<input type="number" class="form-control form-control-sm" name="budget" id="budget" placeholder="">
								</div>
							</div>
						</div>

						<!-- <div class="row">
							<div class="col-md-6 b-r">
								<div class="form-group">
									<label>Subject</label>
									<input type="text" class="form-control form-control-sm" name="subject" id="subject">
								</div>

								<div class="form-row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Start Date</label>
											<div class="input-daterange input-group">
												<input type="text" class="form-control-sm form-control text-left" name="start_date" id="start_date" />
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>End Date</label>
											<div class="input-daterange input-group">
												<input type="text" class="form-control-sm form-control text-left" name="end_date" id="end_date" />
											</div>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label>Attachments</label>
									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm" multiple>
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Budget</label>
									<input type="text" class="form-control form-control-sm" name="budget" id="budget">
								</div>

								<div class="form-group">
									<label>Details</label>
									<textarea name="details" id="details" rows="4" class="form-control"></textarea>
								</div>
							</div>
						</div> -->

						<!-- <div id="plan-positions">
							<h4 class="mt-4 mb-3">Positions</h4>

							<div id="positions">

							</div>

							<a href="" class="btn btn-primary btn-sm add-position"><i class="fa fa-plus"></i> Add Position</a>
						</div> -->

						<!-- <div class="row">
							<div class="col-md-12">
								<a href="javascript:void(0)" id="save_plan" class="btn btn-success btn-sm pull-right">Save</a>
							</div>
						</div> -->
					<!-- </form> -->

				</div>

			</div>

			<div class="ibox">
				<div class="ibox-title">
					<h5>Positions</h5>
					<div class="ibox-tools">

					</div>
				</div>

				<div class="ibox-content">
					<div id="plan-positions">
						<div id="positions">

						</div>

						<a href="" class="btn btn-primary btn-sm add-position mt-2"><i class="fa fa-plus"></i> Add Position</a>
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

		<div class="col-lg-4">
			<div class="ibox ">
				<div class="ibox-title">
					<h5>Tips when creating a plan</h5>
					<div class="ibox-tools">

					</div>
				</div>

				<div class="ibox-content">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis tenetur mollitia non similique! Quos, nemo? Repudiandae, modi. Fugiat, ducimus maiores rem corrupti delectus, consequuntur quisquam dolores, magnam eius autem labore.</p>
					<ul>
						<li>Example 1</li>
						<li>Example 2</li>
					</ul>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Alias soluta at doloremque. </p>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="plan-position-placeholder">
	<div class="form-row addme">
		<div class="col-md-3">
			<div class="form-group">
				<label>Position</label>
				<select name="plan_position[]" class="form-control form-control-sm" size>
					<option value=""></option>
					@foreach ($positions as $position)
                        @php
                        $dept = $position->department ? $position->department->department_short_name: '';
                        @endphp
					<option value="{{ $position->id }}">{{ $position->reference_no . ':' . $dept . ' > ' . $position->title }}</option>
					@endforeach
				</select>
			</div>
		</div>



		<div class="col-md-2">
			<div class="form-group">
				<label>Head Count</label>
				<input type="text" class="form-control form-control-sm" name="plan_position_head_count[]">
			</div>
		</div>

		<div class="col-md-2">
			<div class="form-group">
				<label>Due Date</label>
				<div class="input-daterange input-group">
					<input type="text" class="form-control-sm form-control text-left" name="plan_position_due_date[]" />
				</div>
			</div>
		</div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Budget</label>
                <input type="number" class="form-control form-control-sm" name="plan_position_budget[]">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Remarks</label>
                <input type="text" class="form-control form-control-sm" name="plan_position_title[]">
            </div>
        </div>

		<div class="col-md-1">
			<div class="form-group">
				<label>&nbsp;</label>
				<a href="" class="text-danger d-block delete-position"><i class="fa fa-trash"></i> </a>
			</div>
		</div>
	</div>
</div>

<div class="plan-position-placeholder" id="newD">
    <div class="form-row addme">
        <div class="col-md-3">
            <div class="form-group">
                <label></label>
                <select name="plan_position[]" class="form-control form-control-sm" size>
                    <option value=""></option>
                    @foreach ($positions as $position)
                        @php
                            $dept = $position->department ? $position->department->department_short_name: '';
                        @endphp
                        <option value="{{ $position->id }}">{{ $position->reference_no . ':' . $dept . ' > ' . $position->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>



        <div class="col-md-2">
            <div class="form-group">
                <label></label>
                <input type="text" class="form-control form-control-sm" name="plan_position_head_count[]">
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label></label>
                <div class="input-daterange input-group">
                    <input type="text" class="form-control-sm form-control text-left" name="plan_position_due_date[]" />
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label></label>
                <input type="number" class="form-control form-control-sm" name="plan_position_budget[]">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label></label>
                <input type="text" class="form-control form-control-sm" name="plan_position_title[]">
            </div>
        </div>

        <div class="col-md-1">
            <div class="form-group">
                <label>&nbsp;</label>
                <a href="" class="text-danger d-block delete-position"><i class="fa fa-trash"></i> </a>
            </div>
        </div>
    </div>
</div>


@endsection