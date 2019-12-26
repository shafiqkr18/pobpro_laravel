@extends('admin.layouts.default')

@section('title')
    Create Letter
@endsection

@section('styles')
    <link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/plugins/summernote/summernote-bs4.css') }}" rel="stylesheet">
    <style>

    </style>
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ URL::asset('js/plugins/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ URL::asset('js/operations/correspondence_create_forms.js?v=') }}{{rand(11,99)}}"></script>
    <script>
        $(document).ready(function(){
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']],
                    ['view', ['codeview']],
                ]
            });

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
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
                    Correspondence Mgt.
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ url('admin/correspondence') }}">Letters</a>
                </li>
            </ol>

            <h2 class="d-flex align-items-center">
                <a href="{{ url('admin/correspondence') }}" class="d-flex pt-2 pb-2 pr-3">
                    <img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
                </a>

                Create
            </h2>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">

                <div class="ibox border-bottom">
                    <div class="ibox-title">
                        <h5>Compose Letter</h5>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">

                        <form role="form" id="frm_crspndnc_compose" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="direction" value="IN">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <label>To:</label>
                                        <select name="msg_to_id" id="msg_to_id" class="form-control form-control-sm">
                                            @foreach($contacts_from as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <label>Message Code:</label>
                                        <input type="text" class="form-control form-control-sm" id="msg_code" name="msg_code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
																				<label>From:</label>
																				<div class="d-flex flex-nowrap align-items-center flex-fill">
																					<select name="msg_from_id" id="msg_from_id" class="form-control form-control-sm">
                                            @foreach($contacts_to as $c)
																						<option value="{{$c->id}}">{{$c->company}}</option>
                                            @endforeach
																					</select>
																					
																					<a href="" class="btn btn-sm btn-success ml-2" data-toggle="modal" data-target="#new_contact_modal">Create new contact</a>
																				</div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <label>Reference No:</label>
                                        <input type="text" class="form-control form-control-sm" id="reference_no" name="reference_no">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <label>Department:</label>
                                        <select name="assign_dept_id" id="assign_dept_id" class="form-control form-control-sm">
                                            @foreach($depts as $d)
                                                <option value="{{$d->id}}">{{$d->department_short_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group form-inline">
                                        <label>Subject:</label>
                                        <input type="text" class="form-control form-control-sm" id="subject" name="subject">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group form-inline">
                                        <label class="align-self-start mt-2">Summary/Digest:</label>
                                        <input type="hidden" name="contents">
                                        <div class="summernote"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <label>Attachments:</label>
                                        <div class="custom-file">
                                            <input id="attachment" name="attachment_files" type="file" class="custom-file-input form-control-sm">
                                            <label for="attachment" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
                                        </div>
                                    </div>
																</div>
														</div>

														<div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group form-inline">
                                        <label>Original Files:</label>
                                        <div class="custom-file">
                                            <input id="original_files" name="original_files" type="file" class="custom-file-input form-control-sm">
																						<label for="original_files" class="custom-file-label b-r-xs form-control-sm m-0">Choose file</label>
																						<small class="form-control-static mt-1 text-muted">The original letter file.</small>
																				</div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-12 d-flex align-items-center">
											<a href="" class="btn btn-sm btn-info ml-auto mr-2">
												<i class="fas fa-save mr-1"></i> Save &amp; Assign
											</a>
											
                        <a href="javascript:void(0)" id="save_crspndnc_compose" class="btn btn-sm btn-primary mr-2">
                            <i class="fas fa-save mr-1"></i> Save
                        </a>

                        <a href="" class="btn btn-sm btn-white mr-2">
                            <i class="fas fa-pencil-alt mr-1"></i> Draft
                        </a>

                        <a href="" class="btn btn-sm btn-danger">
                            <i class="fas fa-times mr-1"></i> Discard
                        </a>
                    </div>
                </div>

            </div>
        </div>
		</div>
		
<div class="modal inmodal fade" id="new_contact_modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header p-3 d-flex flex-nowrap">
				<h4 class="m-0">Create new contact</h4>
				<a href="" data-dismiss="modal" class="ml-auto"><i class="fa fa-times text-muted"></i></a>
			</div>

			<div class="modal-body pt-3 pl-3 pr-3 pb-3 bg-white">
				<form role="form" id="frm_address_book" enctype="multipart/form-data">
					<input type="hidden" name="modal" value="1">
					
					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>First Name</label>
								<input type="text" class="form-control form-control-sm" id="first_name" name="first_name">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Middle Name</label>
								<input type="text" class="form-control form-control-sm" id="middle_name" name="middle_name">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Last Name</label>
								<input type="text" class="form-control form-control-sm" id="last_name" name="last_name">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Company Name</label>
								<input type="text" class="form-control form-control-sm" id="company" name="company">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Position</label>
								<input type="text" class="form-control form-control-sm" id="position" name="position">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Email</label>
								<input type="email" class="form-control form-control-sm" id="email" name="email">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Country</label>
								<input type="text" class="form-control form-control-sm" id="country" name="country">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Web</label>
								<input type="text" class="form-control form-control-sm" id="website" name="website">
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>City</label>
								<input type="text" class="form-control form-control-sm" id="city" name="city">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Avatar</label>
								<div class="custom-file">
									<input id="contact_person_avatar" name="contact_person_avatar" type="file" class="custom-file-input form-control-sm">
									<label for="contact_person_avatar" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
								</div>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label class="align-self-start mt-1">Address</label>
								<textarea name="address" id="address" class="form-control" rows="5"></textarea>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group form-inline">
								<label>Company Logo</label>
								<div class="custom-file">
									<input id="company_logo" name="company_logo" type="file" class="custom-file-input form-control-sm">
									<label for="company_logo" class="custom-file-label b-r-xs form-control-sm m-0">Choose file...</label>
								</div>
							</div>
						</div>
					</div>

					<div class="form-row">
						<div class="col-lg-12 d-flex">
							<a href="javascript:void(0)" id="save_address_book" class="btn btn-sm btn-primary ml-auto">Save</a>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
