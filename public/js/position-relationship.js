$(document).ready(function () {

	// division change
	$(document).on('change', '#div_id', function () {
		var id = $(this).val();

		$.ajax({
			type: 'POST',
			url: baseUrl + '/admin/organization-mapping/get-departments/' + id,
			success: function (response) {
				console.log(response);

				if (response.success) {
					$('#dept_id').html('<option value="">Select Department</option>');

					if (response.departments) {
						$.each(response.departments, function (key, value) {
							$('#dept_id').append('<option value="' + value.id + '">' + value.department_short_name + '</option>')
						});
					}
				}

			}, error: function (err) {
				console.log(err);
			}
		});

	});

	// filter by department
	$(document).on('change', '#dept_id', function () {
		var id = $(this).val();

		window.location.href = baseUrl + '/admin/organization-mapping/settings/' + id

		// $.ajax({
		// 	type: 'POST',
		// 	url: baseUrl + '/admin/organization-mapping/get-department-positions/' + id,
		// 	success: function (response) {
		// 		console.log(response);

		// 		if (response.success) {
		// 			$('#dept_id').html('<option value="">Select Department</option>');

		// 			if (response.departments) {
		// 				$.each(response.departments, function (key, value) {
		// 					$('#dept_id').append('<option value="' + value.id + '">' + value.department_short_name + '</option>')
		// 				});
		// 			}
		// 		}

		// 	}, error: function (err) {
		// 		console.log(err);
		// 	}
		// });

	});

	// add positions
	$(document).on('click', '.position .btn-wrap a[data-type="add"]', function (e) {
		e.preventDefault();

		$('.new .position.active').removeClass('active');
		$(this).closest('.position').addClass('active');
		// $('.old .select-label').removeClass('hide')
		// $('.old .select-label span').text($('.position.active .btn-wrap > span').text());

		$('.old .ibox-content.inactive').removeClass('inactive');
		$('[name="position_id"]').val($(this).closest('.position').attr('data-id'));
	});

	// enable removing positions
	$(document).on('click', '.position .btn-wrap a[data-type="remove"]', function (e) {
		e.preventDefault();

		$('.positions-moved .badge i').addClass('hide');
		$(this).closest('.position').find('.positions-moved').find('span i').removeClass('hide');
	});

	// remove position relationship
	$(document).on('click', '.positions-moved .badge i', function (e) {
		e.preventDefault();

		var $this = $(this),
				id = $(this).closest('span').attr('data-id');

		$.ajax({
			type: 'POST',
			url: baseUrl + '/admin/organization-mapping/delete/' + id,
			success: function (response) {
				console.log(response);

				if (response.success) {
					$positionsMovedWrapper = $this.closest('.positions-moved');
					$this.closest('.badge').remove();
				
					if (response.position_relationship_count == 0) {
						$positionsMovedWrapper.prev('div').find('a[data-type="remove"]').remove();
						$positionsMovedWrapper.remove();
					}

					$('#' + response.ex_pos).closest('.i-checks').removeClass('moved');
					toastr.success(response.message, 'Success');
				}
				else {
					toastr.error(response.message, 'Error');
				}

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// cancel move
	$(document).on('click', '.cancel-move', function (e) {
		e.preventDefault();

		$('.old .ibox-content').addClass('inactive');
		$('.new .position.active').removeClass('active');
	});

	// bind ex department checkbox to ex position checkbox
	// $(document).on('change', '.i-checks input[type="checkbox"]', function (e) {
	// 	$(this).closest('.i-checks').prev('input[type="checkbox"]').prop('checked', this.checked);
	// });

	// move positions
	$(document).on('click', '.move-positions', function (e) {
		e.preventDefault();

		let formData = new FormData($(this).closest('form')[0]);

		$.ajax({
			type: 'POST',
			url: $(this).closest('form').attr('action'),
			dataType: 'json',
			data: formData,
			processData: false,
			contentType: false,
			success: function (response) {
				console.log(response);

				if (response.success) {
					toastr.success(response.message);

					setTimeout(function () {
						window.location.reload();
					}, 500);
				}

			}, error: function (err) {
				console.log(err);
			}
		});

	});

});