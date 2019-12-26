$(function () {
	$("#btn_contract_new").click(function (e) {
		e.preventDefault();

		$(".validation_error").hide();

		let formData = new FormData($('#frm_contract_mgt')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/contracts-mgt/contract/save_contract',
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
							$('#' + key).closest('.form-group').addClass('has-error');

						});

					} else {
						toastr.error(data.message ? data.message : 'Error Saving Data');
					}
				} else {
					var msg = data.is_update ? 'Contract data updated.' : 'New contract added.';
					toastr.success(msg, 'Success!');
					setTimeout(function () {
						if (data.is_update)
							window.location.href = baseUrl + '/admin/contracts-mgt/contract/detail/' + data.contract_id;
						else
							window.location.href = baseUrl + '/admin/contracts-mgt/contracts';
					}, 1000);

				}

			}
		});
	});


	$("#btn_contractor_new").click(function (e) {
		e.preventDefault();

		$(".validation_error").hide();

		let formData = new FormData($('#frm_contractor_mgt')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/contracts-mgt/contractor/save_contractor',
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
							$('#' + key).closest('.form-group').addClass('has-error');

						});

					} else {
						toastr.error(data.message ? data.message : 'Error Saving Data');
					}
				} else {
					var msg = data.is_update ? 'Contractor data updated.' : 'New contractor added.';
					toastr.success(msg, 'Success!');
					setTimeout(function () {
						if (data.is_update)
							window.location.href = baseUrl + '/admin/contracts-mgt/contractor/detail/' + data.contractor_id;
						else
							window.location.href = baseUrl + '/admin/contracts-mgt/contractors';
					}, 1000);

				}

			}
		});
	});

	$('#btn_contractor_employee_new').click(function (e) {
		e.preventDefault();

		$('.validation_error').hide();
		$('.form-group.has-error').removeClass('has-error');

		let formData = new FormData($('#frm_contractor_employee')[0]);
		$.ajax({
			/* the route pointing to the post function */
			url: baseUrl + '/admin/contracts-mgt/contractor/employee/save',
			type: 'POST',
			dataType: 'JSON',
			data: formData,
			processData: false,
			contentType: false,
			success: function (data) {
				if (data.success == false) {
					if (data.errors) {
						toastr.warning('Fill the required fields!');
						jQuery.each(data.errors, function (key, value) {
							$('#' + key).closest('.form-group').addClass('has-error');
						});

					} else {
						toastr.error(data.message ? data.message : 'Error Saving Data');
					}
				} else {
					var msg = data.message;
					toastr.success(msg, 'Success!');
					setTimeout(function () {
						// if (data.is_update)
						// 	window.location.href = baseUrl + '/admin/contracts-mgt/contractor/employee/detail/' + data.employee_id;
						// else
							window.location.href = baseUrl + '/admin/contracts-mgt/contractor/employees/' + (data.contractor_id > 0 ? data.contractor_id : '');
					}, 1000);

				}

			}
		});
	});
});
