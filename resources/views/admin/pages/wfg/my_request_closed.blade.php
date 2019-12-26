@extends('admin.layouts.default')

@section('title')
    {{__('messages.process-procedures')}}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
    <style type="text/css">
        .myclass{
            padding-right: 20px !important;
            background-color: #4cc636 !important;
        }
        table.dataTable{border-collapse:collapse !important;}
    </style>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(11,99)}}"></script>
    <script>
        $(document).ready(function(){
            $('#wfg_my_requests').DataTable({
                pageLength: 10,
                responsive: true,
                //"bFilter" : false,
                "bLengthChange": false

            });
        });
    </script>

@endsection

@section('content')
    <div class="row page-heading">
        <div class="col-lg-10">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>{{__('messages.process-procedures')}}</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Closed List</strong>
                </li>
            </ol>

            <h2 class="d-flex align-items-center">{{__('messages.process-procedures')}}</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">
            <a href="{{url('admin/wfg-my-requests')}}" class="btn btn-success " style="margin-right:5px">Open</a>
            <a href="{{url('admin/wfg-my-requests-closed')}}" class="btn btn-warning">Closed</a>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="#">My Requests - Closed</h5>

                    </div>
                    <div class="ibox-content">
                        {{--                        <a style="text-align: right" href="{{url('admin/get_wfg_requests')}}"  >Refresh API</a>--}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover " id="wfg_my_requests" style="width: 100%">
                                <thead>
                                <tr>
                                    {{--                                    <th>#</th>--}}
                                    {{--                                    <th>Request #</th>--}}
                                    {{--                                    <th >Process ID</th>--}}
                                    {{--                                    <th>Test</th>--}}
                                    <th>Process</th>
                                    {{--                                    <th>State</th>--}}

                                    {{--                                    <th>Sub State</th>--}}
                                    <th>Description</th>
                                    <th>Start Time</th>
                                    <th>Due Time</th>
                                    {{--                                    <th>Limit Date</th>--}}
                                    {{--                                    <th>Start Date</th>--}}
                                    {{--                                    <th>P Name</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($lists) > 0)
                                    @foreach($lists as $list)
                                        @php
                                            $str_ID_PROCESS_INST=$list['ID_PROCESS_INST'];;  //ID_PROCESS_INST value at getMyRequests api return data

                                            $wfg_url = "http://8.209.76.37/wfgen/show.aspx?QUERY=PROCESS_INSTANCE_FORM&ID_PROCESS_INST=" . $str_ID_PROCESS_INST . "&FILTER_PROCESSID=-1&ID_USER_DELEGATOR=-1";

                                            //change $wfg_url to Base64 string
                                            $base64_wfg_url=base64_encode($wfg_url);

                                            $username=Auth::user()->id; // use this username first, will change live login user unique ID after complete user synchronization of WFG and POB.

                                            //change $username to Base64 string
                                            $base64_username=base64_encode($username);  //value like d2ZnZW5fYWRtaW4=

                                            $goto_wfg="http://8.209.76.37/wfgen/GoToWFG.aspx?username=".$base64_username."&wfg_url=".$base64_wfg_url;
                                        @endphp
                                        <tr>
                                            {{--                                            <td><a href="{{$goto_wfg}}" target="_blank">{{$list['ID_PROCESS_INST']}}</a> </td>--}}
                                            {{--                                            <td>{{$list['ID_PROCESS']}}</td>--}}
                                            {{--                                            <td>{{$list['TEST']}}</td>--}}
                                            <td><a href="{{$goto_wfg}}" target="_blank">{{$list['NAME']}}</a></td>
                                            {{--                                            <td>{{$list['ID_STATE']}}</td>--}}
                                            {{--                                            <td>{{$list['ID_SUBSTATE']}}</td>--}}
                                            <td>{{$list['DESCRIPTION']}}</td>
                                            <td>{{$list['DATE_OPEN']?date('Y-m-d H:i:s',strtotime($list['DATE_OPEN'])):''}}</td>
                                            <td>{{$list['DATE_LIMIT']?date('Y-m-d H:i:s',strtotime($list['DATE_LIMIT'])):''}}</td>
                                            {{--                                            <td>{{$list['date_close']}}</td>--}}
                                            {{--                                            <td>{{$list['date_limit']}}</td>--}}
                                            {{--                                            <td>{{$list['date_start']}}</td>--}}
                                            {{--                                            <td>{{$list['PNAME']}}</td>--}}

                                        </tr>
                                    @endforeach

                                @endif
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
