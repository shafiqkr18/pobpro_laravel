@extends('frontend.layouts.candidate')

@section('title')
	Interview Detail
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<style>
.custom-file-label,
.custom-file-label::after {
	padding: 3px 10px;
}

.custom-file-label::after {
	height: 29px;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function(){
	$('.custom-file-input').on('change', function() {
		let fileName = $(this).val().split('\\').pop();
		$(this).next('.custom-file-label').addClass('selected').html(fileName);
	});

	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});
});
</script>
@endsection

@section('content')
<div class="card candidate">
	<h6 class="card-header pt-2 pb-2">
		My Interview Detail
	</h6>

	<div class="card-body p-0 bg-grey">
		<div class="text-content bg-green">Feedback Sent Successfully</div>
		<div class="text-content">
			<p>Dear Mr. Nick Chen,</p> 

			<p>Thanks for your feedback. We have sent a notification to your email: <a href="">nick.chen@gmail.com</a> or you can check <a href="">here</a> for updates.</p>

			<p>
			--------	<br>
			HR Department<br>
			ITforce Technology DMCC 
			</p>
		</div>
	</div>

	<div class="row action-row p-3">
		<div class="col-md-12 d-flex justify-content-center">
			<a href="" class="btn btn-sm btn-info">OK</a>
		</div>
	</div>
</div>
@endsection