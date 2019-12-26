<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Reference No.</th>
			<th>Title</th>
			<th>Contractor</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Department</th>
			<th>Amount</th>
			<th>Currency</th>
			<th>Location</th>
			<th>Primary Term</th>
			<th>Notes</th>
			<th>Company</th>
			<th>Status</th>
		</tr>
	</thead>

	<tbody>
		@if (count($contracts) > 0)
			@foreach ($contracts as $contract)
			<tr>
				<td>{{ $contract->id }}</td>
				<td>{{ $contract->tender_reference }}</td>
				<td>{{ $contract->tender_title }}</td>
				<td>{{ $contract->contractor ? $contract->contractor->title : '' }}</td>
				<td>{{ date('m/d/Y', strtotime($contract->start_date)) }}</td>
				<td>{{ date('m/d/Y', strtotime($contract->end_date)) }}</td>
				<td>{{ $contract->department->department_short_name }}</td>
				<td>{{ $contract->amount }}</td>
				<td>{{ $contract->currency }}</td>
				<td>{{ $contract->location }}</td>
				<td>{{ $contract->primary_term }}</td>
				<td>{{ $contract->notes }}</td>
				<td>{{ $contract->company ? $contract->company->name : '' }}</td>
				<td>{{ $contract->status }}</td>
			</tr>
			@endforeach
		@endif
	</tbody>
</table>