<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Allocate Task</h5>
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
                        <div class="col-sm-3">
                            <p>
                                <label>Project Name :</label> <?php if(isset($taskDetails[0]['projectName'])){ echo $taskDetails[0]['projectName']; } ?>
                            </p>
                        </div>
                        <div class="col-sm-3">
                            <p>
                                <label>Task Name :</label> <?php if(isset($taskDetails[0]['taskName'])){ echo $taskDetails[0]['taskName']; } ?>
                            </p>
                        </div>
                        <div class="col-sm-2">
                            <p>
                                <label>Start Date :</label> <?php if(isset($taskDetails[0]['startDate'])){ echo $taskDetails[0]['startDate']; } ?>
                            </p>
                        </div>

                        <div class="col-sm-2">
                            <p>
                                <label>End Date :</label> <?php if(isset($taskDetails[0]['endDate'])){ echo $taskDetails[0]['endDate']; } ?>
                            </p>
                        </div>
                        <div class="col-sm-2" align="right">
                            <a href="#" id="assignUser" class="btn btn-primary btn-sm">Assign User</a>
                        </div>
                    </div>
                    <input type="hidden" name="taskId" value="<?php echo $taskId; ?>">

                    <input type="hidden" name="projectId" value="<?php if(isset($taskDetails[0]['projectId'])){ echo $taskDetails[0]['projectId']; } ?>">
                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Hours</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                if($taskDetailsUserWise)
                                {
                                    foreach($taskDetailsUserWise as $details)
                                    {
                            ?>
                                <tr>
                                    <td><?php echo $details['name']; ?></td>
                                    <td><?php echo $details['totalWorkedHours']; ?></td>
                                    <td align="center">
                                        <!-- <a href="<?php echo base_url(); ?>Manager/assignTask/<?php echo base64_encode($details['taskId']); ?>" class="btn btn-primary btn-xs">Assign Task</a> -->
                                    </td>
                                </tr>
                            <?php

                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="assignTaskModal">
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
                    <label class="col-sm-4">Users</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="users">
                            <option value="">Select User</option>

                            <?php
                                if($allocatedUsers)
                                {
                                    foreach($allocatedUsers as $user)
                                    {
                            ?>
                                        <option value="<?php echo $user['userId']; ?>"><?php echo $user['name']; ?></option>
                            <?php            
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            
            
            <!-- <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">Projects</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="project">
                            <option value="">Select Project</option>

                            <?php
                                if($allocatedProjects)
                                {
                                    foreach($allocatedProjects as $project)
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
            </div> -->
            <!-- <br>
            <div class="row">
                <div class="col-sm-12">
                    <label class="col-sm-4">Task</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="task">
                            <option value="">Select Task</option>
                        </select>
                    </div>
                </div>
            </div>  -->

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