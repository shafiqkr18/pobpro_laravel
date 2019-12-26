@extends('admin.layouts.default')

@section('title')
    Sections Requests
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
    <link href="{{ URL::asset('css/plugins/textSpinners/spinners.css') }}" rel="stylesheet">

    <style>
        table.dataTable {
            border-collapse: collapse !important;
        }
    </style>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(11,99)}}"></script>
    <script>
        $(document).ready(function () {
            $('#section_list_pending').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},


                ]

            });
            $("#bulk_section_form").submit(function () {
                $(".offer-confirm").attr("disabled", true);
                return true;
            });
        });
        $(document).ready(function () {
            $('input[name="row_id"]').on('change', function () {
                var ids = [];
                $('input[name="row_id"]').each(function() {
                    if ($(this).is(':checked')) {
                        ids.push($(this).val());
                    }
                });
                $('.selected_ids').val(ids);

                $('#bulk_section_input_pending').val(ids);

            });

            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });



            //approve offers
            $('#bulk_section_btn_approve').click(function () {

                var ids = [];
                var $checkedBoxes = $('#section_list_pending input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#bulk_section_input_pending').val('');

                    // Gather IDs

                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        ids.push(value);


                    });
                    // Set input value
                    $('#bulk_section_input_pending').val(ids);



                } else {
                    $('#mdlSectionPending').modal('toggle');

                    // No row selected
                    toastr.warning('You haven&#039;t selected any record!');
                }
            });

        });
    </script>
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Pending Sections</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>Management</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Pending Requests</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" id="pending" name="pending" value="{{$pending}}">
                <input type="hidden" id="type" name="type" value="{{$type}}">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="#">Sections Requests</h5>


                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="section_list_pending" style="width: 100%">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="select_all"></th></th>
                                    <th>Section Code</th>
                                    <th>Short Name</th>
                                    <th>Full Name</th>
                                    <th>Department</th>
                                    <th>Request Date</th>
                                    <th>Status</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requested_sections as $section)
                                    <tr>
                                        <td><input type="checkbox"  name="row_id" id="checkbox_{{$section->id}}" value="{{$section->id}}"></td>
                                        <td>{{$section->section_code}}</td>
                                        <td>{{$section->short_name}}</td>
                                        <td>{{$section->full_name}}</td>
                                        <td>{{$section->department ? $section->department->department_short_name : ''}}</td>
                                        <td>{{$section->created_at}}</td>
                                        <td>{{$section->is_approved ? "Approved" : "Pending"}}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>



                <button  id="bulk_section_btn_approve"type="button" class="btn btn-primary btm-sm float-right" data-toggle="modal" data-target="#mdlSectionPending">
                    Approve Section(s)
                </button>
            </div>
        </div>
    </div>


    {{--    models here--}}

    <div class="modal inmodal" id="mdlSectionPending" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-clock-o modal-icon"></i>
                    <h4 class="modal-title">Confirmation</h4>
                    <small>Section Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to Approve these sections?</strong></p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/section_requests/section_pending_status')}}" id="bulk_section_form" method="POST">
                        @csrf
                        <input type="hidden" name="ids" id="bulk_section_input_pending" value="">
                        <input type="hidden"  name="type" value="{{$type}}">
                        <input type="submit" class="btn btn-danger pull-right offer-confirm"
                               value="Yes, Sure">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>





@endsection
