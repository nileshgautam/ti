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
                            Booked Time: <?php echo bcadd(0, $totalhrs, 2) ?> hrs.
                        </div>
                        <div class="col-sm-6"> <a class="btn btn-warning float-right mr-2" id="submit-task" href="javascript:window.history.back(-1);"><i class="fas fa-arrow-left"></i></a></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table dataTable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Time Range</th>
                                        <th scope="col">Task</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Consumed hrs</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($dailytimesheet)) {
                                        // echo '<pre>';
                                        // print_r($dailytimesheet);
                                        // die;
                                        $count = 1;
                                        foreach ($dailytimesheet as $item) {
                                    ?>
                                            <tr>
                                                <th scope="row"><?php echo  $count++; ?></th>
                                                <td><?php echo time_in_12_hour_format($item['taskStTime']) . ' to ' . time_in_12_hour_format($item['taskedTime'])  ?></td>
                                                <td><?php echo $item['title'] ?></td>
                                                <td><?php echo $item['name'] ?></td>
                                                <td><?php echo bcadd(0, $item['consumedTime'] / 60, 2)  . ' hrs' ?></td>
                                                <td>
                                                    <a class="btn btn-primary  btn-xs ml-2 showTask" href="#" title="show task" dataTaskid="<?php echo base64_encode($item['task_id']) ?>" dataprojectid="<?php echo base64_encode($item['project_id']) ?>" taskStTime="<?php echo base64_encode($item['taskStTime']) ?>" taskedTime="<?php echo base64_encode($item['taskedTime']) ?>">show</a>
                                                </td>
                                            </tr>
                                    <?php }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="col-sm-3">Calender</div> -->

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
                            <a class="btn btn-xs btn-link hide" id="save-remark">
                                Save remark</a>
                            <a class="btn btn-xs btn-link" id="accept-task" title="Save">
                                Mark as complete</a>
                            <a class="btn btn-xs text-danger" id="reject-task" title="Reject">
                                Mark as Rejected</a>
                            <a class="btn btn-xs text-danger close mr-1" data-dismiss="modal" aria-label="Close" title="Cancle">
                                Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>