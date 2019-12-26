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

	if ($('.select2').length) {
		$('.select2').select2();
	}

	// save topic
	$(document).on('click', '.btn-save', function (e) {
		e.preventDefault();

		$('.has-error').removeClass('has-error');
		$('input[name="contents"]').val($('.summernote').summernote('code'));

		let formData = new FormData($('#frm_topic')[0]);

		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/topic/save',
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
						window.location.href = baseUrl + '/admin/topic/detail/' + data.topic.id;
					}, 1000);

				}

			}
		});
	});

});