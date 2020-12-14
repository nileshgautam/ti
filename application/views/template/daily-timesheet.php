<style>
    .dailytimesheet .fs-14 {
        font-size: 13px !important;
        border-radius: 20px;
        cursor: pointer;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-6">
                        <h4 class="text-header">Daily Timesheet</h4>
                    </div>
                    <div class="col-sm-6 row m-0">
                        <div class="col-sm-6">
                            Booked Time: <?php echo $totalhrs?>
                        </div>
                        <div class="col-sm-6"> <a class="btn btn-warning btn-xs float-right mr-2" id="submit-task" href="javascript:window.history.back(-1);">Back</a></div>
                   
                
                </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-sm-3">Calender</div> -->
                        <div class="col-sm-12">
                          
                                
                                <div class="card-body dailytimesheet">
                                    <div class="row">
                                       
                                        <div class="col-sm-12">
                                            <?php if (!empty($dailytimesheet)) {
                                                foreach ($dailytimesheet as $key => $time) { ?>
                                                    <div class="row bg-light mb-2 border-bottom">
                                                        <div class="col-sm-2"><?php echo $key; ?></div>
                                                        <div class="col-sm-10 ">
                                                            <?php
                                                            if (!empty($time)) {
                                                                foreach ($time as $key1 => $bookedTime) {
                                                                    foreach ($bookedTime as $time) {
                                                            ?>
                                                                        <div class="bg-info">
                                                                            <p class="p-2 fs-14 showTask" dataTaskid="<?php echo base64_encode($time['task_id']) ?>">
                                                                                <?php
                                                                                // print_r($time);
                                                                                echo $time['title'] . '   status: <span class="badge badge-success">  ' . $time['status'] . ' </span>';
                                                                                echo '<br/>';
                                                                                echo '<span>' . date('h:i a', strtotime($time['taskStTime'])) . '<span> -' .
                                                                                    '</span> ' . date('h:i a', strtotime($time['taskedTime'])) . ' </span>' ?>
                                                                            </p>
                                                                        </div>

                                                            <?php }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                            <?php }
                                            }
                                            ?>
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
    <div class="modal fade" id="dailytimeSheetData" tabindex="-1" role="dialog" aria-labelledby="dailyTimesheetLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card-header">
                    <button type="button" class="close mr-1" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <button type="button" class="btn btn-xs text-danger mr-5 float-right" id="reject-task" title="Reject">
                        <i class="fa fa-ban" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="savedailytimesheet">
                        <div id="task-widght">
                            <div id="task-details">
                            </div>
                            <div id='files' class="pl-5 d-flex">
                            </div>
                        </div>
                        <div id="remark-widght" class="hide">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="remark" id="remarks" placeholder="Enter resion for reject" required></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="taskid" id="taskid">
                        <div class="modal-footer">
                            <a class="btn btn-xs btn-link float-right mr-2 hide" id="save-remark">
                                Save remark</a>
                                <a class="btn btn-xs btn-link float-right mr-2" id="accept-task">
                                Mark as complete</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>