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

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="#">Process List</h5>

                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover " id="wfg_process_list" style="width: 100%">
                                <thead>
                                <tr>

                                    <th >Process ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
{{--                                    <th>Status</th>--}}

{{--                                    <th>Create Date</th>--}}
{{--                                    <th>Update Date</th>--}}
{{--                                    <th>Category</th>--}}
{{--                                    <th>Access Level</th>--}}

                                </tr>
                                </thead>
                                <tbody>
                                @if(count($lists) > 0)
                                    @foreach($lists as $res)
                                        @php
                                            $str_processname=$res['NAME'];  //NAME value at getProcessesList api return data, like  REQUEST_OF_VISA
                                            $str_backurl_submit="http://itforce.pobpro.com/admin/wfg-my-requests";  //pob show my request data page url -- full url
                                            $str_backurl_cancel="http://itforce.pobpro.com/admin/wfg-process-list";  //pob show process list data page url-- full url(e.g: http://itforce.pobpro.com/admin/wfg-process-list)
                                            $wfg_url="http://8.209.76.37/wfgen/show.aspx?QUERY=START&P=".$str_processname."&BACKURL_SUBMIT=".$str_backurl_submit."&BACKURL_CANCEL=".$str_backurl_cancel;
                                            //change $wfg_url to Base64 string
                                            $base64_wfg_url=base64_encode($wfg_url);
                                            $username=Auth::user()->id;  // use this username first, will change live login user unique ID after complete user synchronization of WFG and POB.
                                            //change $username to Base64 string
                                            $base64_username=base64_encode($username);  //value like d2ZnZW5fYWRtaW4=
                                            $goto_wfg="http://8.209.76.37/wfgen/GoToWFG.aspx?username=".$base64_username."&wfg_url=".$base64_wfg_url;
                                        @endphp
                                        <tr>

                                            <td>{{$res['ID_PROCESS']}}</td>
                                            <td><a href="{{$goto_wfg}}">{{$res['NAME']}}</a> </td>
                                            <td>{{$res['DESCRIPTION']}}</td>
{{--                                            <td>{{$res['ID_PROCESS_STATUS']}}</td>--}}
{{--                                            <td>{{$res['DATE_CREATION']?date('Y-m-d H:i:s',strtotime($res['DATE_CREATION'])):''}}</td>--}}
{{--                                            <td>{{$res['DATE_UPDATE']?date('Y-m-d H:i:s',strtotime($res['DATE_UPDATE'])):''}}</td>--}}
{{--                                            <td>{{$res['CATEGORYNAME']}}</td>--}}
{{--                                            <td>{{$res['ACCESSLEVEL']}}</td>--}}

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
