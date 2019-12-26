@extends('admin.layouts.default')

@section('title')
	Contracts
@endsection

@section('styles')
<link rel="stylesheet" href="{{ URL::asset('css/plugins/dataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/new-pages.css') }}">
<style>
table.dataTable {
	border-collapse: collapse !important;
}
</style>
@endsection

@section('scripts')
<script src="{{ URL::asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ URL::asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('js/operations/listings.js?version=') }}{{rand(11,99)}}"></script>
<script>
    $(document).ready(function () {
        $("#bulk_cn_form").submit(function () {
            $(".contract-confirm").attr("disabled", true);
            return true;
        });
    });
    $(document).ready(function () {
        $('input[name="row_id"]').on('change', function () {
            var ids = [];
            $('input[name="row_id"]').each(function() {
                if ($(this).is(':checked')) {
                    ids.push($(this).val());
                }
            });
            $('.selected_ids').val(ids);
            $('#bulk_cn_input').val(ids);

        });

        $('.select_all').on('click', function(e) {
            $('input[name="row_id"]').prop('checked', $(this).prop('checked'));
        });

        //send offer click
        $('#bulk_cn_btn').click(function () {
            console.log('send offer clicked');
            var ids = [];
            var $checkedBoxes = $('#contract_list input[type=checkbox]:checked').not('.select_all');
            var count = $checkedBoxes.length;
            if (count) {
                // Reset input value
                $('#bulk_cn_input').val('');

                // Gather IDs
                $.each($checkedBoxes, function () {
                    var value = $(this).val();
                    ids.push(value);
                })
                // Set input value
                $('#bulk_cn_input').val(ids);
                console.log('offer ids='+ids);
                // Show modal
                //$bulkDeleteModal.modal('show');
            } else {
                $('#mdlContract').modal('toggle');

                // No row selected
                toastr.warning('You haven&#039;t selected any contract!');
            }
        });

    });
</script>
@endsection

@section('content')
<div class="row wrapper page-heading">
	<div class="col-lg-10">
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{ url('admin') }}">Dashboard</a>
			</li>
			<li class="breadcrumb-item">
				<a href="javascript:void(0);">HR</a>
			</li>
			<li class="breadcrumb-item active">
				<strong>Contracts</strong>
			</li>
		</ol>

		<h2 class="d-flex align-items-center">Contracts</h2>
	</div>
	<div class="col-lg-2 d-flex align-items-center justify-content-end">

	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
			<input type="hidden" id="pending" name="pending" value="{{$pending}}">
			<input type="hidden" id="ur" name="ur" value="{{$ur}}">
			<div class="ibox ">
				<div class="ibox-title">
					<h5 data-url="#">Contracts</h5>

					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						    <i class="fa fa-wrench"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li>
								<a href="#" class="dropdown-item">Config option 1</a>
							</li>
							<li>
								<a href="#" class="dropdown-item">Config option 2</a>
							</li>
						</ul>
						<a class="close-link">
							<i class="fa fa-times"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-bordered table-hover" id="contract_list" style="width: 100%">
							<thead>
								<tr>
									<th><input type="checkbox" class="select_all"></th></th>
									<th>Status</th>
									<th>Contract Sent</th>
									<th>Candidate Approval</th>
									<th>Candidate</th>
									<th>Current Position</th>
									<th>New Position</th>
									<th>Salary</th>
									<th>Level</th>
									<th></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
            <button  id="bulk_cn_btn" type="button" class="btn btn-success btm-sm float-right ml-2 mt-3" data-toggle="modal" data-target="#mdlContract">
                Send Contract
            </button>
		</div>
	</div>
</div>



<div class="modal inmodal" id="mdlContract" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header" style="text-align: center">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-clock-o modal-icon"></i>
                <h4 class="modal-title">Confirmation</h4>
                <small>Contract Confirmation</small>
            </div>
            <div class="modal-body">
                <p><strong>Are you sure you want to Send Contract to selected Candidates?</strong></p>
            </div>
            <div class="modal-footer">
                <form action="{{url('admin/send_contract_letter_final')}}" id="bulk_cn_form" method="POST">
                    @csrf
                    <input type="hidden" name="ids" id="bulk_cn_input" value="">
                    {{--                    <input type="hidden" id="pos_id" name="pos_id" value="{{$data['position_id']}}">--}}
                    {{--                    <input type="hidden" id="contract_plan_id" name="plan_id" value="{{$data['plan_id']}}">--}}
                    <input type="submit" class="btn btn-danger pull-right contract-confirm"
                           value="Yes, Sure">
                </form>
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>
@endsection