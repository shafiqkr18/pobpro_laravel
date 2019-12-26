@extends('admin.layouts.default')

@section('title')
	Create Topic
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
<script src="{{ URL::asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ URL::asset('js/admin/tasks.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-12">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="{{ url('admin/tasks') }}">Tasks</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/tasks') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>
			
			Update
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<form id="frm_tasks">
		<input type="hidden" name="is_update" value="1">
		<input type="hidden" name="listing_id" value="{{ $task->id }}">

		<div class="row">
			<div class="col-lg-12">

				<div class="ibox ">
					<div class="ibox-title">
						<h5>Task Details</h5>
					</div>

					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Title: </label>
									<input type="text" class="form-control form-control-sm" name="title" id="title" value="{{ $task->title }}">
								</div>

								<div class="form-group form-inline">
									<label>Status: </label>
									<select name="status" id="status" class="form-control form-control-sm">
										<option value="0" {{ $task->status == 0 ? 'selected' : '' }}>Open</option>
										<option value="1" {{ $task->status == 1 ? 'selected' : '' }}>Processing</option>
										<option value="2" {{ $task->status == 2 ? 'selected' : '' }}>Closed</option>
									</select>
								</div>
							</div>

							<div class="col-lg-6">
								<div class="form-group form-inline">
									<label>Due Date: </label>
									<div class="input-daterange input-group">
										<input type="text" class="form-control-sm form-control text-left" name="due_date" id="due_date" value="{{ date('m/d/Y', strtotime($task->due_date)) }}">
									</div>
								</div>

								<div class="form-group form-inline">
									<label>Owners: </label>
									<select class="select2 form-control form-control-sm" name="users[]" multiple="multiple">
									@if ($users)
										@foreach ($users as $user)
										<option value="{{ $user->id }}" {{ in_array($user->id, $task_users) ? 'selected' : '' }}>{{ $user->getName() }}</option>
										@endforeach
									@endif
									</select>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label class="align-self-start mt-2">Contents: </label>
									<div class="summernote">{!! $task->contents !!}</div>
									<input type="hidden" name="contents">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-12">
								<div class="form-group form-inline">
									<label>Topics: </label>
									<select class="select2 form-control form-control-sm" name="topics[]" multiple="multiple">
									@if ($topics)
										@foreach ($topics as $topic)
										<option value="{{ $topic->id }}" {{ in_array($topic->id, $task->topics->pluck('topic_id')->all()) ? 'selected' : '' }}>{{ $topic->title }}</option>
										@endforeach
									@endif
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>

		<div class="row mt-3">
			<div class="col-lg-12 d-flex align-items-center">
				<a href="" class="btn btn-primary btn-sm ml-auto btn-save">Save</a>
			</div>
		</div>

	</form>
</div>

@endsection