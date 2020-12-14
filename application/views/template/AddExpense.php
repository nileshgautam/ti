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
                    <h5>Add Expense</h5>
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
                    <form method="POST" action="<?php echo base_url(); ?><?php echo $class; ?>/addExpensePost">
                        <div class="row">
                            

                            <div class="col-sm-6">
                                <label class="col-sm-4">Date</label>
                                <div class="col-sm-8">
                                    <input type="text" name="expenseDate" value="<?php echo date('d/m/Y'); ?>" class="form-control datepicker">
                                </div>
                            </div>

                            

                            <div class="col-sm-6">
                                <label class="col-sm-4">Project</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="project">
                                        <option value="">Select Project</option>
                                        <?php
                                            if($allProjects)
                                            {
                                                foreach($allProjects as $allProject)
                                                {
                                        ?>
                                                    <option value="<?php echo $allProject['projectId']; ?>"><?php echo $allProject['projectName']; ?></option>
                                        <?php            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Category</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="category">
                                        <option value="billable">Billable</option>
                                        <option value="non-Billable">Non-Billable</option>
                                    </select>
                                </div>
                            </div>

                            <!-- <div class="col-sm-6 col-sm-push-6">
                                <label class="col-sm-4"></label>
                                <div class="col-sm-8">
                                    
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Expense Title</label>
                                <div class="col-sm-8">
                                    <input type="text" name="description" class="form-control">
                                </div>
                            </div> -->

                            <div class="col-sm-6">
                                <label class="col-sm-4">Expense Details</label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="comment"></textarea>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Amount (incl GST)</label>
                                <div class="col-sm-8">                                    
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-inr"></i>
                                      </div>
                                      <input type="text" name="cost" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">GST</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                      <div class="input-group-addon">
                                        <i class="fa fa-inr"></i>
                                      </div>
                                      <input type="text" name="gst" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Attachment</label>
                                <div class="col-sm-8">
                                    <input type="file" name="attachment" class="form-control">
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