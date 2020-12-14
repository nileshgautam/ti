<style>
    .space-between {
        display: flex;
        justify-content: space-around;
    }

    .space {
        margin: 1px 5px !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="card">
        <div class="card-header row mb-2">
            <div class="col-sm-6">
                <h4 class="breadcrumb-item active">Project Administration</h4>
            </div>
            <div class="col-sm-6">
                <a href="javascript:window.history.back(-1);" class="btn btn-xs btn-warning float-right"><i class="fas fa-arrow-left" title="Back"></i></a>
            </div>
        </div>

        <!-- /.content-header -->
        <!-- Main content -->

        <div class="card-body">
            <form id="project-form">

                <div class="card-body row">
                    <div class="form-group col-sm-6">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" value="<?php echo isset($project) ? $project[0]['name'] : '' ?>" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="enq-date">Enquiry Date</label>
                        <input type="text" class="form-control datepicker" id="enq-date" name="enq-date" placeholder="Enquiry date" value="<?php echo isset($project) ? date_format(date_create($project[0]['enquiry_date']), 'd/m/Y') : '' ?>" required>
                    </div>
                
                    <div class="form-group col-sm-6">
                        <label for="services">Services</label>
                        <div class="input-group">
                            <select class="select2 form-control" multiple="multiple" data-placeholder="Select services" style="width: 100%;" id="services" name='services[]' value="<?php echo isset($project) ? $project[0]['services'] : '' ?>" required>
                                <?php if (!empty($services)) {
                                    foreach ($services as $item) { ?>
                                        <option <?php if (isset($project) && in_array($item['services_id'], json_decode($project[0]['services'], true))) {
                                                    echo "selected";
                                                } ?> value="<?php echo $item['services_id'] ?>">
                                            <?php echo $item['title'] ?>
                                        </option>
                                <?php }
                                } ?>

                            </select>
                            <!-- <div class="input-group-prepend">
                                <button class="btn btn-info" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div> -->
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="billable">Billable</label>
                        <select name="billable" id="billable" class="form-control">
                            <option value="yes" <?php echo (isset($project[0]['billable']) == 'yes') ? 'selected' : '' ?>>Billable</option>
                            <option value="no" <?php echo (isset($project[0]['billable']) == 'no') ? 'selected' : '' ?>>Non-Billable</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="billtp">Billing Type</label>
                        <select name="billtp" id="billtp" class="form-control">
                            <option value="Fixed Price" <?php echo (isset($project[0]['billing_type']) == 'Fixed Price') ? 'selected' : '' ?>>Fixed Price</option>
                            <option value="Time & Material" <?php echo (isset($project[0]['billing_type']) == 'Time & Material') ? 'selected' : '' ?>>Time & Material</option>
                            <option value="Other" <?php echo (isset($project[0]['billing_type']) == 'Other') ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="client">Client</label>
                        <div class="input-group">
                            <select name="client" id="client" class="form-control">
                                <option value="" class="">Select</option>
                                <?php if (!empty($client)) {
                                    foreach ($client as $item) { ?>
                                        <option value="<?php echo $item['client_id'] ?>" <?php echo (isset($project[0]['client_id']) == $item['client_id']) ? 'selected' : '' ?>>
                                            <?php echo $item['client_name'] ?></option>
                                    <?php }
                                } else { ?>
                                    <option value="" class="bg-gray">No data</option>
                                <?php } ?>

                            </select>
                            <div class="input-group-prepend">
                                <button class="btn btn-info add-new-client" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="stdate">Start Date</label>
                        <div class="input-group ">
                            <input type="text" class="form-control datepicker" name="stdate" placeholder="DD/MM/YYYY" value="<?php echo isset($project) ? date_format(date_create($project[0]['start_date']), 'd/m/Y') : '' ?>" required>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="eddate">End Date</label>
                        <div class="input-group">
                            <input type="text" class="form-control datepicker" name="eddate" placeholder="DD/MM/YYYY" value="<?php echo isset($project) ? date_format(date_create($project[0]['end_date']), 'd/m/Y') : '' ?>" required>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="bgthrs">Budgeted Hrs</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="<?php echo isset($project) ? $project[0]['budget_hours'] : '' ?>" name="bgthrs" placeholder="200" required>
                            <div class="input-group-prepend">
                                <button class="btn btn-info" type="button">
                                    <i class="fas fa-clock"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="ot">Overtime Allowed</label>
                        <select name="ot" id="ot" class="form-control">
                            <option value="yes" <?php echo (isset($project[0]['ot']) == 'yes') ? 'selected' : '' ?>>Yes</option>
                            <option value="no" <?php echo (isset($project[0]['ot']) == 'no') ? 'selected' : '' ?>>No</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="" rows="" class="form-control"><?php echo (isset($project[0]['description'])) ? $project[0]['description'] : '' ?></textarea>
                    </div>

                    <div class="form-group date col-sm-6">
                        <label for="value">Value</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="value" name="value" placeholder="100000" value="<?php echo (isset($project[0]['value'])) ? $project[0]['value'] : '' ?>" required>
                            <div class="input-group-append">
                                <select class="form-control" name="currency">
                                    <?php if (!empty($currency)) {

                                        foreach ($currency as $item) {
                                            $cur = isset($project[0]['currency']) ? $project[0]['currency'] : $item['currency'];
                                    ?>
                                            <option <?php

                                                    if (($item['currency'] == $cur)) {
                                                        echo 'selected';
                                                    }

                                                    ?>>

                                                <?php echo $item['currency'] ?></option>
                                    <?php }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="hidden" id="project-id" name="project-id" value="<?php echo isset($project) ? $project[0]['project_Id'] : '' ?>">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </div>
                </div>

            </form>

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


<!-- Modal -->
<div class="modal fade" id="create-clients-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo 'Add new' ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row" id="create-clients-form">
                    <div class="form-group col-sm-12">
                        <label for="org-name">Orgnization name</label>
                        <input type="text" class="form-control" id="org-name" name="org-name" placeholder="Enter Orgnization name" required>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="org-name">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Orgnization name" required>
                    </div>

                    <div class="col-sm-12 pd-33">
                        <button type="submit" class="btn btn-primary btn-xs float-right">Create</button>
                    </div>
                    <!-- /.card-body -->
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>