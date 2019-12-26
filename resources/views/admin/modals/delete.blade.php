@extends('admin.layouts.modal')

@section('title') 
Confirm Delete 
@endsection

@section('content')
<p>Are you sure you want to delete this?</p>
@endsection

@section('footer')
<a href="" class="btn btn-white btn-sm" data-dismiss="modal">Cancel</a>
<a href="{{ $url }}" class="btn btn-danger btn-sm action-confirmed" data-type="{{ $type }}" data-view="{{ $view }}">Delete</a>
@endsection