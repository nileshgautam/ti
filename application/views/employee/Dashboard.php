<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5>Timesheets</h5>
                </div>
                <div class="card-body">
                    <div class="ibox-content">
                        <table class="table table-hover no-margins">
                            <thead>
                                <tr>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($timesheetWeeklyData) {
                                    foreach ($timesheetWeeklyData as $details) {
                                        $weekNumber = sprintf("%02d", $details['week']);
                                        $this_week_sd = date('d/m/Y', strtotime($details['year'] . "W" . $weekNumber));

                                        $previousDate = date("Y-m-d", strtotime(date('Y-m-d', strtotime($details['year'] . "W" . $weekNumber)) . "-1 day"));
                                        $this_week_ed = date('d/m/Y', strtotime($details['year'] . "W" . $weekNumber . "+6 days"));
                                ?>
                                        <tr>

                                            <td> <?php echo $this_week_sd; ?></td>
                                            <td><?php echo $this_week_ed; ?></td>
                                            <td>
                                                <a href="<?php echo base_url() ?>Employee/timesheet/<?php echo base64_encode(+1); ?>/<?php echo base64_encode($previousDate); ?>">
                                                    <span class="label label-danger"><?php echo ucfirst($details['status']); ?></span>
                                                </a>
                                            </td>
                                            <!-- <td class="text-navy"> <i class="fa fa-level-up"></i> 23% </td> -->
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="3" align="center">No record found</td>
                                    </tr>
                                <?php
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