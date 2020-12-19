<script>
    $(function() {

        // Function for show task
        // $('.project-task').click(function() {
        //     let projectId = $(this).attr('data-id');
        //     let projectName = $(this).attr('data-name');
        //     // console.log(projectId);
        //     let url = BASEURL + 'Manager/projectTask';
        //     $.post(url, {
        //         projectid: projectId,
        //         projecName:projectName
        //     }, function(data) {
        //         console.log(data);
        //     });
        // });

        $('body').on('click', '.showTask', function() {
            // alert('hi');
            let url = BASEURL + 'Manager/getTask';
            let id = $(this).attr('dataTaskid');
            let projectid = $(this).attr('dataprojectid');
            let taskStTime = $(this).attr('taskStTime');
            let taskedTime = $(this).attr('taskedTime');

            $.post(url, {
                id,
                projectid,
                taskStTime,
                taskedTime
            }, function(data) {
                let res = JSON.parse(data);
                // console.log(res);
                data = `<div class="pl-5">
                        <strong id="task_title">${res.title}</strong>
                        <p id="time">
                        <span>${timeConvert12hrs(res.taskStTime)} - </span>${timeConvert12hrs(res.taskedTime)}</p>
                        <p>
                        <strong>Remark</strong>    
                        <p>${res.userDescription}</p>
                        </p>
                        </div>`;
                let files = '';

                // console.log(fileData);
                if (res.uploadedFiles != 'No-files') {
                    fileData = JSON.parse(res.uploadedFiles);
                    // console.log(fileData);
                    fileData.map((url, i) => {
                        // console.log(url); 
                        files += `<a href="<?php echo base_url() ?>${url.filePath}" target=_blank>
                            <img src="<?php echo base_url() ?>./assets/custom/media/docs.png" alt="" height="50">
                            <p>${url.docTitle}</p>
                            </a>`;
                    });
                } else if (res.uploadedFiles == 'No-files') {
                    files += 'No file.';
                }
                $('#task-details').html(data);
                $('#taskid').val(res.task_id);
                $('#reject-task').attr('data-tid', res.task_id);
                $('#reject-task').attr('data-st', res.taskStTime);
                $('#reject-task').attr('data-et', res.taskedTime);
                $('#accept-task').attr('data-tid', res.task_id);
                $('#accept-task').attr('data-st', res.taskStTime);
                $('#accept-task').attr('data-et', res.taskedTime);
                $('#files').html(files);
                $('#dailytimeSheetData').modal('show');
            });

        });

        $('.add-task').click(function() {
            
            loadSelectedServices();

        });
        const loadSelectedServices = () => {

            let id = $('.add-task').attr('data-id');
            let url = BASEURL + 'Manager/selected_services'
            $.post(url, {
                id: id
            }, function(data) {
                // console.log(data);
                let res = JSON.parse(data);
                let option = '<option value="">Select</option>';
                for (let i = 0; i < res.length; i++) {
                    option += `<option value="${res[i]['id']}">${res[i]['title']}</option>`;
                }

                $('#project-id').val(id);

                $('.manager-service').html(option);
            });
        }

        $('body').on('change', '#manager-service', function() {
            let id = $(this).children(':selected').val();
            let url = BASEURL + 'Manager/tasklist';
            $.post(url, {
                id
            }, function(data) {
                let res = JSON.parse(data);
                // let option = '';
                // for (let i = 0; i < res.length; i++) {
                //     // console.log(res[i]['id']);
                //     option += `<option value="${res[i]['task_id']}">${res[i]['title']}</option>`;
                // }
                // $('#selected-task').append(option);
                // $('#selected-task').removeAttr('disabled');

                saveLsData('taskdata', res);

            });
        });

        $('#selected-task-view').keyup(function() {
            let data = $(this).val();
            let taskData = hasLsData('taskdata');

            if (taskData != false) {
                taskData = JSON.parse(retriveLsData('taskdata'));
                if (taskData != false) {
                    let task = taskData.filter(e => (e.title).toLowerCase().includes(data.toLowerCase()));
                    // console.log(task);
                    let html = '';
                    for (let i = 0; i < task.length; i++) {
                        // console.log(name)
                        html += `<label class='task-label ${i<task.length?'border':''}' id=${task[i].task_id}>${task[i].title}</label>`;
                    }
                    // console.log(html);

                    if (data != '') {
                        $('.shorted-task').removeClass('hide');
                        $('.shorted-task').html(html);
                        // removeLsData('taskdata');
                    } else if (data == '') {
                        $('.shorted-task').html();
                    }
                }
            } else {
                return false;
            }


        });

        $('.shorted-task').on('click', '.task-label', function() {
            // alert('hello');
            let taskTitle = $(this).text();
            let taskid = $(this).attr('id');
            // console.log(taskid);
            $('#selected-task-view').val(taskTitle);
            // console.log(taskTitle)
            $('#selected-task').val(taskid);
            $(this).remove();
            $('.shorted-task').addClass('hide');
        });


        $('#create-task').submit(function(e) {
            e.preventDefault();
            let url = BASEURL + 'Manager/psotServicesTask';
            let s = $('#manager-service').val();
            let t = $('#selected-task').val();
            if ((s != '') && (t != '')) {
                let formData = $(this).serialize();
                $.post(url, formData, function(data) {
                    // console.log(data);
                    let res = JSON.parse(data);
                    // swal('Done!', res.msg, res.type);
                    res.type === 'success' ? successAlert(res.msg) : errorAlert(res.msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                });
            } else {
                errorAlert('selecte services and task');
            }
        });

        $('.assign-task').click(function(e) {
            e.preventDefault();
            $('#taskId').val($(this).attr('data-id'));
            $('#hr').val($(this).attr('data-hr'));
            $('#s-date').val($(this).attr('data-st'));
            $('#e-date').val($(this).attr('data-et'));
            $('#projectid').val($(this).attr('data-projectid'));
        });

        $('#allocateTask').submit(function(e) {
            e.preventDefault();
            let url = BASEURL + 'Manager/allocateTaskToUser';
            // console.log('hi');
            let formData = $(this).serialize();
            let s = $('#self').val();
            // console.log(s);
            $.post(url, formData, function(data) {
                // console.log(data);
                let res = JSON.parse(data);
                // swal('Response', res.msg, res.type);
                res.type === 'success' ? successAlert(res.msg) : errorAlert(res.msg);
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            });
        });

        $('#reject-task').click(function() {
            let taskid = $(this).attr('data-tid');
            let st = $(this).attr('data-st');
            let et = $(this).attr('data-et');
            let url = BASEURL + 'Manager/rejectTask';
            $('#dailytimeSheetData').modal('hide');
            swal("Are you sure!", " Wants to reject this task?", "warning", {
                    buttons: {
                        Yes: true,
                        No: true,
                    },
                })
                .then((value) => {
                    switch (value) {
                        case "Yes":
                            $('#remark-widght').removeClass('hide');
                            $('#task-widght').addClass('hide');
                            $('#task-widght').addClass('hide');
                            $('#reject-task').addClass('hide');
                            $('#save-remark').removeClass('hide');
                            $('#accept-task').addClass('hide');
                            $('#dailytimeSheetData').modal('show');
                            let form_data = {
                                taskid: taskid,
                                st: st,
                                et: et,
                            };
                            $('#save-remark').click(function() {
                                let remark = $('#remarks').val();
                                form_data.remark = remark;
                                if (taskid !== undefined) {
                                    $('#dailytimeSheetData').modal('hide');
                                    $.post(url, form_data, function(data) {
                                        response = JSON.parse(data);
                                        (response.type === 'success') ? successAlert(response.msg): errorAlert(res.msg);
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 4000);
                                    });
                                }
                            });
                            break;
                        case "No":
                            swal('Confirmation', 'Data safe', 'success');
                        default:
                            break;
                    }
                });
            // console.log(taskid);
        });

        $('#accept-task').click(function(e) {
            e.preventDefault();
            let url = BASEURL + 'Manager/approved_task';
            let taskid = $(this).attr('data-tid');
            let st = $(this).attr('data-st');
            let et = $(this).attr('data-et');
            if (taskid != undefined) {
                $.post(url, {
                    task_id: taskid,
                    st: st,
                    et: et,
                }, function(data) {
                    let res = JSON.parse(data);
                    $('#dailytimeSheetData').modal('hide');
                    res.type === 'success' ? successAlert(res.msg) : errorAlert(res.msg);
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                    // console.log(task_id);
                });

            }

        });

        let selfid = '<?php echo $_SESSION['logged_in']['people_id'] ?>';
        $('#self').click(function() {
            $(this).prop("checked") == true ? $(this).val(selfid) : $(this).val('');
        });

        $('.self').click(function() {
            let ob = {
                startDate: $(this).attr('data-st'),
                endDate: $(this).attr('data-et'),
                taskId: $(this).attr('data-id'),
                Hours: $(this).attr('data-hr'),
                projectid: $(this).attr('data-projectid'),
                users: selfid,
            }
            console.log(ob);
            let url = BASEURL + 'Manager/allocateTaskToUser';
            $.post(url, ob, function(data) {
                // console.log(data);
                let res = JSON.parse(data);
                // swal('Response', res.msg, res.type);
                res.type === 'success' ? successAlert(res.msg) : errorAlert(res.msg);
                setTimeout(() => {
                    window.location.reload();
                }, 3000);
            });

        });

        $('.addnew-task').click(function() {

            // $('#taskModal').modal('hide');
            // $('#newtaskModal').modal('show');

            let serviceid = $('#manager-service').children(':selected').val()
            let task = $('#selected-task-view').val();

            if (serviceid == '') {
                errorAlert('Select service first');
            } else if (task == '') {
                errorAlert('Invalid task title');
            } else {
                // successAlert('Now you are eligible for insert data');
                let form_data = {
                    serviceid,
                    task
                };
                let url = BASEURL + 'Manager/addnewTask';
                $.post(url, form_data, function(data) {

                    data = JSON.parse(data);
                    console.log(data);
                    if (data.type == 'error') {
                        errorAlert(data.message);
                    } else if (data.type == 'success') {
                        $('#selected-task').val(data.data.task_id);
                        $('#selected-task-view').val(data.data.title);
                        successAlert(data.message);
                    }
                });
            }

            // alert('hi');

        });

        $('#create-new-task').submit(function(e) {
            e.preventDefault();
            let form_data = $(this).serialize();
            let url = BASEURL + 'Admin/postFormData';
            if ($('#ser-cgt').val() != '' && $('#taskTile').val() != '') {
                $.post(url, form_data, function(data) {
                    console.log(data);
                    data = JSON.parse(data);
                    data.type === 'success' ? successAlert(data.message) : errorAlert(data.message);
                    setTimeout(() => {
                        $('#newtaskModal').modal('hide');
                        $('#manager-service').change();
                        $('#taskModal').modal('show');
                    }, 4000);
                })
            } else {
                errorAlert('Please check service and task title. empty not allowed');
                return false;
            }
        });

        // $('#projectid').change(function() {
        //     let pid = $(this).children(':selected').val();
        //     alert(pid);
        // });

        $('#projectid').change(function() {

            let projectid = $(this).children(':selected').val();

            if (projectid == '') {
                errorAlert('Project not found!');
            } else {
                let url = BASEURL + 'Manager/getTasklist';

                $.post(url, {
                    projectid
                }, function(data) {

                    if (data) {
                        data = JSON.parse(data);

                        let html = '<option value="">Select</option>';
                        for (let i = 0; i < data.length; i++) {
                            console.log(data[i]);
                            html += `<option 
                value="${data[i].task_id}" 
                data-hrs="${data[i].assigned_hrs}"
                data-st="${data[i].start_date}"
                data-et="${data[i].end_date}"
            
                >${data[i].title}</option>`;
                        }
                        $('#taskid').html(html);
                    } else {
                        errorAlert('No task assigned');
                    }
                })
            }

        });

    });
</script>