<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="m-0">Managers</h4>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table dataTable table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">username</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($manager)) {
                                // echo '<pre>';
                                // print_r($project);
                                $count = 1;
                                foreach ($manager as $item) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>
                                       
                                        <td><?php echo $item['first_name'] . ' ' . $item['last_name']; ?></td>
                                        <td><?php echo $item['username']; ?></td>
                                        <td>
                                        <a class="btn btn-primary btn-xs" href="<?php echo base_url('Admin/assignedProject/').base64_encode($item['people_id'])?>" title="Projects">Show projects</a>
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