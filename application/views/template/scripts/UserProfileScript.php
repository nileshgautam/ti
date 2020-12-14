<script type="text/javascript">
	$(function(){

		$("#userForm").on("submit",function(e){
			e.preventDefault();

			var formData = new FormData(this);

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

			request.open("POST","<?php echo base_url(); ?><?php echo $class; ?>/saveUserDetails");
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