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
            <h4 class="title"><?php echo $title ?></h4>
          </div>
          <div class="col-sm-2"><button type="button" class="btn btn-primary btn-xs float-right" data-toggle="modal" data-target="#modal-master" title="Add New">
              Add
            </button>
          </div>

        </div>

        <!-- /.card-header -->
        <div class="card-body">
          <table id="masterTaskTbl" class="table table-bordered table-striped" data='<?php print_r(base64_encode(json_encode($tasks))) ?>'>
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>Title</th>
                <th>Description</th>
                <th>category</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="tableData">
            </tbody>
          </table>
        </div>
      </div>
  </div>
  </section>

  <!-- /.content -->

  <div class="modal fade" id="modal-master">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?php echo $title ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form-data row">
            <div class="form-group col-sm-12">
              <label for="description">Service category</label>
              <select name="categories" id="categories" class="form-control">
                <option value="">Select category</option>
                <?php if (!empty($categories)) {
                  print_r($categories);
                  foreach ($categories as $item) { ?>
                    <option value="<?php echo $item['services_id'] ?>"><?php echo $item['title'] ?></option>
                <?php  };
                } ?>
              </select>
            </div>
            <div class="form-group col-sm-12">
              <label for="title"> Task Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="<?php echo $title; ?> Title" required>
            </div>
            <div class="form-group col-sm-12">
              <label for="description">Description</label>
              <textarea cols="30" rows="5" class="form-control" id="description" name="description" placeholder="<?php echo $title; ?> description" required></textarea>
            </div>
        
            <input type="hidden" name="flage" id="flage" value="<?php echo $flage ?>">
            <input type="hidden" name="id" id="row_id">
            <div class="col-sm-12 ">
              <button type="submit" class="btn btn-primary btn-xs float-right" title="Save">
                <!-- <i class="fas fa-save"></i> -->
              Save changes
              </button>
            </div>
            <!-- /.card-body -->
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>

  <!-- /.modal -->
  </div>
  <!-- /.content-wrapper -->