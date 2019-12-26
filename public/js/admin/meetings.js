$(function () {

	if ($('.input-daterange').length) {
		$('.input-daterange').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			startDate: 'today',
			todayHighlight: true
		});
	}

	if ($('.clockpicker').length) {
		$('.clockpicker').clockpicker();
	}

	if ($('.chosen-select').length) {
		$('.chosen-select').chosen({
			width: '100%'
		});
	}

	// show create topic/task fields
	$(document).on('click', '.create-trigger', function (e) {
		e.preventDefault();
		$(this).addClass('hide');
		$(this).next('.new-topic-task').removeClass('hide');
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
						$('.topics').append('<a href="" class="btn btn-xs btn-secondary mr-2 mb-2" data-id="' + response.topic.id + '">' + response.topic.title + '</a>');
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
						$('.tasks').append('<a href="" class="btn btn-xs btn-secondary mr-2 mb-2" data-id="' + response.task.id + '">' + response.task.title + '</a>');
						$('#new_task').val('');
						$('#new_task_due_date').val('');
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

	// topic modal on hide
	$('#topics_modal, #tasks_modal').on('hidden.bs.modal', function (e) {
		$(this).find('.create-trigger').removeClass('hide');
		$(this).find('.new-topic-task').addClass('hide');
		$(this).find('.new-topic-task input').val('');
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
				type: 1,
				listing_id: $(this).attr('data-mom'),
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

	$('.create-new-topicc').keypress(function (e) {
		if (e.which == 13) {
			e.preventDefault();
			console.log('done');

			$('#new_topic').removeClass('border-danger');

			var topic = $('#new_topic').val();
			if (topic == '') {
				$('#new_topic').addClass('border-danger');
				console.log('it is null');
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

	// add topic to minutes of meeting recording
	$(document).on('click', '#mom-recording .btn-add-topic', function (e) {
		e.preventDefault();

		var $topic = $('.topic-placeholder').html();

		$('#frm_recording .topics').append($topic);
		$('#frm_recording .topics .select2').select2();
	});

	// add topic to MOM
	$(document).on('click', '.topic-add', function (e) {
		e.preventDefault();

		let type = $(this).attr('data-type');
		$(this).closest('div').addClass('hide');
		$('.' + type + '-topic').removeClass('hide');
		$(this).closest('.ibox-content').find('.tasks').removeClass('hide');
		
	});

	// add task
	$(document).on('click', '.btn-add-task', function (e) {
		e.preventDefault();

		$(this).closest('.tasks').find('.tasks-table tbody').append(
			'<tr>' +
				'<td></td>' + 
				'<td><input type="task_title[]" class="form-control form-control-sm"></td>' + 
				'<td><select name="topic_[]" id="topic_id" class="select2 form-control-form-control-sm" multiple>' +
							'<option value="0">John Doe</option>' +
							'<option value="1">Lorem ipsum</option>' +
						'</select ></td>' + 
			'<td><div class="input-daterange input-group">' + 
						'<input type="text" class="form-control-sm form-control text-left" name="due_date" id="due_date">' + 
					'</div></td>' + 
			'</tr>'
		);

		$(this).closest('.tasks').find('tbody tr:last-child .select2').select2();
		$(this).closest('.tasks').find('tbody tr:last-child .input-daterange').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			startDate: 'today',
			todayHighlight: true
		});
	});

});