  <!-- Content Wrapper. Contains page content -->
  </section>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
          <div class="card py-2">
              <!--  Card for Table -->
              <div class="card-header row m-0">
                  <div class="col-sm-10">
                      <h5 class="title"><?php echo $title ?></h5>
                  </div>
                  <div class="col-sm-2">
                      <!-- <button type="button" class="btn btn-primary btn-xs float-right" data-toggle="modal" data-target="#modal-master" title="Add New">
                          Create new
                      </button> -->

                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <form id="clinet-form" method="post" action="<?php echo base_url('Estimate/insert') ?>">
                      <div class="card-body row">
                          <div class="form-group col-sm-6">
                              <label for="org-name">Orgnization name <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="org-name" name="org-name" placeholder="Enter Orgnization name" value="<?php echo isset($client) ? $client[0]['client_name'] : '' ?>" required>
                          </div>
                          <div class="form-group col-sm-6">
                              <label for="gst-vat">GST/VAT No. <span class="text-danger">*</span></label>
                              <input type="text" class="form-control" id="gst-vat" name="gst-vat" placeholder="Enter GST/VAT number" value="<?php echo isset($client) ? $client[0]['gst_vat_number'] : '' ?>" required>
                          </div>
                          <div class="form-group col-sm-3">
                              <label for="gst-vat">Quotation<span class="text-danger">*</span></label>
                              <select name="og-type" id="og-type" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php if (!empty($quotation_Type)) {
                                        foreach ($quotation_Type as $item) { ?>
                                          <option value="<?php echo $item['title'] ?>" id="<?php echo $item['id'] ?>" <?php echo (isset($client[0]['orgnaization_type']) == $item['title']) ? 'selected' : '' ?>>
                                              <?php echo $item['title'] ?></option>
                                  <?php }
                                    }
                                    ?>
                              </select>
                          </div>
                          <div class="form-group col-sm-3">
                              <label for="gst-vat">Orgnization Type <span class="text-danger">*</span></label>
                              <select name="og-type" id="og-type" class="form-control" required>
                                  <option value="">Select</option>
                                  <?php if (!empty($ogtype)) {
                                        foreach ($ogtype as $item) { ?>
                                          <option value="<?php echo $item['title'] ?>" id="<?php echo $item['id'] ?>" <?php echo (isset($client[0]['orgnaization_type']) == $item['title']) ? 'selected' : '' ?>>
                                              <?php echo $item['title'] ?></option>
                                  <?php }
                                    }
                                    ?>
                              </select>
                          </div>
                          <div class="form-group col-sm-3">
                              <label for="c-phone">Phone <span class="text-danger">*</span></label>
                              <input type="phone" max="10" class="form-control" name="c-phone" id="c-phone" value="<?php echo isset($client) ? $client[0]['phone'] : '' ?>" placeholder="Enter phone" required>
                          </div>
                          <div class="form-group col-sm-3">
                              <label for="c-mobile">Mobile <span class="text-danger">*</span></label>
                              <input type="phone" max="10" class="form-control" name="c-mobile" id="c-mobile" value="<?php echo isset($client) ? $client[0]['phone'] : '' ?>" placeholder="Enter mobile" required>
                          </div>

                          <div class="form-group col-sm-3">
                              <label for="c-email">Email <span class="text-danger">*</span></label>
                              <input type="email" class="form-control" name="c-email" id="c-email" placeholder="Enter email" value="<?php echo isset($client) ? $client[0]['email'] : '' ?>" required>
                          </div>

                          <div class="form-group col-sm-3">
                              <label for="c-country">Country <span class="text-danger">*</span></label>
                              <select name="c-country" id="c-country" class="form-control">
                                  <option value="">Select</option>
                                  <?php if (!empty($country)) {
                                        foreach ($country as $item) {
                                            $ss = (isset($client[0]['country'])) ? $client[0]['country'] : 'India';
                                    ?>
                                          <option value="<?php echo $item['name'] ?>" id="<?php echo $item['id'] ?>" <?php echo ($item['name'] == $ss) ? 'selected' : '' ?>>

                                              <?php echo $item['name'] ?></option>
                                  <?php }
                                    }  ?>

                              </select>
                          </div>
                          <div class="form-group col-sm-3 ">
                              <label for="c-pin-zip">Pin/Zip code</label>
                              <input type="text" class="form-control" id="c-pin-zip" name="c-pin-zip" placeholder="Enter pin/zip" value="<?php echo isset($client) ? $client[0]['pin'] : '' ?>">
                          </div>
                          <div class="form-group col-sm-12">
                              <label for="c-address">Address</label>
                              <textarea name="c-address" id="c-address" cols="" rows="" class="form-control"><?php echo isset($client) ? $client[0]['address'] : '' ?></textarea>
                          </div>

                          <div class="form-group col-sm-12">
                              <a class="btn btn-warning float-right ml-2" href="javascript:window.history.back(-1);" title="Back">Cancel</a>
                              <button type="submit" class="btn btn-primary float-right">Next</button>
                          </div>

                      </div>

                      <!-- /.card-body -->
                      <div class="card-footer">
                          <input type="hidden" id="client-id" name="client-id" value="<?php echo isset($client) ? $client[0]['client_id'] : ''  ?>">

                      </div>
                  </form>
              </div>
          </div>
  </div>
  </section>

  <!-- /.modal -->
  </div>
  <!-- /.content-wrapper -->