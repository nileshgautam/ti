<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="text-header">Daily Timesheet</h4>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h6 class="header-text badge badge-secondary"><?php echo date('d/m/Y') ?></h6>
                        <input type="hidden" name="ssdate" id="ssdate" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary btn-xs float-right" id="submit-task">Submit Task</a>
                    </div>
                </div>
                <div class="card-body dailytimesheet">
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Task</th>
                                <th>Project</th>
                                <th>Consumed Time <br>0H:0M</th>
                                <th>Deadline</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="taskBody">
                            <?php
                            if ($allocatedTask) {
                                // my_print($allocatedTask);
                                foreach ($allocatedTask as $details) {
                                    $checkbox = '';
                                    $deadLine=date_create($details['end_date'])->format('d/m/y');
                                    if ($details['status'] === SUBMIT || $details['status'] === APPROVE ) {
                                        $checkbox  = "<input type='checkbox' checked disabled>";
                                    } elseif ($details['status'] === SAVE ||$details['status']==UPDATED) {
                                        $checkbox  = "<input type='checkbox' checked='true' class='tasks' value=" . $details['task_id'] . ">";
                                    } else {
                                        $checkbox  = "<input type='checkbox' class='tasks' value=" . $details['task_id'] . ">";
                                    }
                            ?>
                                    <tr>
                                        <td><?php
                                            echo $checkbox;
                                            ?></td>
                                        <td><?php echo $details['title']; ?></td>
                                        <td><?php echo $details['projectName']; ?></td>
                                        <!-- <td><?php echo $details['serviceName']; ?></td> -->
                                        <td><?php echo time_deff_two($details['taskStTime'], $details['taskedTime']) ?> </td>
                                        <td><?php echo $deadLine; ?></td>
                                        <td>
                                            <?php
                                            if ($details['status'] == 'submitted') { ?>
                                                <button class="btn btn-secondary edit-time-box btn-xs" disabled>Submitted</button>
                                            <?php } else if ($details['status'] == 'Saved') { ?>
                                                    <a href="#" class="btn btn-primary edit-task btn-xs" data-taskId="<?php echo $details['task_id']; ?>">
                                                    view</a>

                                            <?php } else if ($details['status'] == REJECT) { ?>
                                                <a href="#" class="btn btn-warning btn-xs edit-task" data-client="<?php echo $details['client_id']; ?>" data-project="<?php echo $details['project_id']; ?>" data-service="<?php echo $details['service_id']; ?>" data-taskId="<?php echo $details['task_id']; ?>">
                                                    Rejected</a>
                                            <?php } else if ($details['status'] == 'approved') { ?>
                                                <a href="#" class="btn btn-success disabled btn-xs edit-task" data-client="<?php echo $details['client_id']; ?>" data-project="<?php echo $details['project_id']; ?>" data-service="<?php echo $details['service_id']; ?>" data-taskId="<?php echo $details['task_id']; ?>">
                                                    Approved</a>
                                           <?php } else if ($details['status'] == UPDATED) { ?>
                                                <a href="#" class="btn btn-info  btn-xs edit-task" data-client="<?php echo $details['client_id']; ?>" data-project="<?php echo $details['project_id']; ?>" data-service="<?php echo $details['service_id']; ?>" data-taskId="<?php echo $details['task_id']; ?>">
                                                    Updated</a>
                                            <?php } else { ?>
                                                <a href="#" class="btn btn-primary time-box btn-xs" data-client="<?php echo $details['client_id']; ?>" data-project="<?php echo $details['project_id']; ?>" data-service="<?php echo $details['service_id']; ?>" data-taskId="<?php echo $details['task_id']; ?>">
                                                    Upload File</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                            <?php

                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<!-- Modal 0 -->
<div class="modal fade" id="dailyTimesheetModalLong" tabindex="-1" role="dialog" aria-labelledby="dailyTimesheetLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="savedailytimesheet">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <input type="text" class="show-time form-control " value="" id="st-time" placeholder="Start time" name="st-time">
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" id="et-time" name="et-time">
                                <option value="">End time</option>
                            </select>
                          
                        </div>
                    </div>
                    <small id="isAvailble" class="hide">Hi</small>
                    <div class="row mb-2">
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="description" id="description" placeholder="Add description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-10">
                            <input type="file" class="files" name="files[]" id="files" multiple>
                        </div>
                    </div>
                    <input type="hidden" name="projectid" id="projectid">
                    <input type="hidden" name="taskid" id="taskid">
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="clientid" id="clientid">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-xs btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal 1 -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editmodal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                
                    <span aria-hidden="true" class="float-right  btn-xs edit-btn"><i class="fas fa-edit f-16"></i>
                    </span>
             
            </div>
            <div class="modal-body">
                <form id="editTimesheet">
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <h6>Remarks:</h6>
                            <p class="pl-5" id="manager-remarks"></p>
                        </div>
                    </div>
                    <h6>Files:</h6>
                    <div id="uploaded-files" class="bordered d-flex">
                    </div>
                    <div class="task-widget hide">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <input type="text" class="show-time form-control st-time" id="t-st-time" placeholder="Start time" name="t-st-time">
                            </div>
                            <div class="col-sm-6">
                                <select class="form-control et-time" id="t-et-time" name="t-et-time">
                                    <option value="">End time</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="t-description" id="t-description" placeholder="Add description"></textarea>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-10">
                                <input type="file"  name="files[]" id="up-files" multiple>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="up-projectid" id="up-projectid">
                    <input type="hidden" name="up-task" id="up-taskid">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-xs btn-primary update-task">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>