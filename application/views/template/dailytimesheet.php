<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-header">Daily Timesheet</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- <div class="col-sm-3">Calender</div> -->
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <div><?php echo date('d/m/Y') ?></div>
                                    <input type="hidden" name="ssdate" id="ssdate" value="<?php echo date('Y-m-d') ?>">
                                </div>
                                <div class="card-body dailytimesheet">
                                    <?php
                                    $timeArr = timeRange(7, 22);      
                                    ?>
                                    <?php
                                    echo "<pre>";
                                    // $TArr = [];
                                    print_r($task);
                                    foreach ($timeArr as $item) {
                                        if ($task) {
                                            foreach ($task as $taskItem) {
                                                // print_r($taskItem['start_time']);
                                                // /
                                                // / print_r($item);
                                                // $st = explode(':', $taskItem['start_time']);
                                                // $fxtime = explode(':', $item);
                                                // $tI1 = explode(' ', $st[1]);
                                                // $tI2 = explode(' ', $fxtime[1]);

                                                $st= $st[0];
                                                $fxtime=$fxtime[0];
                                                print_r($st);
                                                print_r($fxtime);
                                                if ($st[0] == $fxtime[0] && $tI1[1] == $tI2[1]) { ?>
                                                <!-- if ($st[0] == $fxtime[0] && $tI1[1] == $tI2[1]) { ?> -->
                                                    <div data-id="<?php echo $item ?>" class="time-box p-2">
                                                        <?php echo $item; ?>
                                                        <div class="bg-info ml-2 taks-title">
                                                            <?php echo $taskItem['taks_id'] ?>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <div data-id="<?php echo $item ?>" class="time-box p-2">
                                                        <?php echo $item; ?>
                                                    </div>
                                            <?php }
                                            }
                                        } else {
                                            ?>
                                            <div data-id="<?php echo $item ?>" class="time-box p-2">
                                                <?php echo $item; ?>
                                            </div>
                                    <?php }
                                    }
                                    //    die;
                                    ?>

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
                                <input type="text" placeholder="start time" class="show-time form-control" value="" id="st-time" name="st-time" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" placeholder=" Select closing time" class="show-time form-control" id="et-time" name="et-time" required>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <select name="taskId" id="task" class="form-control">
                                    <option value="">Select task</option>
                                    <?php if (!empty($allocatedTask)) {

                                        // my_print($allocatedTask);
                                        foreach ($allocatedTask as $item) { ?>
                                            <option value="<?php echo $item['task_id'] ?>" data-client="<?php echo $item['client_id']; ?>" data-project="<?php echo $item['project_id']; ?>" data-service="<?php echo $item['service_id']; ?>">
                                                <?php echo $item['title'] . '(Pro->' . $item['projectName'] . ')' ?>

                                            </option>
                                    <?php   }
                                    } ?>




                                </select>
                            </div>
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