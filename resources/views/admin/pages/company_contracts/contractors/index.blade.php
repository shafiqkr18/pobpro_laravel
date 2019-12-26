@extends('admin.layouts.default')

@section('title')
	Contractors
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/company-contracts.css') }}">
@endsection

@section('scripts')
<script src="{{ URL::asset('js/company-contracts.js') }}"></script>
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
		</ol>

		<h2 class="d-flex align-items-center">
			Contractor Management

			<div class="ml-auto d-flex align-items-center header-buttons">
				<div class="search">
					<input type="text" class="border rounded bg-transparent form-control-sm" placeholder="Search">
				</div>

				<div class="dropdown ml-2">
					<a href="" id="dropdownMenuLink" role="button" class="btn btn-sm d-flex btn-outline-secondary text-dark bg-transparent align-items-center justify-content-center flex-nowrap dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="min-height: 29px;">
						<i class="fas fa-filter text-navy mr-1"></i>
						<i class="fas fa-chevron-down ml-1 text-muted" style="font-size: 8px;"></i>
					</a>

					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</div>

				<a href="{{ url('admin/contracts-mgt/contractor/import') }}" class="btn btn-sm d-flex btn-outline-secondary text-dark bg-transparent align-items-center justify-content-center flex-nowrap ml-2">
					<i class="fas fa-download text-warning mr-2"></i>
					Import
				</a>

				<a href="{{ url('admin/contracts-mgt/contractors/export-excel') }}" class="btn btn-sm d-flex btn-outline-secondary text-dark bg-transparent align-items-center justify-content-center flex-nowrap ml-2">
					<i class="fas fa-file-excel text-navy mr-2"></i>
					Excel
				</a>

				<a href="{{ url('admin/contracts-mgt/contractor/create') }}" class="btn btn-sm btn-success d-flex align-items-center justify-content-center flex-nowrap ml-2">
					<small class="fas fa-plus mr-2"></small>
					Create
				</a>
			</div>
		</h2>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row mt-3 no-padding-form-group">

		@if (count($contractors) > 0)
		@foreach($contractors as $contractor)
            @php
                $logo = $contractor->logo ? json_decode($contractor->logo, true) : null;
            @endphp
		<div class="col-lg-4">
			<div class="ibox contractor">
				<div class="ibox-title d-flex align-items-center flex-nowrap pt-0 pb-0">
					<h5><a href="" class="text-navy">{{$contractor->title}}</a></h5>
					@if($logo)
					<div class="contractor-img ml-auto">
						<img src="{{ asset('storage/' . $logo[0]['download_link']) }}" class="img-fluid" alt="">
					</div>
					@endif
				</div>

				<div class="ibox-content">
					<div class="form-group form-inline">
						<label>No. of contracts:</label>
						<p class="form-control-static">{{$contractor->contracts->count()}}</p>
					</div>

					<div class="form-group form-inline">
						<label>No. of employees:</label>
						<p class="form-control-static">{{$contractor->employees->count()}}</p>
					</div>

					<div class="form-group form-inline">
						<label>Contact person:</label>
						<p class="form-control-static">{{$contractor->contact_person}}</p>
					</div>

					<div class="form-group form-inline">
						<label>Email:</label>
						<p class="form-control-static">{{$contractor->email}}</p>
					</div>

					<div class="form-group form-inline">
						<label>Phone number:</label>
						<p class="form-control-static">{{$contractor->phone}}</p>
					</div>

	{{--					<div class="form-group form-inline">--}}
	{{--						<label>Price:</label>--}}
	{{--						<p class="form-control-static text-warning font-weight-bold">$120,000</p>--}}
	{{--					</div>--}}

					<a href="{{url('admin/contracts-mgt/contractor/detail/')}}/{{$contractor->id}}" class="btn btn-outline-success btn-xs">View Details</a>
				</div>
			</div>
		</div>
		@endforeach
		@else
			<div class="col-lg-12">
				<div class="alert alert-secondary text-center">You currently do not have any contractors.</div>

				<p class="text-center mt-4">
					<a href="{{ url('admin/contracts-mgt/contractor/create') }}" class="btn btn-success btn-sm">Create contractor</a>
				</p>
			</div>
		@endif

	</div>
</div>

@endsection