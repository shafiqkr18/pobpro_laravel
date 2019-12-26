$(function () {

	// $('.i-checks').iCheck({
	// 	checkboxClass: 'icheckbox_square-green',
	// 	radioClass: 'iradio_square-green',
	// });

	$(document).on('change', '[name="check_sub"]', function (e) {
		if ($(this).hasClass('has-children')) {
			$(this).closest('.role-group').find('.name').find('input[type="checkbox"]').prop('checked', this.checked);
			$(this).closest('.role-group').find('.function').find('[name="permission[]"]').prop('checked', this.checked);
		}
		// else {
		$(this).closest('.permission-row').find('.function').find('[name="permission[]"]').prop('checked', this.checked);
		// }

		checkParentProp($(this));
	});

	function checkParentProp(el) {

		var parentId = el.attr('data-parent');

		if (parentId > 0) {
			updateParentProp(el);
		}
	}

	function updateParentProp(el) {
		var parentId = el.attr('data-parent');

		if (el.prop('checked')) {
			$('[data-id="' + parentId + '"]').prop('checked', true);
			$('[data-id="' + parentId + '"]').closest('.permission-row').find('.function').find('[name="permission[]"]').prop('checked', true);
		}
		else {
			var hasChecked = false;
			$('[data-parent="' + parentId + '"]').each(function () {
				if ($(this).prop('checked')) {
					hasChecked = true;
				}
			});

			if (!hasChecked) {
				$('[data-id="' + parentId + '"]').prop('checked', false);
				$('[data-id="' + parentId + '"]').closest('.permission-row').find('.function').find('[name="permission[]"]').prop('checked', false);
			}
		}

		if ($('[data-id="' + parentId + '"]').attr('data-parent') > 0) {
			var parent = $('[data-id="' + parentId + '"]');
			checkParentProp(parent);
		}
		// else {
		// 	console.log('#' + parentId);
		// 	$('#' + parentId).closest('.role-group').find('.function').find('[name="permission[]"]').prop('checked', this.checked);
		// }
	}

	$(document).on('change', '.function input[type="checkbox"]', function (e) {
		$(this).closest('.permission-row').find('.name').find('input[type="checkbox"]').prop('checked', this.checked);
		$(this).closest('.permission-row').find('.name').find('input[type="checkbox"]').trigger('change');
		checkParentProp($(this).closest('.permission-row').find('.name').find('input[type="checkbox"]'));
	});

});