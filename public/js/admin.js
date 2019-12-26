$(function () {
	// trigger confirmation modal
	$(document).on('click', '[confirmation-modal]', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $(this).attr('href'),
			data: {
				'url': $(this).attr('data-url'),
				'type': $(this).attr('confirmation-modal'),
				'view': $(this).attr('data-view')
			},
			success: function (response) {
				$('#modal').html(response).modal('show');

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// confirm action from modal
	$(document).on('click', '.action-confirmed', function (e) {
		e.preventDefault();

		if ($('.sk-spinner').length) {
			$('.sk-spinner').closest('.ibox-content').addClass('sk-loading');
		}

		$.ajax({
			type: 'POST',
			url: $(this).attr('href'),
			data: {
				'type': $(this).attr('data-type'),
				'view': $(this).attr('data-view')
			},
			success: function (response) {
				console.log(response);
				$('#modal').modal('hide');

				if (response.success) {
					if (response.view == 'table') {
						if (response.contract_id)
							$('#contract_list').DataTable().ajax.reload();
						else if (response.position_id)
							$('#position_list').DataTable().ajax.reload();
						else if (response.organization_id)
							$('#org_list').DataTable().ajax.reload();
						else if (response.candidate_id)
							$('#candidates_list').DataTable().ajax.reload();
						else if (response.division_id) {
							if ($('#my_organization').length) {
								window.location.reload(true);
							}
							else {
							$('#division_list').DataTable().ajax.reload();
							}
						}
						else if (response.department_id)
							$('#department_list').DataTable().ajax.reload();
						else if (response.section_id)
							$('#section_list').DataTable().ajax.reload();
						else if (response.template_id)
							$('#template_list').DataTable().ajax.reload();
						else if (response.passport_id)
							$('#passport_list').DataTable().ajax.reload();
						// else if (response.contractor_employee_id)
						// 	$('#contractor_employees_list').DataTable().ajax.reload();
						else
							$('table.table').DataTable().ajax.reload();
					}
					else if (response.view == 'detail' || response.view == 'settings' || response.view == 'department_request') {
						setTimeout(function() {
							window.location.href = response.return_url;
						}, 1000);
					}

				}

				toastr.success(response.msg);

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// trigger information modal
	$(document).on('click', '[info-modal]', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'POST',
			url: $(this).attr('href'),
			data: {

			},
			success: function (response) {
				$('#modal').html(response).modal('show');

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// short list a candidate
	$(document).on('click', '.btn-short-list', function (e) {
		e.preventDefault();

		$.ajax({
			type: 'POST',
			url: $(this).attr('href'),
			success: function (response) {
				console.log(response);

				if (response.success) {
					$('#matching_candidates_list').DataTable().ajax.reload();
					toastr.success(response.candidate.reference_no + '(' + response.candidate.name + ') has been shortlisted.', 'Success!');
				}

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// number input filter
	$(document).on('keypress', 'input[type="number"]', function (e) {
		if ((e.keyCode >= 48 && e.keyCode <= 57) || e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46) {
            if (e.keyCode == 46 && this.value.split('.').length === 2) {
                e.preventDefault();
            }else{
			return true;
		}

		}
		else {
			e.preventDefault();
		}
	});

});