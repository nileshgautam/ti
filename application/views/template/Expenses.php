<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>All Expenses</h5>
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
                    <?php        
                        }
                    ?>
                    <div class="row">
                        <div class="col-sm-12" align="right">
                            <a href="<?php echo base_url(); ?><?php echo $class; ?>/addExpenses" class='btn btn-primary btn-flat btn-sm'>Add Expenses</a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTable">
                            <thead>
                                <tr>
                                    <!-- <th>Description</th> -->
                                    <th>Expense Date</th>
                                    <th>Expense Detail</th>
                                    <th>Project</th>
                                    <th>Category</th>
                                    <th>Cost (incl GST)</th>
                                    <th>GST</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($allExpenses)
                                    {
                                        foreach ($allExpenses  as $expenses) {
                                           
                                        
                                ?>
                                        <tr class="gradeX">
                                            <!-- <td><?php echo $expenses['description']; ?></td> -->
                                            <td><?php echo date("d/m/Y",strtotime($expenses['expenseDate'])); ?></td>
                                            <td><?php echo $expenses['comment']; ?></td>
                                            <td><?php echo $expenses['projectName']; ?></td>
                                            <td><?php echo $expenses['category']; ?></td>
                                            <td><?php echo $expenses['cost']; ?></td>
                                            <td><?php echo $expenses['gst']; ?></td>
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
</div>    