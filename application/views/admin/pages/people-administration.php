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
    <div class="content-header">

        <?php
        // echo '<pre>';
        // print_r($employee);

        ?>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content " id="internal-people">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-2">
                        <input type="hidden" id="mode" value="<?php echo isset($employee) ? '1' : '0' ?>">
                        <h6 class="text-header"> <?php echo isset($employee) ? 'Edit' : 'Add New' ?></h6>
                    </div>
                    <div class="col-sm-10">
                        <a href="javascript:window.history.back(-1);" class="btn btn-warning float-right"><i class="fas fa-arrow-left" title="Back"></i></a>
                    </div>
                </div>


                <input type="hidden" name="type" value="INP">
                <div class="card-header">
                    <div class="col-md-12">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-item nav-link active" id="nav-personal-info-tab" data-toggle="tab" href="#nav-personal-info" role="tab" aria-controls="nav-personal-info" aria-selected="true">Personal info</a>

                            <a class="nav-item nav-link" id="nav-document-tab" data-toggle="tab" href="#nav-document" role="tab" aria-controls="nav-document" aria-selected="false">Documents</a>

                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"> Emergency Contact</a>

                            <a class="nav-item nav-link" id="nav-cost-tab" data-toggle="tab" href="#nav-cost" role="tab" aria-controls="nav-cost" aria-selected="false">Cost</a>

                            <!-- <a class="nav-item nav-link" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="false"> Login access</a> -->

                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-personal-info" role="tabpanel" aria-labelledby="nav-personal-info">
                            <form id="people-form">
                                <input type="hidden" name="type" value="INP">
                                <div class="card-body row">
                                    <div class="form-group col-sm-6">
                                        <label for="first-name">First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="first-name" name="first-name" placeholder="Enter first name" value="<?php echo isset($employee) ? $employee[0]['first_name'] : ''  ?>" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="last-name">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="last-name" name="last-name" placeholder="Enter last name" value="<?php echo isset($employee) ? $employee[0]['last_name'] : ''  ?>" required>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="gender">Gender <span class="text-danger">*</span></label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="male" checked name="gender" value="male" <?php echo isset($employee[0]['gender']) && $employee[0]['gender'] == 'male' ? 'checked' : ''  ?>>
                                                <label for="male">
                                                    Male
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="female" name="gender" value="female" <?php echo isset($employee[0]['gender']) && $employee[0]['gender'] == 'female' ? 'checked' : ''  ?>>
                                                <label for="female">
                                                    Female
                                                </label>
                                            </div>
                                            <div class="icheck-primary d-inline">
                                                <input type="radio" id="other" name="gender" value="other" <?php echo isset($employee[0]['gender']) && $employee[0]['gender'] == 'other' ? 'checked' : ''  ?>>
                                                <label for="other">
                                                    Other
                                                </label>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- Date DOB-->

                                    <div class="form-group col-sm-6">
                                        <label for="dob">Birth date <span class="text-danger">*</span></label>
                                        <div class="input-group ">
                                            <input type="text" class="form-control datepicker" name="dob" id="dob" value="<?php echo isset($employee) ? date_format(date_create($employee[0]['dob']), 'd/m/Y') : ''  ?>" placeholder="DD/MM/YYYY" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control check-mobile-number" name="mobile" id="mobile" placeholder="Enter mobile no: 9612345612" value="<?php echo isset($employee) ? $employee[0]['phone'] : ''  ?>" required>
                                        <small aria-details="mobile" id='mobile-error'></small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email :email@mail.com" value="<?php echo isset($employee) ? $employee[0]['email'] : ''  ?>" required>
                                    </div>

                                    <!-- start Address -->
                                    <div class="form-group col-sm-12">
                                        <label for="address">Address</label>
                                        <textarea name="address" id="address" cols="" rows="" class="form-control"><?php echo isset($employee) ? $employee[0]['address'] : ''  ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="country">Country<span class="text-danger">*</span></label>
                                        <select name="country" id="country" class="form-control">
                                            <?php if (!empty($country)) {
                                                foreach ($country as $item) {
                                                    $sc = isset($employee) ? $employee[0]['country'] : 'United Arab Emirates'
                                            ?>
                                                    <option value="<?php echo $item['name'] ?>" id="<?php echo $item['id'] ?>" <?php echo ($item['name'] == $sc) ? 'selected' : '' ?>>
                                                        <?php echo $item['name'] ?></option>
                                            <?php }
                                            }  ?>

                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="last-name">State <span class="text-danger">*</span></label>
                                        <select name="state" id="state" class="form-control" data-val="<?php echo isset($employee) ? $employee[0]['state'] : ''  ?>">
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="City">City</label>
                                        <select name="city" id="city" class="form-control" aria-placeholder="select city" data-val="<?php echo isset($employee) ? $employee[0]['city'] : ''  ?>">
                                            <!-- <option value="">Select</option> -->
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="pin-zip">Pin/Zip code</label>
                                        <input type="text" class="form-control" id="pin-zip" name="pin-zip" value="<?php echo isset($employee) ? $employee[0]['pin'] : ''  ?>" placeholder="Enter pin/zip">
                                    </div>
                                    <!-- Employee details -->
                                    <!-- Join date -->

                                    <div class="form-group col-sm-6">
                                        <label for="join-date">Joining date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="join-date" id="join-date" value="<?php echo isset($employee) ? date_format(date_create($employee[0]['join_date']), 'd/m/Y') : ''  ?>" placeholder="DD/MM/YYYY" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="clinets">Clinet <span class="text-danger">*</span></label>
                                        <select name="clinets" id="clinets" class="form-control" required>
                                            <option value="">Select clinet</option>
                                            <?php if (!empty($clinets)) {
                                                foreach ($clinets as $item) { ?>
                                                    <option value="<?php echo $item['client_id'] ?>" <?php echo (isset($employee[0]['client_id']) && $employee[0]['client_id'] == $item['client_id']) ? 'selected' : ''  ?> data-id="<?php echo base64_encode($item['client_id']) ?>">
                                                        <?php echo $item['client_name'] ?></option>
                                            <?php }
                                            }  ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="department">Department <span class="text-danger">*</span></label>
                                        <select name="department" id="department" class="form-control select2" data-placeholder="Select client first" disabled>
                                            <option value="">Select</option>
                                            <?php if (!empty($department)) {
                                                foreach ($department as $item) { ?>
                                                    <option value="<?php echo $item['title'] ?>" <?php echo (isset($employee[0]['department']) && $employee[0]['department'] == $item['title']) ? 'selected' : ''  ?> data-id="<?php echo base64_encode($item['dept_id']) ?>">
                                                        <?php echo $item['title'] ?></option>
                                            <?php }
                                            }  ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="designation">Designation<span class="text-danger">*</span></label>
                                        <select name="designation" id="designation" class="form-control select2 " data-placeholder="Select department first" disabled>
                                            <option value="">Select clinet</option>
                                            <?php if (!empty($designation)) {
                                                foreach ($designation as $item) {
                                                    print_r($item);
                                            ?>
                                                    <option value="<?php echo $item['title'] ?>" <?php echo (isset($employee) && $employee[0]['designation'] == $item['title']) ? 'selected' : ''  ?>>
                                                        <?php echo $item['title'] ?></option>
                                            <?php }
                                            }  ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="manager">Manager<span class="text-danger">*</span></label>
                                        <select name="manager" id="manager" class="form-control" data-placeholder="select Manager">
                                            <option value="">Select</option>
                                            <?php if (!empty($manager)) {
                                                foreach ($manager as $item) { ?>
                                                    <option value="<?php echo $item['people_id'] ?>" <?php echo (isset($employee[0]['managerId']) && $employee[0]['managerId']  == $item['people_id']) ? 'selected' : ''  ?>>
                                                        <?php echo $item['first_name'] . ' ' . $item['last_name'] ?></option>
                                                <?php }
                                            } else { ?>
                                                <option value="<?php echo $_SESSION['logged_in']['people_id'] ?>">
                                                    <?php echo $_SESSION['logged_in']['Name']; ?></option>
                                            <?php }  ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="role">Role <span class="text-danger">*</span></label>
                                        <select name="role" id="role" class="select2 form-control">
                                            <option value="">Select</option>
                                            <?php if (!empty($role)) {
                                                foreach ($role as $item) { ?>
                                                    <option value="<?php echo trim($item['title']) ?>" <?php echo (isset($employee[0]['role']) && $employee[0]['role'] == $item['title']) ? 'selected' : ''  ?>>
                                                        <?php echo $item['title']; ?></option>
                                            <?php }
                                            }  ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label for="skill">Skill <span class="text-danger">*</span></label>
                                        <select class="select2 form-control" multiple="multiple" data-placeholder="Select your skills" style="width: 100%;" id="skill" name='skill[]' required>
                                            <?php if (!empty($skill)) {
                                                foreach ($skill as $item) { ?>
                                                    <option value="<?php echo $item['title'] ?>" <?php if (isset($employee) && in_array($item['title'], json_decode($employee[0]['skill'], true))) {
                                                                                                        echo "selected";
                                                                                                    } ?>>
                                                        <?php echo $item['title'] ?></option>
                                            <?php }
                                            }  ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">

                                    <!-- <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>                -->

                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary float-right">Next</button>
                                    </div>


                                </div>
                            </form>
                        </div>

                        <!-- Cost Form -->
                        <div class="tab-pane fade" id="nav-cost" role="tabpanel" aria-labelledby="nav-cost-tab">
                            <form id="cost-data">
                                <!-- <input type="hidden" name="costId" id="costId"> -->
                                <div class="card-body row">
                                    <div class="form-group col-sm-4">
                                        <label for="working-hours">Working Hours/Day <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="working-hours" name="working-hours" value="<?php echo isset($employee) ? $employee[0]['working_hours'] : ''  ?>" placeholder="Enter working-hours" required>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="cost-per-hours">Cost/Hour <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="cost-per-hours" name="cost-per-hours" value="<?php echo isset($employee) ? $employee[0]['cost_per_hours'] : ''  ?>" placeholder="Enter cost per hours" required>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="rate-per-hours">Rate/Hour<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="rate-per-hours" name="rate-per-hours" value="<?php echo isset($employee) ? $employee[0]['rate_per_hour'] : ''  ?>" placeholder="100" required>
                                    </div>
                                </div>
                                <input type="hidden" id="empid" value="<?php echo isset($employee) ? $employee[0]['people_id'] : ''  ?>">
                                <div class="card-footer">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Emergency contact -->
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <form id="emer-form">
                                <!-- <input type="hidden" name="people_id" id="people_id"> -->
                                <div class="card-body row">
                                    <div class="form-group col-sm-6">
                                        <label for="em-first-name">Person Name</label>
                                        <input type="text" class="form-control" id="em-first-name" name="em-first-name" placeholder="Enter first name" value="<?php echo isset($employee) ? $employee[0]['person_name'] : ''  ?>">
                                    </div>
                                    <!-- <div class="form-group col-sm-6">
                                        <label for="em-last-name">Last Name</label>
                                        <input type="text" class="form-control" id="em-last-name" name="em-last-name" placeholder="Enter last name">
                                    </div> -->
                                    <div class="form-group col-sm-6">
                                        <label for="em-mobile">Mobile</label>
                                        <input type="number" class="form-control" name="em-mobile" id="em-mobile" placeholder="Enter mobile" value="<?php echo isset($employee) ? $employee[0]['em_phone'] : ''  ?>">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="em-email">Email</label>
                                        <input type="email" class="form-control" id="em-email" name="em-email" placeholder="Enter email" value="<?php echo isset($employee) ? $employee[0]['em_email'] : ''  ?>">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="em-address">Address</label>
                                        <textarea name="em-address" id="em-address" cols="" rows="" class="form-control"><?php echo isset($employee) ? $employee[0]['em_address'] : ''  ?></textarea>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="em-country">Country</label>
                                        <select name="em-country" id="em-country" class="form-control">
                                            <?php if (!empty($country)) {
                                                foreach ($country as $item) {
                                                    $sc = (isset($employee)) ? $employee[0]['em_country'] : 'United Arab Emirates';

                                            ?>
                                                    <option value="<?php echo $item['name'] ?>" id="<?php echo $item['id'] ?>" <?php echo ($item['name'] == $sc) ? 'selected' : '' ?>>
                                                        <?php echo $item['name'] ?></option>
                                            <?php }
                                            }  ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="em-state">State</label>
                                        <select name="em-state" id="em-state" data-val="<?php echo isset($employee) ? $employee[0]['em_state'] : ''  ?>" class="form-control ">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="em-city">City</label>
                                        <select name="em-city" id="em-city" data-val="<?php echo isset($employee) ? $employee[0]['em_city'] : ''  ?>" class="form-control ">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="em-pin-zip">Pin/Zip code</label>
                                        <input type="text" class="form-control" name="em-pin-zip" id="em-pin-zip" placeholder="Enter pin/zip" value="<?php echo isset($employee) ? $employee[0]['em_pin'] : ''  ?>">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary float-right">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>

               
                        <!-- Document -->
                        <div class="tab-pane fade" id="nav-document" role="tabpanel" aria-labelledby="nav-document-tab" data-select='<?php echo json_encode($document, true) ?>'>
                            <div class="doc py-2 card">

                                <input type="hidden" id="document-available" value='<?php echo isset($employee) ? $employee[0]['documents'] : '' ?>'>

                                <input type="hidden" id="doc_id" value="<?php echo isset($employee) ? $employee[0]['doc_id'] : '' ?>">

                                <?php
                                if (isset($employee)) {
                                    $doc = json_decode($employee[0]['documents'], true);

                                    if (!empty($doc['doc'])) {
                                        $doc = json_decode($doc['doc'], true);
                                        // print_r('d'.$doc);
                                        foreach ($doc as $item) {
                                ?>
                                            <div class="row pl-2">
                                                <div class="col-sm-4">
                                                    <?php echo $item['docTitle'] ?></div>
                                                <div class="col-sm-4">
                                                    <?php echo $item['docNumber'] ?></div>
                                                <div class="col-sm-4">
                                                    <a href="<?php echo base_url() . $item['filePath'] ?>" target="_blank" class="m-2">
                                                        <img src="<?php echo base_url() ?>./assets/custom/media/docs.png" alt="<?php echo $item['docTitle'] ?>" height="50">
                                                    </a>
                                                </div>
                                            </div>
                                <?php
                                        }
                                    }
                                }

                                ?>
                            </div>
                            <form id='document-form'>
                                <div class="card">
                                    <div class="row m-0">
                                        <div class="col-sm-12 py-2">
                                            <a id="addmore" class="btn btn-primary float-right " title="Add more">
                                                <i class="fas fa-plus-circle"></i></a>
                                        </div>
                                    </div>
                                    <div id="document-row" class="card-body">
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn  btn-primary float-right">Next</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </section>

    </div>



    <!-- general form elements -->

</div>
<!-- /.content -->



<!-- /.content-wrapper -->

<script>
    $(function() {
        $('#clinets').change(function() {
            $('#department').removeAttr('disabled');
        });
    });
</script>