<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="cord">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0">People Administration </h4>
                    </div>
                    <div class="col-sm-8">
                        <ul class="nav nav-pills  float-right btn-xs" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-employees-tab" data-toggle="pill" href="#pills-employees" role="tab" aria-controls="pills-employees" aria-selected="true">Employees</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-clients-tab" data-toggle="pill" href="#pills-clients" role="tab" aria-controls="pills-clients" aria-selected="false">Clients</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-employees" role="tabpanel" aria-labelledby="pills-employees-tab">
                            <div class="card">
                                <div class="card-header row m-0">
                                    <div class="col-sm-2">Employees</div>
                                    <div class="col-sm-10">
                                        <a class="btn btn-primary float-right btn-xs d-btn" id='employees' href="<?php echo base_url('Admin/people') ?>" title="Add more"><i class="fas fa-plus-square"></i></a>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <table class="table dataTable table-striped table-responsive">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Manager</th>
                                                <th scope="col">Client</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="emp-t-body">
                                            <?php if (!empty($employee)) {
                                                // print_r($employee);
                                                $count = 1;
                                                foreach ($employee as $item) { ?>
                                                    <tr>
                                                        <th scope="row"><?php echo  $count++; ?></th>
                                                        <td><?php echo $item['username']; ?></td>
                                                        <td><?php echo $item['first_name'] . ' ' . $item['last_name']; ?></td>
                                                        <td><?php echo $item['phone']; ?></td>

                                                        <td><?php echo $item['department']; ?></td>
                                                        <td><?php echo $item['role'] ?></td>
                                                        <td><?php echo $item['manager_name']; ?></td>
                                                        <td><?php echo $item['client_name']; ?></td>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <a href="#" data-id="<?php echo $item['people_id']; ?>" title="Reset password" class="btn btn-primary btn-xs reset-password">
                                                                        <i class="fas fa-cog"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <a href="<?php echo base_url('Admin/emp_edit/') . base64_encode($item['people_id']) ?>" class="btn btn-warning btn-xs" title="Edit">
                                                                        <i title="Show" class="fas fa-edit"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4" title="Delete">
                                                                    <a href="#" class="del-employee" data-id='<?php echo base64_encode($item['people_id']) ?>'>
                                                                        <i class="fas fa-trash btn-danger btn-xs">
                                                                        </i>
                                                                    </a>

                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-clients" role="tabpanel" aria-labelledby="pills-clients-tab">
                            <div class="card">
                                <div class="card-header row m-0">
                                    <div class="col-sm-2">Clients</div>
                                    <div class="col-sm-10">
                                        <a class="btn btn-primary float-right btn-xs d-btn" id='clients' href="<?php echo base_url('Admin/') ?>clinetForm">
                                            <i class="fas fa-plus-square"></i></a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table class="table dataTable table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">id</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Orgnization Type</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Country</th>
                                                <th scope="col">Currency</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="client-t-body">
                                            <?php if (!empty($client)) {
                                                $count = 1;
                                                foreach ($client as $item) { ?>
                                                    <tr>
                                                        <th scope="row"><?php echo  $count++; ?></th>
                                                        <td><?php echo $item['client_id']; ?></td>
                                                        <td><?php echo $item['client_name']; ?></td>
                                                        <td><?php echo $item['orgnaization_type']; ?></td>
                                                        <td><?php echo $item['email']; ?></td>
                                                        <td><?php echo $item['phone']; ?></td>
                                                        <td><?php echo $item['country']; ?></td>
                                                        <td><?php echo $item['currency']; ?></td>
                                                        <td>
                                                            <div class="row">
                                                                <!-- <div class="col-sm-4">
                                                                   <a href="" title="show" class="btn btn-primary btn-xs"> 
                                                                       <i class="fas fa-eye"></i>
                                                                </a>
                                                                </div> -->
                                                                <div class="col-sm-4">
                                                                    <a href="<?php echo base_url('Admin/client_edit/') . base64_encode($item['client_id']) ?>" class="btn btn-warning btn-xs" title="Edit">
                                                                        <i title="Show" class="fas fa-edit"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-sm-4" title="Delete">
                                                                    <a href="#" class="del-client" data-id='<?php echo base64_encode($item['client_id']) ?>'>
                                                                        <i class="fas fa-trash btn-danger btn-xs">
                                                                        </i>
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr>
                                            <?php }
                                            } ?>

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
</div>

<div class="modal fade" id="empPasswordModal" tabindex="-1" role="dialog" aria-labelledby="empPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="empPasswordModal">Resent password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id='resent-password-form'>
                    <div class="form-group col-sm-12">
                        <label for="email">Email<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="email@mail.com" required>
                    </div>
                    <input type="hidden" id="emp-id-hidden" name="emp-id-hidden">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Resnt Password</button>
            </div>
            </form>
        </div>
    </div>
</div>