<script type="text/javascript">
	$(function(){

		$("[name=project]").change(function(){
			var projectId = $(this).val();

			var formData = new FormData();
			formData.append('projectId',projectId);

			if(projectId!="")
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
									$("[name=category]").prop("disabled",true);
								}
								else if(result.success[0]['billable']=="N")
								{
									$("[name=category]").val("non-Billable");
									$("[name=category]").prop("disabled",true);
								}
							}

							if(typeof result.error !== "undefined")
							{
								errorAlert(result.error);
							}
						}
					}
				}

				request.open("POST","<?php echo base_url(); ?><?php echo $class ?>/getProjectDetails");
				request.send(formData);
			}
			else
			{
				$("[name=category]").val("billable");
				$("[name=category]").prop("disabled",false);
			}
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