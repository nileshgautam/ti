<script type="text/javascript">
	$(function() {

		$('#addProject').click(function(e) {
			e.preventDefault();
			var task = $("#projects").find("tbody > tr").find(".task");

			// console.log(task);
			var container = [];

			// console.log(task);

			for (var i = 0; i < task.length; i++) {
				// console.log(task.eq(i));
				if (task.eq(i).is(":checked")) {
					// console.log(task.eq(i));
					if (task.eq(i).attr("id") !== undefined) {
						container.push({
							taskId: task.eq(i).attr("id")
						});
					}
				}
			}
			
			console.log(container);

			if (container.length == 0) {
				errorAlert('Please select at least one task');
			} else {
				var formData = new FormData();
				formData.append("tasks", JSON.stringify(container));

				var request = new XMLHttpRequest;
				request.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						var content = request.responseText.trim();
						var result = "";
						try {
							result = JSON.parse(content);
						} catch (e) {}

						if (result != "") {
							if (typeof result.success !== "undefined") {
								successAlert(result.success);
								setTimeout(function() {
									location.reload();
								}, 4000);
							}

							if (typeof result.error !== "undefined") {
								errorAlert(result.error);
							}
						}
					}
				}

				request.open("POST", "<?php echo base_url(); ?><?php echo $class; ?>/addAllocatePost");
				request.send(formData);
			}
		});

		function errorAlert(errorMessage = null) {
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

		function successAlert(errorMessage = null) {
			toastr.options = {
				closeButton: true,
				progressBar: true,
				showMethod: 'slideDown',
				preventDuplicates: true,
				timeOut: 4000,
				positionClass: "toast-top-right"
			};
			toastr.success(errorMessage, 'Success');

		}

	});
</script>