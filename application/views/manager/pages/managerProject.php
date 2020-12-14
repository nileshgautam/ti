<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0">Assigned Projects</h4>
                    </div>
                    <div class="col-sm-8">
                        <!-- <a class="btn btn-primary float-right ml-2" href="#" title="Add Project" data-toggle="modal" data-target="#assignModal"><i class="fas fa-plus-square"></i></a> -->
                    </div>
                </div>
                <div class="card-body">
                    <table class="table dataTable table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Project <br />Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Budget <br />Hrs</th>
                                <th scope="col">Start <br>Date</th>
                                <th scope="col">End <br>Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($projects)) {
                                // echo '<pre>';
                                // print_r($projects);
                                $count = 1;
                                foreach ($projects as $item) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>
                                        <td><?php echo $item['name'] ?></td>
                                        <td><?php echo $item['description'] ?></td>
                                        <td><?php echo $item['budget_hours'] ?></td>
                                        <td><?php
                                            echo date_format(date_create($item['start_date']), "d/m/Y"); ?></td>
                                        <td><?php echo date_format(date_create($item['end_date']), "d/m/Y"); ?></td>
                                        <td>
                                            <!-- <a class="btn btn-primary float-right ml-2 add-task" href="#" title="Add Project" data-toggle="modal" data-target="#assignModal" data-id="<?php echo $item['project_Id'] ?>">Tasks</a> -->

                                            <a class="btn btn-primary  btn-xs ml-2" href="<?php echo base_url('Manager/projectTask/').base64_encode($item['project_Id']).'/'.base64_encode($item['name'])?>">Tasks</a>
                                    
                                        </td>
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
                                <h5 class="modal-title" id="assignModalLabel">Create Task</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form id="create-task" class="row m-0">
                                    <input type="hidden" name="project-id" id="project-id">
                                    <div class="form-group col-sm-12">
                                        <label for="projects">Services</label>
                                        <select name="service" id="manager-service" class="form-control">
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="hours">Budget Hours</label>
                                        <input type="text" class="form-control" name="hours" />
                                    </div>
                                    <div class="form-group col-sm-6 date">
                                        <label for="description">Start Date</label>
                                        <input type="date" class="form-control" name="e-date" id="e-date">
                                    </div>
                                    <div class="form-group col-sm-6 date">
                                        <label for="description">End Date</label>
                                        <input type="date" class="form-control" name="s-date" id="s-date">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <input type="hidden" name="mid" value="<?php echo isset($Mid) ? $Mid : '' ?>">
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