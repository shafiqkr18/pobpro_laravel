@extends('admin.layouts.default')

@section('title')
	Letter Detail
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link href="{{ URL::asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<style>
.ibox-title {
	min-height: auto;
	padding: 10px 15px;
	text-align: center;
	line-height: 1;
}

.alert {
	padding: 10px 15px;
}

table.table-mail tr td {
	padding: 8px;
}

.table-mail .mail-date {
	padding-right: 8px;
}

.new-topic-task > input {
	height: 24px;
}

.topics > a:not(.assigned),
.tasks > a:not(.assigned) {
	background: transparent;
	color: #1c84c6;
}

.select2-container {
	z-index: 99999 !important;
	width: 100% !important;
}

.form-group.form-inline {
	padding: 0;
}

.form-group.form-inline > label {
	width: 70px;
	min-width: 70px;
	justify-content: center;
}

.note-editor {
	z-index: 99999 !important;
}

.note-btn-group > .note-btn {
	padding: 2px 6px;
}

.note-editing-area {
	padding-top: 40px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/correspondence.js?v=') }}{{rand(111,999)}}"></script>
@endsection

@section('content')
    @php
        $attachments = $letter->attachment_files ? json_decode($letter->attachment_files, true) : null;
    @endphp
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">

		<div class="col-lg-7">
			<div class="ibox border-bottom">
				<div class="ibox-content">
					<h3 class="d-flex align-items-start mb-4">
						<span class="mr-5">{{$letter->subject}}
                            {!! LetterStatusBtn($letter->pob_status) !!}
                        </span>

						<div class="actions ml-auto text-nowrap">
							<a href="{{ asset('storage/' . $attachments[0]['download_link']) }}" target="_blank" class="btn btn-xs btn-white mr-1">
								<i class="fas fa-print"></i> Print
							</a>
                            	<a href="{{ asset('storage/' . $attachments[0]['download_link']) }}" target="_blank" class="btn btn-xs btn-white ml-auto">
                            	<i class="fas fa-download mr-1"></i> Download
                            	</a>

{{--							<a href="" class="btn btn-xs btn-white">--}}
{{--								<i class="fas fa-edit"></i> Edit--}}
{{--							</a>--}}
						</div>
					</h3>

					<div class="d-flex align-items-start flex-nowrap">
						<div class="mr-5">
							<div class="d-flex align-items-start mb-1">
								<label class="text-muted mb-0">Ref No:</label>
								<span class="form-control-static font-weight-bold ml-2">{{$letter->reference_no}}</span>
							</div>

							<div class="d-flex align-items-start mb-1">
								<label class="text-muted mb-0">From:</label>
								<span class="form-control-static font-weight-bold ml-2">
                                    @if($letter->direction == 'IN')
                                        {{$letter->from? $letter->from->company: ''}}
                                        @else
                                        {{$letter->from ? $letter->from->name: ''}}
                                    @endif
                                </span>
							</div>

							<div class="d-flex align-items-start mb-1">
								<label class="text-muted mb-0">To:</label>
								<span class="form-control-static font-weight-bold ml-2">
                                    @if($letter->direction == 'OUT')
                                        {{$letter->to ? $letter->to->company : ''}}
                                    @else
                                        {{$letter->to? $letter->to->name: ''}}
                                    @endif
                                </span>
							</div>
						</div>

						<small class="d-flex flex-column form-control-static ml-auto text-muted">{{date("F j, Y, g:i a",strtotime($letter->msg_date))}}
                            <span class="align-self-end">({{time_ago($letter->msg_date)}} ago)</span></small>
					</div>

				</div>
			</div>

			<div class="ibox border-bottom">
				<div class="ibox-content">
                    <p>
                       {!! $letter->contents !!}
                    </p>
				</div>
			</div>

			<div class="ibox">
				<div class="ibox-content">
					<h5 class="d-flex align-items-center mb-3">
						Letter Preview
{{--						<a href="" class="btn btn-xs btn-white ml-auto">--}}
{{--							<i class="fas fa-download mr-1"></i> Download--}}
{{--						</a>--}}

{{--						<a href="" class="btn btn-xs btn-white ml-2">--}}
{{--							<i class="fas fa-print"></i> Print--}}
{{--						</a>--}}
					</h5>
                    {{--http://pobpro.itforce-tech.com/admin/Letters/MFPD-IT-AOS-637%20Using%20Huawei%20Technology.pdf--}}
                    @if($attachments)
					<div class="attachment">
						<embed src="{{ asset('storage/' . $attachments[0]['download_link']) }}" type="application/pdf" width="100%" height="900px">
					</div>
                        @else
					<div class="attachment">
                            <div class="alert alert-warning">
                                <strong>Warning!</strong> There is no file to view it.
					</div>
				</div>
                        @endif
				</div>
			</div>
		</div>

		<div class="col-lg-5">
			<div class="ibox mb-4">
				<div class="alert alert-success m-0 text-center">
					<h5 class="m-0">
						<i class="fas fa-user-circle"></i> Contact
					</h5>
				</div>
                @php

                if($letter->direction == 'IN')
                {
                $addressDetails = $letter->from;
                }else{
                 $addressDetails = $letter->to;
                }
                $avatar = $addressDetails && $addressDetails->contact_person_avatar ? json_decode($addressDetails->contact_person_avatar, true) : null;
				$company_logo = $addressDetails && $addressDetails->company_logo ? json_decode($addressDetails->company_logo, true) : null;
                @endphp
				<div class="ibox-content p-0">
					<div class="contact-box border-0 mb-0">
						<a class="row" href="{{ url('admin/correspondence/address/detail/' . $addressDetails->id) }}">
							<div class="col-4">
								<div class="text-center">
                                    @if($company_logo)
									<img alt="image" class="rounded-circle m-t-xs img-fluid"
                                         src="{{ asset('/storage/' . $company_logo[0]['download_link']) }}">
                                    @else
                                        <img alt="image" class="rounded-circle m-t-xs img-fluid" src="{{ asset('img/avatar-default.jpg') }}" style="width: 72px; height: 72px; object-fit: cover;">
                                    @endif
									<div class="m-t-xs font-bold">{{$addressDetails->position}}</div>
								</div>
							</div>

							<div class="col-8">
								<h3><strong>{{$addressDetails->first_name." ".$addressDetails->last_name}}</strong></h3>
								<p><i class="fa fa-map-marker"></i>  {{ $addressDetails->address }}</p>
								<address>
                                    <strong>{{ $addressDetails->company }}</strong><br>
                                    {{ $addressDetails->city }}<br>
                                    {{ $addressDetails->country }}<br>
                                    <abbr title="Email">E:</abbr> {{ $addressDetails->email }}
								</address>
							</div>
						</a>
					</div>
				</div>
			</div>

			<div class="ibox mb-4">
				<div class="alert alert-warning m-0 text-center">
					<h5 class="m-0">Letter Assignment</h5>
				</div>

				<div class="ibox-content">
					<div class="d-flex mb-3">
						<a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#tasks_modal">
							<i class="fas fa-mail-forward"></i> Assign
						</a>
					</div>

					<h5 class="d-flex align-items-center flex-nowrap">
						<em class="fab fa-slack-hash text-warning mr-1"></em> Assigned Topics

						<!-- <a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#topics_modal">
							<i class="fas fa-mail-forward"></i> Assign
						</a> -->
					</h5>

					<ul class="folder-list mb-3" style="padding: 0">
						@if (count($letter->topicRelationships) > 0)
							@foreach ($letter->topicRelationships as $letter_topic)
							<li>
								<a href="{{ url('admin/topic/detail/' . $letter_topic->topic->id) }}" class="d-flex align-items-center flex-nowrap pt-1 pb-1">
									<span class="ellipsis pr-2"># {{ $letter_topic->topic?$letter_topic->topic->title:'' }}</span>
									<span class="ml-auto font-normal"><i class="fa fa-share-alt-square text-warning m-0"></i></span>
								</a>
							</li>
							@endforeach
						@else
						<li class="d-flex align-items-center flex-nowrap pt-1 pb-1 pl-3 border-0">
							No topics assigned.
						</li>
						@endif
					</ul>

					<h5 class="d-flex align-items-center flex-nowrap">
						<em class="fab fa-slack-hash text-warning mr-1"></em> Assigned Tasks

						<!-- <a href="" class="btn btn-xs btn-success ml-auto" data-toggle="modal" data-target="#tasks_modal">
							<i class="fas fa-mail-forward"></i> Assign
						</a> -->
					</h5>

					<ul class="folder-list mb-3" style="padding: 0">
						@if (count($letter->taskRelationships) > 0)
							@foreach ($letter->taskRelationships as $letter_task)
							<li>
								<a href="{{ url('admin/task/detail/' . $letter_task->task->id) }}" class="d-flex align-items-center flex-nowrap pt-1 pb-1">
									<span class="font-normal mr-1"><i class="far fa-check-square text-muted m-0"></i></span>
									<span class="ellipsis pr-2">{{ $letter_task->task? $letter_task->task->title:'' }}</span>
									@if ($letter_task->task->due_date)
									<span class="font-normal text-warning ml-auto text-nowrap"><!--IT--> <i class="far fa-dot-circle text-warning mr-1"></i>{{ date('m/d/Y', strtotime($letter_task->task->due_date)) }}</span>
									@endif
								</a>
							</li>
							@endforeach
						@else
						<li class="d-flex align-items-center flex-nowrap pt-1 pb-1 pl-3 border-0">
							No tasks assigned.
						</li>
						@endif
					</ul>

				</div>
			</div>

			<div class="ibox mb-4">
				<div class="alert alert-info m-0 text-center">
					<h5 class="m-0">
						<i class="fas fa-comments"></i> Conversations
					</h5>
				</div>

				<div class="ibox-content p-0">
					<table class="table table-hover table-mail mb-2">
						<tbody>
							@if($letter->children)
                                @foreach($letter->children as $reply)

										<tr class="read">
								<td nowrap=""><i class="fa fa-inbox"></i></td>
							        <td nowrap="">{{$reply->subject}}</td>
									<td class=""><a href="#">@if($letter->direction == 'IN')
                                                {{$letter->from->company}}
                                            @else
                                                {{$letter->from->name}}
                                            @endif</a></td>
								<td class="mail-ontact"><a href="#">  @if($letter->direction == 'OUT')
                                            {{$letter->to->company}}
                                        @else
                                            {{$letter->to->name}}
                                        @endif</a></td>

									<td class="text-right mail-date">{{$reply->msg_date}}</td>
							</tr>
                                        @endforeach
                                @endif
						</tbody>
					</table>
				</div>

				<div class="d-flex mt-2">
					<a href="{{ url('admin/correspondence/letter/receive') }}?id={{$letter->id}}" class="btn btn-xs btn-primary ml-auto">
						<i class="fas fa-reply mr-1"></i> Receive Reply
					</a>

					<a href="{{ url('admin/correspondence/letter/reply') }}?id={{$letter->id}}" class="btn btn-xs btn-primary ml-2">
						<i class="fas fa-mail-forward mr-1"></i> Reply Now
					</a>
				</div>
			</div>

			<div class="ibox mb-4">
				<div class="alert alert-secondary m-0 text-center">
					<h5 class="m-0">
						<i class="fas fa-comments"></i> Workflow &amp; Timeline
					</h5>
				</div>

				<div class="ibox-content inspinia-timeline">

                    @foreach($activities as $activity)
					<div class="timeline-item">
							<div class="row">
									<div class="col-3 date">
											<i class="fa fa-briefcase"></i>
                                        {{date('d M, h:i A',strtotime($activity->created_at))}}
											<br>
											<small class="text-navy">{{time_ago($activity->created_at)}} ago</small>
									</div>
									<div class="col-7 content no-top-border">
											<p class="m-b-xs"><strong>{{$activity->activity_title}}</strong></p>

											<p>{!! $activity->activity_details !!}</p>


									</div>
							</div>
					</div>
                    @endforeach


				</div>
			</div>


			<div class="ibox">
				<div class="alert alert-secondary m-0 text-center">
					<h5 class="m-0">
						<i class="fas fa-envelope"></i> Related Letters
					</h5>
				</div>

				<div class="ibox-content">
					<div class="related d-flex flex-wrap align-items-start">
						@if ($related)
							@foreach ($related as $related_letter)
							<!-- <pre>{{ var_dump($related_letter) }}</pre> -->
							<span class="badge badge-secondary mr-2 mb-2"><a href="{{ url('admin/correspondence/letter/detail/' . $related_letter->id) }}" class="text-primary">{{ $related_letter->subject }}</a></span>
							@endforeach
						@endif
					</div>
				</div>
			</div>


		</div>

	</div>
</div>

{{--<div class="modal inmodal fade" id="topics_modal" tabindex="-1" role="dialog"  aria-hidden="true">--}}
{{--	<div class="modal-dialog">--}}
{{--		<div class="modal-content">--}}
{{--			<div class="modal-header p-3 d-flex flex-nowrap">--}}
{{--				<h4 class="m-0">Assign Topics</h4>--}}
{{--				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>--}}
{{--			</div>--}}

{{--			<div class="modal-body pt-3 pl-3 pr-3 pb-3 bg-white">--}}
{{--				<div class="d-flex align-items-center flex-nowrap new-topic-task mb-3">--}}
{{--					<input type="text" name="new_topic" id="new_topic" class="form-control form-control-sm mr-2">--}}
{{--					<a href="" class="btn btn-xs btn-success create-new-topic">--}}
{{--						<i class="fas fa-plus mr-1"></i> Create topic--}}
{{--					</a>--}}
{{--				</div>--}}

{{--				<label>Select topics:</label>--}}
{{--				<div class="topics d-flex align-items-start flex-wrap">--}}
{{--					@if ($topics)--}}
{{--						@foreach ($topics as $topic)--}}
{{--						<a href="" class="btn btn-xs btn-secondary mr-2 mb-2 {{ in_array($topic->id, $letter_topics_ids) ? 'assigned' : '' }}" data-id="{{ $topic->id }}">{{ $topic->title }}</a>--}}
{{--						@endforeach--}}
{{--					@endif--}}
{{--				</div>--}}

{{--				<div class="d-flex mt-3">--}}
{{--					<a href="" class="btn btn-primary btn-xs ml-auto btn-assign-topics" data-letter="{{ $letter->id }}">Assign Topics</a>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--	</div>--}}
{{--</div>--}}

<div class="modal inmodal fade" id="tasks_modal" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- <div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Assign Tasks</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div> -->

			<div class="modal-body p-4 bg-white">
				<h4 class="d-flex align-items-center m-0">
					<span>Assigned Tasks: </span>
					<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
				</h4>

				<ul class="assigned-tasks list-unstyled mt-3 mb-0 pl-3">
					@foreach($letter_tasks_idss as $tasks)
					<li class="mb-2">
						<a href="" class="d-flex align-items-center">
							<div>
								<input type="checkbox" class="i-checks check-all">
							</div>

							<span class="text-primary-color ellipsis pl-2">{{$tasks->task->title}}</span>
						</a>
					</li>
					@endforeach
				</ul>

				<div class="border p-3 mt-4 bg-muted">
					<h4 class="d-flex align-items-center m-0">
						<span>Assign Task: </span>
					</h4>

					<div class="row mt-3">
						<div class="col-lg-7">
							<div class="form-row">
								<div class="col-lg-6">
									<div class="form-group form-inline">
										<label>@</label>
										<div class="flex-fill">
											<select class="select2 form-control form-control-sm w-100" name="user_id" id="user_id">
												@foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                                    @endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<div class="form-group form-inline">
										<label>Due</label>
										<div class="input-daterange input-group">
											<input type="text" class="form-control-sm form-control text-left" name="due_date" id="due_date">
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-lg-12">
									<div class="form-group form-inline">
										<label>Task</label>
										<input type="text" class="form-control form-control-sm" name="title" id="title">
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-lg-12">
									<div class="form-group form-inline">
										<label class="align-self-start mt-2">Summary</label>
										<div class="summernote"></div>
                                        <input type="hidden" name="hdn_summary" id="hdn_summary" value="">
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-5 d-flex flex-column">
							<div class="form-group">
								<label>Topics</label>
								<div class="topics d-flex align-items-start flex-wrap">


                                    @if ($topics)
                                        @foreach ($topics as $topic)
                                            <a href="" class="btn btn-xs btn-success mr-2 mb-2 ellipsis {{ in_array($topic->id, $letter_topics_ids) ? 'assigned' : '' }}" data-id="{{ $topic->id }}">{{ $topic->title }}</a>
                                        @endforeach
                                    @endif
								</div>
							</div>

							<div class="form-group">
								<input type="text" id="new_topic" name="new_topic" class="form-control form-control-sm create-new-topicc" placeholder="New topic">
							</div>

							<div class="form-group mt-auto d-flex justify-content-center">
								<a href="javascript:void(0)" class="btn btn-sm btn-primary btn-assign-tasks" data-letter="{{ $letter->id }}">Assign Task</a>
							</div>
						</div>
					</div>
				</div>

				<div class="row mt-3">
					<div class="col-lg-12 d-flex">
						<a href="" class="btn btn-success btn-sm ml-auto">Done</a>
						<a href="" class="btn btn-sm btn-danger ml-3">Remove selected</a>
					</div>
				</div>


			</div>
		</div>
	</div>
</div>

@endsection
