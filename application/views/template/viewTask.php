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
                        <a class="btn btn-primary btn-xs float-right" id="submit-task">Edit</a>
                        <a class="btn btn-warning btn-xs float-right mr-2" id="submit-task" href="javascript:window.history.back(-1);">Back</a> 

                    

                    </div>
                </div>
                <div class="card-body dailytimesheet">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><strong>Title:</strong>
                                <?php echo $task[0]['title']; ?>
                            </h5>
                            <p class="card-text"> <strong>Time:</strong>
                                <?php
                                echo date("g:i a", strtotime($task[0]['taskStTime'])) . '-' . date("g:i a", strtotime($task[0]['taskedTime'])) ?></p>
                            <p class="card-text"><strong>Remark:</strong> <?php echo $task[0]['userDescription'] ?></p>
                            <p class="card-text"><strong>Files:</strong>
                                <?php
                                $file = json_decode($task[0]['uploadedFiles'], true);
                                if ($file) { ?>
                                    <div class="d-flex">
                                        <?php
                                        $count = 1;
                                        foreach ($file as $item) {
                                        ?>
                                            <a href="<?php echo base_url($item) ?>">
                                                <img src="<?php echo base_url() ?>./assets/custom/media/docs.png" alt="" height="50">
                                                <p><?php echo 'File' . $count++ ?></p>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php   }
                                ?>
                            </p>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="dailyTimesheetModalLong" tabindex="-1" role="dialog" aria-labelledby="dailyTimesheetLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
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
                            <input type="text" class="show-time form-control" value="" id="st-time" placeholder="Start time" name="st-time">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" placeholder="End time" class="show-time form-control" id="et-time" name="et-time">
                        </div>
                    </div>
                    <div class="row mb-2">
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <textarea class="form-control" name="description" id="description" placeholder="Add description"></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-10">
                            <input type="file" name="files[]" id="files" multiple>
                        </div>
                    </div>
                    <input type="hidden" name="projectid" id="projectid">
                    <input type="hidden" name="taskid" id="taskid">
                    <input type="hidden" name="serviceid" id="serviceid">
                    <input type="hidden" name="clientid" id="clientid">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>