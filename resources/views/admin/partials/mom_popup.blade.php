@if($mom)
    <div class="detail-preview">
        <div class="form-row">
            <div class="col-md-12">
                <h3 class="mt-0 mb-3 d-flex flex-nowrap align-items-start">
                    {{$mom->subject}}

                    <a href="" data-dismiss="modal" class="ml-auto"><small class="fa fa-times text-muted"></small></a>
                </h3>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6 d-flex flex-nowrap">
                <label>Host:</label>
                <div class="value">{{$mom->host? $mom->host->name: ''}}</div>
            </div>

            <div class="col-md-6 d-flex flex-nowrap">
                <label>Meeting Date:</label>
                <div class="value">{{$mom->meeting_date}}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-6 d-flex flex-nowrap">
                <label>Department:</label>
                <div class="value">{{$mom->department? $mom->department->department_short_name: ''}}</div>
            </div>

            <div class="col-md-6 d-flex flex-nowrap">
                <label>End Time:</label>
                <div class="value">{{$mom->meeting_time}}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 d-flex flex-nowrap">
                <label>Location:</label>
                <div class="value text-navy font-weight-bold">{{$mom->location}}</div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 d-flex flex-nowrap">
                <label>Attendants:</label>
                <div class="value d-flex">
                    @if($mom->attendants)
                       @foreach($mom->attendants as $att)
                        @if($att->attendant)
                            @php

                               $avatar = $att->attendant->avatar ? json_decode($att->attendant->avatar, true) : null;

                            @endphp
                            @if($avatar)
                                    <img class="rounded-circle img-sm mr-1 mb-1" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" title="{{$att->attendant->name}}">
                                @else
                                <img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/profile_small.jpg') }}" title="{{$att->attendant->name}}">
                        @endif
                        @endif
                       @endforeach
                    @endif
{{--                    <img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/profile_small.jpg') }}" alt="">--}}
{{--                    <img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/a4.jpg') }}" alt="">--}}
{{--                    <img class="rounded-circle img-sm mr-1 mb-1" src="{{ URL::asset('img/a1.jpg') }}" alt="">--}}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-12 d-flex flex-nowrap">
                <label>Objective:</label>
                <div class="value">
                    <p class="mb-2">
                        {{$mom->summary}}
                    </p>
                </div>
            </div>
        </div>

        <div class="form-row mt-2">
            <div class="col-md-12 d-flex">
                <a href="{{ url('admin/minutes-of-meeting/update/') }}/{{$mom->id}}" class="btn btn-sm btn-success ml-auto">Edit</a>
            </div>
        </div>

    </div>
@endif
