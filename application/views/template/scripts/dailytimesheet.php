<script type="text/javascript">
	$(function() {

		let timeIsAvailble = true;
		$('.dailytimesheet').on('click', '.time-box', function() {
			$('#projectid').val($(this).attr('data-project'));
			$('#serviceid').val($(this).attr('data-service'));
			$('#taskid').val($(this).attr('data-taskId'));
			$('#clientid').val($(this).attr('data-client'));
			$('#dailyTimesheetModalLong').modal('show');

			let url = BASEURL + 'Employee/getBookedTime';
			$.post(url, function(data) {
				if (data) {
					// console.log(data);
					data = JSON.parse(data);
					saveLsData('bookedTime', data);
				}
			});

		});

		$('.show-time').timepicker({
			'step': 15,
			minTime: '7:00:00',
			maxTime: '23:00:00',
		});

		$('.show-end-time').timepicker({
			'step': 15,
			minTime: '7:00:00',
			maxTime: '24:00:00',
		});

		$('#st-time').on('change', () => {
			let st = $('#st-time').val();
			let et = addTime(st, 60);
			let endt = addTime(st, 15);


			ts = timeSlots($('#st-time').val(), et, 15);
			let option = '';
			ts.map((element) => {
				option += `<option value="${element}">${element}</option>`;
			});

			$('#et-time').html(option);
			$('#et-time').val(endt);
		});
		// Function to check if Sloat avaible
		$('#et-time').change(function() {

			stTime = $('#st-time').val()
			endTime = $('#et-time').val()
			let url = BASEURL + 'Employee/isAvaible';
			console.log(`st Time${stTime} End: ${endTime}`);

			if (endTime) {
				$.post(url, {
					stTime,
					endTime
				}, (data) => {
					console.log(endTime);
					let res = JSON.parse(data);
					if (res.message === 'true') {
						timeIsAvailble = false;
						$('#isAvailble').removeClass('hide');
						$('#isAvailble').addClass('text-danger');
						$('#isAvailble').text('Time slot already booked, Choose another');

					} else {
						$('#isAvailble').addClass('hide');
						timeIsAvailble = true;
					}

				});
			}

		});

		// Function to save dailytimesheet 
		$('#savedailytimesheet').submit(function(e) {
			e.preventDefault();
			let stTime = $('#st-time').val();
			let edTime = $('#et-time').val();
			let sdate = $('#s-date').val();
			let ssdate = $('#ssdate').val();
			let description = $('#description').val();
			let taskId = $('#taskid').val();
			let projectId = $('#projectid').val();
			let servicesId = $('#serviceid').val();
			let clientid = $('#clientid').val();
			let files = $('#files').val();

			let formData = {
				projectId: projectId,
				servicesId: servicesId,
				taskId: taskId,
				clientid: clientid,
				description: description,
				stTime: stTime,
				edTime: edTime,
				selectedDate: sdate,
				updatedDate: ssdate
			};

			let url = BASEURL + 'Employee/updateTask';
			let st = addTime(stTime);
			let status = checkTime(stTime, edTime);

			if (timeIsAvailble) {
				if (stTime >= edTime) {
					errorAlert('Start time should be less from End time');
					return false;
				} else {
					let bookedTime = retriveLsData('bookedTime');
					if (bookedTime === 'false') {
						// console.log('if false');
						formData.fileData = (files === '') ? removeLsData('taskFile') : retriveLsData('taskFile');
						$.post(url, formData, function(data) {
							data = JSON.parse(data);
							(data.type === 'success') ? successAlert(data.message): errorAlert(data.message);
							$('#dailyTimesheetModalLong').modal('hide');
							$('#savedailytimesheet').trigger("reset");
							setTimeout(() => {
								window.location.reload();
							}, 4000);
						});
					} else if ((bookedTime != '') && (bookedTime.length != false)) {
						let bookedTimeSlots = JSON.parse(bookedTime);
						insertTimeSlots = [{
							stTime: stTime,
							edTime: edTime
						}];
						let status = check_time_orverRide(insertTimeSlots, bookedTimeSlots);

						console.log(status);

						if (status) {
							formData.fileData = (files === '') ? removeLsData('taskFile') : retriveLsData('taskFile');

							// console.log(formData);

							$.post(url, formData, function(data) {
								data = JSON.parse(data);
								(data.type === 'success') ? successAlert(data.message): errorAlert(data.message);
								$('#dailyTimesheetModalLong').modal('hide');
								$('#savedailytimesheet').trigger("reset");
								setTimeout(() => {
									window.location.reload();
								}, 4000);
							});
						} else {
							errorAlert('Choose diffrent time slot already booked');
							return false;
						}
					}
				}
			} else {
				errorAlert('Time override not allowed');
			}


		});

		// Upload frash file
		$('#files').change(function() {
			// let file = $(this).prop('files')[0];
			let formData = new FormData();
			let projectId = $('#projectid').val();
			formData.append('projectid', projectId);
			let url = BASEURL + 'Employee/uploadFile';

			// Read selected files
			let totalfiles = document.getElementById('files').files.length;
			for (let index = 0; index < totalfiles; index++) {
				formData.append("files[]", document.getElementById('files').files[index]);
			}
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function(data) {
					if (data) {
						data = JSON.parse(data);
						saveLsData('taskFile', data);
						console.log(data);
					}
				},
				cache: false,
				contentType: false,
				processData: false
			});
		});

		//update Uploaded file
		$('#up-files').change(function() {
			let projectId = $('#up-projectid').val();
			uploadFile(projectId, 'up-files');
		});
		// Submit selected task
		$('#submit-task').click(() => {
			let url = BASEURL + 'Employee/submitDailyTask';
			let CheckedId = Checked('taskBody', 'tasks');
			// console.log(CheckedId);
			if (CheckedId.length !== 0) {
				$.post(url, {
					data: CheckedId
				}, function(data) {
					data = JSON.parse(data);
					data.type === 'success' ? successAlert(data.message) : errorAlert(data.message);
					setTimeout(() => {
						window.location.reload();
					}, 4000);

				});
			} else if (CheckedId.length === 0) {
				errorAlert('You did not select the task.');
				return false
			}

			// console.log(CheckedId);
		});
		// Function to update task
		$('.edit-task').click(function() {
			let taskId = $(this).attr('data-taskId');
			$('#editmodal').modal('show');

			let url = BASEURL + 'Employee/getTask';

			if (taskId) {
				$.post(url, {
					taskId: taskId
				}, (data) => {
					res = JSON.parse(data);
					console.log(res);
					console.log(res);
					let remarks = (res.remark === '') ? 'No remark' : res.remark;

					$('#manager-remarks').html(remarks);
					$('#up-taskid').val(res.task_id);
					$('#up-projectid').val(res.project_id);

					$('#t-st-time').val(timeConvert12hrs(res.taskStTime));

					let option = `<option value="${timeConvert12hrs(res.taskedTime)}" selected>${timeConvert12hrs(res.taskedTime)}</option>`

					$('#t-et-time').append(option);

					$('#t-description').val((res.userDescription));

					let fileData = '';

					let files = JSON.parse(res.uploadedFiles);

					if (files != '') {
						files.map((file, i) => {
							fileData += `<a href="${BASEURL}${file}" class="pl-5" target="_blank">
                        <img src="${BASEURL}/assets/custom/media/docs.png" alt="File${i+1}" height="50">
                         <p class="pl-2">File${i+1}</p>
                         </a>`;
						});
					}
					// console.log(fileData);

					$('#uploaded-files').html(fileData);

				});
			} else {
				errorAlert('Task not Found');
			}

		});
		// To show edit form
		$('.edit-btn').click(function() {
			console.log('hi');
			$('.task-widget').removeClass('hide');
		});
		// To update task form value into the DB
		$('.update-task').click(function(e) {
			e.preventDefault();
			let taskid = $('#up-taskid').val();
			let url = BASEURL + 'Employee/updateSelectedTask';
			let formData = {
				taskid: $('#up-taskid').val(),
				projectId: $('#up-projectid').val(),
				description: $('#t-description').val(),
				edTime: $('#t-et-time').val(),
				stTime: $('#t-st-time').val(),
				file: retriveLsData('taskFile')
			}
			if (taskid != '') {
				$('#editmodal').modal('hide');
				$.post(url, formData, function(data) {
					console.log(data);
					let res = JSON.parse(data);
					res.type == 'success' ? successAlert(res.message) : errorAlert(res.message);
					setTimeout(() => {
						window.location.reload();
					}, 4000)
				});
			}
		});
	});
	function check_time_orverRide(insertTimeSlots, bookedTimeSlots) {

		iLength = insertTimeSlots.length;
		bLength = bookedTimeSlots.length;
		console.log(iLength);
		console.log(bLength);

		let status = undefined;
		for (let i = 0; i < iLength; i++) {
			console.log(bookedTimeSlots[i]);
			status = checkCanInsert(insertTimeSlots, bookedTimeSlots[i]);
		}
		return status
	}

	function checkCanInsert(insertTimeSlot, bookedTimeSlot) {
		// console.log(insertTimeSlot)
		let bts = tConvert(bookedTimeSlot.start_time);
		let bte = tConvert(bookedTimeSlot.end_time);

		// console.log(bookedTimeSlot)

		if (insertTimeSlot.stTime == bts) {
			return false;
		} else if (insertTimeSlot.stTime < bts) {
			if (insertTimeSlot.edTime <= bts) {
				return true;
			} else {
				return false;
			}
		} else if (insertTimeSlot.stTime < bte) {
			return false;
		} else {
			return true;
		}
	}

	const uploadFile = (projectid, fileid) => {
		let url = BASEURL + 'Employee/uploadFile';
		let formData = new FormData();
		formData.append('projectid', projectid);
		let totalfiles = document.getElementById(`${fileid}`).files.length

		console.log(totalfiles);
		console.log(fileid);
		console.log(url);


		for (let index = 0; index < totalfiles; index++) {
			formData.append("files[]", document.getElementById(`${fileid}`).files[index]);
		}
		// console.log(formData);
		$.ajax({
			url: url,
			type: 'POST',
			data: formData,
			success: function(data) {
				if (data) {
					data = JSON.parse(data);
					saveLsData('taskFile', data);
					console.log(data);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
	};

	const addTime = (time, diff) => {
		let totalTime = time.split(":");
		let hrs = parseInt(totalTime[0]);
		let minute = totalTime[1].slice(0, -2);
		minute = parseInt(diff) + parseInt(minute);
		postFix = totalTime[1].slice(-2);

		if (minute >= 60) {
			minute = parseInt(minute) - 60;
			hrs++;
		}
		minute == 0 ? minute = '00' : minute;
		// console.log(minute);
		if (postFix === 'am' && hrs > 12) {
			hrs = hrs - 12;
			postFix = 'pm';
		} else if (postFix === 'pm' && hrs > 12) {
			hrs = hrs - 12;
		}
		return postTime = `${ parseInt (hrs)}:${minute}${postFix}`
	}

	const timeSlots = (Slot_stime, Slot_etime, diff) => {

		let start_range = Slot_stime.split(":");
		let start_range_hrs = parseInt(start_range[0]);
		let start_range_minute = parseInt(start_range[1].slice(0, -2));
		let postFix = start_range[1].slice(-2);
		let end_range = Slot_etime.split(":");
		let end_range_hrs = parseInt(Slot_etime[0]);
		let end_range_minute = parseInt(Slot_etime[1].slice(0, -2));
		TimeSlt = [];
		let time = 0;

		while (time < 60) {
			time = time + parseInt(diff);
			let slt = 0;
			if (time == 60) {
				let hrs = start_range_hrs + 1;
				hrs = hrs > 12 ? hrs - 12 : hrs;
				if (Slot_stime == '11:00pm') {
					slt = `${hrs}:00am`;
				} else if (Slot_stime == '11:00am') {
					slt = `${hrs}:00pm`;
				} else {
					slt = `${hrs}:00${postFix}`;
				}
				TimeSlt.push(slt);
			} else if (time < 60) {
				slt = `${start_range_hrs}:${time}${postFix}`;
				TimeSlt.push(slt);
			}
		}
		console.log(TimeSlt);
		return TimeSlt;
	};

	const checkTime = ((stTime, edTime) => {

		let start_range = stTime.split(":");
		let start_range_hrs = parseInt(stTime[0]);
		let start_range_minute = parseInt(stTime[1].slice(0, -2));
		let postFixST = start_range[1].slice(-2);
		let end_range = edTime.split(":");
		let end_range_hrs = parseInt(edTime[0]);
		let end_range_minute = parseInt(edTime[1].slice(0, -2));
		let postFixET = start_range[1].slice(-2);

		let startTime = undefined;
		let endTime = undefined;

		if (postFixST == 'am' && postFixET == 'am') {
			startTime = (parseInt(start_range_hrs) * 60) + parseInt(start_range_minute);
		} else if (postFixST == 'pm' && postFixET == 'pm') {
			endTime = (parseInt(start_range_hrs) * 60) + parseInt(start_range_minute);
		}
		if (postFixST == 'am' && postFixET == 'am') {
			return start_range_hrs >= end_range_hrs
		}

	});









	// timeSlotFrom = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23];
	// timeSlotTo = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24];

	// bookedTimeSlots = [
	// 	[7, 7.5],
	// 	[8, 8.5],
	// 	[10, 13.50]
	// ];
	// insertTimeSlots = [
	// 	[7, 7.5],
	// 	[6.5, 7],
	// 	[7.5, 8],
	// 	[8.5, 10]
	// ];


	// iLength = insertTimeSlots.length;
	// bLength = bookedTimeSlots.length;

	// top: for (let i = 0; i < 24; i++) {
	// 	console.log(`${timeSlotFrom[i]}-${timeSlotTo[i]} \n`);
	// 	for (let j = 0; j < iLength; j++) {
	// 		let flag = false;
	// 		for (let k = 0; k < bLength; k++) {
	// 			flag = checkCanInsert(insertTimeSlots[j], bookedTimeSlots[k]);
	// 			if (!flag) {
	// 				console.log(`Can't insert ${insertTimeSlots[j]} in ${bookedTimeSlots[k]}`);
	// 				break top;
	// 			}
	// 		}

	// 	}

	// 	function checkCanInsert(insertTimeSlot, bookedTimeSlot) {
	// 		if (insertTimeSlot[0] == bookedTimeSlot[0]) {
	// 			return false;
	// 		} else if (insertTimeSlot[0] < bookedTimeSlot[0]) {
	// 			if (insertTimeSlot[1] <= bookedTimeSlot[0]) {
	// 				return true;
	// 			} else {
	// 				return false;
	// 			}
	// 		} else if (insertTimeSlot[0] < bookedTimeSlot[1]) {
	// 			return false;
	// 		} else {
	// 			return true;
	// 		}
	// 	}

	// }
</script>