@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
@endsection

@php
$status = ['Pending Response', 'Confirmed', 'Requested to reschedule', 'Declined'];
$status_class = ['warning', 'success', 'info', 'danger'];
@endphp

<style>
*, ::after, ::before {
	box-sizing: border-box;
}

th, td {
	font-size: 10pt;
	vertical-align: top;
}

.row {
	display: -ms-flexbox;
	display: flex;
	-ms-flex-wrap: wrap;
	flex-wrap: wrap;
	margin-right: -15px;
	margin-left: -15px;
}

.col-lg-12 {
	-ms-flex: 0 0 100%;
	flex: 0 0 100%;
	max-width: 100%;
}

.mb-1, .my-1 {
	margin-bottom: .25rem!important;
}

.col-sm-4 {
	-ms-flex: 0 0 33.333333%;
	flex: 0 0 33.333333%;
	max-width: 33.333333%;
}

.col-sm-8 {
	-ms-flex: 0 0 66.666667%;
	flex: 0 0 66.666667%;
	max-width: 66.666667%;
}

.ibox-content {
	background-color: #ffffff;
	color: inherit;
	padding: 15px 20px 20px 20px;
	border-color: #e7eaec;
	border-image: none;
	border-style: solid solid none;
	border-width: 1px 0;
}

dt {
	font-weight: normal;
}

dd {
	font-weight: bold;
}

.text-sm-left {
	text-align: left!important;
}

.mt-3, .my-3 {
	margin-top: 1rem!important;
}

.label {
	background-color: #d1dade;
	color: #5e5e5e;
	font-family: 'Open Sans', 'Helvetica Neue', Helvetica, Arial, sans-serif;
	font-weight: 600;
	padding: 3px 8px;
	text-shadow: none;
	border-radius: 0.25em;
	line-height: 1;
	white-space: nowrap;
}

.label-warning, .badge-warning {
	background-color: #f8ac59;
	color: #FFFFFF;
}

.nav .label, .ibox .label {
	font-size: 10px;
}

p {
	margin-top: 0;
	margin-bottom: 1rem;
}

table {
	width: 100% !important;
}

td {
	padding-bottom: 20pt !important;
}
</style>

<h3>Interview with {{ $interview->candidate->name." ".$interview->candidate->last_name }}</h3>

<table cellpadding="5" cellspacing="0" style="width: 100% !important;">
	<tr>
		<th width="25%"></th>
		<th width="75%"></th>
	</tr>

	<tr>
		<td style="color: #808080;">Name:</td>
		<td><a href="{{ url('admin/candidate/detail/' . $interview->candidate->id) }}" class="text-primary" target="_blank">{{ $interview->candidate ? $interview->candidate->name . ' ' . $interview->candidate->last_name : '' }}</a></td>
	</tr>

	<tr>
		<td style="color: #808080;">Status:</td>
		<td><span class="label label-{{ $status_class[$interview->is_confirmed] }}" style="display: inline-block;"> {{ $status[$interview->is_confirmed] }} </span></td>
	</tr>

	<tr>
		<td style="color: #808080;">Position:</td>
		<td>{{ $interview->candidate && $interview->candidate->position ? $interview->candidate->position->title : '' }}</td>
	</tr>

	<tr>
		<td style="color: #808080;">Created By:</td>
		<td>{{ $interview->createdBy ? $interview->createdBy->getName() : '' }}</td>
	</tr>

	<tr>
		<td style="color: #808080;">Subject:</td>
		<td>{{ str_replace('{position}', ($interview->position ? $interview->position->title : ''), $interview->subject) }}</td>
	</tr>

	<tr>
		<td style="color: #808080;">Date:</td>
		<td>{{ date('Y-m-d', strtotime($interview->interview_date)) }}</td>
	</tr>

	<tr>
		<td style="color: #808080;">Time:</td>
		<td>{{ date('H:i', strtotime($interview->interview_date)) }}</td>
	</tr>

	<tr>
		<td style="color: #808080;">Location:</td>
		<td>{{ $interview->location }}</td>
	</tr>

	<tr>
		<td style="color: #808080;">Interviewer:</td>
		<td>
			@if ($interview->attendees)
				@foreach ($interview->attendees as $attendee)
				<span class="font-weight-bold mr-2">{{ $attendee->interviewer ? $attendee->interviewer->getName() : '' }}</span>
				@endforeach
			@endif
		</td>
	</tr>

	<tr>
		<td style="color: #808080;">Remarks:</td>
		<td>{!! $template_data !!}</td>
	</tr>
</table>

		