@extends('admin.layouts.default')

@section('title')
    Shortlisted Candidates
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
.row-actions .dropdown-toggle::after {
	display: none;
}

table.dataTable {
	border-collapse: collapse !important;
}
</style>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(000000,999999)}}"></script>

    <script>
        $(document).ready(function () {

            $('.btn-create').hide();
            $('input[name="row_id"]').on('change', function () {
                var ids = [];
                $('input[name="row_id"]').each(function() {
                    if ($(this).is(':checked')) {
                        ids.push($(this).val());
                    }
                });
                $('.selected_ids').val(ids);
                $('#bulk_delete_input').val(ids);
                $('#rmv_ids').val(ids);

            });

            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
						});

						$(document).on('click', '#todo li', function (e) {
							e.preventDefault();

							window.location = $(this).attr('data-url');
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
                var $checkedBoxes = $('#shortlisted_position_candidates_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $bulkDeleteInput.val('');
                    // Deletion info
                    var displayName = count > 1 ? 'Candidates' : 'Candidate';
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
                    toastr.warning('You haven&#039;t selected any Candidate');
                }
            });


            $('#assign_automatch').click(function () {
                console.log('clicked');
                var c_ids = [];
                var $checkedBoxes = $('#myAutoMatch_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#automatch_ids').val('');


                    // Gather IDs
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        c_ids.push(value);
                    })
                    // Set input value
                    $('#automatch_ids').val(c_ids);
                    console.log('dd='+c_ids);
                    // Show modal
                    $('#myAutoMatch').modal('toggle');
                    assignPersonTOList(c_ids);
                } else {

                    // No row selected
                    toastr.warning('You haven&#039;t selected any Candidate');
                    $('#myAutoMatch').modal('toggle');
                }
            });


            $('#assign_candidate').click(function () {
                console.log('clicked');
                var c_ids = [];
                var $checkedBoxes = $('#myCandidates_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#candidate_ids').val('');


                    // Gather IDs
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        c_ids.push(value);
                    })
                    // Set input value
                    $('#candidate_ids').val(c_ids);
                    console.log('dd='+c_ids);
                    // Show modal
                    //$('#myCandidates').modal('show');
                    assignPersonTOList(c_ids);
                } else {

                    // No row selected
                    toastr.warning('You haven&#039;t selected any Candidate');
                    $('#myCandidates').modal('toggle');
                }
            });
            $('#assign_applicant').click(function () {
                console.log('clicked');
                var c_ids = [];
                var $checkedBoxes = $('#myApplicants_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#applicant_ids').val('');


                    // Gather IDs
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        c_ids.push(value);
                    })
                    // Set input value
                    $('#applicant_ids').val(c_ids);
                    console.log('dd='+c_ids);
                    // Show modal
                    //$('#myCandidates').modal('show');
                    assignPersonTOList(c_ids);
                } else {

                    // No row selected
                    toastr.warning('You haven&#039;t selected any Applicant');
                    $('#myApplicants').modal('toggle');
                }
            });

            $('#btnRmvPopup').click(function () {
                var ids = [];
                var $checkedBoxes = $('#shortlisted_position_candidates_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#rmv_ids').val('');

                    // Gather IDs
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        ids.push(value);
                    })
                    // Set input value
                    $('#rmv_ids').val(ids);
                    console.log('dd='+ids);
                    // Show modal
                    //$bulkDeleteModal.modal('show');
                } else {
                    $('#rmvFrmLst').modal('toggle');

                    // No row selected
                    toastr.warning('You haven&#039;t selected any Candidate');
                }

            });

            $('#btn_rmvFrmLst').click(function () {
                removePersonFromList();
            });
        }

        function assignPersonTOList(c_ids=0) {
            var queryString = 'candidate_ids='+c_ids+'&_token='+$('meta[name=csrf-token]').attr('content')+'&po_id='+$('#position_id').val()+'&plan_id='+$('#plan_id').val();
            jQuery.ajax({
                url: baseUrl+'/admin/assignPersonTOList',
                data:queryString,
                type: "POST",
                success:function(data){
                    toastr.success('Candidates assigned to list');
                    $('#myCandidates').modal('hide');
                    $('#myApplicants').modal('hide');
                    $('#shortlisted_position_candidates_list').DataTable().ajax.reload();

                },
                error:function (){}
            });
        }

        function removePersonFromList() {
            let ids = $('#rmv_ids').val();
            var queryString = 'ids='+ids+'&_token='+$('meta[name=csrf-token]').attr('content');
            jQuery.ajax({
                url: baseUrl+'/admin/removePersonTOList',
                data:queryString,
                type: "POST",
                success:function(data){
                    toastr.warning('Candidate Removed From list');
                    $('#rmvFrmLst').modal('hide');

                    $('#shortlisted_position_candidates_list').DataTable().ajax.reload();

                },
                error:function (){}
            });

				}
    </script>
    <script>
        $(document).ready(function(){
            $('#myApplicants_list,#myCandidates_list,#myAutoMatch_list').DataTable({
                pageLength: 10,
                responsive: true,
                //"bFilter" : false,
                "bLengthChange": false

            });
        });
    </script>
@endsection

@section('content')
    @php

    $filtered_applicants = $data['candidates']->where('is_online', 1);
    $filtered_candidates = $data['candidates']->where('is_online', 0);

    @endphp
    <div class="row wrapper page-heading">
        <div class="col-lg-10">
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
					<h2 class="d-flex align-items-center">
						Shortlisted candidates
							@if($data['position'])
									{{" For ".$data['position']->title}}
							@endif
					</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">



			<ul class="nav nav-tabs border-0">
				<li class="nav-item">
					<a class="nav-link border-0 active text-success" href="{{url('admin/vacancy/shortlisted_by_position/')}}/{{$data['position_id']}}/{{$data['plan_id']}}">Shortlist</a>
				</li>
				<li class="nav-item">
					<a class="nav-link border-0" href="{{url('admin/vacancy/interviewee_list/')}}/{{$data['position_id']}}/{{$data['plan_id']}}">Qualified</a>
				</li>
				<li class="nav-item">
					<a class="nav-link border-0" href="{{ url('admin/contract-onboarding') }}/{{$data['position_id']}}/{{$data['plan_id']}}">Contract &amp; Onboarding</a>
				</li>
			</ul>

        <div class="form-row">
            <div class="col-lg-9">
                <div class="ibox ">

                    <div class="ibox-content border-top-0">
                        @if (($plan->is_approved == 1) && ($plan->is_open == 1))
												<div class="row-actions btn-group float-right mb-3">
													<button id="btnRmvPopup" type="button" data-toggle="modal" data-target="#rmvFrmLst" class="btn btn-default btn-sm" title="Remove from list">
														<i class="fa fa-trash text-danger"></i>
													</button>

													<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Add to list">
														<i class="fa fa-plus text-navy"></i>
													</button>

													<div class="dropdown-menu dropdown-menu-right">
														<h4 class="dropdown-header m-0 pl-2 pr-2 text-left"><small>Add person from:</small></h4>
														<div class="dropdown-divider m-0"></div>
														<a class="dropdown-item pl-2 pr-2" href="#" data-toggle="modal" data-target="#myApplicants">Applicants</a>
														<a class="dropdown-item pl-2 pr-2" href="#" data-toggle="modal" data-target="#myCandidates">Candidates Database</a>
														<a class="dropdown-item pl-2 pr-2" href="#" data-toggle="modal" data-target="#myAutoMatch">Suggested</a>
													</div>
												</div>
                        @endif

                        <input type="hidden" id="position_id" name="position_id" value="{{$data['position_id']}}">
                        <input type="hidden" id="plan_id" name="plan_id" value="{{$data['plan_id']}}">
                        <input type="hidden" id="applicant_ids" value="">
                        <input type="hidden" id="candidate_ids" value="">
                        <input type="hidden" id="automatch_ids" value="">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover " id="shortlisted_position_candidates_list" >
                                <thead>
                                <tr>
                                    <th><input type="checkbox" class="select_all"></th>
                                    <th>RefNo</th>
                                    <th>Interview Status</th>
                                    <th>Name</th>
                                    <th>Nationality</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Education</th>
                                    <th>Location</th>
                                    <th></th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                        <!-- <br><br>
                        <button  id="bulk_delete_btn"type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal4">
                            Schedule Interview
                        </button> -->
                    </div>

								</div>
                @if (($plan->is_approved == 1) && ($plan->is_open == 1))
				<button  id="bulk_delete_btn" type="button" class="btn btn-primary btn-sm float-right mt-3" data-toggle="modal" data-target="#myModal4">Schedule Interview</button>
                @else
                    <span class="badge">This plan is pending for approval or closed!</span>
                @endif
						</div>

						<div class="col-lg-3">
							@include('admin.partials.interviews_list')
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
                    <small>Interview Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to call these candidates for interview?</strong></p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/call_for_interview')}}" id="bulk_delete_form" method="GET">

                        <input type="hidden" name="ids" id="bulk_delete_input" value="">
                        <input type="hidden" name="plan_id" value="{{$data['plan_id']}}">
                        <input type="hidden" name="position_id" value="{{$data['position_id']}}">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Sure">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal" id="rmvFrmLst" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-clock-o modal-icon"></i>
                    <h4 class="modal-title">Confirmation</h4>
                    <small>Remove From List Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to remove these candidates from list?</strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="rmv_ids" id="rmv_ids" value="">
                     <input type="button" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Sure" id="btn_rmvFrmLst">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="myApplicants" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Applicants</h4>
                    <small class="font-bold">Add applicants to the list.</small>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myApplicants_list" >
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Education</th>
                                <th>Location</th>
{{--                                <th>Action</th>--}}
                            </tr>
                            </thead>

                            <tbody>
                            @if($filtered_applicants->count()>0)
                            @foreach($filtered_applicants as $applicant)
                                <tr>
                                    <td><input type="checkbox" value="{{$applicant->id}}" name="" class="i-checks"  /></td>
                                <td>{{$applicant->name}}</td>
                                <td>{{$applicant->email}}</td>
                                <td>{{$applicant->gender}}</td>
                                <td>{{findEducation($applicant->education_level)}}</td>
                                <td>{{$applicant->location}}</td>
                                </tr>
                            @endforeach
                                @else
                                <tr><td></td><td></td><td><p>No Data Found</p></td><td></td><td></td><td></td></tr>

                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="assign_applicant">Assign To List</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="myCandidates" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Candidates</h4>
                    <small class="font-bold">Add candidates to the list.</small>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myCandidates_list" >
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Education</th>
                                <th>Location</th>
                                {{--                                <th>Action</th>--}}
                            </tr>
                            </thead>

                            <tbody>
                            @if($filtered_candidates->count()>0)
                                @foreach($filtered_candidates as $candidate)
                                    <tr>
                                    <td><input type="checkbox" value="{{$candidate->id}}" name="" class="i-checks"  /></td>
                                    <td>{{$candidate->name}}</td>
                                    <td>{{$candidate->email}}</td>
                                    <td>{{$candidate->gender}}</td>
                                    <td>{{findEducation($candidate->education_level)}}</td>
                                    <td>{{$candidate->location}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td></td><td></td><td><p>No Data Found</p></td><td></td><td></td><td></td></tr>

                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="assign_candidate">Assign To List</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="myAutoMatch" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Auto Match Candidates</h4>
                    <small class="font-bold">Add candidates to the list.</small>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="myAutoMatch_list" >
                            <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Education</th>
                                <th>Location</th>
                                {{--                                <th>Action</th>--}}
                            </tr>
                            </thead>

                            <tbody>
                            @if($data['candidates']->count()>0)
                                @foreach($data['candidates'] as $cn)
                                    <tr>
                                        <td><input type="checkbox" value="{{$cn->id}}" name="" class="i-checks"  /></td>
                                        <td>{{$cn->name}}</td>
                                        <td>{{$cn->email}}</td>
                                        <td>{{$cn->gender}}</td>
                                        <td>{{findEducation($cn->education_level)}}</td>
                                        <td>{{$cn->location}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td></td><td></td><td><p>No Data Found</p></td><td></td><td></td><td></td></tr>

                            @endif

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="assign_automatch">Assign To List</button>
                </div>
            </div>
        </div>
    </div>

@endsection