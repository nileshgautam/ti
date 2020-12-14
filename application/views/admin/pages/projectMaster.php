<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0">Projects Administration </h4>
                    </div>
                    <div class="col-sm-4">
                        <?php echo ($this->session->flashdata('success') != null) ? '<h5 class="m-0 text-success">' . $this->session->flashdata('success') . '</h5>' : '<h5 class="m-0 text-danger">' . $this->session->flashdata('success') . '</h5>'; ?></h4>
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary btn-xs float-right ml-2" href="<?php echo base_url('Admin/projectForm') ?>" title="New Project"><i class="fas fa-plus-square"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table dataTable table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Code</th>
                                <th scope="col">Client Name</th>
                                <th scope="col">Title</th>
                                <th scope="col">Services</th>
                                <th scope="col">Billing <br />Type</th>
                                <th scope="col">Description</th>
                                <!-- <th scope="col">Consumed <br />Hours</th> -->
                                <th scope="col">Start<br />Date</th>
                                <th scope="col">End <br />Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody class="project-tbody">
                            <?php if (!empty($project)) {
                                // echo '<pre>';
                                // print_r($project);
                                $count = 1;
                                foreach ($project as $item) {

                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>
                                        <td><?php echo $item['project_Id']; ?></td>
                                        <td><?php echo $item['client_name']; ?></td>
                                        <td><?php echo $item['name']; ?></td>
                                        <td>
                                            <?php
                                            $service = selectedServices($item['services']);
                                            $ss = '';
                                            foreach ($service as $key => $s) {
                                                $ss .= '<span>' . $s . '</span>,';
                                            }
                                            echo $ss;
                                            ?>

                                        </td>
                                        <td><?php echo $item['billing_type']; ?></td>
                                        <td><?php echo $item['description']; ?></td>

                                        <td><?php echo date_format(date_create($item['start_date']), "d/m/y"); ?></td>
                                        <td><?php echo date_format(date_create($item['end_date']), "d/m/y") ?></td>
                                        <td>
                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <a href="<?php echo base_url('Admin/project_edit/') . base64_encode($item['project_Id']) ?>" class="btn btn-warning btn-xs" title="Edit">
                                                        <i title="Show" class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                                <div class="col-sm-4" title="Delete">
                                                    <a href="#" class="del-project" data-id="<?php echo base64_encode($item['project_Id']) ?>">
                                                        <i class="fas fa-trash btn-danger btn-xs">
                                                        </i>
                                                    </a>
                                                </div>

                                                <div class="col-sm-4 " title="Assign">
                                                    <a href="#" class="assign-project" data-id="<?php echo base64_encode($item['project_Id']) ?>">
                                                        <i class="fas fa-plus btn-success btn-xs">
                                                        </i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-assign-project">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo 'Assign Project To Manager' ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row" id="assignProjectToManager">
                    <div class="form-group col-sm-12">
                        <label for="title">Select Manager</label>
                        <select name="mid" class="form-control" id="mid">
                            <?php if (!empty($manager)) {
                                foreach ($manager as $item) { ?>
                                    <option value="<?php echo base64_encode($item['people_id']) ?>">
                                        <?php echo $item['first_name'] . ' ' . $item['last_name'] ?></option>
                                <?php }
                            } else { ?>
                                <option value="not selected">
                                    Not Available
                                </option>
                            <?php } ?>

                        </select>
                    </div>
                    <input type="hidden" id="project" name="projects">
                    <div class="col-sm-12 pd-33">
                        <button type="submit" class="btn btn-primary btn-xs float-right">Assign</button>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>