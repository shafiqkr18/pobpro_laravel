<!-- <link href="{{ URL::asset('css/plan-export.css') }}" rel="stylesheet"> -->

<table style="border-collapse: collapse; border-top: 1px solid #000000;">
	<thead>
		<tr>
			<th colspan="10">{{$company}} Manpower Planning</th>
		</tr>

		<tr>
			<th colspan="6">General Information</th>
			<th colspan="4">Manpower Requirement Planning</th>
		</tr>

		<tr>
			<th rowspan="2">No.</th>
			<th rowspan="2">Position</th>
			<th rowspan="2">Dept</th>
			<th rowspan="2">Rotation Type</th>
			<th rowspan="2">Recruitment Type</th>
			<th rowspan="2">Nationality</th>
			<th rowspan="2">Starting month</th>
			<th colspan="2">Staff Type</th>
			<th rowspan="2">Description / Reason to add positions</th>
		</tr>

		<tr>
			<th>Local</th>
			<th>Expat</th>
		</tr>
	</thead>

	<tbody>
    @if($plans)
        @foreach($plans->positions as $pos)
		<tr style="">
			<td style="border: 1px solid #000000; text-align: center;">{{$loop->iteration}}</td>
			<td style="border: 1px solid #000000;">{{$pos->position->title}}</td>
			<td style="border: 1px solid #000000;">{{$pos->position->department?$pos->position->department->department_short_name:''}}</td>
			<td style="border: 1px solid #000000;">@if($pos->rotationType)
                {{$pos->rotationType->title}}
            @endif</td>
			<td style="border: 1px solid #000000;">{{$recruitment_type}}</td>
			<td style="border: 1px solid #000000;">
                @if($pos->nationality)
                    {{$pos->nationality->title}}
                @endif
            </td>
			<td style="border: 1px solid #000000;">{{date("F",strtotime($pos->due_date))}}</td>
			<td style="border: 1px solid #000000;">{{$pos->expat_positions}}</td>
			<td style="border: 1px solid #000000;">{{$pos->local_positions}}</td>
			<td style="border: 1px solid #000000;"></td>
		</tr>
        @endforeach
        @endif

		<tr  style="border-bottom: 0;">
			<td colspan="6"></td>
			<td style="border: 1px solid #000000; background: #569cd0; color: #ffffff;">Total</td>
			<td style="border: 1px solid #000000;">{{$plans->positions->sum('expat_positions')}}</td>
			<td style="border: 1px solid #000000;">{{$plans->positions->sum('local_positions')}}</td>
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

		<tr>
			<td colspan="2"></td>
			<td style="font-size: 12px; padding: 15px 5px 5px">Prepared By:</td>
			<td style="border-bottom: 1px solid #000000;"></td>
			<td style="border-bottom: 1px solid #000000;"></td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td style="font-size: 12px; padding: 15px 5px 5px">Checked By:</td>
			<td style="border-bottom: 1px solid #000000;"></td>
			<td style="border-bottom: 1px solid #000000;"></td>
		</tr>

		<tr>
			<td colspan="2"></td>
			<td style="font-size: 12px; padding: 15px 5px 5px">Approved By:</td>
			<td style="border-bottom: 1px solid #000000;"></td>
			<td style="border-bottom: 1px solid #000000;"></td>
		</tr>
	</tbody>
</table>
