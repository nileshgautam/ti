  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    

    <!-- Main content -->
    <section class="content">
      <!--  Card for Table -->
      <div class="card-header">
        <button type="button" class="btn btn-primary btn-xs float-right" data-toggle="modal" data-target="#modal-default">
          Add
        </button>
      </div>
      <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
          <table id="conf-dataTable" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Sr. No.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Level</th>
                <th>Action</th>

              </tr>
            </thead>
            <tbody id="conf-tbody">
              <?php if ($description) {
                $count = 1;
                $rowid = 1;
                foreach ($description as $item) {
              ?>
                  <tr id="<?php echo $rowid++; ?>">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $item['title']; ?>
                    </td>
                    <td><?php echo $item['description']; ?>
                    </td>
                    <td><?php echo $item['visibility_level']; ?>
                    </td>
                    <td>
                      <div class="tbl-btn"><i class="fas fa-edit edit" data-id="<?php echo $item['id']; ?>" data-toggle="modal" data-target="#modal-default"></i>
                        <i class="fas fa-trash-alt delete" data-id="<?php echo $item['id']; ?>"></i></div>
                    </td>
                  </tr>
              <?php }
              } ?>
            </tbody>
          </table>
        </div>
      </div>

    </section>
  </div>
  <!-- /.content -->

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?php echo $title ?></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="row" id="cnf-form-data">
            <div class="form-group col-sm-12">
              <label for="description">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="<?php echo $title; ?> title" required>
            </div>
            <div class="form-group col-sm-12">
              <label for="description">Description</label>
              <textarea cols="30" rows="2" class="form-control" id="description" name="description" placeholder="<?php echo $title; ?> description" required></textarea>
            </div>
            <div class="form-group col-sm-12">
              <label for="location">Level</label>
              <select name="visibility-level" id="visibility-level" class="form-control">
                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Low">Low</option>
              </select>
            </div>

            <input type="hidden" name="flage" id="flage" value="<?php echo $flage ?>">
            <input type="hidden" name="id" id="row_id">

            <div class="col-sm-12 pd-33">
              <button type="submit" class="btn btn-primary float-right"><i class="fas fa-save"></i></button>
              <!-- <button type="button" class="btn btn-danger" data-card-widget="collapse"><i class="fas fa-window-close"></i></button> -->
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