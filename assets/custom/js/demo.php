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