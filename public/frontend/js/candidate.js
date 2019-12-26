$(function () {

	// My Profile edit
	$(document).on('click', '.edit-profile', function (e) {
		e.preventDefault();

		$(this).closest('form').addClass('editable');
		$(this).closest('form').find(':disabled').removeAttr('disabled');
	});

	// Update profile
	$(document).on('click', '.save-profile', function (e) {
		e.preventDefault();

		var url = $(this).closest('form').attr('action'),
				formData = new FormData($(this).closest('form')[0]);

		$('.is-invalid').removeClass('is-invalid');

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.success == false) {
					if (response.errors) {
						toastr.error('Please fill the required fields.');
						jQuery.each(response.errors, function (key, value) {
							$('#' + key).addClass('is-invalid');
						});

					}
					else {
						toastr.error('Error saving data.');
					}
				}
				else {
					toastr.success(response.message, 'Success');
					if (response.is_online == 1) {
						setTimeout(function () {
							window.location.href = baseUrl + '/candidate/vacancies';
						}, 1000);
					}

				}

			}
		});
	});

	// Interview response
	$(document).on('click', '.btn-interview-response', function (e) {
		e.preventDefault();

		$('input[name="is_confirmed"]').val($(this).attr('data-response'));

		$.ajax({
			url: $('#interview-response').attr('action'),
			type: 'POST',
			dataType: 'json',
			data: new FormData($('#interview-response')[0]),
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.success == false) {
					if (response.errors) {
						toastr.error('Please fill the required fields.');
						jQuery.each(response.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});

					}
					else {
						toastr.error('Error saving data.');
					}
				}
				else {
					toastr.success(response.message, 'Success');
					$('.interview-detail-wrap').css('display', 'none');
					$('.interview-feedback-wrap').css('display', 'block');
				}

			}
		});
	});

	// Offer feedback buttons
	$(document).on('click', '.btn-offer-feedback', function (e) {
		e.preventDefault();

		$('#offer-detail').css('display', 'none');
		$($(this).attr('href')).css('display', 'block');
	});

	// Accept/decline offer
	$(document).on('click', '.btn-offer-decision', function (e) {
		e.preventDefault();

		if ($(this).hasClass('ignore')) {
			$('#offer-decline form input[name="ignore"]').val(1);
		}

		$.ajax({
			url: $(this).closest('.offer-feedback').find('form').attr('action'),
			type: 'POST',
			dataType: 'json',
			data: new FormData($(this).closest('.offer-feedback').find('form')[0]),
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.success == false) {
					if (response.errors) {
						toastr.error('Please fill the required fields.');
						jQuery.each(response.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});

					}
					else {
						toastr.error('Error saving data.');
					}
				}
				else {
					toastr.success(response.message, 'Success');
					setTimeout(function () {
						location.reload();
					}, 1000)
				}

			}
		});
	});

	// Accept/decline contract
	$(document).on('click', '.btn-send-contract', function (e) {
		e.preventDefault();
		$('.has-error').removeClass('has-error');

		$.ajax({
			url: $('#send-contract').attr('action'),
			type: 'POST',
			dataType: 'json',
			data: new FormData($('#send-contract')[0]),
			processData: false,
			contentType: false,
			success: function (response) {
				if (response.success == false) {
					if (response.errors) {
						toastr.error('Please fill the required fields.');
						jQuery.each(response.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});

					}
					else {
						toastr.error('Error saving data.');
					}
				}
				else {
					toastr.success(response.message, 'Success');
					setTimeout(function () {
						location.reload();
					}, 1000)
				}

			}
		});
	});

	// save question,not working online
	$("#save_question, #save_question_draft").click(function (e) {
		e.preventDefault();

		var $this = $(this);
		$this.addClass('disabled');

		// var iboxContent = $('.ibox-content');
		// iboxContent.toggleClass('sk-loading');

		$('.has-error').removeClass('has-error');

		$('[name="status_id"]').val($(this).attr('data-status'));
		// $('input[name="content"]').val($('.summernote').summernote('code'));

		$('.validation_error').hide();
		let formData = new FormData($('#frm_question')[0]);

		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/question/save',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				$this.removeClass('disabled');
				// iboxContent.toggleClass('sk-loading');

				if (data.success == false) {
					if (data.errors) {
						toastr.warning('Fill the required fields.');
						jQuery.each(data.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});

					} else {
						//Show toastr message
						toastr.error('Error Saving Data');
					}
				} else {
					toastr.success(data.message, 'Success!');
					$('#frm_question')[0].reset();
					setTimeout(function () {
						window.location.href = baseUrl + '/candidate/questions';
					}, 1000);

				}

			}
		});
	});

});