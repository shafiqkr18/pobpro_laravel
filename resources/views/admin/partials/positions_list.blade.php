<ol class="dd-list">
    @if($positions->count()>0)
        @foreach($positions as $position)
            <li class="dd-item" data-id="{{$position->id}}">
                <div class="dd-handle">
									@if ($new_plan)
									<label><input name="position" type="checkbox" value="{{ $position->id }}">
									<i class="mr-1"></i> {{$position->title}} </label>
									@else
									{{$position->title}}
									@endif

									<span class="float-right"> {{$position->total_positions}} {{ $new_plan ? '' : 'Positions' }} </span>
                </div>
            </li>
        @endforeach
    @endif
</ol>