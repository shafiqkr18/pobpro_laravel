$(function () {

	$("#save_crspndnc_compose").click(function (e) {
		e.preventDefault();

		$(".validation_error").hide();
		$('input[name="contents"]').val($('.summernote').summernote('code'));
		$('input[name="ar_contents"]').val($('.ar_summernote').summernote('code'));
		let formData = new FormData($('#frm_crspndnc_compose')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/correspondence/letters/save_new_letter',
			type: 'POST',
			dataType: "JSON",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning("Fill the required fields!");
						jQuery.each(data.errors, function (key, value) {
							toastr.warning(value);
							$('#' + key).closest('.form-group').addClass('has-error');

						});

					} else {
						//Show toastr message
						toastr.error("Error Saving Data");
					}
				} else {
					var msg = data.is_update ? 'Letter data updated.' : 'New Letter added.';
					toastr.success(msg, 'Success!');
					setTimeout(function () {
						window.location.href = baseUrl + '/admin/correspondence';
					}, 1000);

				}

			}
		});
	});
	$("#save_address_book").click(function (e) {
		e.preventDefault();

		$(".validation_error").hide();

		let formData = new FormData($('#frm_address_book')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/correspondence/address/save_address',
			type: 'POST',
			dataType: "JSON",
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning("Fill the required fields!");
						jQuery.each(data.errors, function (key, value) {
							//$('#'+key).addClass('text-danger');
							$('#' + key).closest('.form-group').addClass('has-error');

						});

					} else {
						//Show toastr message
						toastr.error("Error Saving Data");
					}
				} else {
					var msg = data.is_update ? 'Address data updated.' : 'New address added.';
					toastr.success(msg, 'Success!');
					if (data.modal) {
						// hide modal, append option to select - create received letter page
						$('.modal').modal('hide');
						$('#msg_from_id').append('<option value="' + data.contact.id + '">' + ((data.contact.first_name ? data.contact.first_name : '') + ' ' + (data.contact.last_name ? data.contact.last_name : '')) + '</option>');
						$('[name="msg_from_id"]').val(data.contact.id);
						$('#frm_address_book')[0].reset();
					}
					else {
						setTimeout(function () {
							window.location.href = baseUrl + '/admin/correspondence/address';
						}, 1000);
					}

				}

			}
		});
	});
});
