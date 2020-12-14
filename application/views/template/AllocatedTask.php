<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="ibox-title">
                        <h5>Allocated Tasks</h5>
                    </div>
                    <div class="ibox-content">
                        <?php
                        if ($this->session->flashdata("error")) {
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
                        if ($this->session->flashdata("success")) {
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
                                <a href="#" class='btn btn-primary btn-flat btn-sm' id='addProject'>Add Task</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover dataTable" id="projects">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <th>Task Name</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($allocatedTask) {
                                        // echo '<pre>';
                                        // print_r($allocatedTask);die;
                                        foreach ($allocatedTask  as $details) {
                                    ?>
                                            <tr>
                                                <td align="center">
                                                    <?php

                                                    if (isset($details['employeeTaskId']) && $details['employeeTaskId'] == "NULL") {
                                                    ?>
                                                        <input type="checkbox" class="task" id="<?php echo $details['taskId']; ?>">
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <input type="checkbox" class="task" checked="" disabled="">
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $details['title']; ?></td>
                                                <td><?php echo $details['description']; ?></td>
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
</div>
</div>