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
            $('#wfg_process_list').DataTable({
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
                    <strong>List</strong>
                </li>
            </ol>

            <h2 class="d-flex align-items-center">{{__('messages.process-procedures')}}</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">
            <a href="{{url('admin/wfg-action-list')}}" class="btn btn-success " style="margin-right:5px">Open</a>
            <a href="{{url('admin/wfg-action-list-closed')}}" class="btn btn-warning">Closed</a>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="#">My Actions </h5>

                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover " id="wfg_process_list" style="width: 100%">
                                <thead>
                                <tr>

                                    <th >Request #</th>
                                    <th>Process</th>
                                    <th>Action</th>
                                    <th>Launched</th>
                                    <th>Time Limit</th>


                                </tr>
                                </thead>
                                <tbody>
                                @if(count($lists) > 0)
                                    @foreach($lists as $res)
                                        @php
                                            $str_ID_PROCESS_INST=$res['ID_PROCESS_INST'];
                                        $wfg_url = "http://8.209.76.37/wfgen/show.aspx?QUERY=PROCESS_INSTANCE_FORM&ID_PROCESS_INST=" .$str_ID_PROCESS_INST . "&FILTER_PROCESSID=-1&ID_USER_DELEGATOR=-1";
                                        $base64_wfg_url=base64_encode($wfg_url);
                                        $username=Auth::user()->id;
                                        $base64_username=base64_encode($username);
                                        $goto_wfg="http://8.209.76.37/wfgen/GoToWFG.aspx?username=".$base64_username."&wfg_url=".$base64_wfg_url;

                                        //process
                                        $str_ID_PROCESS_INST=$res['ID_PROCESS_INST'];
                                        $str_ID_ACTIVITY_INST=$res['ID_ACTIVITY_INST'];
                                        $str_ID_APPLICATION=$res['ID_APPLICATION'];

                                        $str_openurl = "http://8.209.76.37/wfgen/show.aspx?QUERY=APPLICATION_START&ID_PROCESS_INST=" . $str_ID_PROCESS_INST .
                      "&ID_ACTIVITY_INST=" . $str_ID_ACTIVITY_INST . "&ID_APPLICATION=" . $str_ID_APPLICATION;


                                        $base64_str_openurl=base64_encode($str_openurl);

                                        $username1=Auth::user()->id;  // use this username first, will change live login user unique ID after complete user synchronization of WFG and POB.

                                                //change $username to Base64 string
                                            $base64_username1=base64_encode($username1);  //value like d2ZnZW5fYWRtaW4=

                                        $goto_wfg2="http://8.209.76.37/wfgen/GoToWFG.aspx?username=".$base64_username1."&wfg_url=".$base64_str_openurl;
                                        @endphp
                                        <tr>

                                            <td><a href="{{$goto_wfg}}" target="_blank">{{$res['ID_PROCESS_INST']}}</a> </td>
                                            <td>{{$res['PNAME']}}</td>
                                            <td><a href="{{$goto_wfg2}}" target="_blank">{{$res['NAME']}}</a></td>
{{--                                            <td>{{$res['NAME']}}</td>--}}
{{--                                            <td>{{$res['DESCRIPTION']}}</td>--}}
                                            <td>{{$res['DATE_OPEN']?date('Y-m-d H:i:s',strtotime($res['DATE_OPEN'])):''}}</td>
                                            <td>{{$res['DATE_LIMIT']?date('Y-m-d H:i:s',strtotime($res['DATE_LIMIT'])):''}}</td>


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
