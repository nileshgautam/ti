<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>User Tasks</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php
                        if($this->session->flashdata("error"))
                        {
                    ?>
                            <div class="row">
                                <div class="col-sm-12" align="center" style="color:red;">
                                    <?php echo $this->session->flashdata("error"); ?>
                                </div>    
                            </div>
                            <br>
                    <?php        
                        }
                    ?>

                    <?php
                        if($this->session->flashdata("success"))
                        {
                    ?>
                            <div class="row">
                                <div class="col-sm-12" align="center" style="color:green;">
                                    <?php echo $this->session->flashdata("success"); ?>
                                </div>    
                            </div>
                            <br>
                    <?php        
                        }
                    ?>

                    <div class="row">
                        <div class="col-sm-12" align="right">
                            <a href="#" class="btn btn-primary btn-sm" id="addProject">Add Task</a>
                        </div>
                    </div>
                    <br>
                    <!-- <?php echo base_url(); ?>/Manager/allocateProjectToUser/<?php echo $userId; ?> -->

                    <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Description</th>
                                <th>Project Name</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                if($allUserTask)
                                {
                                    foreach($allUserTask as $task)
                                    {
                            ?>
                                <tr>
                                    <td><?php echo $task['taskName']; ?></td>
                                    <td><?php echo $task['taskDescription']; ?></td>
                                    <td><?php echo $task['projectName']; ?></td>
                                    <!-- <td align="center">
                                        <a href="<?php echo base_url(); ?>Manager/userProjects/<?php echo base64_encode($users['userId']); ?>" class="btn btn-primary btn-xs">Projects</a>
                                    </td> -->
                                </tr>
                            <?php

                                    }
                                }
                            ?>
                        </tbody>
                    </table>

                    <div class="row">
                        <div class="col-sm-12" align="right">
                            <a href="<?php echo base_url(); ?><?php echo $class; ?>/<?php echo $function; ?>" class="btn btn-danger btn-sm">Back</a>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="projectModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Assign Task</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            </button>
          </div>
          <div class="modal-body">
            
            <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">Projects</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="project">
                            <option value="">Select Project</option>

                            <?php
                                if($allProjects)
                                {
                                    foreach($allProjects as $project)
                                    {
                            ?>
                                        <option value="<?php echo $project['projectId']; ?>"><?php echo $project['projectName']; ?></option>
                            <?php            
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">Task</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="task">
                            <option value="">Select Task</option>
                        </select>
                    </div>
                </div>
            </div> 

            <br>
            <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">Hours</label>
                    <div class="col-sm-8">
                        <input type="text" name="hours" class="form-control">
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">Start Date</label>
                    <div class="col-sm-8">
                        <input type="text" name="startDate" class="form-control datepicker">
                    </div>
                </div>
            </div>

            <br>
            <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">End Date</label>
                    <div class="col-sm-8">
                        <input type="text" name="endDate" class="form-control datepicker">
                    </div>
                </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="save">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
</div>   