<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row m-0">
                    <div class="col-sm-6">
                        <h4 class="m-0">Assigned Projects To <?php echo isset($mangerName)?$mangerName[0]['first_name'].' '.$mangerName[0]['last_name']:''?></h4>
                    </div>
                    <div class="col-sm-6">
                        <a class="btn btn-primary float-right ml-2" href="#" title="Assign new project" data-toggle="modal" data-target="#assignModal"><i class="fas fa-plus-square"></i></a> 
                        <a class="btn btn-warning float-right ml-2" href="javascript:history.go(-1)" title="Back" ><i class="fas fa-arrow-left text-white"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table dataTable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Project <br />Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Consumed <br />Hrs</th>
                                <th scope="col">Start <br>Date</th>
                                <th scope="col">End <br>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($projects)) {
                                // echo '<pre>';
                                // print_r($projects);
                                $count = 1;
                                foreach ($projects as $item) {
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo  $count++; ?></th>

                                        <td><?php echo $item['name'] ?></td>
                                        <td><?php echo $item['description']; ?></td>
                                        <td></td>
                                        <td><?php
                                            echo date_format(date_create($item['start_date']), "d/m/Y"); ?></td>
                                        <td><?php echo date_format(date_create($item['end_date']), "d/m/Y"); ?></td>


                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="assignModalLabel">Assign Project</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="assignForm">
                                    <div class="form-group col-sm-12">
                                        <label for="projects">Projects</label>
                                        <select name="projects" id="projects" class="form-control">
                                            <?php if (!empty($newProjects)) {
                                                foreach ($newProjects as $item) { ?>
                                                    <option value="<?php echo base64_encode($item['project_Id']) ?>"><?php echo $item['name'] ?></option>
                                            <?php }
                                            }else {?>
                                                <option value="">Not available</option>
                                            <?php }?>
                                        </select>
                                        <input type="hidden" name="mid" value="<?php echo isset($Mid) ? base64_encode($Mid) : '' ?>">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary float-right">Assign</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>