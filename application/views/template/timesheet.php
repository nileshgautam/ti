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
.br-8{
    border-radius: 8px !important;
}
    /*tr#totalRow td
    {
        background: white !important;
    }*/
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="ibox-title">
                        <h5>Manage Timesheet</h5>
                        <div class="ibox-tools">
                            <div class="row">
                                <div class="col-sm-12" align="right">
                                    <button type="button" name="addProject" class="btn btn-primary btn-sm br-8 btn-flat">Add Task</button>
                                    <button type="button" name="removeProject" class="btn btn-danger br-8 btn-sm btn-flat">Remove Task</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12" align="right" style="font-size:16px;">
                            <?php echo "Week " . $dateDetails['currentWeek'] . ", " . $dateDetails['thisWeekSd'] . " - " . $dateDetails['thisWeekEd']; ?>
                            <a href="<?php echo base_url(); ?><?php echo $class; ?>/timesheet/<?php echo base64_encode(-1) ?>/<?php echo base64_encode(date("Y-m-d", strtotime($dateDetails['thisWeekSd']))) ?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></a>

                            <a href="<?php echo base_url(); ?><?php echo $class; ?>/timesheet/<?php echo base64_encode(+1) ?>/<?php echo base64_encode(date("Y-m-d", strtotime($dateDetails['thisWeekEd']))) ?>" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <input type="hidden" name="currentWeek" value="<?php echo $dateDetails['currentWeek']; ?>">
                    <input type="hidden" name="year" value="<?php echo date("Y", strtotime($dateDetails['thisWeekSd'])); ?>">
                    <table class="table table-bordered timesheetTable">
                        <thead>
                            <tr>
                                <th style="width:5%;text-align: center;"></th>
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
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if ($dateDetails['userTimesheetData']) {
                                $total = [];
                                foreach ($dateDetails['userTimesheetData'] as $key => $details) {
                                    // echo "<pre>";

                                    // print_r($details);die;
                            ?>
                                    <tr id="<?php echo $key; ?>" projectId="<?php echo $details[0]['projectId']; ?>">

                                        <td>
                                            <?php
                                            if (isset($details[0]['scope']) && $details[0]['scope'] != 'global') {
                                            ?>
                                                <input type="checkbox" class="project" id="<?php echo $key; ?>">
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $details[0]['taskName'] ?></td>
                                        <?php
                                        if ($details) {
                                            $totalHours = 0;
                                            foreach ($details as $newKey => $userData) {
                                                // print_r($userData);die;
                                                $hours = 0;
                                                $total[$key][$userData['date']]['hours'] = 0;
                                                if (isset($userData['hours'])) {
                                                    $hours = $userData['hours'];
                                                }
                                                $totalHours += $hours;
                                                $total[$key][$userData['date']]['hours'] += $hours;
                                        ?>
                                                <td>
                                                    <input type="text" name="hours" date="<?php echo $userData['date']; ?>" class="form-control hours" value="<?php echo $hours; ?>" style="text-align: center;">
                                                </td>
                                        <?php
                                            }
                                        }

                                        ?>
                                        <td style="background: white !important; text-align: center;"><?php echo $totalHours; ?></td>
                                        <?php
                                        ?>
                                    </tr>

                                <?php
                                }

                                ?>
                        <tfoot>
                            <tr id="totalRow">
                                <td></td>
                                <th>Total</th>
                                <?php
                                if ($dateDetails['dateRange']) {
                                    foreach ($dateDetails['dateRange'] as $dateRageDetail) {
                                        $date = $dateRageDetail->format("Y-m-d");
                                        $columnArray = array_column($total, $date);
                                        $hours = array_column($columnArray, 'hours');
                                        $sum = array_sum($hours);
                                ?>
                                        <td align="center" class="totalColumn" id="<?php echo $sum; ?>"><?php echo $sum; ?></td>
                                <?php
                                    }
                                }
                                ?>
                                <td></td>
                                <?php
                                ?>
                            </tr>
                        </tfoot>
                    <?php
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
                    <?php
                    if (isset($dateDetails['timesheetWeeklyDetails'][0]['remarks']) && $dateDetails['timesheetWeeklyDetails'][0]['remarks'] != '') {

                    ?>
                        <div class="row">
                            <label class="col-sm-2">Remarks : -</label>
                            <div class="col-sm-10" style="color:red;">
                                <?php echo $dateDetails['timesheetWeeklyDetails'][0]['remarks'];  ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <br>
                    <div class="row">
                        <div class="col-sm-12" align="center">
                            <button type="button" class="btn btn-primary btn-sm btn-flat br-8" id="saveTimesheet">Save Timesheet</button>

                            <button type="button" class="btn btn-danger btn-sm btn-flat br-8" id="submitTimesheet">Submit Timesheet</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>