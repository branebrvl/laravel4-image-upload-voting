$(function() {
	$('form.task-update-form input').click(function () {
		var form = $(this).parent();
		var checked = $(this).prop('checked');
		
		var completed = checked ? 1 : 0;
		
		$.ajax({
			url: $(form).attr('action'),
			data: { '_method': $("[name='_method']", form).val(), 'completed': completed },
			type: 'POST',
			success: function (res) { console.log(res); },
			error: function (res) { console.log(res); }
		});
		
		var displayClass = checked ? form.parent().addClass('completed'): form.parent().removeClass('completed');
	});
	
	
	$('a.task-delete').click(function () {
		var task_id = $(this).data('task-id');
		
		if (confirm("Are you sure you want to delete this task?")) {
			$.ajax({
				url: '/tasks/delete',
				data: { '_method': 'DELETE', 'task_id': task_id },
				type: 'POST',
				success: function (res) { console.log(res); },
				error: function (res) { console.log(res); }
			});
			
			
			$(this).parent().hide();
		}
		
		return false;
	});
});