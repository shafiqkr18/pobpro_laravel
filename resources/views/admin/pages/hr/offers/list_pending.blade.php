@extends('admin.layouts.default')

@section('title')
    Offers
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
            $("#bulk_offer_form").submit(function () {
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
                $('#bulk_offer_input').val(ids);
                $('#bulk_offer_input_pending').val(ids);

            });

            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });

            //send offer click
            $('#bulk_offer_btn').click(function () {

                var ids = [];
                var $checkedBoxes = $('#offer_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#bulk_offer_input').val('');

                    // Gather IDs
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        ids.push(value);
                    })
                    // Set input value
                    $('#bulk_offer_input').val(ids);
                    console.log('offer ids='+ids);
                    // Show modal
                    //$bulkDeleteModal.modal('show');
                } else {
                    $('#mdlOffer').modal('toggle');

                    // No row selected
                    toastr.warning('You haven&#039;t selected any offer!');
                }
            });

            //approve offers
            $('#bulk_offer_btn_approve').click(function () {
                console.log('approve offer clicked');
                var ids = [];
                var $checkedBoxes = $('#offer_list_pending input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#bulk_offer_input_pending').val('');

                    // Gather IDs
                    let how_much = 0;
                    let user_role = $('#ur').val();
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        let dm = $(this).attr("dm");
                        let hrm = $(this).attr("hrm");
                        let gm = $(this).attr("gm");
                        if(user_role == 'itfpobadmin')
                        {
                        ids.push(value);
                        }else if((user_role == 'DM') && (dm != 1))
                        {
                            ids.push(value);
                        }else if((user_role == 'HRM') && (dm == 1) && (hrm != 1))
                        {
                            ids.push(value);
                        }else if((user_role == 'GM') && (dm == 1) && (hrm == 1) && (gm != 1))
                        {
                            ids.push(value);
                        }else{
                            how_much ++;
                            $('#row_'+value).addClass("highlight");
                            $(this).prop('checked', false);
                        }


                    });
                    // Set input value
                    $('#bulk_offer_input_pending').val(ids);
                    //show error
                    if(how_much> 0)
                    {
                        toastr.warning('('+how_much+') offers can not be approved!');
                    }

                    //as many offers will be unselected so count again
                    let boxed = $('#offer_list_pending input[type=checkbox]:checked').not('.select_all');
                    let boxed_count = boxed.length;
                    if(!boxed_count)
                    {
                        $('#mdlOfferPending').modal('toggle');
                        toastr.warning('You haven&#039;t selected any offer!');
                    }
                } else {
                    $('#mdlOfferPending').modal('toggle');

                    // No row selected
                    toastr.warning('You haven&#039;t selected any offer!');
                }
            });

        });
    </script>
@endsection

@section('content')
    <div class="row wrapper page-heading">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>HR</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Offers</strong>
                </li>
						</ol>
						
						<h2 class="d-flex align-items-center">Offers</h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <input type="hidden" id="pending" name="pending" value="{{$pending}}">
                <input type="hidden" id="ur" name="ur" value="{{$ur}}">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="#">Offers</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="offer_list_pending" style="width: 100%">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="select_all"></th></th>
                                    <th>Status</th>
																		<th>Offer Sent</th>
																		<th>Candidate Approval</th>
																		<th>Candidate</th>
									<th>Old Position</th>
																		<th>New Position</th>
																		<th>Salary</th>
																		<th>Level</th>
																		<th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


{{--                <button  id="bulk_offer_btn"type="button" class="btn btn-primary btm-sm float-right" data-toggle="modal" data-target="#mdlOffer">--}}
{{--                    Send Offer--}}
{{--                </button>--}}

                                <button  id="bulk_offer_btn_approve"type="button" class="btn btn-primary btm-sm float-right mt-3" data-toggle="modal" data-target="#mdlOfferPending">
                                    Approve Offers
                                </button>
            </div>
        </div>
    </div>


    {{--    models here--}}

    <div class="modal inmodal" id="mdlOfferPending" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-clock-o modal-icon"></i>
                    <h4 class="modal-title">Confirmation</h4>
                    <small>Offer Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to Approve these offers?</strong></p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/offers/xple_status')}}" id="bulk_offer_form" method="POST">
                        @csrf
                        <input type="hidden" name="ids" id="bulk_offer_input_pending" value="">
                        <input type="hidden"  name="my_role" value="{{$ur}}">
                        <input type="submit" class="btn btn-danger pull-right offer-confirm"
                               value="Yes, Sure">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="mdlOffer" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-clock-o modal-icon"></i>
                    <h4 class="modal-title">Confirmation</h4>
                    <small>Offer Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to send Offer to selected Candidates?</strong></p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/send_offer_letter_final')}}" id="bulk_offer_form" method="POST">
                        @csrf
                        <input type="hidden" name="ids" id="bulk_offer_input" value="">
                        {{--                    <input type="hidden" id="pos_id" name="pos_id" value="{{$data['position_id']}}">--}}
                        {{--                    <input type="hidden" id="offer_plan_id" name="plan_id" value="{{$data['plan_id']}}">--}}
                        <input type="submit" class="btn btn-danger pull-right offer-confirm"
                               value="Yes, Sure">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



@endsection
