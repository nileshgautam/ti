<script type="text/javascript">
	$(function(){
		var refClass = "<?php echo $class; ?>";
		$("#addProject").click(function(e){
			e.preventDefault();
			$("#projectModal").modal("show");
		});

		$("[name=project]").change(function(){
			var projectId = $(this).val();

			if(projectId!="")
			{
				var formData = new FormData();
				formData.append("projectId",projectId);

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

						if(result!=="")
						{
							if(typeof result.success !== "undefined")
							{
								var html = "<option value=''>Select Task</option>";

								for(var i=0;i<result.success.length;i++)
								{
									html += "<option value='"+result.success[i].taskId+"'>"+result.success[i].taskName+"</option>"
								}

								$("[name=task]").html(html)
							}

							if(typeof result.error !== "undefined")
							{
								errorAlert(result.error);
							}
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?>"+refClass+"/getTaskByproject");
				request.send(formData);
			}
		});

		$("#save").click(function(){
			var project = $("[name=project]");
			var task = $("[name=task]");
			var startDate = $("[name=startDate]");
			var endDate = $("[name=endDate]");
			var hours = $("[name=hours]");
			var userId = $("[name=userId]");
			var error = "";

			if(project.val()=="")
			{
				error = "Please select project";
			}

			if(error!="")
			{
				errorAlert(error);
				return false;
			}

			var formData = new FormData();

			formData.append('project',project.val());
			formData.append('task',task.val());
			formData.append('startDate',startDate.val());
			formData.append('endDate',endDate.val());
			formData.append('userId',userId.val());
			formData.append('hours',hours.val());

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

					if(result!=="")
					{
						if(typeof result.success !== "undefined")
						{
							successAlert(result.success);
							setTimeout(function(){
								location.reload();
							},4000);
						}

						if(typeof result.error !== "undefined")
						{
							errorAlert(result.error);
						}
					}
				}
			}

			request.open("POST","<?php echo base_url(); ?>"+refClass+"/allocateProjectToUser");
			request.send(formData);

		});

		function errorAlert(errorMessage=null)
		{
			toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                preventDuplicates: true,
                timeOut: 4000,
                positionClass: "toast-top-right"
            };
            toastr.error(errorMessage, 'Error');
		}

		function successAlert(successMessage=null)
		{
			toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                preventDuplicates: true,
                timeOut: 4000,
                positionClass: "toast-top-right"
            };
            toastr.success(successMessage, 'Success');

		}
	});
</script>