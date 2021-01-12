  <!-- Content Wrapper. Contains page content -->
  </section>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content my-2">
          <div class="card ">
              <!--  Card for Table -->
              <div class="card-header row ">
                  <div class="col-sm-10">
                      <h5 class="title"><?php echo $title ?></h5>
                  </div>
                  <div class="col-sm-2">
                      <a href="<?php echo base_url('Estimate/create') ?>" class="btn btn-primary">Create new</a>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="estimate-list-table" class="table table-bordered table-striped" data='<?php print_r(base64_encode(json_encode($description))) ?>'>
                      <thead>
                          <tr>
                              <th>Sr. No.</th>
                              <th>Clinet</th>
                              <th>Estimate date</th>
                              <th>Service</th>
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


  </div>
  <!-- /.content-wrapper -->
  <script>
    
  </script>