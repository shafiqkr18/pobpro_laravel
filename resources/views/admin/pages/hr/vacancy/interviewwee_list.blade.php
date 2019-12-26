@extends('admin.layouts.default')

@section('title')
    Candidate List
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
.highlight{
    background-color: #ff000059 !important;
}
</style>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(000000,999999)}}"></script>

    <script>
        function assignToQualified(c_ids=0,position_id=0,plan_id=0) {
            var queryString = 'candidate_ids='+c_ids+'&_token='+$('meta[name=csrf-token]').attr('content')+'&position_id='+position_id+'&plan_id='+plan_id;
            jQuery.ajax({
                url: baseUrl+'/admin/assignToQualified',
                data:queryString,
                type: "POST",
                success:function(data){
                    toastr.success('Candidates assigned to list');
                    $('#myCandidates').modal('hide');
                    $('#myApplicants').modal('hide');
                    $('#interviewee_list').DataTable().ajax.reload();

                },
                error:function (){}
            });
        }
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
                $('#bulk_cn_input').val(ids);
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
                var $checkedBoxes = $('#interviewee_list input[type=checkbox]:checked').not('.select_all');
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
                    let how_much = 0;
                    $.each($checkedBoxes, function () {

                        var value = $(this).val();
                        let prepared_approved = $(this).attr("prepared_approved");
                        if(prepared_approved == 1)
                        {
                            how_much ++;
                            console.log("----"+how_much);
                            $('#row_'+value).addClass("highlight");
                            $(this).prop('checked', false);

                        }else{
                        ids.push(value);
                        }
                    });
                    // Set input value
                    $bulkDeleteInput.val(ids);
                    console.log('dd='+ids);
                    if(how_much> 0)
                    {
                        if(count == 1)
                        {
                            $('#myModal4').modal('toggle');
                            $('#bulk_delete_modal').modal('hide');
                        }

                        toastr.warning('Offer already approved for ('+how_much+') candidates! These will be ignored!');
                    }
                } else {
                    $('#myModal4').modal('toggle');
                    // $('#myModal4').modal('hide');
                    $('#bulk_delete_modal').modal('hide');
                    // No row selected
                    toastr.warning('You haven&#039;t selected any candidate!');
                }
            });

            $('#bulk_cn_btn').click(function () {
                console.log('clicked');
                var ids = [];
                var $checkedBoxes = $('#interviewee_list input[type=checkbox]:checked').not('.select_all');
                var count = $checkedBoxes.length;
                if (count) {
                    // Reset input value
                    $('#bulk_cn_input').val('');
                    // Deletion info
                    var displayName = count > 1 ? 'Candidates' : 'Candidate';
                    displayName = displayName.toLowerCase();
                    $bulkDeleteCount.html(count);
                    $bulkDeleteDisplayName.html(displayName);
                    // Gather IDs
                    let how_much = 0;
                    $.each($checkedBoxes, function () {
                        var value = $(this).val();
                        let is_offered = $(this).attr("offer");
                        if(is_offered == 0)
                        {
                            how_much ++;
                            console.log("----"+how_much);
                            $('#row_'+value).addClass("highlight");
                            $(this).prop('checked', false);

                        }else{
                        ids.push(value);
                        }



                    });
                    // Set input value
                    $('#bulk_cn_input').val(ids);
                    //console.log('dd='+ids);
                    // Show modal
                    //$bulkDeleteModal.modal('show');
                    if(how_much> 0)
                    {
                        toastr.warning('Offer did not prepared for ('+how_much+') candidates! These will be ignored!');
                    }
                } else {
                    $('#myModal5').modal('toggle');
                    // $('#myModal4').modal('hide');
                    $('#bulk_cn_modal').modal('hide');
                    // No row selected
                    toastr.warning('You haven&#039;t selected any candidate!');
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
                    let position_id = $('#position_id').val();
                    let plan_id = $('#plan_id').val();
                    assignToQualified(c_ids,position_id,plan_id);
                } else {

                    // No row selected
                    toastr.warning('You haven&#039;t selected any Candidate');
                    $('#myCandidates').modal('toggle');
                }
            });
        }
    </script>

    <script>
        $(document).ready(function(){
            $('#myCandidates_list').DataTable({
                pageLength: 10,
                responsive: true,
                //"bFilter" : false,
                "bLengthChange": false

            });
        });
    </script>
@endsection

@section('content')
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
                    <strong>Candidates </strong>
                </li>
            </ol>
            <h2 class="d-flex align-items-center">Candidates List</h2>
        </div>
        <div class="col-lg-2 d-flex align-items-center justify-content-end">

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
			<ul class="nav nav-tabs border-0">
				<li class="nav-item">
					<a class="nav-link border-0" href="{{url('admin/vacancy/shortlisted_by_position/')}}/{{$data['position_id']}}/{{$data['plan_id']}}">Shortlist</a>
				</li>
				<li class="nav-item">
					<a class="nav-link border-0 active text-success" href="{{url('admin/vacancy/interviewee_list/')}}/{{$data['position_id']}}/{{$data['plan_id']}}">Qualified</a>
				</li>
				<li class="nav-item">
					<a class="nav-link border-0" href="{{ url('admin/contract-onboarding') }}/{{$data['position_id']}}/{{$data['plan_id']}}">Contract &amp; Onboarding</a>
				</li>
			</ul>

        <div class="form-row">
            <div class="col-lg-9">
                <div class="ibox ">

                    <div class="ibox-content mb-3">

												<h5 data-url="#">Candidates For <strong>{{$data['position']->title}}</strong></h5>
                        @if (($data['plan']->is_approved == 1) && ($data['plan']->is_open == 1))
												<div class="row-actions btn-group float-right mb-3">
													<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myCandidates" title="Add to list">
														<i class="fa fa-plus text-navy"></i>
													</button>
												</div>
                        @endif

                        <input type="hidden" id="position_id" name="position_id" value="{{$data['position_id']}}">
                        <input type="hidden" id="plan_id" name="plan_id" value="{{$data['plan_id']}}">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover " id="interviewee_list" >
                                <thead>
                                <tr>
																		<th><input type="checkbox" class="select_all"></th>
																		<th></th>
                                    <th>RefNo</th>
                                    <th>Name</th>
                                    <th>Nationality</th>
                                    <th>Location</th>
                                    <th>Gender</th>
                                    <th>Age</th>
                                    <th>Education Level</th>
																		<th>Salary</th>
																		<th>Level</th>
                                </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
								</div>

								@if (($data['plan']->is_approved == 1) && ($data['plan']->is_open == 1))
								<button  id="bulk_cn_btn" type="button" class="btn btn-success btm-sm float-right ml-2" data-toggle="modal" data-target="#myModal5">
                                    Prepare Contract
								</button>

								<button  id="bulk_delete_btn" type="button" class="btn btn-primary btm-sm float-right" data-toggle="modal" data-target="#myModal4">
										Prepare Offer
								</button>
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
                    <small>Offer Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to Prepare Offer to selected Candidates?</strong></p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/send_offer')}}" id="bulk_delete_form" method="GET">

                        <input type="hidden" name="ids" id="bulk_delete_input" value="">
                        <input type="hidden" id="pos_id" name="pos_id" value="{{$data['position_id']}}">
                        <input type="hidden" id="offer_plan_id" name="plan_id" value="{{$data['plan_id']}}">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Sure">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal inmodal" id="myModal5" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header" style="text-align: center">
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-clock-o modal-icon"></i>
                    <h4 class="modal-title">Confirmation</h4>
                    <small>Contract Confirmation</small>
                </div>
                <div class="modal-body">
                    <p><strong>Are you sure you want to Prepare Contract to selected Candidates?</strong></p>
                </div>
                <div class="modal-footer">
                    <form action="{{url('admin/send_contract')}}" id="bulk_cn_form" method="GET">

                        <input type="hidden" name="ids" id="bulk_cn_input" value="">
                        <input type="hidden" id="pos_id" name="pos_id" value="{{$data['position_id']}}">
                        <input type="hidden" id="contract_plan_id" name="plan_id" value="{{$data['plan_id']}}">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="Yes, Sure">
                    </form>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

		@php
    $filtered_candidates = $data['candidates']->where('is_online', 0);
    $plucked = $data['ex_positions']->pluck('ex_position_id')->toArray();
    $filtered_candidates = $filtered_candidates->whereIn('old_position_id',$plucked);
    @endphp


    <div class="modal inmodal fade" id="myCandidates" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Candidates</h4>
                    <small class="font-bold">Add candidates to the Qualified list.</small>
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

@endsection
