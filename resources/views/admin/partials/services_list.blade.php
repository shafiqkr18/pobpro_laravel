@if($departments->count()>0)
    @foreach($departments as $department)
        <li class="dd-item" data-id="{{$department->id}}" id="{{$department->id}}">
    <div class="dd-handle sec-dept-lst d-flex flex-nowrap" data-id="{{$department->id}}" id="{{$department->id}}">
				<span class="font-weight-normal">{{$department->department_short_name}}</span>
                <span class="ml-auto mr-3 font-weight-normal">{{$department->sections->count() }} Sections</span>
				@if (!$new_plan)
        <a href="#" data-toggle="modal" data-target="#mySections" class="" id="s_anc">
            <small class="label label-primary">+</small>
				</a>
				@endif
    </div>
    <ol class="dd-list">
                @if($department->sections->count()>0)
                    @foreach($department->sections as $section)
                <li class="dd-item" data-id="{{$section->id}}" id="{{$section->id}}">
                    <div class="dd-handle  sec-sec-lst d-flex flex-nowrap align-items-center" data-id="{{$section->id}}" id="{{$section->id}}" data-dept="{{ $department->id }}">
												@if ($new_plan)
												<label><input name="check_all" type="checkbox"><i class="mr-1"></i> </label>
												@endif

												<span class="font-weight-normal">{{$section->short_name}}</span>
												<span class="ml-auto font-weight-normal">{{$section->positions->count() }} Positions</span>
												<i class="fas fa-chevron-right ml-2"></i>

                    </div>
                    <div id="show_position_list_{{$section->id}}"></div>
                </li>
            @endforeach
        @endif
    </ol>
        </li>
    @endforeach
@endif

{{--<li class="dd-item" data-id="{{$department->id}}" id="{{$department->id}}">--}}
{{--    <div class="dd-handle sec-dept-lst d-flex flex-nowrap" data-id="{{$department->id}}" id="{{$department->id}}">--}}
{{--				<span class="font-weight-normal">{{$department->department_short_name}}</span>--}}
{{--        <span class="ml-auto mr-3 font-weight-normal">{{$sections->count() }} Sections</span>--}}
{{--				@if (!$new_plan)--}}
{{--        <a href="#" data-toggle="modal" data-target="#mySections" class="" id="s_anc">--}}
{{--            <small class="label label-primary">+</small>--}}
{{--        </a>--}}
{{--				@endif--}}
{{--    </div>--}}
{{--    <ol class="dd-list">--}}
{{--        @if($sections->count()>0)--}}
{{--            @foreach($sections as $section)--}}
{{--                <li class="dd-item" data-id="{{$section->id}}" id="{{$section->id}}">--}}
{{--                    <div class="dd-handle  sec-sec-lst d-flex flex-nowrap align-items-center" data-id="{{$section->id}}" id="{{$section->id}}" data-dept="{{ $department->id }}">--}}
{{--												@if ($new_plan)--}}
{{--												<label><input name="check_all" type="checkbox"><i class="mr-1"></i> </label>--}}
{{--												@endif--}}

{{--												<span class="font-weight-normal">{{$section->short_name}}</span>--}}
{{--												<span class="ml-auto font-weight-normal">{{$section->positions->count() }} Positions</span>--}}
{{--												<i class="fas fa-chevron-right ml-2"></i>--}}

{{--                    </div>--}}
{{--                    <div id="show_position_list_{{$section->id}}"></div>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        @endif--}}
{{--    </ol>--}}
{{--</li>--}}
