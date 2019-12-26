@extends('admin.layouts.default')

@section('title')
	Add Quick Links
@endsection

@section('styles')
<link href="{{ URL::asset('css/plugins/jsTree/style.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('css/quick-links.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/jsTree/jstree.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery-ui-1.12.1.js') }}"></script>
<script>
$(document).ready(function() {
	const permissions = Object.values(@php echo json_encode($tree); @endphp);
	// console.log(permissions);

	$('.permissions-select').jstree({
		'core' : {
			'themes': {
				'icons': false
			},
			'data': permissions
		} 
	});

	$( "#sortable" ).sortable();

	$(document).on('click', '.sortable', function (e) {
		e.preventDefault();

		if (!$(this).hasClass('link-added') && e.target.tagName == 'SPAN') {
			$('#sortable').append('<li class="ui-state-default p-3 bg-white border rounded mb-3" data-id="' + $(this).closest('li').attr('id') + '">' + 
				'<input type="hidden" name="link_id[]" value="' + $(this).closest('li').attr('id') + '">' + 
				'<i class="fas fa-arrows-alt-v mr-2"></i> ' + $(this).find('span').html() +
			'</li>');

			$(this).addClass('link-added');

			$( "#sortable" ).sortable('refresh');
		}

	});

	$(document).on('click', '.remove-link', function () {
		var $this = $(this);
		var id = $(this).closest('li').attr('id');
		console.log(id);

		$('#sortable').find('li[data-id="' + id + '"]').remove();
		$this.closest('a').removeClass('link-added');

		$( "#sortable" ).sortable('refresh');
	});
});
</script>
<script src="{{ URL::asset('js/quick-links.js') }}"></script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item text-muted">
				Add Quick Links
			</li>
		</ol>

		<h2 class="d-flex align-items-center">
			Quick Links
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">

		<div class="col-lg-6">
			<div class="ibox">
				<div class="ibox-title">
					<h5 class="mb-1">Add Links</h5>
					<p class="mb-1">Click on the links to add to list.</p>
				</div>

				<div class="ibox-content pl-5 pr-5 pt-4 pb-4">
					<div class="permissions-select"></div>
				</div>
			</div>
		</div>

		<div class="col-lg-6">
			<form role="form" action="{{ url('admin/quick-links/save') }}" enctype="multipart/form-data">
				<div class="ibox">
					<div class="ibox-title">
						<h5 class="mb-1">Organize Links</h5>
						<p class="mb-1">Click and drag the links to organize.</p>
					</div>

					<div class="ibox-content">
						<ul id="sortable" class="list-unstyled">
							@if ($user_links)
								@foreach ($user_links as $user_link)
								<li class="ui-state-default p-3 bg-white border rounded mb-3 ui-sortable-handle" data-id="{{ $user_link->permission->id }}">
									<input type="hidden" name="link_id[]" value="{{ $user_link->permission->id }}">
									<i class="fas fa-arrows-alt-v mr-2"></i> {{ $user_link->permission->display_name }}
								</li>
								@endforeach
							@endif
						</ul>
					</div>
				</div>

				<div class="row mt-4">
					<div class="col-lg-12 d-flex justify-content-end">
						<a href="" class="btn btn-primary btn-sm save-quick-links">Save</a>
					</div>
				</div>
			</form>
		</div>

	</div>
</div>
@endsection