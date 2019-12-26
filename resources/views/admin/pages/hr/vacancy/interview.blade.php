@extends('admin.layouts.default')

@section('title')
   Interview
@endsection

@section('styles')
    <!-- <link href="{{ URL::asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"> -->
    <link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    <!-- <script src="{{ URL::asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script> -->
    <script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{ rand(1111,9999) }}"></script>
    <script>

        $(document).ready(function(){

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });

            $('.input-group.date').datepicker({
                todayBtn: 'linked',
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        });
    </script>
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Schedule Interview</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    HR
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/candidates') }}">Candidates</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Interview</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">
            <!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Interview Details</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li>
                                    <a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li>
                                    <a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <form role="form" id="frm_interview" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 b-r">

                                    <div class="form-group">
                                        <label>Ref No</label>
                                        <input type="text" class="form-control form-control-sm" value="{{ $data['cn_no'] }}" id="reference_no" name="reference_no">
                                    </div>

                                    <div class="form-group">
                                        <label>Subject</label>
                                        <input type="text" class="form-control form-control-sm" id="subject" name="subject">
                                    </div>
                                    <div class="form-group">
                                        <label>Interview Date</label>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control form-control-sm" id="interview_date" name="interview_date">
                                        </div>
                                    </div>
                                </div>




                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" class="form-control form-control-sm" id="location" name="location">
                                    </div>
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea name="notes" id="notes" rows="4" class="form-control"></textarea>
                                        <input type="hidden" name="ids" value="{{$data['ids']}}">
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <a href="javascript:void(0)" id="save_interview" class="btn btn-success btn-sm pull-right">Save & Send</a>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection