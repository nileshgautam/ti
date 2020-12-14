<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-sm-6">
                            <h3 class="card-title">Role Master</h3>
                        </div>
                        <div class="col-sm-6">
                            <form class="d-flex form-data">
                                <input class="form-control" name="description" type="text" placeholder="Add role" required>
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-plus"></i>
                                </button>
                        </div>
                        </form>
                    </div>

                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="role-master" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="rolebody">
                                <?php if ($role) {
                                    $count = 1;
                                    $rowid = 1;
                                    foreach ($role as $item) {
                                ?>
                                        <tr id="<?php echo $rowid++; ?>">
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $item['description']; ?>
                                            </td>
                                            <td></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
        <!-- /.card -->
</div>
<!-- /.col -->
</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->