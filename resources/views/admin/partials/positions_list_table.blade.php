

<div class="ibox ">
    <div class="ibox-title">
        <h5>Positions for
            @if($division)
            {{$division->short_name}}
        @endif</h5>
    </div>
    <div class="ibox-content">
        <p  class="m-b-lg">
            Select one organization unit to list positions

        </p>
        <table class="table" style="width: 100%;">
            <thead>
            <tr>
							<th>Position</th>
							<th>Expat</th>
							<th>Local</th>
							<th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($positions as $position)
                <tr>
                    <td>{{ $position->title }} <strong>({{ $position->total_positions ? $position->total_positions : 0 }})</strong></td>
                    <td>{{$position->expat_positions?$position->expat_positions:0}}</td>
                    <td>{{$position->local_positions?$position->local_positions:0}}</td>
                    <td>
											<a href="" class="edit-position" data-id="{{ $position->id }}"><i class="fas fa-pen-square text-success"></i></a>
										</td>
                </tr>
            @endforeach

            </tbody>
            <!-- <tfoot>
							<tr><td></td><td></td><td></td><td>

                    <a href="#" data-toggle="modal" data-target="#myPositions" class="btn btn-primary btn-xs" title="add position">
                        New Position
                    </a>
                </td></tr></tfoot> -->
        </table>

				<div class="d-flex justify-content-end">
					<a href="#" data-toggle="modal" data-target="#myPositions" class="btn btn-primary btn-xs" title="add position">
						<i class="fas fa-plus mr-1"></i> New Position
					</a>
				</div>

    </div>
</div>