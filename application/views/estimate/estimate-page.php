  <!-- Content Wrapper. Contains page content -->
  </section>
  <style>
      .bgColor {
          background-color: #c1c1c1;
      }

      .f-13 {
          font-size: 13px;
      }
  </style>
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- Main content -->
      <section class="content">
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
                      <div style="text-align:right;padding-right:10px;margin-top:;">
                          Estimated Cost: &nbsp;<span id="cost">0 </span> <br>
                          Estimated Hrs/Days: &nbsp; <span id="time">0 </span>
                      </div>
                  </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table class=" table-striped table-responsive" id="report-data-Table">
                      <thead>
                          <tr>
                              <th scope="col">#</th>
                              <th scope="col">Question</th>
                              <th scope="col">Requred <br> Resource (Role)</th>
                              <th scope="col" class="text-center">Rate <br>(*/hrs)</th>
                              <th scope="col" class="text-center">Estimated <br>
                                  <input type="radio" name="estimatedTime" value="1" id="days" class="estimatedTime">Days
                                  <input type="radio" name="estimatedTime" value="2" id="hrs" class="estimatedTime">hrs
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
                                      <td class=" text-center rates" contenteditable="true">1</td>
                                      <td class=" text-center estimate-time" contenteditable="true">1</td>
                                      <td class=" text-center totalAmt">-</td>
                                  </tr>
                          <?php }
                            } ?>
                      </tbody>
                  </table>
                  <div><button class="btn btn-primary float-right my-2">Generate Estimate</button></div>

              </div>
          </div>
  </div>
  </section>

  <!-- /.modal -->

  <!-- /.content-wrapper -->