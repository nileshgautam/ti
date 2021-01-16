  <!-- Content Wrapper. Contains page content -->
  </section>
  <style>
      .bgColor {
          background-color: #c1c1c1;
      }

      .f-13 {
          font-size: 13px;
      }

      .card-p-0 p {
          /* padding: 2px !important; */
          margin-bottom: 0 !important;
      }

      #estimate-view {
          display: none;
      }
  </style>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content" id="estimate-cal">
          <div class="card py-2">
              <!--  Card for Table -->
              <div class="card-header row m-0">
                  <div class="col-sm-6">
                      <div style="font-size:20px;font-weight:400;">
                          <div style="padding-left:50px;display:inline">
                              <strong><?php echo $header ?></strong>
                          </div>
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div style="text-align:right;padding-right:10px;margin-top:0;">
                          Estimated Cost: &nbsp;<span id="cost">0 </span> <br>
                          Estimated Hrs/Days: &nbsp; <span id="time">0 </span>
                      </div>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table class="table table-striped" id="report-data-Table">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Question</th>
                              <th scope="col">Role</th>
                              <th scope="col" class="text-center">Rate <br>(hrs)</th>
                              <th scope="col" class="text-center">Estimated <br>
                                  <input type="radio" name="estimatedTime" value="8" id="days" class="estimatedTime" checked>Days
                                  <input type="radio" name="estimatedTime" value="1" id="hrs" class="estimatedTime">hrs
                              </th>
                              <th scope="col" class="text-center">Total Estimated<br>(Ammount)</th>
                          </tr>
                      </thead>
                      <tbody id='reportTablebody'>
                          <?php

                            if (!empty($question)) {
                                $count = 1;
                                foreach ($question as $questionItem) {
                            ?>
                                  <tr>
                                      <th scope="row"><?php echo $count++ ?></th>
                                      <td class=""><?php echo $questionItem['title'] ?></td>
                                      <td class="">
                                          <select name="" id="" class="form-control border-0 f-13 selected-role">
                                              <option value="">Select</option>
                                              <?php foreach ($roles as $item) { ?>
                                                  <option value="<?php echo $item['id'] ?>" data-rate="<?php echo $item['rate'] ?>"><?php echo $item['role'] ?></option>
                                              <?php } ?>
                                          </select>
                                      </td>
                                      <td class=" text-center rates" contenteditable="true">0.00</td>
                                      <td class=" text-center estimate-time" contenteditable="true">0</td>
                                      <td class=" text-right totalAmt">0.00</td>
                                  </tr>
                          <?php }
                            } ?>
                      </tbody>
                      <tfoot id="grd-tfoot">
                          <tr class="border-top">
                              <th colspan="4" class="text-right">Sub Total</th>
                              <td></td>
                              <td class=" text-right" id="totalAmt">0.00</td>
                          </tr>
                          <tr class="">
                              <th colspan="4" class="text-right">Margin (+%)</th>
                              <td contenteditable="true" class="text-center" id="mrg">10</td>
                              <td class=" text-right" id="margin">0.00</td>
                          </tr>
                          <tr class="">
                              <th colspan="4" class="text-right">Discount (-%)</th>
                              <td contenteditable="true" class="text-center" id="dis">0</td>
                              <td class=" text-right" id="discount">0.00</td>
                          </tr>
                          <tr class="">

                              <th colspan="4" class="text-right">Tax/GST</th>
                              <td contenteditable="true" class="text-center" id="gst">18</td>
                              <td class=" text-right" id="gst-tax">0.00</td>
                          </tr>
                          <tr class="">
                              <th colspan="4" class="text-right">Grand Total</th>
                              <td></td>
                              <td class=" text-right" id='grandTotal'>0.00</td>
                          </tr>

                      </tfoot>
                  </table>
                  <div><button class="btn btn-primary float-right my-2" id="generate-reports"> Show Estimate </button></div>
              </div>
          </div>
      </section>
      <!-- Report print section -->
      <section class="content" id="estimate-view">
          <div class="card">
              <div class="card-header">
                  <div class="row">
                      <div class="col-sm-6">
                          <img src="../assets/custom/media/logo/troiscon-logo.png" alt="logo" class="">
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
                                  <div><a href="" class="btn btn-danger float-right my-2 mr-2" id="cancel">Cancel</a></div>
                                  <div><a class="btn btn-primary float-right my-2 mr-2" id="print">Print</a></div>
                              </div>


                          </div>
                      </div>

                  </div>
              </div>

      </section>
  </div>


  <!-- /.modal -->

  <!-- /.content-wrapper -->