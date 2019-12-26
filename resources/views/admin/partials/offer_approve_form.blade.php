<div class="media-body">
	<form action="{{ url('admin/offer/status') }}">
		<input type="hidden" name="comments">
		
		<div class="row">
			<input type="hidden" name="offer_id" value="{{ $offer->id }}">
			<input type="hidden" name="rdbtn">

			<div class="col-sm-12">
				<div class="d-flex align-items-center justify-content-end">
					<!-- <div class="mr-3">
						<input type="radio" value="2" id="optionsRadios1" name="rdbtn">
						<label for="optionsRadios1" class="radio-label">Reject</label>
					</div>

					<div>
						<input type="radio" value="1" id="optionsRadios2" name="rdbtn">
						<label for="optionsRadios2" class="radio-label">Approve</label>
					</div>

					<input type="hidden" name="my_role" value="{{$my_role}}">
					<a href="" class="btn btn-sm btn-success float-right ml-auto btn-approve disabled">Save</a> -->

					<a href="" class="btn-approve btn btn-danger mr-3" data-value="2">Reject</a>
					<a href="" class="btn-approve btn btn-primary" data-value="1">Approve</a>
				</div>
			</div>
		</div>
	</form>
</div>
