<script type="text/javascript">
	$(function(){

		$("[name=task]").change(function(){
			var taskId = $(this).val();

			var formData = new FormData();
			formData.append('taskId',taskId);

			if(taskId!="")
			{
				var request = new XMLHttpRequest;
				request.onreadystatechange = function(){
					if(this.readyState==4 && this.status==200)
					{
						var content = request.responseText.trim();
						var result = "";

						try
						{
							result = JSON.parse(content);
						}
						catch(e){}

						if(result!="")
						{
							if(typeof result.success !== "undefined")
							{
								if(result.success[0]['billable']=="Y")
								{
									$("[name=category]").val("billable");
									$("[name=category]").prop("readonly",true);
								}
								else if(result.success[0]['billable']=="N")
								{
									$("[name=category]").val("non-Billable");
									$("[name=category]").prop("readonly",true);
								}
							}

							if(typeof result.error !== "undefined")
							{
								errorAlert(result.error);
							}
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?><?php echo $class ?>/getTaskDetails");
				request.send(formData);
			}
			else
			{
				$("[name=category]").val("billable");
				$("[name=category]").prop("disabled",false);
			}
		});



	});
</script>