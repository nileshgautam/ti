<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0"><?php echo isset($projecName) ? $projecName : '' ?></h4>
                    </div>
                    <div class="col-sm-8">
                        <a class="btn btn-primary  float-right ml-2 add-task" href="#" title="Add Project" data-toggle="modal" data-target="#taskModal" data-id="<?php echo $projecid ?>"><i class="fas fa-plus-square"></i></a>

                        <a class="btn btn-warning  float-right ml-2" href="javascript:window.history.back(-1);" title="Back"><i class="fas fa-arrow-left"></i></a>

                    </div>
                </div>
                <div class="card-body">

                    <!-- <div class="card">
                    <select name="" id="" class="hi">
                        
                    </select>
                </div> -->

                    <table class="table dataTable table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Task</th>
                                <th scope="col">Description</th>
                                <th scope="col">Estimate Hrs</th>
                                <th scope="col">Start <br>Date</th>
                                <th scope="col">End <br>Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($task)) {
                                // echo '<pre>';
                                // print_r($task);
                                // die;
                                $count = 1;
                                foreach ($task as $item) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>
                                        <td><?php echo $item['title'] ?></td>
                                        <td><?php echo $item['description'] ?></td>
                                        <td><?php echo $item['assigned_hrs'] ?></td>
                                        <td><?php
                                            echo date_format(date_create($item['start_date']), "d/m/Y"); ?></td>
                                        <td><?php echo date_format(date_create($item['end_date']), "d/m/Y"); ?></td>
                                        <td>
                                            <a class="btn btn-primary btn-xs ml-2 
                                            assign-task" href="#" title="Assign" data-toggle="modal" data-target="#assignModal" data-id="<?php echo $item['task_id'] ?>" data-projectid="<?php echo $item['project_id'] ?>" data-st="<?php echo date_format(date_create($item['start_date']), "d/m/Y") ?>" data-et="<?php echo date_format(date_create($item['end_date']), "d/m/Y") ?>" data-hr="<?php echo $item['assigned_hrs'] ?>">Assign</a>

                                            <a class="btn btn-primary btn-xs m-2 
                                            self" title="Assign self" data-id="<?php echo $item['task_id'] ?>" data-st="<?php echo date_format(date_create($item['start_date']), "d/m/Y") ?>" data-et="<?php echo date_format(date_create($item['end_date']), "d/m/Y") ?>" data-projectid="<?php echo $item['project_id'] ?>" data-hr="<?php echo $item['assigned_hrs'] ?>"> Assign self</a>

                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <!-- Modal assign -->
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
                                    <input type="hidden" name="projectid" id="projectid">
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
                                        <input type="text" name="Hours" id="hr" class="form-control ">
                                    </div>
                                    <div class="form-group col-sm-6 date">
                                        <label for="description">Start Date</label>
                                        <input type="text" class="form-control datepicker" placeholder="DD/MM/YYYY" name="startDate" id="s-date">
                                    </div>
                                    <div class="form-group col-sm-6 date">
                                        <label for="description">End Date</label>
                                        <input type="text" class="form-control datepicker" placeholder="DD/MM/YYYY" name="endDate" id="e-date">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <!-- <input type="hidden" name="mid" value="<?php echo isset($Mid) ? $Mid : '' ?>"> -->
                                        <button type="submit" class="btn btn-primary float-right ">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Add task -->
                <!-- Modal -->
                <div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="taskModalLabel">Add Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <?php
                                // echo '<pre>';
                                // print_r($project[0]['start_date']);
                                // print_r($project[0]['end_date']);
                                // print_r($project[0]['budget_hours']);
                                ?>

                                <form id="create-task" class="row m-0">
                                    <div class="col-sm-12">
                                        <!-- <input type="hidden" name="flage" value="master_tasks"> -->
                                        <input type="hidden" name="project-id" id="project-id">
                                        <div class="form-group col-sm-12">
                                            <label for="manager-service">Services</label>
                                            <select name="service" id="manager-service" class="form-control manager-service">
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-12">
                                            <label for="manager-service">Task</label>
                                            <div class="input-group">

                                                <input type="hidden" name="selected-task" id="selected-task">


                                                <input type="text" class="form-control" id="selected-task-view">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary search-task" type="button"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary addnew-task" type="button"><i class="fas fa-plus"></i></button>
                                                </div>
                                                
                                            </div>
                                            <div class="shorted-task border hide">
                                                <!-- <input type="text"> -->
                                            </div>
                                        </div>
                                        <div class="row">


                                            <div class="form-group col-sm-4">
                                                <label for="hours">Budget Hours</label>
                                                <input type="text" class="form-control" name="hours" value="<?php
                                                                                                            echo $project[0]['budget_hours'] ?>" />
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="description">Start Date</label>
                                                <input type="text" class="form-control datepicker" name="st-date" id="st-date" value="<?php
                                                                                                                                        echo date_format(date_create($project[0]['start_date']), "d/m/Y"); ?>" placeholder="DD/MM/YYYY">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="description">End Date</label>
                                                <input type="text" class="form-control datepicker" name="et-date" id="et-date" value="<?php
                                                                                                                                        echo date_format(date_create($project[0]['end_date']), "d/m/Y"); ?>" placeholder="DD/MM/YYYY">
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <input type="hidden" name="mid" value="<?php echo isset($Mid) ? $Mid : '' ?>">
                                                <button type="submit" class="btn btn-primary float-right  ">Save changes</button>
                                            </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Create new task -->
        <!-- Modal -->
        <div class="modal fade" id="newtaskModal" tabindex="-1" role="dialog" aria-labelledby="newtaskModalLable" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newtaskModalLable">Create Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <?php
                        // echo '<pre>';
                        // print_r($project[0]['start_date']);
                        // print_r($project[0]['end_date']);
                        // print_r($project[0]['budget_hours']);
                        ?>

                        <form id="create-new-task" class="row m-0">
                            <input type="hidden" name="project-id" id="project-id">

                            <div class="form-group col-sm-12">
                                <label for="manager-service">Services</label>
                                <select name="categories" id="ser-cgt" class="form-control manager-service">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="taskTile">Task</label>
                                <textarea name="title" class="form-control" id="taskTile" rows="2"></textarea>
                            </div>

                            <div class="form-group col-sm-12">
                                <label for="task-description">Description</label>
                                <textarea name="description" id="task-description" rows="2" class="form-control"></textarea>
                            </div>

                            <div class="form-group col-sm-12">
                                <input type="hidden" name="flage" value="master_tasks">
                                <button type="submit" class="btn btn-primary   float-right">Save changes</button>
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