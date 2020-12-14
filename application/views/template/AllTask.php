<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Allocate Project</h5>
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
                            <a href="<?php echo base_url(); ?>Manager/createTask" class="btn btn-primary btn-sm">Create Task</a>
                        </div>
                    </div>

                    <table class="table table-bordered dataTable">
                        <thead>
                            <tr>
                                <th>Task Name</th>
                                <th>Task Description</th>
                                <th>Project Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                if($allTasks)
                                {
                                    foreach($allTasks as $details)
                                    {
                            ?>
                                <tr>
                                    <td><?php echo $details['taskName']; ?></td>
                                    <td><?php echo $details['taskDescription']; ?></td>
                                    <td><?php echo $details['projectName']; ?></td>
                                    <td align="center">
                                        <a href="<?php echo base_url(); ?>Manager/assignTask/<?php echo base64_encode($details['taskId']); ?>" class="btn btn-primary btn-xs">Assign Task</a>
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