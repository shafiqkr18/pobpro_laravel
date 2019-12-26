
    <input type="hidden" name="div_id" value="{{$candidate->div_id}}">
    <input type="hidden" name="dept_id" value="{{$candidate->dept_id}}">
    <input type="hidden" name="sec_id" value="{{$candidate->sec_id}}">


    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Position</label>
                <select name="position_id" id="position_id" class="form-control form-control-sm" size requirede>
{{--                    <option value=""></option>--}}
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}" {{ $candidate->position_id == $position->id ? 'selected' : '' }}>{{ $position->title }}</option>
                    @endforeach
                </select>
            </div>
				</div>

				<div class="col-lg-6">
            <div class="form-group">
                <label>Report To</label>
                <select name="report_to_id" id="report_to_id" class="form-control form-control-sm" size>
                    <option value="">asd</option>
										<option value="">ewwewew</option>
                </select>
            </div>
				</div>

		</div>

		<div class="row">
				<div class="col-lg-6">
						<div class="form-group">
                <label>Badge ID</label>
                <input id="badge_id" name="badge_id" type="text" class="form-control form-control-sm required">
						</div>
				</div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Work Type</label>
                <select name="work_type" id="work_type" class="form-control form-control-sm" size>
                    @foreach ($work_types as $work_type)
                        <option value="{{ $work_type->id }}" {{ $candidate->work_type == $work_type->id ? 'selected' : '' }}>{{ $work_type->full_name }}</option>
                    @endforeach
                </select>
            </div>
				</div>
		</div>

		<div class="row">
				<div class="col-lg-6">
            <div class="form-group">
                <label>Level</label>
                <select name="level" id="level" class="form-control form-control-sm" size>
										<option value="1">1</option>
										<option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
				</div>

				<div class="col-lg-6">
            <div class="form-group">
                <label>Rotation Type</label>
                <select name="rotation_type_id" id="rotation_type_id" class="form-control form-control-sm" size>
										<option value="">www</option>
										<option value="">ewewew</option>
                </select>
            </div>
        </div>
		</div>

		<div class="row">
			<div class="col-lg-6">
					<div class="form-group">
							<label>Salary(USD)</label>
							<input id="salary" name="salary" type="text" class="form-control form-control-sm required">
					</div>
			</div>

{{--			<div class="col-lg-6">--}}
{{--					<div class="form-group">--}}
{{--							<label>Company</label>--}}
{{--							<input id="company_id" name="company_id" type="text" class="form-control form-control-sm required">--}}
{{--					</div>--}}
{{--			</div>--}}
		</div>

		<br>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Organization</label>
                <select name="org_id" id="org_id" class="form-control form-control-sm" size>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}">{{ $organization->org_title }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Division</label>

            </div>
				</div>
		</div>

		<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Department</label>

            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Section</label>

            </div>
        </div>
		</div>

		<br>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Agreement Start Date</label>
                <div class="input-daterange input-group">
                    <input type="text" class="form-control-sm form-control text-left" name="agreement_start_date" id="agreement_start_date"
                     value="{{$candidate->agreement_start_date}}"/>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="form-group">
                <label>Agreement End Date</label>
                <div class="input-daterange input-group">
                    <input type="text" class="form-control-sm form-control text-left" name="agreement_end_date" id="agreement_end_date"
                           value="{{$candidate->agreement_end_date}}"/>
                </div>
            </div>
        </div>
		</div>

		<div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Join Date</label>
                <div class="input-daterange input-group">
                    <input type="text" class="form-control-sm form-control text-left" name="joining_date" id="joining_date"
                           value="{{$candidate->joining_date}}"/>
                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-lg-12">
            <div class="form-group">
                <label>Other Benefits</label>
            <!-- <input type="text" class="form-control form-control-sm" name="notes" id="other_benefits" value="{{ $candidate->other_benefits }}"> -->
                <textarea name="other_benefits" id="other_benefits" rows="6" class="form-control">{{ $candidate->other_benefits }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <label>Contract</label>
                <div class="custom-file d-flex justify-content-between">
                    @if ($candidate->contract)
											@php $contract = json_decode($candidate->contract->attachments, true); @endphp
                        <a href="{{ asset('/storage/' . $contract[0]['download_link']) }}" target="_blank" class="text-success"><p class="form-control-static font-weight-bold">{{ $contract[0]['original_name'] }}</p></a>
                    @else
                        <p>No contract uploaded.</p>
                    @endif
                    <input id="attachments" name="contract_file" type="file" class="custom-file-input form-control-sm">
                    <label for="attachments" class="custom-file-label b-r-xs form-control-sm m-0 small text-underline">Change</label>
                </div>
            </div>
        </div>
    </div>

