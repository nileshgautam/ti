<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Leave</h5>
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
                    if ($this->session->flashdata('success')) {
                    ?>
                        <?php echo "<div class='text-success'>". $this->session->flashdata('success')."</div>"; ?>
                    <?php
                    } else{
                         echo"<div class='text-danger'>". $this->session->flashdata('error')."</div>";
                    }
                    ?>
                    <form method="post" action="<?php if (isset($user)) {
                                                    echo base_url('Employee/addLeaveApplicationPost');
                                                } else {
                                                    echo base_url('Employee/addLeaveApplicationPost');
                                                } ?>">

                        <input type="hidden" name="holdayid" value="<?php if (isset($user)) {
                                                                        print_r($user[0]['userId']);
                                                                    } ?>">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="col-sm-4" for="email"> TO</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" name="sdate" class="form-control datepicker" value="<?php if (isset($user)) {
                                                                                                                        print_r($user[0]['date']);
                                                                                                                    } else {
                                                                                                                        echo date('d/m/Y');
                                                                                                                    } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4" for="email">From</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="date" name="edate" class="form-control datepicker" value="<?php if (isset($user)) {
                                                                                                                        print_r($user[0]['date']);
                                                                                                                    } else {
                                                                                                                        echo date('d/m/Y');
                                                                                                                    } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Description</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <textarea name="Description" class="form-control"><?php if (isset($user)) {
                                                                                                    print_r($user[0]['contactAddress']);
                                                                                                } ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4"> Leave Type</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select name="hType" id="" class="form-control">
                                                <option value="RH">Restricted Holidays</option>
                                                <option value="Festival">Festival</option>
                                                <option value="Casuale leave">Casuale leave</option>
                                                <option value="Sick leave">Sick leave</option>
                                                <option value="Emergency leave">Emergency leave</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" align="center">
                                <button type="submit" class="btn btn-primary">SUBMIT</button>
                            </div>
                        </div>

                    </form>


                    <div class="py-2">
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Applying Date</th>
                                    <th scope="col">Days</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Leave Type</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(!empty($leaveApplication)){

                               
                                for ($i = 0; $i < count($leaveApplication); $i++) {
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $i + 1; ?></th>
                                        <td><?php echo $leaveApplication[$i]['start_date'] ?></td>
                                        <td><?php echo $leaveApplication[$i]['days'] ?></td>
                                        <td><?php echo $leaveApplication[$i]['description'] ?></td>
                                        <td><?php echo $leaveApplication[$i]['leave_type'] ?></td>
                                        <th scope="col"><?php echo $leaveApplication[$i]['status'] ?></th>
                                    </tr>
                                <?php }  }?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

