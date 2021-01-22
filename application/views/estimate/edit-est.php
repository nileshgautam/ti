  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Report print section -->
      <section class="content" id="estimate-view">
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-sm-6">
                          <img src="<?php echo base_url()?>assets/custom/media/logo/troiscon-logo.png" alt="logo" class="">
                      </div>
                      <div class="col-sm-6">
                          <h1 class="text-right">WORK ESTIMATE</h1>
                          <p class="text-right">
                              Date:<span id="current-date"></span><br>
                              Estimated Cost: &nbsp;<span id="est-cost">0 </span> <br>
                              Estimated Hrs/Days: &nbsp; <span id="est-time">0</span><br>
                              Estimated For: &nbsp; <span id="est-for">0</span>
                          </p>
                      </div>
                  </div>
                  <div class="row py-2">
                      <div class="col-sm-6">
                          <div class="card">
                              <div class="card-header">
                                  <h6>SERVICE PROVIDER</h6>
                              </div>
                              <div class="card-body card-p-0">
                                  <p class="card-text">Troiscon International FZC</p>
                                  <p class="card-text"> Address: 692 Clover Drive
                                      Burlington, CO 80807</p>
                                  <p class="card-text"><span> Phone:</span> (719) 340 1429</p>
                                  <p class="card-text"><span> FAX:</span></p>
                                  <p class="card-text"><span> Email:</span>info@jasonlimitedinc.com</p>
                              </div>
                          </div>
                      </div>
                      <div class="col-sm-6" id="client-box">

                      </div>
                  </div>
              </div>
              <div class="row ml-2 mr-2">
                  <div class="col-sm-12">
                      <table class="table border-0" id="estimate-report-view">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Role</th>
                                  <th scope="col" class="text-center">Rate <br><span id="rates"></span></th>
                                  <th scope="col" class="text-center">Estimated <br><span id="times"></span> <br>
                                      <span id="estTime"></span>
                                  </th>
                                  <th scope="col" class="text-center">Total<br>(Amount)</th>
                              </tr>
                          </thead>
                          <tbody id="estimate-report-tbody">
                          </tbody>
                          <tfoot id="est-tfoot">
                          </tfoot>
                      </table>

                      <div>
                          <div class="row">
                              <div class="col-sm-12">
                                  <div><a href="#" class="btn btn-danger float-right my-2 mr-2 btn-back" >Back</a></div>
                                  <div><a class="btn btn-primary float-right my-2 mr-2" id="print">Print</a></div>
                              </div>
                          </div>
                      </div>

                  </div>
              </div>

      </section>

  </div>






  <!-- /.content-wrapper -->