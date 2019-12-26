@extends('admin.layouts.modal')

@section('title') 
Confirm Action 
@endsection

@php
$action_value = substr($url, strrpos($url, '/' ) + 1);
$action = ['', 'approve', 'reject', 'publish'];
@endphp

@section('content')
<p>Are you sure you want to {{ $action[$action_value] }} this?</p>
@endsection

@section('footer')
<a href="" class="btn btn-white btn-sm" data-dismiss="modal">Cancel</a>
<a href="{{ $url }}" class="btn btn-{{ substr($url, strrpos($url, '/' ) + 1) == '2' ? 'danger' : 'success' }} btn-sm action-confirmed" data-type="{{ $type }}" data-view="{{ $view }}" style="text-transform: capitalize">{{ $action[$action_value] }}</a>
@endsection