<style type="text/css">
    .col-sm-6
    {
        margin-bottom:10px;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Add Task</h5>
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
                    <form method="POST" action="<?php echo base_url(); ?>Manager/addTaskPost">
                        <div class="row">
                            
                            <div class="col-sm-6">
                                <label class="col-sm-4">Task Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="taskName" class="form-control" required="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Project</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="project" required="">
                                        <option value="">Select Project</option>
                                        <?php
                                            if($allocatedProjects)
                                            {
                                                foreach($allocatedProjects as $allProject)
                                                {
                                                    if($allProject['employeeProjctId']!="NULL")
                                                    {
                                        ?>
                                                    <option value="<?php echo $allProject['projectId']; ?>"><?php echo $allProject['projectName']; ?></option>
                                        <?php       
                                                    }     
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-sm-6 hidden">
                                <label class="col-sm-4">Task Code</label>
                                <div class="col-sm-8">
                                    <input type="text" name="taskCode" class="form-control" required="">
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <label class="col-sm-4">Hours</label>
                                <div class="col-sm-8">
                                    <input type="text" name="hours" class="form-control" required="">
                                </div>
                            </div>


                            <div class="col-sm-6">
                                <label class="col-sm-4">Task Description</label>
                                <div class="col-sm-8">
                                    <textarea name="taskDescription" class="form-control" required=""></textarea>
                                </div>
                            </div>

        
                            <div class="col-sm-6">
                                <label class="col-sm-4">Start Date</label>
                                <div class="col-sm-8">
                                    <input type="text" name="startDate" class="form-control datepicker" required="">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">End Date</label>
                                <div class="col-sm-8">
                                    <input type="text" name="endDate" class="form-control datepicker" required="">
                                </div>
                            </div>


                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12" align="center">
                                <button type="submit" class="btn btn-primary btn-flat">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    