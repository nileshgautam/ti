<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">User Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="<?php echo base_url() . 'assets/custom/media/user/user.png' ?>" alt="User profile picture">
              </div>

              <h3 class="profile-username text-center"><?php echo $details[0]['first_name'] . ' ' . $details[0]['last_name'] ?></h3>

              <p class="text-muted text-center"><?php echo $details[0]['role'] ?></p>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->


          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item">
                  <a class="nav-link disabled"  href="#settings" data-toggle="tab" >Password</a>
                </li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" id="change-password">
                      <div class="form-group row">
                        <label for="inputoldPassword" class="col-sm-3 col-form-label">Old Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputoldPassword"  name="inputoldPassword" placeholder="Old Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputNewPassword" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword" placeholder="New Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputConfirmPassword" class="col-sm-3 col-form-label">Confirm Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="Confirm Password" required>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-6 col-sm-6">
                          <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>