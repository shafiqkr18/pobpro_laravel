$(function () {

	if ($('.summernote').length) {
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
	}

	if ($('.input-daterange').length) {
		$('.input-daterange').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			startDate: 'today',
			todayHighlight: true
		});
	}

	if ($('.select2').length) {
		$('.select2').select2();
	}

	// save task
	$(document).on('click', '.btn-save', function (e) {
		e.preventDefault();

		$('.has-error').removeClass('has-error');
		$('input[name="contents"]').val($('.summernote').summernote('code'));

		let formData = new FormData($('#frm_tasks')[0]);

		$.ajax({
			url: baseUrl + '/admin/task/save',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.error('Fill the required fields!');
						jQuery.each(data.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');

						});

					} else {
						//Show toastr message
						toastr.error('Error Saving Data');
					}
				} else {
					toastr.success(data.message);
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/task/detail/' + data.task.id;
					}, 1000);

				}

			}
		});
	});

	// search task
	$(document).on('submit', '#search_tasks', function (e) {
		e.preventDefault();

		let formData = new FormData($(this)[0]);

		$.ajax({
			url: $(this).attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data) {
					$('.tasks-list tbody').html('');
					$('.tasks-list tbody').append(data.list_view);
					$('.tasks_count').html('Found ' + data.tasks.length + ' task' + (data.tasks.length > 1 ? 's' : '') + '.');
					$('span.pie').peity('pie', {
						fill: ['#1ab394', '#d7d7d7', '#ffffff']
					});
				}

			},
			error: function (err) {
				console.log(err);
			}
		});
	});

});