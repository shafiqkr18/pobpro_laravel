$(function () {

	// show positions on section click
	$(document).on('click', 'span.name, .show-positions', function (e) {
		e.preventDefault();

		var list_item = $(this).closest('li'),
				id = list_item.attr('data-id');

		$('li.selected').removeClass('selected');
		list_item.addClass('selected');

		$('#new_position form').find('input[name="section_id"]').val(list_item.attr('data-id'));

		// if (list_item.closest('ul').hasClass('requested')) {
		// 	$('.new-position.hide').removeClass('hide');
		// }
		// else {
		// 	$('.new-position').addClass('hide');
		// }

		$.ajax({
			url: baseUrl + '/admin/department-requests/get-positions',
			type: 'POST',
			dataType: 'json',
			data: {
				'id': id,
				'type': list_item.closest('ul').hasClass('requested') ? 'requested' : 'existing'
			},
			success: function (response) {
				// $('.positions-table:nth-child(2)').remove();
				// $('.positions-table').removeClass('existing');
				// $('.positions-table').removeClass('requested');
				// $('.positions-table thead > tr').removeClass('alert-warning');
				// $('.positions-table thead > tr').removeClass('alert-success');
				// $('.positions-table').addClass(list_item.closest('ul').hasClass('requested') ? 'requested' : 'existing');
				// $('.positions-table thead > tr').addClass(list_item.closest('ul').hasClass('requested') ? 'alert-warning' : 'alert-success');
				// $('.section-label').text(list_item.find('span.name').text());
				$('.positions-table tbody').html('');

				var requested_positions = response.requested_positions;
				if (requested_positions.length > 0) {
					$.each(requested_positions, function (key, position) {
						var d = new Date(position.due_date);
						$('.positions-table.requested tbody').append('<tr>' + 
							'<td>' + position.title + '</td>' + 
							'<td>' + position.local_positions + '</td>' + 
							'<td>' + position.expat_positions + '</td>' + 
							'<td>' + position.total_positions + '</td>' + 
							'<td>' +
								'<div class="d-flex flex-nowrap align-items-center justify-content-center">' + 
								'<a href="" class="mr-1 edit-position ' + (response.type == 'existing' ? 'update-existing' : '') + '" data-id="' + position.id + '" data-location="' + (position.location ? position.location : '') + '" data-duedate="' + (position.due_date ? ((d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear()) : '') + '" data-notes="' + (position.notes ? position.notes : '') + '">' + 
										'<i class="fas fa-pen-square text-success" title="Edit"></i>' + 
									'</a>' + 
								'<a href="' + baseUrl + '/admin/modal/delete" confirmation-modal="delete" data-view="' + (list_item.closest('ul').hasClass('requested') ? 'detail' : 'department_request') + '" data-url="' + baseUrl + (list_item.closest('ul').hasClass('requested') ? ('/admin/department-requests/delete-position/' + position.id) : ('/admin/department-requests/delete-position/' + position.id + '/existing')) + '" class="ml-1">' + 
										'<i class="fa fa-trash text-danger" title="Delete"></i>' + 
									'</a>' + 
								'</div>' + 
							'</td>' + 
						'</tr>');
					});
				}
				else {
					$('.positions-table.requested tbody').append('<tr><td>No positions.</td></tr>');
				}

				var existing_positions = response.existing_positions;
				var existing_positions_updates = response.existing_positions_updates;

				if (existing_positions.length > 0 || existing_positions_updates.length > 0) {

					if (existing_positions_updates.length > 0) {
						$.each(existing_positions_updates, function (key, position) {
							var d = new Date(position.due_date);
							$('.positions-table.existing tbody').append('<tr>' +
								'<td>' + position.title + '</td>' +
								'<td>' + position.local_positions + '</td>' +
								'<td>' + position.expat_positions + '</td>' +
								'<td>' + position.total_positions + '</td>' +
								'<td>' +
								'<div class="d-flex flex-nowrap align-items-center justify-content-center">' +
								'<a href="" class="mr-1 edit-position ' + (response.type == 'existing' ? 'update-existing' : '') + '" data-id="' + position.id + '" data-location="' + (position.location ? position.location : '') + '" data-duedate="' + (position.due_date ? ((d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear()) : '') + '" data-notes="' + (position.notes ? position.notes : '') + '">' +
								'<i class="fas fa-pen-square text-success" title="Edit"></i>' +
								'</a>' +
								'<a href="' + baseUrl + '/admin/modal/delete" confirmation-modal="delete" data-view="' + (list_item.closest('ul').hasClass('requested') ? 'detail' : 'department_request') + '" data-url="' + baseUrl + (list_item.closest('ul').hasClass('requested') ? ('/admin/department-requests/delete-position/' + position.id) : ('/admin/department-requests/delete-position/' + position.id + '/existing')) + '" class="ml-1">' +
								'<i class="fa fa-trash text-danger" title="Delete"></i>' +
								'</a>' +
								'</div>' +
								'</td>' +
								'</tr>');
						});
					}

					if (existing_positions.length > 0) {
						$.each(existing_positions, function (key, position) {
							var d = new Date(position.due_date);
							$('.positions-table.existing tbody').append('<tr>' +
								'<td>' + position.title + '</td>' +
								'<td>' + position.local_positions + '</td>' +
								'<td>' + position.expat_positions + '</td>' +
								'<td>' + position.total_positions + '</td>' +
								'<td>' +
								'<div class="d-flex flex-nowrap align-items-center justify-content-center">' +
								'<a href="" class="mr-1 edit-position ' + (response.type == 'existing' ? 'update-existing' : '') + '" data-id="' + position.id + '" data-location="' + (position.location ? position.location : '') + '" data-duedate="' + (position.due_date ? ((d.getMonth() + 1) + '/' + d.getDate() + '/' + d.getFullYear()) : '') + '" data-notes="' + (position.notes ? position.notes : '') + '" data-lock="' + position.is_lock + '">' +
								'<i class="fas fa-pen-square text-success" title="Edit"></i>' +
								'</a>' +
								'<a href="' + baseUrl + '/admin/modal/delete" confirmation-modal="delete" data-view="' + (list_item.closest('ul').hasClass('requested') ? 'detail' : 'department_request') + '" data-url="' + baseUrl + (list_item.closest('ul').hasClass('requested') ? ('/admin/department-requests/delete-position/' + position.id) : ('/admin/department-requests/delete-position/' + position.id + '/existing')) + '" class="ml-1">' +
								'<i class="fa fa-trash text-danger" title="Delete"></i>' +
								'</a>' +
								'</div>' +
								'</td>' +
								'</tr>');
						});
					}
				}
				else {
					$('.positions-table.existing tbody').append('<tr><td>No positions.</td></tr>');
				}

			}, error: function (err) {
				console.log(err);
			}
		});

	});

	// save section/position
	$(document).on('click', '.save-section, .save-position', function (e) {
		e.preventDefault();

		var url = $(this).closest('form').attr('action'),
				formData = new FormData($(this).closest('form')[0]);

		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {

				if (response.success) {
					toastr.success(response.message);

					setTimeout(function () {
						window.location.reload();
					}, 500);
				}
				else {
					$.each(response.errors, function (key, value) {
						$('#' + key).closest('.form-group').addClass('has-error');
						toastr.error(value);
					});
				}
			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// edit section
	$(document).on('click', '.edit-section', function (e) {
		e.preventDefault();

		var list_item = $(this).closest('li');

		if (!$(this).hasClass('update-existing')) {
			$('#new_section form').prepend('<input type="hidden" name="is_update" value="1">');
		}

		$('#new_section .modal-header h4').text('Update section');
		$('#new_section form').prepend('<input type="hidden" name="section_id" value="' + (list_item.attr('data-existing') > 0 ? list_item.attr('data-existing') : list_item.attr('data-id')) + '">');
		$('#new_section form').find('input[name="short_name"]').val(list_item.find('span.name').text());
		$('#new_section form').find('input[name="full_name"]').val(list_item.attr('data-fullname'));
		$('#new_section form').find('input[name="action_type"]').val(list_item.closest('ul.sections').hasClass('requested') ? 0 : 1);
		$('#new_section form').find('.save-section').text('Update');
		$('#new_section').modal('show');
	});

	// edit position
	$(document).on('click', '.edit-position', function (e) {
		e.preventDefault();

		$('#new_position .modal-header h4').text('Update position');

		if (!$(this).hasClass('update-existing')) {
			$('#new_position form').prepend('<input type="hidden" name="is_update" value="1">');
		}

		if ($(this).attr('data-section')) {
			$('#new_position form').find('input[name="section_id"]').val($(this).attr('data-section'));
		}
		
		$('#new_position form').prepend('<input type="hidden" name="position_id" value="' + $(this).attr('data-id') + '">');
		$('#new_position form').find('input[name="title"]').val($(this).closest('tr').find('td:first-child').text());
		if ($(this).attr('data-lock') == 1) {
			$('#new_position form').find('input[name="title"]').attr('disabled', true);
		}
		$('#new_position form').find('input[name="location"]').val($(this).attr('data-location'));
		$('#new_position form').find('input[name="due_date"]').val($(this).attr('data-duedate'));
		$('#new_position form').find('textarea[name="remarks"]').val($(this).attr('data-notes'));
		$('#new_position form').find('input[name="local_positions"]').val($(this).closest('tr').find('td:nth-child(2)').text());
		$('#new_position form').find('input[name="expat_positions"]').val($(this).closest('tr').find('td:nth-child(3)').text());
		$('#new_position form').find('input[name="total_positions"]').val($(this).closest('tr').find('td:nth-child(4)').text());
		$('#new_position form').find('input[name="position_type"]').val($(this).closest('table').hasClass('requested') ? 'requested' : 'existing');
		$('#new_position form').find('input[name="action_type"]').val($(this).closest('table').hasClass('requested') ? 0 : 1);
		$('#new_position form').find('.save-position').text('Update');
		$('#new_position').modal('show');
	});

	// clear section fields
	$('#new_section').on('hidden.bs.modal', function (e) {
		$('#new_section .modal-header h4').text('Create new section');
		$('#new_section form').find('.save-section').text('Create');
		$('#new_section form').find('input[name="is_update"]').remove();
		$('#new_section form').find('input[name="section_id"]').remove();
		$('#new_section form').find('input[name="section_type"]').val(0);
		$('#new_section form')[0].reset();
	});

	// clear position fields
	$('#new_position').on('hidden.bs.modal', function (e) {
		$('#new_position .modal-header h4').text('Create new position');
		$('#new_position form').find('.save-position').text('Create');
		$('#new_position form').find('input[name="title"]').attr('disabled', false);
		$('#new_position form').find('input[name="is_update"]').remove();
		$('#new_position form').find('input[name="position_id"]').remove();
		$('#new_position form').find('input[name="position_type"]').val('requested');
		$('#new_position form')[0].reset();
	});

	// update positions quantity
	$(document).on('keyup', '[name="local_positions"], [name="expat_positions"]', function (e) {
		e.preventDefault();

		var row = $(this).closest('.form-row'),
			expat = row.find('[name="expat_positions"]').val() ? row.find('[name="expat_positions"]').val() : 0,
			local = row.find('[name="local_positions"]').val() ? row.find('[name="local_positions"]').val() : 0,
			total = row.find('[name="total_positions"]');

		total.val(parseInt(expat) + parseInt(local));
	});

});