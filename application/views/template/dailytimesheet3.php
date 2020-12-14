<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-4">
                        <h4 class="text-header">Daily Timesheet</h4>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h6 class="header-text badge badge-secondary"><?php echo date('d/m/Y') ?></h6>
                        <input type="hidden" name="ssdate" id="ssdate" value="<?php echo date('Y-m-d') ?>">
                    </div>
                    <div class="col-sm-4">
                        <a class="btn btn-primary btn-xs float-right" id="submit-task">Submit Task</a>
                    </div>
                </div>
                <?php
                // echo '<pre>';
                // print_r($allocatedTask)
                ?>
                <div class="card-body dailytimesheet">
                    <div class="row m-0">

                        <div class="col-sm-3">
                            <select class="col-sm-12 form-control task-list" id="slected-task">
                                <option value="">Select Task</option>
                                <?php if (!empty($allocatedTask)) {
                                    foreach ($allocatedTask as $item) { ?>
                                        <option value="<?php echo $item['task_id'] ?>" project-id="<?php echo $item['project_id'] ?>" servicesId="<?php echo $item['service_id'] ?>" client-id="<?php echo $item['client_id'] ?>">
                                            <?php echo $item['title'] ?></option>
                                <?php }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" placeholder="Description" class=" form-control" id="description" />
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="show-time col-sm-12 form-control" id="from-time" placeholder="start time">
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="show-time col-sm-12 form-control" id="to-time" placeholder="end time">
                        </div>
                        <div class="col-sm-1">
                            <input type="hidden" name="task-id" id="task-id">
                            <input type="hidden" name="project-id" id="project-id">
                            <input type="hidden" name="client-id" id="client-id">
                            <input type="hidden" name="service-id" id="service-id">
                            <button class="btn btn-success saveTask">save</button>
                        </div>
                    </div>

                    <div class="py-5 ml-2" id="alltasks">
                    </div>
                    <input type="hidden" id="doc" data-dropdown='<?php echo base64_encode(json_encode($document, true)) ?>'>
                </div>
            </div>
        </div>
    </div>
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
                <div class="col-sm-1 float-right"><i class="fas fa-edit ml-5 cursor edit-files"></i></div>
                <div class="col-sm-1"><button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
            </div>


            <div class="files-view hide m-2">
                <div class="row ml-2" id="rejected-res">
                </div>
                <div class="file-row row"></div>
            </div>
            <form id='file-form'>
                <div class="card">
                    <div class="row m-0">
                        <div class="col-sm-12 py-2">
                            <a class="btn btn-primary btn-xs float-right addmore" title="Add more">
                                <i class="fas fa-plus-circle"></i></a>
                        </div>
                    </div>
                    <div id="file-row" class="card-body">
                    </div>
                </div>
                <div class="card-footer">
                    <input type="hidden" name="task-id" id="taskid">
                    <input type="hidden" name="project-id" id="projectid">

                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn  btn-primary btn-xs float-right">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>