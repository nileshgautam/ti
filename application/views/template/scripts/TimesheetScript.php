<script type="text/javascript">
	$(function() {
		var numericPattern = /^[0-9]+$/;

		<?php
		if ($dateDetails['timesheetWeeklyDetails']) {
			$status = $dateDetails['timesheetWeeklyDetails'][0]['status'];
			if ($status == 'submitted' || $status == 'approved') {
		?>
				$(".timesheetTable").find('tbody tr td').find('input').prop('disabled', true);
		<?php
			}
		}
		?>

		$("#submitTimesheet").click(function() {
			var week = parseInt($("[name=currentWeek]").val());
			var year = $("[name=year]").val();
			var columns = $(".timesheetTable").find("tfoot").find(".totalColumn");
			var columnTotalFlag = false;

			for (var j = 0; j < columns.length; j++) {
				var colTotal = columns.eq(j).attr("id");
				if (colTotal == 0) {
					// columnTotalFlag = true;
				}
			}

			if (columnTotalFlag) {
				errorAlert('Please complete timesheet before submit');
				return false;
			}

			var formData = new FormData();
			formData.append('week', week);
			formData.append('year', year);

			var request = new XMLHttpRequest;
			request.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var content = request.responseText.trim();
					var result = '';

					try {
						result = JSON.parse(content);
					} catch (e) {}

					if (result != '') {
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

			request.open("POST", "<?php echo base_url(); ?><?php echo $class; ?>/submituserTimesheetData");
			request.send(formData);
		});

		$("#saveTimesheet").click(function() {
			var tasks = $(".timesheetTable").find("tbody > tr");
			var container = [];
			var week = parseInt($("[name=currentWeek]").val());
			// var year = $("[name=year]").val();

			for (var i = 0; i < tasks.length; i++) {
				var column = tasks.eq(i).find("td");
				var taskId = tasks.eq(i).attr("id");
				var projectId = tasks.eq(i).attr("projectId");

				for (var j = 0; j < column.length; j++) {
					if (column.eq(j).has('input')) {
						var hours = column.eq(j).find(".hours").val();
						var date = column.eq(j).find(".hours").attr('date');
						if ($.trim(hours) != "") {
							if ($.trim(hours) <= 24) {
								container.push({
									taskId: taskId,
									projectId: projectId,
									date: date,
									hours: hours,
								});
							}
							else{
								alert("Invalid Entry")
								$.trim(hours)='';
								return;

							}

						}
					}
				}
			}

			var formData = new FormData();
			formData.append("timesheetData", JSON.stringify(container));
			formData.append('week', week);
			// formData.append('year',year);

			var request = new XMLHttpRequest;
			request.onreadystatechange = function() {
				if (this.readyState = 4 && this.status == 200) {
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

			request.open("POST", "<?php echo base_url(); ?><?php echo $class; ?>/saveTimesheetData");
			request.send(formData);

		});

		$("[name=removeProject]").click(function(e) {

			var container = [];
			var timesheet = $(".timesheetTable").find("tbody > tr > td").find(".project");

			for (var i = 0; i < timesheet.length; i++) {
				if (timesheet.eq(i).is(":checked")) {
					container.push({
						taskId: timesheet.eq(i).attr("id")
					});
				}
			}

			if (container.length == 0) {
				errorAlert('Please select any one task to remove from timesheet');
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

				request.open("POST", "<?php echo base_url(); ?><?php echo $class; ?>/removeTaskFromTimesheet");
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

		function successAlert(successMessage = null) {
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