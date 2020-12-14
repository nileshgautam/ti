<style type="text/css">
    .btn-default {
        border: 1px solid #908b8b;
    }

    table tbody tr td:not(:nth-child(2)) {
        background: #f1f1f1;
    }

    table tbody tr td:first-child {
        background: white;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">


            <div class="card">
                <div class="col-lg-12">

                    <div class="card-header row m-0">
                        <div class="col-sm-6"><h5>Manage Timesheet</h5></div>
                        <div class="col-sm-6"><a class="btn btn-warning btn-xs float-right mr-2" id="submit-task" href="javascript:window.history.back(-1);">Back</a></div>
                    </div>
                    <div class="ibox-content">
                        <?php
                        if ($this->session->flashdata("error")) {
                        ?>
                            <?php $this->session->flashdata("error"); ?>
                        <?php
                        }
                        ?>

                        <?php
                        if ($this->session->flashdata("success")) {
                        ?>
                            <?php $this->session->flashdata("success"); ?>
                        <?php
                        }
                        ?>
                        <div class="card-body">
                            <div class="col-sm-12" align="right" style="font-size:16px;">
                                <?php echo "Week " . $dateDetails['currentWeek'] . ", " . $dateDetails['thisWeekSd'] . " - " . $dateDetails['thisWeekEd']; ?>
                                <a href="<?php echo base_url(); ?><?php echo $class; ?>/userTimesheet/<?php echo base64_encode($userId); ?>/<?php echo base64_encode(-1) ?>/<?php echo base64_encode(date("Y-m-d", strtotime($dateDetails['thisWeekSd']))) ?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>

                                <a href="<?php echo base_url(); ?><?php echo $class; ?>/userTimesheet/<?php echo base64_encode($userId); ?>/<?php echo base64_encode(+1) ?>/<?php echo base64_encode(date("Y-m-d", strtotime($dateDetails['thisWeekEd']))) ?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
                            </div>

                            <input type="hidden" name="currentWeek" value="<?php echo $dateDetails['currentWeek']; ?>">
                            <input type="hidden" name="year" value="<?php echo date("Y", strtotime($dateDetails['thisWeekSd'])); ?>">

                            <table class="table timesheetTable table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:5%;text-align: center;display: none;"></th>
                                        <th style="width:20%;">Task Name</th>
                                        <?php
                                        if ($dateDetails['dateRange']) {
                                            foreach ($dateDetails['dateRange'] as $date) {
                                        ?>
                                                <th style="text-align: center;"><?php echo $date->format("D d"); ?></th>

                                        <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($dateDetails['userTimesheetData']) {

                                        // echo '<pre>';

                                        // print_r($dateDetails);die;

                                        foreach ($dateDetails['userTimesheetData'] as $key => $details) {
                                    ?>
                                            <tr id="<?php echo $key; ?>" projectId="<?php echo $details[0]['projectId']; ?>">
                                                <td style="display: none;">
                                                    <?php
                                                    if (isset($details[0]['scope']) && $details[0]['scope'] != 'global') {
                                                    ?>
                                                        <input type="checkbox" class="project" id="<?php echo $key; ?>">
                                                    <?php
                                                    }
                                                    ?>

                                                </td>
                                                <td id="task"><?php echo $details[0]['taskName']?></td>

                                                <?php
                                                if ($details) {
                                                    foreach ($details as $userData) {
                                                ?>
                                                        <td>
                                                            <input type="text" name="hours" date="<?php echo $userData['date']; ?>" class="form-control hours" value="<?php if (isset($userData['hours'])) {
                                                                                                                                                                            echo $userData['hours'];
                                                                                                                                                                        } ?>" style="text-align: center;">
                                                        </td>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </tr>

                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="9" align="center">No Project found</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <br />
                            <div class="row">
                                <label class="col-sm-2">Remarks</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="remarks"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-sm-12" align="center">
                                    <button type="button" class="btn btn-primary btn-sm btn-flat" id="saveTimesheet">Save Timesheet</button>

                                    <button type="button" class="btn btn-warning btn-sm btn-flat" id="submitTimesheet">Submit Timesheet</button>

                                    <button type="button" class="btn btn-success btn-sm btn-flat" id="approveTimesheet" status='approved'>Approve Timesheet</button>

                                    <button type="button" class="btn btn-danger btn-sm btn-flat" id="rejectTimesheet" status='rejected'>Reject Timesheet</button>
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