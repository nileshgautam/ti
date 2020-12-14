<style type="text/css">
    .datepicker .datepicker-days tr td.active~td,
    .datepicker .datepicker-days tr td.active {
        color: #af1623 !important;
        background: transparent !important;
    }

    .datepicker .datepicker-days tr:hover td {
        color: #000;
        background: #e5e2e3;
        border-radius: 0;
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-5">
                        <h4 class="m-0">All users</h4>
                    </div>
                    <div class="col-sm-7 row m-0">
                        <!-- <label class="col-sm-2">Select Week</label>
                        <div class="col-sm-4">
                            <input type="text" name="week" class="form-control" id="weekpicker" value="<?php echo $startDate . " - " . $endDate; ?>">
                        </div> -->

                        <!-- <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="prevWeek">Prev</button>
                        </div>

                        <div class="col-sm-1">
                            <button type="button" class="btn btn-primary btn-sm" id="nextWeek">Next</button>
                        </div> -->

                        <!-- <div class="col-sm-3">
                            <button type="button" class="btn btn-info" id="getData">Get Status</button>
                        </div> -->
                    </div>
                </div>
                <div class="card-body">
                    <table class="table dataTable table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">UserId</th>
                                <th scope="col">Users Name</th>
                                <!-- <th scope="col">Status</th> -->
                                <th scope="col">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($allUsers)) {
                                // echo '<pre>';
                                // print_r($allUsers);
                                $count = 1;
                                foreach ($allUsers as $item) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>
                                        <td><?php echo $item['username'] ?></td>
                                        <td><?php echo $item['first_name'] . '
                                         ' . $item['last_name'] ?></td>
                                        <!-- <td><?php echo $item['status'] ?></td> -->
                                        <td class="d-flex">
                                            <!-- <a href="javascript:void(0)" id="<?php echo $item['people_id']; ?>" class="btn btn-primary btn-xs timesheet mr-2">Weekly Timesheet</a>  -->
                                            <a href="<?php echo base_url('Manager/dailyTimesheet/').base64_encode($item['people_id'])?>" id="" class="btn btn-info btn-xs ml-2">Daily Timesheet</a>
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