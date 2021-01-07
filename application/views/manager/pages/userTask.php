<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0"><?php echo ($users) ? $users[0]['first_name'] . ' ' . $users[0]['last_name'] : ''; ?></h4>
                    </div>
                    <div class="col-sm-8">
                        <a class="btn btn-primary float-right ml-2" href="#" id="assignModel" title="Assign new task" data-toggle="modal" data-target="#assignModal"><i class="fas fa-plus-square"></i></a>
                        <a class="btn btn-warning float-right mr-2" id="submit-task" href="javascript:window.history.back(-1);">Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table dataTable table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>

                                <th scope="col">Project</th>
                                <th scope="col">Task</th>
                                <th scope="col">Description</th>
                                <th scope="col">Estimate Hrs</th>
                                <th scope="col">Start <br>Date</th>
                                <th scope="col">End <br>Date</th>
                                <!-- <th scope="col">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($task)) {
                                // echo '<pre>';
                                // print_r($task);
                                $count = 1;
                                foreach ($task as $item) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>
                                        <td><?php echo $item['project_name'] ?></td>
                                        <td><?php echo $item['title'] ?></td>

                                        <td><?php echo $item['description'] ?></td>
                                        <td><?php echo $item['budgetedHours'] ?></td>
                                        <td><?php
                                            echo date_format(date_create($item['startDate']), "d/m/Y"); ?></td>
                                        <td><?php echo date_format(date_create($item['endDate']), "d/m/Y"); ?></td>
                                        <!-- <td>
                                            <a class="btn btn-primary float-right ml-2 assign-task" href="#" title="Add Project" data-toggle="modal" data-target="#assignModal" data-id="<?php echo $item['task_id'] ?>">Assign</a>
                                        </td> -->
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignModalLabel">Assign Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="allocateTask" class="row m-0">
                                    <input type="hidden" name="users" id="taskId" value="<?php echo $users[0]['people_id'] ?>">

                                    <!-- <input type="hidden" name="projectid" id="projectid" > -->

                                    <!-- <?php print_r($projects_task); ?> -->
                                    <div class="form-group col-sm-12">

                                        <label for="projectid">Project</label>
                                        <select id="projectid" name="projectid" class="form-control">
                                            <option value="">Select</option>
                                            <?php if (!empty($projects_task)) {
                                                $count = 1;
                                                foreach ($projects_task as $item) {
                                                    // print_r($item);
                                            ?>
                                                    <option value="<?php echo $item['project_id'] ?>" data-projectid='<?php echo  $item['project_id'] ?>'>
                                                        <?php echo $item['name'] ?>
                                                    </option>
                                            <?php }
                                            } ?>
                                        </select>
                                        <label for="taskId">Task</label>
                                        <select name="taskId" id="taskid" class="form-control">
                                            <!-- <option value="">Select</option>
                                            <?php if (!empty($MasterTask)) {
                                                $count = 1;
                                                foreach ($MasterTask as $item) {
                                                    // print_r($item);
                                            ?>
                                                    <option 
                                                    value="<?php echo $item['task_id'] ?>" 
                                                    data-hrs='<?php echo  $item['assigned_hrs'] ?>' data-st='<?php echo ddmmyy($item['start_date']) ?>' data-projectid='<?php echo  $item['project_id'] ?>'
                                                    data-et='<?php echo  ddmmyy($item['end_date']) ?>'>
                                                        <?php echo $item['title'] ?>
                                                    </option>
                                            <?php }
                                            } ?> -->
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-12">
                                        <label for="title">Hours</label>
                                        <input type="text" name="Hours" id="ashrs" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="description">Start Date</label>
                                        <input type="text" class="form-control datepicker" name="startDate" id="s-date" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="description">End Date</label>
                                        <input type="text" class="form-control datepicker" name="endDate" id="e-date" placeholder="DD/MM/YYYY" id="e-date">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <!-- <input type="hidden" name="mid" value="<?php echo isset($Mid) ? $Mid : '' ?>"> -->
                                        <button type="submit" class="btn btn-primary float-right">Assign Task</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    $('#taskid').change(function() {

        $('#ashrs').val($(this).children(':selected').attr('data-hrs'));
        $('#s-date').val(ddmmyy($(this).children(':selected').attr('data-st')));
        $('#e-date').val(ddmmyy($(this).children(':selected').attr('data-et')));

    });

    const ddmmyy = (date) => {
        let std = date.split('-');
        let sdate = `${std[2]}/${std[1]}/${std[0]}`;
        return sdate

    }
</script>