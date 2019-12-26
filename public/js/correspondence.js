$(function () {

	// custom checkbox
	$('.i-checks').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});

	// datepicker
	$('.input-daterange').datepicker({
		keyboardNavigation: false,
		forceParse: false,
		autoclose: true
	});

	if ($('.summernote').length) {
		$('.summernote').summernote({
			height: 200,
			toolbar: [
				// [groupName, [list of button]]
				['style', ['bold', 'italic', 'underline']],
				// ['font', ['strikethrough', 'superscript', 'subscript']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ul', 'ol', 'paragraph']],
				['insert', ['link']],
				// ['view', ['codeview']],
			]
		});
	}

	// custom select
	if ($('.select2').length) {
		$('.select2').select2();
	}

	// enable tooltip
	$('body').tooltip({
		selector: '[data-toggle="tooltip"]',
		html: true
	});

	// tab change event
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		// e.target // newly activated tab
		// e.relatedTarget // previous active tab
		$('table.table').DataTable().ajax.reload();
	});

	// messages table
	$('#messages_table').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 20,
		responsive: true,
		lengthChange: false,
		searching: false,
		dom: '<"html5buttons"B>lTfgtp',
		buttons: [
			{
				className: 'text-center rounded mr-1',
				text: '<i class="fas fa-sync-alt" title="Refresh"></i>',
				action: function (e, dt, node, config) {
					$('#messages_table').DataTable().ajax.reload();
				}
			},
			{
				className: 'text-center rounded mr-1',
				text: '<i class="fa fa-eye" title="Mark as read"></i>',
				action: function (e, dt, node, config) {
					window.location.href = '';
				}
			},
			{
				className: 'text-center rounded mr-1',
				text: '<i class="fa fa-exclamation" title="Mark as important"></i>',
				action: function (e, dt, node, config) {
					window.location.href = '';
				}
			},
			{
				className: 'text-center rounded mr-1 move-to-trash',
				text: '<i class="fas fa-trash" title="Move to trash"></i>',
				action: function (e, dt, node, config) {
					e.preventDefault();
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/correspondence/messages_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.directions = 'IN';
                data.contacts = $('[name="contact"]').val();
				data.topics = $('[name="hdn_topics"]').val();
				data.tasks = $('[name="hdn_tasks"]').val();
				data.msg_from = $('#id_from').val();
				data.msg_to = $('#id_to').val();
				data.msg_start_date = $('#start_date').val();
				data.msg_end_date = $('#end_date').val();
				data.msg_keywords = $('#id_keyword').val();


			},
		},
		drawCallback: function (settings) {
			$('.inbox-count').html(settings.json.recordsFiltered > 0 ? '(' + settings.json.recordsFiltered + ')' : '');
		},
		order: [[1, 'asc']],
		rowGroup: {
			dataSrc: 1
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(0).addClass('check-mail').html('').append(
				'<input type="checkbox" class="i-checks" name="message_check[]" value="' + data[0] + '">'
			);

			setTimeout(function () {
				$('td.check-mail .i-checks').iCheck({
					checkboxClass: 'icheckbox_square-green',
					radioClass: 'iradio_square-green',
				});
			}, 100);


			$('td', row).eq(1).html('').append(
				'<a href="' + baseUrl + '/admin/correspondence/letter/detail/' + data[0] + '" class="text-success">' + data[1] + '</a>'
			);

			var status = ['New', 'Assigned', 'Processing','Replied','Closed'],
			badge = ['info', 'primary', 'warning', 'success', 'secondary'];

			$('td', row).eq(5).html('').append(
				'<label class="badge badge-' + badge[data[5]] + ' m-0">' + status[data[5]] + '</label>'
			);

			if (data[9].length > 0) {
				$('td', row).eq(6).html('').append(
					'<span class="text-success" style="border-bottom: 1px dotted" data-toggle="tooltip" data-placement="bottom" title="' + data[6] + '">' +
					data[9].length + ' Topic' + (data[9].length > 1 ? 's' : '') +
					'</span>'
				);
			}

			// var attachment = JSON.parse(data[5]);
			//
			// if (data[5]) {
			// 	$('td', row).eq(5).html('').append(
			// 		'<a href="' + baseUrl + '/storage/' + attachment[0].download_link + '" class="text-muted" target="_blank"><i class= "fa fa-paperclip"></i></a>'
			// 	);
			// }

		}


	});

	// messages sent table
	$('#messages_sent_table').DataTable({
		processing: true,
		serverSide: true,
		pageLength: 20,
		responsive: true,
		lengthChange: false,
		searching: false,
		dom: '<"html5buttons"B>lTfgtp',
		buttons: [
			{
				className: 'text-center rounded mr-1',
				text: '<i class="fas fa-sync-alt" title="Refresh"></i>',
				action: function (e, dt, node, config) {
					$('#messages_sent_table').DataTable().ajax.reload();
				}
			},
			{
				className: 'text-center rounded mr-1',
				text: '<i class="fa fa-eye" title="Mark as read"></i>',
				action: function (e, dt, node, config) {
					window.location.href = '';
				}
			},
			{
				className: 'text-center rounded mr-1',
				text: '<i class="fa fa-exclamation" title="Mark as important"></i>',
				action: function (e, dt, node, config) {
					window.location.href = '';
				}
			},
			{
				className: 'text-center rounded mr-1 move-to-trash',
				text: '<i class="fas fa-trash" title="Move to trash"></i>',
				action: function (e, dt, node, config) {
					e.preventDefault();
				}
			}
		],
		ajax: {
			url: baseUrl + '/admin/correspondence/messages_filter',
			type: 'POST',
			data: function (data) {
				// Append to data
				data.directions = 'OUT';
				data.contacts = $('[name="contact"]').val();
				data.topics = $('[name="hdn_topics"]').val();
				data.tasks = $('[name="hdn_tasks"]').val();
				data.msg_from = $('#id_from').val();
				data.msg_to = $('#id_to').val();
				data.msg_start_date = $('#start_date').val();
				data.msg_end_date = $('#end_date').val();
				data.msg_keywords = $('#id_keyword').val();


			},
		},
		drawCallback: function (settings) {
			$('.sent-count').html(settings.json.recordsFiltered > 0 ? '(' + settings.json.recordsFiltered + ')' : '');
		},
		order: [[1, 'asc']],
		rowGroup: {
			dataSrc: 1
		},
		createdRow: function (row, data, index) {
			$('td', row).eq(0).addClass('check-mail').html('').append(
				'<input type="checkbox" class="i-checks" name="message_check[]" value="' + data[0] + '">'
			);

			setTimeout(function () {
				$('td.check-mail .i-checks').iCheck({
					checkboxClass: 'icheckbox_square-green',
					radioClass: 'iradio_square-green',
				});
			}, 100);


			$('td', row).eq(1).html('').append(
				'<a href="' + baseUrl + '/admin/correspondence/letter/detail/' + data[0] + '" class="text-success">' + data[1] + '</a>'
			);

			var status = ['New', 'Assigned', 'Processing', 'Replied', 'Closed'],
				badge = ['info', 'success', 'success', 'success', 'success'];

			$('td', row).eq(5).html('').append(
				'<label class="badge badge-' + badge[data[5]] + ' m-0">' + status[data[5]] + '</label>'
			);

			if (data[9].length > 0) {
				$('td', row).eq(6).html('').append(
					'<span class="text-success" style="border-bottom: 1px dotted" data-toggle="tooltip" data-placement="bottom" title="' + data[6] + '">' +
					data[9].length + ' Topic' + (data[9].length > 1 ? 's' : '') +
					'</span>'
				);
			}

			// var attachment = JSON.parse(data[5]);
			//
			// if (data[5]) {
			// 	$('td', row).eq(5).html('').append(
			// 		'<a href="' + baseUrl + '/storage/' + attachment[0].download_link + '" class="text-muted" target="_blank"><i class= "fa fa-paperclip"></i></a>'
			// 	);
			// }

		}


	});

	// trigger all table checkboxes
	$('th.check-mail .i-checks').on('ifToggled', function (event) {
		if ($(this).hasClass('check-all')) {
			$('td .i-checks:not(.check-all)').iCheck(this.checked ? 'check' : 'uncheck');
		}
	});

	// move to trash
	$(document).on('click', '.move-to-trash', function (e) {
		e.preventDefault();

		var ids = $('.i-checks:checkbox:checked').map(function () {
			return $(this).val();
		}).get();

		if (ids.length == 0) {
			toastr.error('Please select at least 1 letter to trash.');
		}

		$.ajax({
			type: 'POST',
			url: baseUrl + '/admin/correspondence/letters/move-to-trash',
			data: {
				'ids': ids
			},
			success: function (response) {
				console.log(response);
				if (response.success) {
					toastr.success(response.message);
					setTimeout(function () {
						window.location.reload();
					}, 1000);
				}
				else {
					toastr.error('An error has occurred. Please try again.');
				}

			}, error: function (err) {
				console.log(err);
			}
		});
	});

	// filter checkbox change
	$('.i-checks.checkbox-filter').on('ifToggled', function (event) {
		var directions = $('.i-checks[name="direction[]"]:checked').map(function () {
			return $(this).val();
		}).get();

		var contacts = $('.i-checks[name="contact[]"]:checked').map(function () {
			return $(this).val();
		}).get();

		var topics = $('.i-checks[name="topic[]"]:checked').map(function () {
			return $(this).val();
		}).get();

		var tasks = $('.i-checks[name="task[]"]:checked').map(function () {
			return $(this).val();
		}).get();

		$('[name="hdn_directions"]').val(directions);
		$('[name="hdn_contacts"]').val(contacts);
		$('[name="hdn_topics"]').val(topics);
		$('[name="hdn_tasks"]').val(tasks);

		$('#messages_table').DataTable().ajax.reload();
        $('#messages_sent_table').DataTable().ajax.reload();
	});


	$(document).on('click', '#btn_search', function (e) {
		e.preventDefault();
		console.log('search clicked');
		$('#messages_table').DataTable().ajax.reload();
        $('#messages_sent_table').DataTable().ajax.reload();

	});

    $("#contact").change(function() {
        $('#messages_table').DataTable().ajax.reload();
        $('#messages_sent_table').DataTable().ajax.reload();
    });
	// create new topic
	$(document).on('click', '.create-new-topic', function (e) {
		e.preventDefault();

		$('#new_topic').removeClass('border-danger');

		var topic = $('#new_topic').val();
		if (topic == '') {
			$('#new_topic').addClass('border-danger');
		}
		else {

			$.ajax({
				type: 'POST',
				url: baseUrl + '/admin/topic/save',
				data: {
					'title': topic,
					'type': 0
				},
				success: function (response) {
					if (response.success) {
						$('.topics').append('<a href="" class="btn btn-xs btn-success mr-2 mb-2" data-id="' + response.topic.id + '">' + response.topic.title + '</a>');
						$('#new_topic').val('');
					}
					else {
						toastr.error('An error occurred.');
					}
				},
				error: function (err) {
					console.log(err);
				}
			});
		}
	});

	// assign/remove topic
	$(document).on('click', '.topics > a', function (e) {
		e.preventDefault();

		$(this).toggleClass('assigned');
	});

	// create new task
	$(document).on('click', '.create-new-task', function (e) {
		e.preventDefault();

		$('#new_task').removeClass('border-danger');

		var task = $('#new_task').val();
		if (task == '') {
			$('#new_task').addClass('border-danger');
		}
		else {
			$.ajax({
				type: 'POST',
				url: baseUrl + '/admin/task/save',
				data: {
					'skip': 1,
					'title': task,
					'type': 0,
					'status': 0
				},
				success: function (response) {
					if (response.success) {
						$('.tasks').append('<a href="" class="btn btn-xs btn-success mr-2 mb-2" data-id="' + response.task.id + '">' + response.task.title + '</a>');
						$('#new_task').val('');
					}
					else {
						toastr.error('An error occurred.');
					}
				},
				error: function (err) {
					console.log(err);
				}
			});
		}
	});

	// assign/remove task
	$(document).on('click', '.tasks > a', function (e) {
		e.preventDefault();

		$(this).toggleClass('assigned');
	});

	// save assigned topics
	$(document).on('click', '.btn-assign-topics', function (e) {
		e.preventDefault();
		let topic_ids = [];
		$('.topics a.assigned').each(function () {
			topic_ids.push($(this).attr('data-id'));
		});

		$.ajax({
			url: baseUrl + '/admin/topic/assign',
			type: 'POST',
			data: {
				topic_ids: topic_ids,
				type: 0,
				listing_id: $(this).attr('data-letter')
			},
			success: function (data) {
				if (data.success == false) {
					console.log(data);
					toastr.error('There was an error in assigning topics.');
				} else {
					toastr.success(data.message);
					$('#topics_modal').modal('hide');
					setTimeout(function () {
						location.reload();
					}, 1000);

				}

			}
		});
	});

	// save assigned tasks
	$(document).on('click', '.btn-assign-tasks', function (e) {
		e.preventDefault();
       let topic_ids = [];
		$('.topics a.assigned').each(function () {
            topic_ids.push($(this).attr('data-id'));
		});

		$.ajax({
			url: baseUrl + '/admin/task/assign',
			type: 'POST',
			data: {
                topics: topic_ids,
				type: 0,
				listing_id: $(this).attr('data-letter'),
				status: 0,
                users: $('#user_id').val(),
                title: $('#title').val(),
                due_date: $('#due_date').val(),
                contents: $('#hdn_summary').val(),
			},
			success: function (data) {
				if (data.success == false) {
					console.log(data);
					toastr.error('There was an error in assigning tasks.');
				} else {
					toastr.success(data.message);
					$('#tasks_modal').modal('hide');
					setTimeout(function () {
						location.reload();
					}, 1000);

				}

			}
		});
	});

	//
	// $('#tasks_modal').on('show.bs.modal', function (e) {
	// 	console.log('asdasdsa');
	// 	$('.summernote').summernote({
	// 		height: 200,
	// 		toolbar: [
	// 			// [groupName, [list of button]]
	// 			['style', ['bold', 'italic', 'underline', 'clear']],
	// 			['font', ['strikethrough', 'superscript', 'subscript']],
	// 			['fontsize', ['fontsize']],
	// 			['color', ['color']],
	// 			['para', ['ul', 'ol', 'paragraph']],
	// 			['insert', ['link']],
	// 			['view', ['codeview']],
	// 		]
	// 	});
	// });


    $('#new_topic').keypress(function (e) {
        if(e.which == 13) {
            e.preventDefault();
            console.log('done');

            $('#new_topic').removeClass('border-danger');

            var topic = $('#new_topic').val();
            if (topic == '') {
                $('#new_topic').addClass('border-danger');
            }
            else {

                $.ajax({
                    type: 'POST',
                    url: baseUrl + '/admin/topic/save',
                    data: {
                        'title': topic,
                        'type': 0
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.topics').append('<a href="" class="btn btn-xs btn-success mr-2 mb-2" data-id="' + response.topic.id + '">' + response.topic.title + '</a>');
                            $('#new_topic').val('');
                        }
                        else {
                            toastr.error('An error occurred.');
                        }
                    },
                    error: function (err) {
                        console.log(err);
                    }
                });
            }
        }
    });

});