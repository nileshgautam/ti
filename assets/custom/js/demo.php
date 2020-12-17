<?php if (!empty($description)) {
                // print_r($description);
                $rowid=1;
                $count = 1;
                foreach ($description as $row) { ?>
                  <tr id="<?php echo $rowid++; ?>">
                    <td><?php echo $count++ ?></td>
                    <td><?php echo $row['description'] ?></td>
                    <td><div class="tbl-btn"><i class="fas fa-edit edit" data-id="<?php echo $row['id'] ?>"></i>
                    <i class="fas fa-trash-alt delete" data-id="<?php echo $row['id'] ?>"></i></div></td>
                  </tr>
              <?php  }
              }
              ?>


<div class="col-sm-12">
                                            <?php if (!empty($dailytimesheet)) {
                                                foreach ($dailytimesheet as $key => $time) { ?>
                                                    <div class="row bg-light mb-2 border-bottom">
                                                        <div class="col-sm-2"><?php echo $key; ?></div>
                                                        <div class="col-sm-10 ">
                                                            <?php
                                                            if (!empty($time)) {
                                                                foreach ($time as $key1 => $bookedTime) {
                                                                    foreach ($bookedTime as $time) {
                                                            ?>
                                                                        <div class="bg-info">
                                                                            <p class="p-2 fs-14 showTask" dataTaskid="<?php echo base64_encode($time['task_id']) ?>">
                                                                                <?php
                                                                                // print_r($time);
                                                                                echo $time['title'] . '   status: <span class="badge badge-success">  ' . $time['status'] . ' </span>';
                                                                                echo '<br/>';
                                                                                echo '<span>' . date('h:i a', strtotime($time['taskStTime'])) . '<span> -' .
                                                                                    '</span> ' . date('h:i a', strtotime($time['taskedTime'])) . ' </span>' ?>
                                                                            </p>
                                                                        </div>

                                                            <?php }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                            <?php }
                                            }
                                            ?>
                                        </div>