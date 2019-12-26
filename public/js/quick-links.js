$(function () {

	$(document).on('click', '.save-quick-links', function (e) {
		e.preventDefault();

		let formData = new FormData($(this).closest('form')[0]);
		console.log($(this).closest('form').attr('action'));

		$.ajax({
			url: $(this).closest('form').attr('action'),
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				// if (data.success == false) {
				// 	if (data.errors) {
				// 		toastr.warning("Fill the required fields!");
				// 		jQuery.each(data.errors, function (key, value) {
				// 			toastr.warning(value);
				// 			$('#' + key).closest('.form-group').addClass('has-error');

				// 		});

				// 	} else {
				// 		//Show toastr message
				// 		toastr.error("Error Saving Data");
				// 	}
				// } else {
				// 	var msg = data.is_update ? 'Role data updated.' : 'New Role added.';
				// 	toastr.success(msg, 'Success!');
				// 	setTimeout(function () {
				// 		window.location.href = baseUrl + '/admin/role-management';
				// 	}, 2000);

				// }
				console.log(response);

				if (response.success) {
					toastr.success(response.message);

					setTimeout(function () {
						window.location.reload();
					}, 500);
				}
				else {
					if (response.errors.link_id) {
						toastr.error('Please select one or more links to save.');
					}
				}

				console.log(response);

			}, error: function (err) {
				console.log(err);
			}
		});
	});

});