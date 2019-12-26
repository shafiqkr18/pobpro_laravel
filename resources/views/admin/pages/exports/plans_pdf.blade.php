<!-- <link href="{{ URL::asset('css/plan-export.css') }}" rel="stylesheet"> -->

<table style="border-collapse: collapse; border-top: 1px solid #000;">
	<thead>
    <tr style="border-left: 1px solid #000;">
        <th colspan="10" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #666795;" align="center">{{$company}} Manpower Planning</th>
    </tr>

    <tr style="border-left: 1px solid #000;">
        <th colspan="6" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #ff9735;">General Information</th>
        <th colspan="4" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #99c3e3;">Manpower Requirement Planning</th>
    </tr>

    <tr style="border-left: 1px solid #000;">
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #f17b41;">No.</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #f17b41;">Position</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #f17b41;">Dept</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #f17b41;">Rotation Type</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #f17b41;">Recruitment Type</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #f17b41;">Nationality</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #4174be;">Starting month</th>
        <th colspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #4174be;">Staff Type</th>
        <th rowspan="2" align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #4174be; min-width: 200px;">Description/Reason to add positions</th>
    </tr>

    <tr style="border-left: 1px solid #000;">
        <th align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #4174be;">Local</th>
        <th align="center" style="color: #fff; font-size: 9px; padding: 5px 2px; border-bottom: 1px solid #000; border-right: 1px solid #000; background-color: #4174be;">Expat</th>
    </tr>
	</thead>

    <tbody>
    @if($plans)
			@foreach($plans->positions as $pos)
			<tr style="border-left: 1px solid #000;">
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000; text-align: center;">{{$loop->iteration}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$pos->position->title}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$pos->position->department?$pos->position->department->department_short_name:''}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">@if($pos->rotationType)
								{{$pos->rotationType->title}}
						@endif</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$recruitment_type}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">
						@if($pos->nationality)
								{{$pos->nationality->title}}
						@endif
				</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{date("F",strtotime($pos->due_date))}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$pos->expat_positions}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$pos->local_positions}}</td>
				<td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;"></td>
			</tr>
			@endforeach
    @endif

    <tr style="border-bottom: 0;">
        <td colspan="6"></td>
        <td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000; border-left: 1px solid #000; background-color: #4174be; color: #fff;">Total</td>
        <td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$plans->positions->sum('expat_positions')}}</td>
        <td style="font-size: 9px; padding: 5px 2px; border-right: 1px solid #000; border-bottom: 1px solid #000;">{{$plans->positions->sum('local_positions')}}</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>

		
    </tbody>
</table>

