<script type="text/javascript">
	$(function(){

		$("#addProject").click(function(e){
			e.preventDefault();
			$("#projectModal").modal("show");
		});


		$("#save").click(function(){
			var project = $("[name=project]");
			var startDate = $("[name=startDate]");
			var endDate = $("[name=endDate]");
			var hours = $("[name=hours]");
			var userId = $("[name=userId]");
			var error = "";

			if(project.val()=="")
			{
				error = "Please select project";
			}
			else if($.trim(hours.val())=="")
			{
				error = "Please enter budegted hours";
			}
			else if($.trim(startDate.val())=="")
			{
				error = "Please select start date";
			}
			else if($.trim(endDate.val())=="")
			{
				error = "Please select end date";
			}

			if(error!="")
			{
				errorAlert(error);
				return false;
			}

			var formData = new FormData();

			formData.append('project',project.val());
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

			request.open("POST","<?php echo base_url(); ?>Manager/allocateProjectToUser");
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