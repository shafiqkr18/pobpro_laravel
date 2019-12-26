@extends('admin.layouts.default')

@section('title')
	View Plan
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/new-pages.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.plan-position-placeholder {
	display: none;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
$(document).ready(function () {
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});
});
</script>
@endsection

@php
$attachments = json_decode($plan->attachments, true);
$approval = ['Pending', 'Approved', 'Rejected'];
@endphp

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item text-muted">
				HR
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/hr-plan') }}">HR Plan</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>View</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/hr-plan') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			View Plan
		</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
		<!-- <a href="" class="btn btn-success btn-sm pull-right">Save</a> -->
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-9">
			<div class="ibox">
				<div class="ibox-content">
					<div class="sk-spinner sk-spinner-three-bounce">
						<div class="sk-bounce1"></div>
						<div class="sk-bounce2"></div>
						<div class="sk-bounce3"></div>
					</div>

					<div class="row">
						<div class="col-lg-12">
							<div class="m-b-md d-flex flex-nowrap align-items-center">
								<h2>
									Plan: {{ $plan->subject }}
									<a href="{{ url('admin/plans/export_plans_pdf/' . $plan->id) }}" class="ml-3">
										<i class="fas fa-file-pdf text-danger"></i>
									</a>

									<a href="{{ url('admin/plans/export_plans/' . $plan->id) }}" class="ml-2">
										<i class="fas fa-file-excel text-navy"></i>
									</a>
								</h2>

								@if ($plan->is_draft)
								<span class="badge ml-2">Draft</span>
								@endif


								<div class="btn-group ml-auto">
                                    @role('GM|itfpobadmin|HRM')
                                    @if($plan->is_approved == 0)
                                        <a href="{{ url('admin/modal/plan') }}" class="btn btn-default btn-sm text-navy" title="Approve it" style="width: 30px" data-url="{{ url('admin/hr-plan/approval/' . $plan->id . '/1') }}" confirmation-modal="plan" data-view="detail"><i class="fa fa-check"></i></a>
                                        <a href="{{ url('admin/modal/plan') }}" class="btn btn-default btn-sm text-danger" title="Reject it" style="width: 30px" data-url="{{ url('admin/hr-plan/approval/' . $plan->id . '/2') }}" confirmation-modal="plan" data-view="detail"><i class="fa fa-times"></i></a>
                                    @endif
                                    @endrole
                                    @role('GM|itfpobadmin|HRM|HR')
                                        @if($plan->created_by == $user->id && $plan->is_approved != 1)
                                            <a href="{{ url('admin/modal/delete') }}" class="btn btn-default btn-sm text-muted" title="Delete" data-url="{{ url('admin/hr-plan/delete/' . $plan->id) }}" confirmation-modal="delete" data-view="detail" style="width: 30px"><i class="fa fa-trash"></i></a>
                                    @endif

									@if ($plan->is_draft)
									<a href="{{ url('admin/modal/plan') }}" class="btn btn-default btn-sm text-success" title="Publish"  data-url="{{ url('admin/hr-plan/approval/' . $plan->id . '/3') }}" confirmation-modal="plan" data-view="detail"><i class="fa fa-send-o"></i></a>
									@endif
                                    @endrole
								</div>

							</div>

						</div>
					</div>

					<div class="row">
						<div class="col-lg-6">
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Status:</dt> </div>
								<div class="col-sm-8 text-sm-left"><dd class="mb-1"><span class="label label-{{ (($plan->is_open==1)?'primary':'default') }}">
                                            {{ (($plan->is_open==1)?'Open':'Closed') }}</span></dd></div>
							</dl>
{{--							<dl class="row mb-0">--}}
{{--								<div class="col-sm-4 text-sm-right"><dt>Created by:</dt> </div>--}}
{{--								<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{$plan->createdBy->name}}</dd> </div>--}}
{{--							</dl>--}}
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt> Positions:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{count($plan->positions)}}</dd></div>
							</dl>
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt>Head Count:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1"><span class="text-navy"> {{$plan->positions->sum('positions_filled')}}/{{$plan->positions->sum('head_count')}}</span> </dd></div>
							</dl>
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right"><dt> Approval:</dt> </div>
								<div class="col-sm-8 text-sm-left"> <dd class="mb-1">  {{ $approval[$plan->is_approved] }}</dd></div>
							</dl>
{{--							<dl class="row mb-0">--}}
{{--								<div class="col-sm-4 text-sm-right"> <dt>Version:</dt></div>--}}
{{--								<div class="col-sm-8 text-sm-left"> <dd class="mb-1"> 	v1.4.2 </dd></div>--}}
{{--							</dl>--}}
						</div>

						<div class="col-lg-6" id="cluster_info">
{{--							<dl class="row mb-0">--}}
{{--								<div class="col-sm-4 text-sm-right">--}}
{{--										<dt>Start Date:</dt>--}}
{{--								</div>--}}
{{--								<div class="col-sm-8 text-sm-left">--}}
{{--										<dd class="mb-1">{{$plan->start_date}}</dd>--}}
{{--								</div>--}}
{{--							</dl>--}}
							<dl class="row mb-0">
								<div class="col-sm-4 text-sm-right">
									<dt>Due Date:</dt>
								</div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1"> {{$plan->end_date}}</dd>
								</div>
							</dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-right">
                                    <dt>Budget:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">USD {{$plan->budget}}</dd>
                                </div>
                            </dl>
{{--							<dl class="row mb-0">--}}
{{--								<div class="col-sm-4 text-sm-right">--}}
{{--									<dt>Participants:</dt>--}}
{{--								</div>--}}
{{--								<div class="col-sm-8 text-sm-left">--}}
{{--									<dd class="project-people mb-1">--}}
{{--										<a href=""><img alt="image" class="rounded-circle" src="img/a3.jpg"></a>--}}
{{--										<a href=""><img alt="image" class="rounded-circle" src="img/a1.jpg"></a>--}}
{{--										<a href=""><img alt="image" class="rounded-circle" src="img/a2.jpg"></a>--}}
{{--										<a href=""><img alt="image" class="rounded-circle" src="img/a4.jpg"></a>--}}
{{--										<a href=""><img alt="image" class="rounded-circle" src="img/a5.jpg"></a>--}}
{{--									</dd>--}}
{{--								</div>--}}
{{--							</dl>--}}
						</div>
					</div>
                    @php
                        $total = $plan->positions->sum('head_count');
                    $filled =  $plan->positions->sum('positions_filled');
                    if ($total != 0) {
				        $filled = floor($filled / $total * 100);

				        } else {
				        $filled = 0;

				        }
                    @endphp
					<div class="row">
							<div class="col-lg-12">
									<dl class="row mb-0">
											<div class="col-sm-2 text-sm-right">
													<dt>Completed:</dt>
											</div>
											<div class="col-sm-10 text-sm-left">
													<dd>
															<div class="progress m-b-1">
																	<div style="width: {{$filled}}%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
															</div>
															<small>Project completed in <strong>{{$filled}}%</strong>. Remaining close the interviews, sign a contract and enrolment.</small>
													</dd>
											</div>
									</dl>
							</div>
					</div>

					@if ($plan->attachments)
					<div class="row">
						<div class="col-lg-12">
							<dl class="row mb-0">
								<div class="col-sm-2 text-sm-right"><dt> Attachments:</dt> </div>
								<div class="col-sm-8 text-sm-left">
									<dd class="mb-1">
										<p class="form-control-static font-weight-bold">
											@foreach ($attachments as $attachment)
											{{ $loop->index > 0 ? ', ' : '' }}
											<a href="{{ asset('/storage/' . $attachment['download_link']) }}" target="_blank" class="text-success">{{ $attachment['original_name'] }}</a>
											@endforeach
										</p>
									</dd>
								</div>
							</dl>
						</div>
					</div>
					@endif

					<div class="row">
						<div class="col-lg-10 offset-lg-1">
							<div id="plan-positions">
								<h4 class="mt-4 mb-4 border-bottom pb-2">Open Positions</h4>

								<div class="table-responsive">
									<table class="table table-striped">
										<thead>
											<tr>
												<th></th>
												<th>Position</th>
												<th>Head Count</th>
												<th>Completed</th>
												<th>Due Date</th>
                                                <th>Budget</th>
											</tr>
										</thead>

										<tbody>
											@if (count($plan->positions) > 0)
												@foreach ($plan->positions as $position)
                                                    @php
                                                        $total = $position->head_count;
                                                    $filled =  $position->positions_filled;
                                                    if ($total != 0) {
                                                        $filled = floor($filled / $total * 100);

                                                        } else {
                                                        $filled = 0;

                                                        }
                                                    @endphp
												<tr>
													<td>
														<i class="fa fa-user text-muted"></i>
													</td>
													<td><a href="{{url('admin/vacancy/shortlisted_by_position/')}}/{{$position->position_id}}/{{$position->plan_id}}" class="text-success pt-0 pb-0 pl-2 pr-2">
                                                            {{ $position->position ? $position->position->title : '' }}</a></td>
													<td>{{$position->positions_filled}}/{{ $position->head_count }}</td>
													<td>
														<div class="small">Completion with {{$filled}}%</div>
														<div class="progress progress-mini flex-col">
															<div style="width: {{$filled}}%;" class="progress-bar"></div>
														</div>
													</td>
													<td>{{ $position->due_date }}</td>
                                                    <td>{{ $position->budget }}</td>
												</tr>
												@endforeach
											@else
											<tr>
												<td colspan="6" class="text-center">No data.</td>
											</tr>
											@endif
										</tbody>
									</table>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
@endsection