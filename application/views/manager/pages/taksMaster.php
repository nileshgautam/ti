<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0">Task Master</h4>
                    </div>
                    <div class="col-sm-8">
                        <a class="btn btn-primary btn-xs float-right ml-2" href="#" title="Add Project" data-toggle="modal" data-target="#assignModal"><i class="fas fa-plus-square"></i></a>
                        <a class="btn btn-primary btn-xs float-right ml-2" href="#" >Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table dataTable table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task</th>
                                <th scope="col">Description</th>
                                <th scope="col"> Budgeted<br/>Hrs</th>
                                <th scope="col">Start <br>Date</th>
                                <th scope="col">End <br>Date</th>
                                <th scope="col">Action</th>
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
                                        <td><?php echo $item['title'] ?></td>
                                        <td><?php echo $item['description'] ?></td>
                                        <td><?php echo $item['budgeted_hours'] ?></td>
                                        <td><?php
                                            echo date_format(date_create($item['start_date']), "d/m/Y"); ?></td>
                                        <td><?php echo date_format(date_create($item['end_date']), "d/m/Y"); ?></td>
                                        <td>
                                            <a class="btn btn-primary  btn-xs ml-2 assign-task" href="#" title="Add Project" data-toggle="modal" data-target="#assignModal" data-id="<?php echo $item['task_id'] ?>">Assign</a></td>
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
                                    <input type="hidden" name="taskId" id="taskId">
                                    <div class="form-group col-sm-12">
                                        <label for="users">Users</label>
                                        <select name="users" id="users" class="form-control">
                                            <?php if (!empty($employee)) {
                                                // echo '<pre>';
                                                // print_r($employee);
                                                $count = 1;
                                                foreach ($employee as $item) {
                                            ?>
                                                    <option value="<?php echo $item['people_id'] ?>">
                                                        <?php echo $item['first_name'] . ' ' . $item['last_name'] ?>
                                                    </option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="title">Hours</label>
                                        <input type="text" name="Hours" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="description">Start Date</label>
                                        <input type="text" class="form-control datepicker" name="startDate" id="s-date" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="description">End Date</label>
                                        <input type="text" class="form-control datepicker" name="endDate" id="e-date" placeholder="DD/MM/YYYY">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <!-- <input type="hidden" name="mid" value="<?php echo isset($Mid) ? $Mid : '' ?>"> -->
                                        <button type="submit" class="btn btn-primary float-right">Create Task</button>
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