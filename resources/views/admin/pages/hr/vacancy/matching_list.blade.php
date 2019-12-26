@extends('admin.layouts.default')

@section('title')
    Candidate Management
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(000000,999999)}}"></script>

    <script>
        $(document).ready(function () {
            $('input[name="row_id"]').on('change', function () {
                var ids = [];
                $('input[name="row_id"]').each(function() {
                    if ($(this).is(':checked')) {
                        ids.push($(this).val());
                    }
                });
                $('.selected_ids').val(ids);
                $('#bulk_delete_input').val(ids);
            });

            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
            });

        });
        window.onload = function () {
            // Bulk delete selectors
            var $bulkDeleteBtn = $('#bulk_delete_btn');
            var $bulkDeleteModal = $('#bulk_delete_modal');
            var $bulkDeleteCount = $('#bulk_delete_count');
            var $bulkDeleteDisplayName = $('#bulk_delete_display_name');
            var $bulkDeleteInput = $('#bulk_delete_input');
            // Reposition modal to prevent z-index issues
            $bulkDeleteModal.appendTo('body');
            // Bulk delete listener
            $bulkDeleteBtn.click(function () {
                console.log('clicked');
                var ids = [];
                var $checkedBoxes = $('#matching_candidates_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $bulkDeleteInput.val('');
                    // Deletion info
                    var displayName = count > 1 ? 'Products' : 'Product';
                    displayName = displayName.toLowerCase();
                    $bulkDeleteCount.html(count);
                    $bulkDeleteDisplayName.html(displayName);
                    // Gather IDs
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        ids.push(value);
                    })
                    // Set input value
                    $bulkDeleteInput.val(ids);
                    console.log('dd='+ids);
                    // Show modal
                    //$bulkDeleteModal.modal('show');
                } else {
                    $('#myModal4').modal('toggle');
                   // $('#myModal4').modal('hide');
                    $('#bulk_delete_modal').modal('hide');
                    // No row selected
                    toastr.warning('You haven&#039;t selected anything to delete');
                }
            });
        }
    </script>


@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Matching Candidates</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ url('admin') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a>HR</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Candidates</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 data-url="{{ url('admin/candidate/create') }}">Matching Candidates</h5>

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
{{--                        <button  id="bulk_delete_btn"type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal4">--}}
{{--                          Short List--}}
{{--                        </button>--}}
{{--                        <a class="btn btn-default btn-create" id="bulk_delete_btn"><i class="fa fa-plus mr-1"></i> <span>Bulk Delete</span></a>--}}
                        <input type="hidden" id="position_id" name="position_id" value="{{$data['position_id']}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover " id="matching_candidates_list" >
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="select_all"></th>
                                    <th>RefNo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Nationality</th>
                                    <th>Location</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Education Level</th>
                                    <th>Position Applied</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-clock-o modal-icon"></i>
                    <h4 class="modal-title">Confirmation</h4>
                    <small>Short List Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Do you really want to short list these candidate? It will be moved to short list page!</p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/short_list_xple_candidate')}}" id="bulk_delete_form" method="POST">
{{--                        <input type="hidden" name="_method" value="DELETE">--}}
                        <input type="hidden" name="_token" value="{{@csrf_token()}}">
                        <input type="hidden" name="ids" id="bulk_delete_input" value="">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Short List">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
{{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
                </div>
            </div>
        </div>
    </div>


@endsection