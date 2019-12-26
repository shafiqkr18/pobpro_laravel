<table>
	<thead>
		<tr>
			<th>ID</th>
			<th>Reference No.</th>
			<th>Title</th>
			<th>Contact Person</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Fax</th>
			<th>Website</th>
			<th>Address</th>
			<th>City</th>
			<th>Country</th>
			<th>Company</th>
		</tr>
	</thead>

	<tbody>
		@if (count($contractors) > 0)
			@foreach ($contractors as $contractor)
			<tr>
				<td>{{ $contractor->id }}</td>
				<td>{{ $contractor->reference_number }}</td>
				<td>{{ $contractor->title }}</td>
				<td>{{ $contractor->contact_person ? $contractor->contact_person : '' }}</td>
				<td>{{ $contractor->email ? $contractor->email : '' }}</td>
				<td>{{ $contractor->phone ? $contractor->phone : '' }}</td>
				<td>{{ $contractor->fax ? $contractor->fax : '' }}</td>
				<td>{{ $contractor->website ? $contractor->website : '' }}</td>
				<td>{{ $contractor->address ? $contractor->address : '' }}</td>
				<td>{{ $contractor->city ? $contractor->city : '' }}</td>
				<td>{{ $contractor->country ? $contractor->country : '' }}</td>
				<td>{{ $contractor->company ? $contractor->company->name : '' }}</td>
			</tr>
			@endforeach
		@endif
	</tbody>
</table>