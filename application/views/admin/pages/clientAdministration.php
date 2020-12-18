<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <section class="content" id="external-people">
                <div class="card">
                    <div class="card-header row m-0">
                        <div class="col-sm-2">
                            <h6 class="text-header">External People</h6>
                        </div>
                        <div class="col-sm-10">
                            <a href="javascript:window.history.back(-1);" class="btn btn-xs btn-warning float-right"><i class="fas fa-arrow-left" title="Back"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="type" value="EXT">
                        <div class="col-md-12">
                            <div class="nav nav-tabs" id="nav-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-item nav-link active" id="nav-client-info-tab" data-toggle="tab" href="#nav-client-info" role="tab" aria-controls="nav--info" aria-selected="true">Client info </a>
                                <a class="nav-item nav-link" id="nav-documents-tab" data-toggle="tab" href="#nav-documents" role="tab" aria-controls="nav-cost" aria-selected="false">Documents</a>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-client-info" role="tabpanel" aria-labelledby="nav-client-info">
                                    <form id="ext-people-form">
                                        <div class="card-body row">
                                            <div class="form-group col-sm-12">
                                                <label for="org-name">Orgnization name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="org-name" name="org-name" placeholder="Enter Orgnization name" value="<?php echo isset($client) ? $client[0]['client_name'] : '' ?>" required>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="gst-vat">GST/VAT No. <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="gst-vat" name="gst-vat" placeholder="Enter GST/VAT number" value="<?php echo isset($client) ? $client[0]['gst_vat_number'] : '' ?>" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="gst-vat">Orgnization Type <span class="text-danger">*</span></label>
                                                <select name="og-type" id="og-type" class="form-control" required>
                                                    <?php if (!empty($ogtype)) {
                                                        foreach ($ogtype as $item) { ?>
                                                            <option value="<?php echo $item['title'] ?>" id="<?php echo $item['id'] ?>" <?php echo (isset($client[0]['orgnaization_type']) == $item['title']) ? 'selected' : '' ?>>
                                                                <?php echo $item['title'] ?></option>
                                                    <?php }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="c-phone">Phone <span class="text-danger">*</span></label>
                                                <input type="phone" max="10" class="form-control" name="c-phone" id="c-phone" value="<?php echo isset($client) ? $client[0]['phone'] : '' ?>" placeholder="Enter phone" required>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="c-mobile">Mobile <span class="text-danger">*</span></label>
                                                <input type="phone" max="10" class="form-control" name="c-mobile" id="c-mobile" value="<?php echo isset($client) ? $client[0]['phone'] : '' ?>" placeholder="Enter mobile" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="c-email">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="c-email" id="c-email" placeholder="Enter email" value="<?php echo isset($client) ? $client[0]['email'] : '' ?>" required>
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label for="c-country">Country <span class="text-danger">*</span></label>
                                                <select name="c-country" id="c-country" class="form-control">
                                                    <?php if (!empty($country)) {
                                                        foreach ($country as $item) {
                                                            $ss = (isset($client[0]['country'])) ? $client[0]['country'] : 'United Arab Emirates';
                                                    ?>

                                                            <option value="<?php echo $item['name'] ?>" id="<?php echo $item['id'] ?>" <?php echo ($item['name'] == $ss) ? 'selected' : '' ?>>

                                                                <?php echo $item['name'] ?></option>
                                                    <?php }
                                                    }  ?>

                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="currency">Currency <span class="text-danger">*</span></label>
                                                <select name="currency" id="currency" class="form-control" required>
                                                    <?php if (!empty($currency)) {
                                                        foreach ($currency as $item) {
                                                            $sc = (isset($client[0]['currency'])) ? $client[0]['currency'] : 'AED';
                                                    ?>
                                                            <option value="<?php echo $item['currency'] ?>" id="<?php echo $item['id'] ?>" <?php echo ($item['currency'] == $sc) ? 'selected' : '' ?>>
                                                                <?php echo $item['currency'] ?></option>
                                                    <?php }
                                                    }  ?>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12">
                                                <label for="c-address">Address</label>
                                                <textarea name="c-address" id="c-address" cols="" rows="" class="form-control"><?php echo isset($client) ? $client[0]['address'] : '' ?></textarea>
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label for="c-pin-zip">Pin/Zip code</label>
                                                <input type="text" class="form-control" id="c-pin-zip" name="c-pin-zip" placeholder="Enter pin/zip" value="<?php echo isset($client) ? $client[0]['pin'] : '' ?>">
                                            </div>
                                        </div>

                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <!-- <div class="form-group col-sm-12">
                                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                                            </div>  -->
                                            <input type="hidden" id="client-id" name="client-id" value="<?php echo isset($client) ? $client[0]['client_id'] : ''  ?>" >
                                            
                                            <div class="form-group col-sm-12">
                                                <button type="submit" class="btn btn-primary float-right">Next</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- Document section -->
                                <div class="tab-pane fade" id="nav-documents" role="tabpanel" aria-labelledby="nav-documents-tab" data-select='<?php echo json_encode($document, true) ?>'>
                                    <div class="doc p-2">
                                        <?php
                                        if(isset($client)){
                                        if (!empty(json_decode($client[0]['documents'], true))) {
                                            foreach (json_decode($client[0]['documents'], true) as $item) {
                                        ?>
                                                <div class="row">
                                                    <div class="col-sm-4"> <?php echo $item['docTitle'] ?></div>
                                                    <div class="col-sm-4"><?php echo $item['docNumber'] ?></div>
                                                    <div class="col-sm-4">
                                                        <a href="<?php echo base_url() . $item['filePath'] ?>" target="_blank" class="m-2">
                                                            <img src="<?php echo base_url() ?>./assets/custom/media/docs.png" alt="<?php echo $item['docTitle'] ?>" height="50">
                                                        </a>
                                                    </div>
                                                </div>
                                        <?php
                                            }}
                                        }
                                        ?>

                                    </div>
                                    <form id='document-form'>
                                        <div class="card">
                                            <div class="row m-0">
                                                <div class="col-sm-12 py-2">
                                                    <a id="addmore" class="btn btn-primary float-right" title="Add more">
                                                        <i class="fas fa-plus-circle"></i></a>
                                                </div>
                                            </div>
                                            <div id="document-row" class="card-body">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                        <input type="hidden" id="doc-id" name="doc-id" value="<?php echo isset($client) ? $client[0]['doc_id'] : ''  ?>" >
                                            <div class="form-group col-sm-12">
                                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <!-- /.card-body -->


                        </div>

                    </div>

                </div>

        </div>
        </section>
    </div>

    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</div>


</div>


<!-- general form elements -->


<!-- /.content -->

<!-- /.content-wrapper -->