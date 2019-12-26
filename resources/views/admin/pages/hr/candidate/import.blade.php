@extends('admin.layouts.default')

@section('title')
	Import Candidates
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}

.dropzone {
	border: 1px dashed #e7eaec;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/operations/create_forms.js?version=') }}{{rand(111,999)}}"></script>
<script src="{{ URL::asset('js/plugins/dropzone/dropzone.js') }}"></script>
<script>
Dropzone.options.dropzoneForm = {
    url:baseUrl + '/admin/import_candidate_xls',
	paramName: 'file', // The name that will be used to transfer the file
	maxFilesize: 2, // MB
    init: function() {
        this.on("success", function(file, responseText) {
            console.log(responseText.message);
            if(responseText.success == false) {
                toastr.warning(responseText.message, 'Warning!');
            }else{
                toastr.success(responseText.message, 'Success!');
            }

            setTimeout(function(){
                window.location.href = baseUrl+'/admin/candidates';
            },2000);
        });
    },
    headers: {
        'x-csrf-token': $('meta[name=csrf-token]').attr('content'),
    },
	dictDefaultMessage: '<i class="fa fa-upload mr-2 text-muted"></i> <strong class="text-muted">Drop files here or click to upload. </strong>'
};
$(document).ready(function () {

});
</script>
@endsection

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Import Candidates</h2>
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
				<strong>View</strong>
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
			<div class="ibox">
				<div class="ibox-title">
					<h5>Import</h5>
				</div>

				<div class="ibox-content">

					<form action="#" class="dropzone" id="dropzoneForm" enctype="multipart/form-data">
							<div class="fallback">
									<input name="file" type="file" multiple />
							</div>
					</form>

					<p class="text-center text-secondary mt-4 pb-4">The file you upload must be a valid Excel file.(Download sample below)</p>
					<p class="text-center text-secondary mt-4">All imports must be uploaded using the correct template file.</p>
					<p class="text-center mt-2">
						<a href="{{url('public/samples/candidates/candidateSample.xlsx')}}" target="_blank" class="btn btn-success btn-outline font-weight-bold text-default">Download Template</a>
					</p>

				</div>
			</div>
		</div>
	</div>
</div>
@endsection
