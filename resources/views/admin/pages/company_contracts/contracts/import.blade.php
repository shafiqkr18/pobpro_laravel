@extends('admin.layouts.default')

@section('title')
	Import Contract
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/dropzone/basic.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/plugins/dropzone/dropzone.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('css/company-contracts.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dropzone/dropzone.js') }}"></script>
<script src="{{ URL::asset('js/company-contracts.js') }}"></script>
<script>
$(document).ready(function(){
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});
});

Dropzone.options.dropzoneForm = {
	url:baseUrl + '/admin/contracts-mgt/contract/import_excel',
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
								window.location.href = baseUrl+'/admin/contracts-mgt/contracts';
						},2000);
				});
		},
		headers: {
				'x-csrf-token': $('meta[name=csrf-token]').attr('content'),
		},
	dictDefaultMessage: '<div class="d-flex flex-column justify-content-center"><i class="fas fa-download mb-3 text-navy" style="font-size: 36px;"></i> <strong class="text-navy">Drop files here or click to upload. </strong></div>'
};
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
				Contracts Mgt.
			</li>
			<li class="breadcrumb-item active">
				<a href="{{ url('admin/contracts-mgt/contracts') }}">Contract Management</a>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			<a href="{{ url('admin/contracts-mgt/contracts') }}" class="d-flex pt-2 pb-2 pr-3">
				<img src="{{ URL::asset('img/arrow-back.png') }}" srcset="{{ URL::asset('img/arrow-back.png') }} 1x, {{ URL::asset('img/arrow-back@2x.png') }} 2x" class="img-fluid">
			</a>

			Import Contract
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox ">
			
				<div class="ibox-content">
					<form action="#" class="dropzone mt-4" id="dropzoneForm" enctype="multipart/form-data">
						<div class="fallback">
							<input name="file" type="file" multiple />
						</div>
					</form>

					<p class="text-center text-secondary mt-4 mb-1">The file you upload must be a valid Excel file. (<a href="{{url('public/samples/contracts/contractSample.xlsx')}}" class="text-success">Download sample</a>)</p>
					<p class="text-center text-secondary mb-2">All imports must be uploaded using the correct template file.</p>

					<div class="d-flex justify-content-center">
						<a href="{{ url('admin/contracts-mgt/contracts') }}" class="d-flex align-items-center p-2 text-muted">
							<i class="fas fa-times mr-2"></i> Cancel
						</a>
					</div>
					
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
