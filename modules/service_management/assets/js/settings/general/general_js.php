<script type="text/javascript">
	function auto_create_change_setting(invoker){
		"use strict";
		var input_name = invoker.value;
		var input_name_status = $('input[id="'+invoker.value+'"]').is(":checked");

		var data = {};
		data.input_name = input_name;
		data.input_name_status = input_name_status;

		$.post(admin_url + 'service_management/sm_check_box_setting', data).done(function(response){
			response = JSON.parse(response); 
			if (response.success == true) {
				alert_float('success', response.message);
			}else{
				alert_float('warning', response.message);

			}
		});

	}
</script>