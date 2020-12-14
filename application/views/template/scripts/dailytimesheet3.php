<script type="text/javascript">
	$(function() {
		let userId = '<?php echo $_SESSION['logged_in']['people_id'] ?>';

		let timeIsAvailble = true;

		// $('.show-time').timepicker({
		// 	'step': 15,
		// 	minTime: '7:00:00',
		// 	maxTime: '23:00:00',
		// });

		$('body').on('focus', ".show-time", function() {
			$(this).timepicker({
				'step': 15,
				minTime: '7:00:00',
				maxTime: '23:00:00',
			})
		});

		$('.show-end-time').timepicker({
			'step': 15,
			minTime: '7:00:00',
			maxTime: '24:00:00',
		});


		// Function to check if Sloat avaible
		$('#to-time').change(function() {
			stTime = $('#from-time').val()
			endTime = $('#to-time').val()
			let url = BASEURL + 'Employee/getBookedTime';
			if (endTime) {
				$.post(url, (data) => {
					let res = JSON.parse(data);
					// console.log(res);
					if (res === false) {
						timeIsAvailble == true;
					} else {
						saveLsData('BookedSlots', res);
						timeIsAvailble == false;
					}
				});
			}
		});


		$('.task-list').change(function() {
			// console.log('hi')
			$('#task-id').val($(this).find('option:selected').val());
			$('#project-id').val($(this).find('option:selected').attr('project-id'));
			$('#client-id').val($(this).find('option:selected').attr('client-id'));
			$('#service-id').val($(this).find('option:selected').attr('servicesId'));

		});

		const insertTaskData = () => {
			let url = BASEURL + 'Employee/updateTask';
			let obj = {
				taskId: $('#task-id').val(),
				stTime: $('#from-time').val(),
				edTime: $('#to-time').val(),
				projectId: $('#project-id').val(),
				clientid: $('#client-id').val(),
				servicesId: $('#service-id').val(),
				description: $('#description').val(),
			}
			$.post(url, obj, function(res) {
				res = JSON.parse(res)
				// console.log(res);
				loadData();
			});
		}

		const loadData = () => {
			let url = BASEURL + 'Employee/getAllTask';
			$.post(url, function(res) {
				res = JSON.parse(res)
				saveLsData('allTask', res);
				loadTable(res);
			});
		}
		const loadTable = (res = null) => {
			let html = '';
			if (res) {
				res.map((el) => {
					borderColor = ''
					console.log(el);
					if (el.status == 'submitted') {
						borderColor = 'border-primary';
					} else if (el.status == 'Saved') {
						borderColor = 'border-warning';
					} else if (el.status == 'rejected') {
						borderColor = 'border-danger';
					} else if (el.status == 'approved') {
						borderColor = 'border-success';
					}
					html += `<div class="row border-top ${borderColor} py-2" >
						<div class="col-sm-3 row m-0">
						<div class="col-sm-1">`;
					if (el.status == 'submitted') {
						html += `<input type="checkbox"  class="task" checked='true' value="${el.task_id}" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)}>`;
					} else {
						html += `<input type="checkbox"  class="task " value="${el.task_id}" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)}>`;
					}
					html += `
						</div>
							<div class="col-sm-11"><p class="userDescription fs-13" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)} data-projectid=${btoa(el.project_id)}>${el.userDescription}</p></div>
						</div>
                        <div class="col-sm-3">
						<span class="fs-13">${el.title}</span>
                        </div>
                        <div class="col-sm-2">
						<input type="text" class="show-time w-72 form-control task-st fs-13" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)} data-projectid=${btoa(el.project_id)} value="${timeConvert12hrs(el.taskStTime)}"/>
						</div>

                        <div class="col-sm-2">
						<input type="text" class="show-time w-72 form-control task-et fs-13" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)} data-projectid=${btoa(el.project_id)} value="${timeConvert12hrs(el.taskedTime)}"/>

						</div>
						<div class="col-sm-2">`;
					if (el.uploadedFiles != 'No-files') {
						html += `	<span class="ml-2 btn btn-primary btn-xs showTaskFile fs-13" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)} data-projectid=${btoa(el.project_id)}>
						<i class="fa fa-eye" aria-hidden="true"></i>
						</span>
					
						<span class="ml-2 btn btn-danger btn-xs deleteTask fs-13" data-et=${btoa(el.taskedTime)}
						data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)}><i class="fa fa-trash " aria-hidden="true"></i></span>
				
                        </div>
                    </div>`
					} else {
						html += `<span class="ml-2 btn btn-primary btn-xs uploadTaskFile" data-et=${btoa(el.taskedTime)} data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)} data-projectid=${btoa(el.project_id)}>
						<i class="fa fa-upload" aria-hidden="true"></i>
						</span>
						<span class="ml-2 btn btn-danger btn-xs deleteTask" data-et=${btoa(el.taskedTime)}
						data-st=${btoa(el.taskStTime)} data-taskid=${btoa(el.task_id)}><i class="fa fa-trash " aria-hidden="true"></i></span>

					
						</div>
						
                    </div>`;
					}
				});
			}
			$('#alltasks').html(html);
		}



		loadData();

		const inValid = (bookedSlot, fromTime, toTime) => {
			bookedSlot = JSON.parse(bookedSlot);
			let invalid = false;
			// fromTime = convertT24hrs(fromTime);
			// toTime = convertT24hrs(toTime);
			for (let i = 0; i < bookedSlot.length; i++) {
				let stTime = setDate(bookedSlot[i].start_time);
				let edTime = setDate(bookedSlot[i].end_time);
				if (fromTime < stTime) {
					if (toTime <= stTime) {
						invalid = false;
						break;
					} else if (toTime > stTime) {
						invalid = true;
						break;
					}
				} else if (fromTime === stTime) {
					invalid = true;
					break;
				}
			}

			return invalid;
		};

		$('.saveTask').click(function() {
			let allTask = JSON.parse(retriveLsData('allTask'));
			let stTime = convertT24hrs($('#from-time').val());
			let edTime = convertT24hrs($('#to-time').val());
			let selectedTask = $('#slected-task').val();
			// console.log(stTime);
			// console.log(edTime);
			if (selectedTask) {
				if (stTime < edTime) {
					if (allTask == false) {
						insertTaskData();
						timeIsAvailble = false;
					} else {
						let bookedSlot = retriveLsData('BookedSlots');
						let invalid = inValid(bookedSlot, stTime, edTime);
						if (invalid) {
							// console.log(`if: ${invalid}`);
							errorAlert('Invalid time slot');
							return false;
						} else {
							// console.log(`else: ${invalid}`);
							insertTaskData();
							timeIsAvailble = false;
						}
					}

				} else {
					errorAlert('Start Time should be less form end time.')

				}
			} else {
				errorAlert('Task not found.')
				return false;

			}
		});

		// upload task file if any
		$('#alltasks').on('click', '.uploadTaskFile', function() {
			saveLsData('projectid', $(this).attr('data-projectid'));
			saveLsData('taskid', $(this).attr('data-taskid'));
			saveLsData('st', $(this).attr('data-st'));
			saveLsData('et', $(this).attr('data-et'));
			$('#file-form').removeClass('hide');
			$('.files-view').addClass('hide');
			// loadTable();
			$('#dailyTimesheet-upload-file-ModalLong').modal('show');
		});

		// upload task file if any
		$('#alltasks').on('click', '.showTaskFile', function() {

			$('#file-form').addClass('hide');
			$('.files-view').removeClass('hide');
			// loadDocumentRow();
			$('#dailyTimesheet-upload-file-ModalLong').modal('show');
			let url = BASEURL + 'Employee/getfiles';
			let projectid = $(this).attr('data-projectid');
			let taskid = $(this).attr('data-taskid');
			let st = $(this).attr('data-st');
			let et = $(this).attr('data-et');

			saveLsData('projectid', projectid);

			let condition = {
				projectid: $(this).attr('data-projectid'),
				taskid: $(this).attr('data-taskid'),
				st: $(this).attr('data-st'),
				et: $(this).attr('data-et')
			};

			$.post(url, condition, function(res) {
				res = JSON.parse(res);
				console.log(res);
				let files = JSON.parse(res.files);
				let html = '';
				if (files != 'No-files') {
					files.map((file) => {
						html += `<a href="<?php echo base_url() ?>${file.filePath}" target=_blank class="m-2">
                            <img src="<?php echo base_url() ?>./assets/custom/media/docs.png" 
							alt="${file.docTitle}" height="50">
                            <p>${file.docTitle}</p>
                            </a>`;
					});
				} else {
					html += `${files}`;
				}
				$('.file-row').empty();
				$('.file-row').html(html);
				if (res.remark != '') {
					$('#rejected-res').html(res.remark);

				}

			});

		});

		// Delete task if any
		$('#alltasks').on('click', '.deleteTask', function() {
			let url = BASEURL + 'Employee/deleteTask';
			let taskid = $('#alltasks .deleteTask').attr('data-taskid');
			let st = $('#alltasks .deleteTask').attr('data-st');
			let et = $('#alltasks .deleteTask').attr('data-et');
			deleteRow(taskid, st, et, 'dailytimesheet', url);
		});

		function deleteRow(id, st, et, table, url) {

			swal("Are you sure!", " Wants to delete this entry? It will delete permanently.", "warning", {
					buttons: {
						Yes: true,
						No: true,
					},
				})
				.then((value) => {
					switch (value) {
						case "Yes":
							let form_data = {
								row_id: id,
								st: st,
								et: et,
								table_name: table
							};
							if (id !== undefined) {
								$.post(url, form_data, function(data) {
									response = JSON.parse(data);
									(response.type === 'success') ? successAlert(response.message): errorAlert(res.message);
									setTimeout(() => {
										loadData();
									}, 4000);
								});
							}
							break;
						case "No":
							swal('Confirmation', 'Data safe', 'success');
						default:
							break;
					}
				});
		}

		let counter = 0; //Global variable for rowid

		function loadDocumentRow() {
			let option = '';

			let opdata = JSON.parse(atob($('#doc').attr('data-dropdown')));
			// console.log(opdata);
			if (opdata) {
				let ob = opdata;
				// console.log(ob);
				if (ob != null) {
					for (let i = 0; i < ob.length; i++) {
						option += `<option value="${ob[i]['title']}">${ob[i]['title']}</option>`;
					}

					loadRow(option, counter);
				}
			}
		}

		// Calling loadDocumentRow for load first row
		loadDocumentRow();
		// Add More button for create multiple document rows

		$('.addmore').click(function(e) {
			e.preventDefault();
			counter = counter + 1;
			loadDocumentRow();
		});

		$('#file-row').on('click', '.remove', function() {
			// alert('hi');
			$(this).parent().remove();
		});

		// Function for RowDesign
		function loadRow(option, id) {
			let row = `<div class="row docrid" data-id="${id}">
                            <div class="form-group col-sm-3">
                                <label for="Document" class="fs-13">Name</label>
                                <select id="document${id}" name="document${id}" 
								class="select2 form-control  document-opt br-b">
                                ${option}
                                </select>
                            </div>
                            <div class="form-group col-sm-3">
                                <label for="document_no${id}" class="fs-13">Document number</label>
                                <input type="text" class="form-control docNumber br-b" id="document_no${id}" name="documentNo${id}" placeholder="Document number">
                            </div>
                            <div class="form-group col-sm-2 date">
                                <label for="exp-date${id}" class="fs-13">Expiry date(if any)</label>
                                <input type="text" class="form-control exp-date datepicker br-b" id="exp-date${id}" name="exp-date${id}" placeholder="DD/MM/YYYY">
                            </div>
                            <div class="form-group col-sm-3 actions">
                                <label for="document_no" class="fs-13">Upload file</label>
                                
								<input type="file" class="form-control file br-b" name="file${id}" id="file${id}"placeholder="upload">
                            </div>
							
                            <div class="form-group col-sm-1 remove ">
							
                            <i class="fas fa-minus-circle text-danger remove-btn fs-13" title="Remove row"></i>

                            </div>
							<small class="col-sm-12 text-info"> File type: png, jpeg, jpg, pdf, docx, doc</small>
						</div>`;
			// $('#file-row').empty();
			// $('#file-row').html(row);
			$('#file-row').append(row);
		}

		// Uploading file
		let documentArr = [];

		$('#file-row').on('change', '.file', function() {

			console.log()

			let file = $(this).prop('files')[0];

			let rowid = $(this).parent().parent().attr('data-id');

			let documentTile = $(this).parent().parent().find('.document-opt').val();

			let documentNumber = $(this).parent().parent().find('.docNumber').val();

			let documentExpDate = $(this).parent().parent().find('.exp-date').val();

			let formData = new FormData();

			let projectid = JSON.parse(retriveLsData('projectid'));

			formData.append('files', file);
			formData.append('projectid', projectid);

			let fileUpload = $(this).attr('id');

			let url = BASEURL + 'Employee/uploadFile';
			$.ajax({
				url: url,
				type: 'POST',
				data: formData,
				success: function(data) {
					if (data) {
						let filepath = JSON.parse(data);
						let docArr = {
							rowId: rowid,
							docTitle: documentTile,
							docNumber: documentNumber,
							docExpDate: documentExpDate,
							filePath: filepath
						}

						documentArr.push(docArr);

						let localData = hasLsData('docArr');

						if (localData) {
							removeLsData('docArr');
							saveLsData('docArr', documentArr);
						} else {
							saveLsData('docArr', documentArr);
						}
						let html = `<div class="doc row m-0">
						<div class="col-sm-4">
						<a href="${BASEURL+'/'+filepath}" target="_blank">
						 <img src="${BASEURL+'/'+filepath}" height="30">
						 </a>
						 </div>
						<div class="col-sm-4"><i class="fa fa-times delete" aria-hidden="true" title="remove"></i><div>
					</div>`;

						$(`#${fileUpload}`).parent().append(html);
						$(`#${fileUpload}`).remove();

					}
				},
				cache: false,
				contentType: false,
				processData: false
			});

		});

		// Function for updating document

		$('#file-form').submit(function(e) {
			e.preventDefault();
			let url = BASEURL + 'Employee/updateSelectedTask';
			if (hasLsData('docArr')) {
				let document = {
					doc: JSON.parse(retriveLsData('docArr')),
					st: JSON.parse(retriveLsData('st')),
					et: JSON.parse(retriveLsData('et')),
					proid: JSON.parse(retriveLsData('projectid')),
					taskid: JSON.parse(retriveLsData('taskid')),
					employee_id: userId
				};

				console.log(document);
				$.post(url, document, function(res) {
					$('#dailyTimesheet-upload-file-ModalLong').modal('hide');
					res = JSON.parse(res);
					res.type === 'success' ? successAlert(res.message) : errorAlert(res.message);
					setTimeout(() => {
						loadData();
					}, 4000)
				});

			} else {
				errorAlert("no-file available");
				return false;
			}
		});

		$('.edit-files').click(() => {
			if ($('#file-form').hasClass('hide')) {
				$('#file-form').removeClass('hide');
				$('#file-row').empty();
				loadDocumentRow();
			} else {
				$('#file-form').addClass('hide');
				$('#file-row').empty();
			}
		});

		// Edit description
		$('#alltasks').on('mouseover', '.userDescription', function() {
			$(this).addClass('form-control');
			$(this).css({
				"border": '1px solid gray'
			});

		})

		$('#alltasks').on('click', '.userDescription', function() {
			$(this).addClass('form-control');
			$(this).attr('contenteditable', "true");

		})

		$('#alltasks').on('mouseleave', '.userDescription', function() {
			$(this).removeAttr("style");
			// $(this).re('form-control');
		});

		$('#alltasks').on('blur', '.userDescription', function() {
			let url = BASEURL + 'Employee/updateRow';
			let form_data = {
				condition: {
					task_id: $(this).attr('data-taskid'),
					st: $(this).attr('data-st'),
					et: $(this).attr('data-et'),
					pid: $(this).attr('data-projectid')
				},
				data: {
					userDescription: $(this).text()
				},
				flag: 'description'
			};

			updateRowData(form_data, url);

		});

		// edit End time

		$('#alltasks').on('change', '.task-et', function() {
			let url = BASEURL + 'Employee/updateRow';
			let stTime = convertT24hrs($(this).parent().parent().find('.task-st').val());
			let edTime = convertT24hrs($(this).val());
			// console.log(stTime);
			// console.log(edTime);
			if (stTime < edTime) {
				let bookedSlot = retriveLsData('BookedSlots');
				let invalid = inValid(bookedSlot, stTime, edTime);
				if (invalid) {
					console.log(`if: ${invalid}`);
					errorAlert('Invalid time slot');
					return false;
				} else {
					// console.log(`else: ${invalid}`);
					let form_data = {
						condition: {
							task_id: $(this).attr('data-taskid'),
							st: $(this).attr('data-st'),
							et: $(this).attr('data-et'),
							pid: $(this).attr('data-projectid')
						},
						data: {
							st: $(this).parent().parent().find('.task-st').val(),
							et: $(this).val()
						},
						flag: 'time'
					};

					updateRowData(form_data, url);
				}
			} else {
				errorAlert('Start Time should be less form end time.')

			}
		});


		// Submit selected task
		$('#submit-task').click(() => {
			let url = BASEURL + 'Employee/submitDailyTask';
			let CheckedId = Checked('alltasks', 'task');
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

		const updateRowData = (obj, url) => {
			$.post(url, obj, function(res) {
				// console.log(res);
				res = JSON.parse(res);
				res.type === 'success' ? successAlert(res.message) : errorAlert(res.message);
				setTimeout(() => {
					loadData();
				}, 4000);
			});

		};

		const setDate = (time) => {
			let date = new Date();
			totalTime = time.split(":");
			return date.setHours(totalTime[0], totalTime[1], totalTime[2]);
		};

		const convertT24hrs = (time) => {
			if (time) {
				let totalTime = time.split(":");
				let date = new Date();
				let hrs = parseInt(totalTime[0]);
				let minute = totalTime[1].slice(0, -2);
				postFix = totalTime[1].slice(-2);
				if (postFix === 'pm') {
					if (hrs == 12) {
						hrs += 1;
						return date.setHours(hrs, minute, 00);
					} else {
						hrs += 12;
						return date.setHours(hrs, minute, 00);
					}
				} else if (postFix === 'am') {
					return date.setHours(hrs, minute, 00);
				}
			}
		};

	});
</script>