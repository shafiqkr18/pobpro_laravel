@extends('admin.layouts.default')

@section('title')
	Correspondence Address
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script>
$(document).ready(function(){
	$('#correspondence_address_list').DataTable({
		pageLength: 10,
		responsive: true,
		lengthChange: false,
		dom: '<"html5buttons"B>lTfgitp',
		buttons: [
			{ extend: 'copy'},
			{extend: 'csv'},
			{extend: 'excel', title: 'ExampleFile'},
			{extend: 'pdf', title: 'ExampleFile'},

			{extend: 'print',
				customize: function (win){
					$(win.document.body).addClass('white-bg');
					$(win.document.body).css('font-size', '10px');

					$(win.document.body).find('table')
									.addClass('compact')
									.css('font-size', 'inherit');
				}
			},
			{
				className: 'btn-create',
				text: '<i class="fa fa-plus mr-1"></i> Create',
				action: function ( e, dt, node, config ) {
					window.location.href = baseUrl + '/admin/correspondence/address/create';
				}
			}
		]

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
				Correspondence Mgt.
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Correspondence Address</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">
        <a class="btn btn-primary" href="{{url('admin/correspondence/address/create')}}">Create New</a>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		@if (count($addresses) > 0)
			@foreach ($addresses as $address)
			<div class="col-lg-4">
				<div class="contact-box">
					<a class="row" href="{{ url('admin/correspondence/address/detail/' . $address->id) }}">
						<div class="col-4">
							<div class="text-center">
								@php
								$avatar = $address->contact_person_avatar ? json_decode($address->contact_person_avatar, true) : null;
								$company_logo = $address->company_logo ? json_decode($address->company_logo, true) : null;
								@endphp

								@if ($avatar)
								<img alt="image" class="rounded-circle m-t-xs img-fluid" src="{{ asset('/storage/' . $avatar[0]['download_link']) }}" style="width: 72px; height: 72px; object-fit: cover;">
								@elseif ($company_logo)
								<img alt="image" class="rounded-circle m-t-xs img-fluid" src="{{ asset('/storage/' . $company_logo[0]['download_link']) }}" style="width: 72px; height: 72px; object-fit: cover;">
								@else
								<img alt="image" class="rounded-circle m-t-xs img-fluid" src="{{ asset('img/avatar-default.jpg') }}" style="width: 72px; height: 72px; object-fit: cover;">
								@endif
								<div class="m-t-xs font-bold">{{ $address->position }}</div>
							</div>
						</div>

						<div class="col-8">
							<h3><strong>{{ $address->getName() }}</strong></h3>
							<p><i class="fa fa-map-marker"></i> {{ $address->address }}</p>
							<address>
								<strong>{{ $address->company }}</strong><br>
								{{ $address->city }}<br>
								{{ $address->country }}<br>
								<abbr title="Email">E:</abbr> {{ $address->email }}
							</address>
							<i class="fa fa-briefcase mr-1"></i>
							<i class="fas fa-reply mr-1"></i>
							<i class="fa fa-share-alt-square mr-1"></i>
							<i class="fa fa-edit"></i>
						</div>
					</a>
				</div>
			</div>
			@endforeach
            @else
            <div class="col-lg-12 text-center"><div class="alert alert-warning " role="alert">
                    You do not have any contact!
                </div></div>
		@endif
	</div>

</div>

@endsection