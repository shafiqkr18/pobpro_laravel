@extends('admin.layouts.default')

@section('title')
	Add Candidate
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?v=') }}{{rand(11,99)}}"></script>
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
			<li class="breadcrumb-item text-muted">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/candidates') }}">Candidates</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Create</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/candidates') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			Add Candidate
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<a href="javascript:void(0)" id="save_candidate1" class="btn btn-success btn-sm pull-right">Save</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form role="form" id="frm_candidate" enctype="multipart/form-data">
		<div class="form-row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Candidate Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>First Name</label>
									<input type="text" class="form-control form-control-sm" id="name" name="name">
									<input type="hidden" id="reference_no" name="reference_no" value="{{$data['cn_no']}}">
								</div>

								<div class="form-group form-inline">
									<label>Gender</label>
									<select name="gender" id="gender" class="form-control form-control-sm" size>
										<option value="Male" selected>Male</option>
										<option value="Female">Female</option>
									</select>
								</div>

								<div class="form-group form-inline">
									<label>Position</label>
									<select name="position_id" id="position_id" class="form-control form-control-sm" size>
										@foreach($data['positions'] as $key=>$val)
											<option value="{{ $val->id}}" >{{$val->title}}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Last Name</label>
									<input type="text" id="last_name" name="last_name" class="form-control form-control-sm">
								</div>

								<div class="form-group form-inline">
									<label>Age</label>
									<input type="text" class="form-control form-control-sm" id="age" name="age">
								</div>

								<div class="form-group form-inline">
									<label>Badge ID</label>
									<input type="text" id="badge_id" name="badge_id" class="form-control form-control-sm">
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Contact Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Phone</label>
									<input type="text" class="form-control form-control-sm" id="phone" name="phone">
								</div>

								<div class="form-group form-inline">
									<label>Email</label>
									<input type="email" class="form-control form-control-sm" id="email" name="email">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Skype</label>
									<input type="text" class="form-control form-control-sm" id="skype" name="skype">
								</div>

								<div class="form-group form-inline">
									<label>Other Contact</label>
									<input type="text" class="form-control form-control-sm" id="other_contact" name="other_contact">
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="form-row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Location Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Nationality</label>
									<select name="nationality" id="nationality" class="form-control form-control-sm" size>
										<option value="Chinese" selected>Chinese</option>
										<option value="Iraqi">Iraqi</option>
										<option value="Emirati">Emirati</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label> Current Location</label>
									<select name="location" id="location" class="form-control form-control-sm" size>
										<option value="Dubai" selected>Dubai</option>
										<option value="China">China</option>
										<option value="Iraq">Iraq</option>
									</select>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Expected Package</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Expected Salary(USD)</label>
                                    <input type="number" class="form-control form-control-sm" id="fixed_salary" name="fixed_salary">
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Other Benefits</label>
									<input type="text" class="form-control form-control-sm" id="other_benefits" name="other_benefits">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label> Work Type</label>
									<select name="work_type" id="work_type" class="form-control form-control-sm" size>
										@foreach ($data['work_types'] as $work_type)
										<option value="{{ $work_type->id }}">{{ $work_type->full_name }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label> Education Level</label>
									<select name="education_level" id="education_level" class="form-control form-control-sm" size>
										@foreach ($data['education_levels'] as $education_level)
										<option value="{{ $education_level->id }}">{{ $education_level->title	 }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title indented">
						<h5>Profile Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group form-inline">
									<label>Description</label>
									<textarea name="notes" id="notes" rows="6" class="form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group form-inline">
                                    <label>Ex Department</label>
                                    <input type="text" class="form-control form-control-sm" id="ex_department" name="ex_department">
                                </div>
                            </div>
							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>Upload CV</label>
									<div class="custom-file">
										<input id="logo" name="file" type="file" class="custom-file-input form-control-sm">
										<label for="logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>

			<div class="col-lg-12">
				<div class="ibox mb-3">
					<div class="ibox-title indented">
						<h5>Others</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-sm-6 b-r">
								<div class="form-group form-inline">
									<label>Level</label>
									<select name="level" id="level" class="form-control form-control-sm-xs">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5" selected>5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
									</select>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group form-inline">
									<label>&nbsp;Company</label>
									@php
									$all_companies = $data['all_companies'];
									$my_companies = $data['all_companies']->where('id', Auth::user()->company_id)->all();
									@endphp
									<select data-placeholder="Select role" class="form-control" id="company_id" name="company_id">
									{{--he can see only his company --}}
									@role('itfpobadmin')
										@foreach($all_companies as $company)
										<option value="{{ $company->id }}">
											<span class="text-primary font-weight-bold">{{$company->company_name}}</span>
										</option>
										@endforeach
									@else
										@foreach($my_companies as $company)
											<option value="{{ $company->id }}">
												<span class="text-primary font-weight-bold">{{$company->company_name}}</span>
											</option>
										@endforeach
									@endrole
									</select>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<a href="javascript:void(0)" id="save_candidate" class="btn btn-success btn-sm pull-right">Save</a>
			</div>
		</div>
	</form>
</div>
@endsection