<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                    <h5 class="text-header"><?php echo !empty($employee) ? $employee['first_name'] . ' ' . $employee['last_name'] : $_SESSION['logged_in']['Name'] ?> <span class="badge badge-primary">BookTime</span></h5>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="header-text badge badge-secondary fs-17"><?php echo date('d/m/Y') ?></h3>

                        <input type="hidden" name="ssdate" id="ssdate" value="<?php echo date('Y-m-d') ?>">
                    </div>

                </div>
                <?php
                // echo '<pre>';
                // print_r($allocatedTask)
                ?>
                <div class="card-body dailytimesheet">
                    <div class="row ">
                        <div class="col-sm-4">
                            <select class="col-sm-12 form-control" id="project-task">
                                <option value="">Select project</option>
                                <?php if (!empty($projects)) {
                                    foreach ($projects as $item) { ?>
                                        <option value="<?php echo $item['project_Id'] ?>">
                                            <?php echo $item['name'] ?></option>
                                <?php }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select class="col-sm-12 form-control task-list" id="slected-task">
                                <option value="">Select Task</option>
                                <?php if (!empty($allocatedTask)) {
                                    foreach ($allocatedTask as $item) { ?>
                                        <option value="<?php echo $item['taskId'] ?>" project-id="<?php echo $item['project_Id'] ?>" servicesId="<?php echo $item['category'] ?>" client-id="<?php echo $item['client_id'] ?>">
                                            <?php echo $item['title'] ?></option>
                                <?php }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="show-time col-sm-12 form-control" id="from-time" placeholder="start time">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="show-time col-sm-12 form-control" id="to-time" placeholder="end time">
                        </div>


                    </div>
                    <br />
                    <div class="row">
                        <div class="col-sm-11">
                            <textarea placeholder="Description" class=" form-control" id="description" rows="2"></textarea>

                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-primary saveTask">
                                Save
                                <!-- <i class="fa fa-plus" aria-hidden="true"></i> -->
                            </button>
                            <input type="hidden" name="task-id" id="task-id">
                            <input type="hidden" name="project-id" id="project-id">
                            <input type="hidden" name="client-id" id="client-id">
                            <input type="hidden" name="service-id" id="service-id">

                        </div>
                    </div>


                    <div class="custom-btn-two row m-2">
                        <div class="col-sm-2"><input type="checkbox" class="selectAll" id='selectAll'> <span for="selectAll">Select all</span></div>

                    </div>

                    <div class="py-2 ml-2" id="alltasks">
                    </div>
                    <input type="hidden" id="doc" data-dropdown='<?php echo base64_encode(json_encode($document, true)) ?>'>
                </div>


            </div>
        </div>
    </div>
    <div class="col-sm-12"><a class="btn btn-info float-right submit-btn" id="submit-task">Submit Timesheet</a></div>
</div>
</div>
</div>
</div>

<!-- Modal 0 -->
<div class="modal fade" id="dailyTimesheet-upload-file-ModalLong" tabindex="-1" role="dialog" aria-labelledby="dailyTimesheet-upload-file-ModalLong" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="card-header row">
                <div class="col-sm-10">
                    <h5>Document</h5>
                </div>
                <!-- <div class="col-sm-1 float-right" >
                    
                </div> -->
                <div class="col-sm-2">
                    <button type="button" id='edit-files' class="btn hide">
                        <i class="fas fa-edit ml-5 cursor edit-files"></i>
                    </button>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="files-view hide m-2">
                <div class="row ml-2" id="rejected-res">
                </div>
                <div class="file-row row m-2">

                </div>
            </div>
            <form id='file-form'>
                <div class="card">

                    <div id="file-row" class="card-body">
                        <div class="row docrid" data-id="0">
                            <div class="form-group col-sm-6">
                                <input type="text" class="form-control docTitle br-b" id="document_ti0" name="documentti0" placeholder="Title">
                            </div>
                            <div class="form-group col-sm-4 actions">
                                <input type="file" class="form-control file br-b" name="file0" id="file0" placeholder="upload">
                                <small class="col-sm-12 text-info"> File type: png, jpeg, jpg, pdf, docx, doc</small>
                            </div>
                            <div class="form-group col-sm-2">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="#" class="btn btn-primary btn-custom-one addmore">
                                            <i class="fas fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="card-footer row">
                    <input type="hidden" name="task-id" id="taskid">
                    <input type="hidden" name="project-id" id="projectid">

                    <div class="form-group col-sm-11">
                        <button type="submit" class="btn btn-primary btn-xs float-right">Save Changes</button>
                    </div>

                    <div class="form-group col-sm-1">
                        <button type="button" class="btn btn-danger btn-xs float-right" data-dismiss="modal" aria-label="Close"> Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>