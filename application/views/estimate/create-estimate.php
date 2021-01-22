  <!-- Content Wrapper. Contains page content -->
  </section>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content" id="estimate-cal">
          <div class="inner-block">
              <div class="form-group col-sm-8">
                  <label for="quotation" class="text-dark">Quotation for<span class="text-danger">*</span></label>
                  <form action="<?php echo base_url('Estimate/geneRateQuotation')?>" method="post">
                      <select name="quotation" id="quotation" class="form-control" required>
                          <option value="">Select</option>
                          <?php if (!empty($quotation_Type)) {
                                foreach ($quotation_Type as $item) { ?>
                                  <option value="<?php echo $item['id'] ?>" id="<?php echo $item['id'] ?>" <?php echo (isset($client[0]['title']) == $item['title']) ? 'selected' : '' ?>>
                                      <?php echo $item['title'] ?></option>
                          <?php }
                            }
                            ?>
                      </select>
                      <button id="submit" type="submit" class="btn btn-primary float-right mt-2">Next</button>
                  </form>
              </div>
          </div>

      </section>

  </div>
  <!-- /.content-wrapper -->