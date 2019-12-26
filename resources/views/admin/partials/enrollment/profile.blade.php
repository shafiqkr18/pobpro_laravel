
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>First Name *</label>
                <input type="hidden" name="is_employee" value="{{$is_employee}}">

                <input id="employee_name" name="employee_name" type="text" class="form-control form-control-sm required" value="{{ $candidate->name ? $candidate->name : '' }}">
						</div>
        </div>

        <div class="col-lg-6">
						<div class="form-group">
                <label>Last Name *</label>


                <input id="employee_last_name" name="employee_last_name" type="text" class="form-control form-control-sm required" value="{{ $candidate->last_name ? $candidate->last_name : '' }}">
						</div>
				</div>
		</div>

		<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Gender</label>
                <select name="gender" id="gender" class="form-control form-control-sm">
                    <option value="Male" {{ $candidate->gender == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ $candidate->gender == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Age</label>
                <input type="text" class="form-control form-control-sm" name="age" id="age" value="{{ $candidate->age }}">
            </div>
        </div>
		</div>

		<br>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" class="form-control form-control-sm" name="mobile_number" id="mobile_number" value="{{ $candidate->phone }}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" class="form-control form-control-sm" name="phone_number" id="phone_number" value="{{ $candidate->other_contact }}">
            </div>
				</div>
		</div>

		<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Skype</label>
                <input type="text" class="form-control form-control-sm" name="skype" id="skype" value="{{ $candidate->skype }}">
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Other Contact</label>
                <input type="text" class="form-control form-control-sm" name="other_contact" id="other_contact" value="{{ $candidate->other_contact }}">
            </div>
        </div>
		</div>

		<br>

		<div class="row">
			<div class="col-lg-6">
					<div class="form-group">
							<label>Nationality</label>
							<input type="text" class="form-control form-control-sm" name="nationality" id="nationality" value="{{ $candidate->nationality }}">
					</div>
			</div>

			<div class="col-lg-6">
					<div class="form-group">
							<label>Passport No.</label>
							<input type="text" class="form-control form-control-sm" name="passport_no" id="passport_no">
					</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
				<div class="form-group">
						<label>Location</label>
						<input type="text" class="form-control form-control-sm" name="location" id="location" value="{{ $candidate->location }}">
				</div>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-lg-12">
				<div class="form-group">
						<label>Notes</label>
						<textarea name="notes" id="notes" rows="6" class="form-control">{{ $candidate->notes }}</textarea>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-6">
					<div class="form-group">
							<label>Education Level</label>
							<select name="education_level" id="education_level" class="form-control form-control-sm" size>
									@foreach ($education_levels as $education_level)
											<option value="{{ $education_level->id }}" {{ $candidate->education_level == $education_level->id ? 'selected' : '' }}>{{ $education_level->title	 }}</option>
									@endforeach
							</select>
					</div>
			</div>

			<div class="col-lg-6">
					<div class="form-group">
							<label>Resume</label>
							<div class="custom-file d-flex justify-content-between">
									@if ($candidate->resume)
											<a href="{{ asset('/storage/' . $resume[0]['download_link']) }}" target="_blank" class="text-success"><p class="form-control-static font-weight-bold">{{ $resume[0]['original_name'] }}</p></a>
									@else
											<p>No resume uploaded.</p>
									@endif
									<input id="resume" name="file" type="file" class="custom-file-input form-control-sm">
									<label for="resume" class="custom-file-label b-r-xs form-control-sm m-0 small text-underline">Change</label>
							</div>
					</div>
			</div>
		</div>




