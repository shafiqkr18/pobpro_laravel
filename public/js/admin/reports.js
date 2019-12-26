$(function () {

	if ($('.input-daterange').length) {
		$('.input-daterange').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			// startDate: 'today',
			todayHighlight: true
		});
	}

	if ($('.summernote').length) {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				// ['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link']],
				// ['view', ['codeview']],
			]
		});
	}

	if ($('.full-height-scroll').length) {
		$('.full-height-scroll').slimscroll({
			height: '100%'
		});
	}

	if ($('.select2').length) {
		$('.select2').select2();
	}

	if ($('.previous-tasks  .select2').length) {
		$('.previous-tasks .select2').select2({
			minimumResultsForSearch: -1
		});
	}

	// reload summernote editor on modal open
	$('#add_task').on('show.bs.modal', function (e) {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline', 'clear']],
				['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link']],
				['view', ['codeview']],
			]
		});
	});

	// reset form on modal hide
	$('#add_task').on('hide.bs.modal', function (e) {
		$('#frm_add_next_task')[0].reset();
		$('#frm_add_next_task .select2').select2().val(null).trigger('change');
	});

	$('.input-daterange').datepicker().on('hide.bs.modal', function (event) {
		// prevent datepicker from firing bootstrap modal "show.bs.modal"
		event.stopPropagation();
	});

	// switch type
	$(document).on('click', '.btn-group.type .btn', function (e) {
		$('.btn-group.type .btn-primary').removeClass('btn-primary').addClass('btn-white');
		$(this).removeClass('btn-white').addClass('btn-primary');
		$('#rpt_type').val($(this).attr('report_type'));

	});

	// add task to next tasks table
	$(document).on('click', '.btn-add-task', function (e) {
		e.preventDefault();

		let formData = new FormData($('#frm_add_next_task')[0]);
		$('#frm_add_next_task input[name="contents"]').val($('#frm_add_next_task .summernote').summernote('code'));

		$.ajax({
			url: $('#frm_add_next_task').attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.view) {
					$('#add_task').modal('hide');
					$('#next_tasks tbody').append(data.view);
				}
			},
			error: function (err) {
				console.log(err);
			}
		});
	});

	// add remark to report detail
	$(document).on('click', '.btn-add-remark', function (e) {
		e.preventDefault();

		let formData = new FormData($('#frm_add_remark')[0]);

		$.ajax({
			url: $('#frm_add_remark').attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				console.log(data);

				if (data.success) {
					if (data.view) {
						$('#add_remark').modal('hide');
						$('.element-detail-box .tab-pane.active ul.comments').prepend(data.view);
					}
				}
			},
			error: function (err) {
				console.log(err);
			}
		});
	});

	// reset form on modal hide
	$('#add_remark').on('hide.bs.modal', function (e) {
		$('#frm_add_remark')[0].reset();
	});

	// view task history
	$(document).on('click', '.btn-view-history', function (e) {
		e.preventDefault();

		$.ajax({
			url: baseUrl + '/admin/task/history',
			type: 'POST',
			data: {
				'id': $(this).attr('data-id')
			},
			success: function (data) {
				if (data.view) {
					$('#update_history span.task-title').html(data.task.title);
					$('#update_history ul.history').append(data.view);
					$('#update_history').modal('show');
				}
			},
			error: function (err) {
				console.log(err);
			}
		});
	});

	// reset task history on modal hide
	$('#update_history').on('hide.bs.modal', function (e) {
		$('#update_history ul.history').html('');
		$('#update_history span.task-title').html('');
	});

	// tab change event
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		// e.target // newly activated tab
		// e.relatedTarget // previous active tab
		var id = e.target.href.split('#').pop();
		var reportId = $('.element-detail-box #' + id).attr('data-report');
		if (reportId) {
			$('#frm_add_remark [name="listing_id"]').val(reportId);
		}
	});

	// initial listing_id on load
	$('#frm_add_remark [name="listing_id"]').val($('.element-detail-box .tab-pane.active').attr('data-report'));

	// create new topic
	$(document).on('click', '.btn-create-topic', function (e) {
		e.preventDefault();

		$('#create_topic form [name="contents"]').val($('#create_topic form .summernote').summernote('code'));
		let formData = new FormData($(this).closest('form')[0]);

		$.ajax({
			url: $(this).closest('form').attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				console.log(data);

				if (data.success) {
					var newOption = new Option(data.topic.title, data.topic.id, false, false);
					toastr.success(data.message);
					$('[name="topics[]"]').append(newOption).trigger('change');
					$('#create_topic').modal('hide');
				}
			},
			error: function (err) {
				console.log(err);
			}
		});
	});

	// reset topic form on modal hide
	$('#create_topic').on('hide.bs.modal', function (e) {
		$('#create_topic form')[0].reset();
		$('#create_topic .summernote').summernote('reset');
	});

});
function goto_report(v=0) {
    console.log(v);
    window.location.href = baseUrl + '/admin/reports?type='+v;
}
