<style type="text/css">
    .form-control
    {
        border-radius:0px;
    }
    .form-group .form-line:not('#datepicker')
    {
        border-bottom:0px;
    }
    .form-group
    {
        margin-bottom:0px;
    }
    .demo-checkbox label, .demo-radio-button label
    {
        min-width:0px;
    }
    .clientDes, .contractDes, .serviceDes
    {
        display: none;
    }
    /*.card .body .col-xs-4, .card .body .col-sm-4, .card .body .col-md-4, .card .body .col-lg-4, .card .body .col-xs-3, .card .body .col-sm-3, .card .body .col-md-3, .card .body .col-lg-3
    {
        margin-bottom: 0px;
    }*/
    .margin-zero
    {
        margin-bottom: 0px !important;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <!-- <div class="block-header">
            <h2></h2>
        </div> -->
        <!-- Vertical Layout -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <!-- <div class="header">
                        <h2>
                            VERTICAL LAYOUT
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="material-icons">more_vert</i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another action</a></li>
                                    <li><a href="javascript:void(0);">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div> -->
                    <div class="body">
                        <div class="row">
                            <div class="col-sm-4 margin-zero">
                                <label for="email_address">Resource Id : <?php  if(isset($_SESSION['userInfo']['username'])){ echo $_SESSION['userInfo']['username']; } ?></label>
                            </div>
                            <div class="col-sm-4 margin-zero" align="center">
                                <label for="email_address">Resource Name : <?php  if(isset($_SESSION['userInfo']['name'])){ echo ucwords($_SESSION['userInfo']['name']); } ?></label>
                            </div>
                            <div class="col-sm-4 margin-zero">
                                <label for="email_address" class="col-sm-3">Date</label>
                                <div class="col-sm-9">
                                    <input type="text" name="date" class="form-control" id="datepicker" placeholder="Please select date" autocomplete="off" value="<?php echo date("d/m/Y"); ?>">
                                </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 margin-zero">
                                <label for="email_address" class="col-sm-3">Client</label>
                                <div class="col-sm-9">
                                    <select class="form-control client" class="form-control">
                                        <!-- <option value="">Select Client</option> -->
                                        <?php
                                            if(!empty($allClients))
                                            {
                                                foreach($allClients as $clients)
                                                {
                                        ?>
                                                    <option value="<?php echo $clients['clientId']; ?>" des="<?php echo $clients['clientDescription']; ?>"><?php echo $clients['clientName']; ?></option>
                                        <?php            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>    
                            </div>

                            <div class="col-sm-3 margin-zero">
                                <label for="email_address" class="col-sm-3">Contract</label>
                                <div class="col-sm-9">                                    
                                    <select class="form-control contract" class="form-control">
                                        <option value="">Select Contract</option>
                                    </select>                                        
                                </div>    
                            </div>

                            <div class="col-sm-3 margin-zero">
                                <label for="email_address" class="col-sm-3">Location</label>
                                <div class="col-sm-9">                                    
                                    <select class="form-control location" class="form-control">
                                        <option value="">Select Location</option>
                                    </select>                                        
                                </div>    
                            </div>

                            <div class="col-sm-3 margin-zero">
                                <label for="email_address" class="col-sm-3">Services</label>
                                <div class="col-sm-9">                                    
                                    <select class="form-control service" class="form-control">
                                        <option value="">Select Service</option>
                                    </select>                                        
                                </div>    
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 margin-zero">
                                <label for="email_address" class="col-sm-4">From Time</label>
                                <div class="col-sm-8">
                                    
                                    <input type="text" name="startTime" class="form-control timepicker startTime" autocomplete="off">
                                        
                                </div> 
                            </div>

                            <div class="col-sm-3 margin-zero">
                                <label for="email_address" class="col-sm-4">To Time</label>
                                <div class="col-sm-8">
                                    
                                    <input type="text" name="endTime" class="form-control timepicker endTime" autocomplete="off">
                                        
                                </div> 
                            </div>

                            <div class="col-sm-6 margin-zero">

                                <div class="col-sm-4">
                                    <label for="email_address" class="col-sm-3">Total Hours</label>
                                    <div class="col-sm-9" align="center">
                                        <p id="diffHours">0</p>
                                        <!-- <input type="text" name="diffHours" class="form-control diffHours" autocomplete="off"> -->
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <label for="email_address" class="col-sm-3">Budget Hours</label>
                                    <div class="col-sm-9" align="center">
                                        <span id="budgetedHours">0</span>
                                        <!-- <input type="text" name="diffHours" class="form-control diffHours" autocomplete="off"> -->
                                    </div> 
                                </div>

                                <div class="col-sm-4">
                                    <label for="email_address" class="col-sm-3">Consumed Hours</label>
                                    <div class="col-sm-9" align="right">
                                        <span id="consumed">0</span>
                                        <!-- <input type="text" name="diffHours" class="form-control diffHours" autocomplete="off"> -->
                                    </div> 
                                </div>
                            </div>    
                        </div>

                        <div class="row">
                            
                            <div class="col-sm-11 margin-zero">
                                <table id="mainTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Activity</th>
                                            <th style="width:10%;">Hours</th>
                                            <th>Remarks</th>
                                            <th>File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       <tr class="blank_row">
                                            <td>
                                                <select class="activity form-control">
                                                    <option value="">Select Activity</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="hours form-control timepicker2" autocomplete="off">
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="text" class="remarks form-control">
                                            </td>
                                            <td style="text-align:center;">
                                                <label class="btn-bs-file btn btn-xs btn-flat btn-primary">
                                                    <i class="material-icons">attach_file</i>
                                                    <input type="file" class="attchment" style="display:none;">
                                                </label>
                                            </td>                                      
                                        </tr>

                                        <tr>
                                            <td>
                                                <select class="activity form-control">
                                                    <option value="">Select Activity</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="hours form-control timepicker2" autocomplete="off">
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="text" class="remarks form-control">
                                            </td>
                                            <td style="text-align:center;">
                                                <label class="btn-bs-file btn btn-xs btn-flat btn-primary">
                                                    <i class="material-icons">attach_file</i>
                                                    <input type="file" class="attchment" style="display:none;">
                                                </label>
                                            </td>   
                                        </tr>

                                        <tr>
                                            <td>
                                                <select class="activity form-control">
                                                    <option value="">Select Activity</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="hours form-control timepicker2" autocomplete="off">
                                            </td>
                                            <td style="text-align:center;">
                                                <input type="text" class="remarks form-control">
                                            </td>
                                            <td style="text-align:center;">
                                                <label class="btn-bs-file btn btn-xs btn-flat btn-primary">
                                                    <i class="material-icons">attach_file</i>
                                                    <input type="file" class="attchment" style="display:none;">
                                                </label>
                                            </td>   
                                        </tr>
                                        

                                    </tbody>
                                    <!-- <tfoot>
                                        <tr>
                                            <th><strong>TOTAL</strong></th>
                                            <th>1290</th>
                                            <th>1420</th>
                                            <th>5</th>
                                            <th>1290</th>
                                            <th>1420</th>
                                            <th>5</th>
                                            <th>1290</th>
                                            <th>1420</th>
                                            <th>5</th>
                                            <th>5</th>
                                        </tr>
                                    </tfoot> -->
                                </table>
                            </div>

                            <div class="col-sm-1 margin-zero">
                                <button type="button" id="addAnotherLine" class="btn btn-primary btn-sm waves-effect">
                                    <i class="material-icons">add</i>
                                </button> 
                            </div>
                        </div>

                        <div class="row clientDes">
                            <label class="col-sm-2">Client Description : </label>
                            <div class="col-sm-10">
                                <p id="#clientDes"></p>
                            </div>
                        </div>

                        <div class="row contractDes">
                            <label class="col-sm-2">Contract Description : </label>
                            <div class="col-sm-10">
                                <p id="#contractDes"></p>
                            </div>
                        </div>

                        <div class="row serviceDes">
                            <label class="col-sm-2">Service Description : </label>
                            <div class="col-sm-10">
                                <p id="#contractDes"></p>
                            </div>
                        </div>
                        
                        <div class="row">    
                            <div class="col-sm-12" align="center">
                                <button type="button" class="btn btn-primary btn-sm btn-lg waves-effect" id="submit">SUBMIT</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="header">
                        <h2>
                            Filled Timesheet
                        </h2>
                    </div>

                    <div class="body">

                        <div class="row">
                            <div class="col-sm-12">

                                 <table id="previousDetails" class="table table-bordered datatable">
                                    <thead>
                                        <tr>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Client</th>
                                            <th>Contract</th>
                                            <th>Service</th>
                                            <th>Total Hours</th>
                                            <th>Location</th>
                                            <!-- <th>Activity</th> -->
                                            <!-- <th>Budget Hours</th>
                                            <th>Consumed</th> -->
                                            <!-- <th>Hours</th> -->
                                            <!-- <th>Total Hours</th> -->
                                            <th>File</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                            if(!empty($todayTimesheetData))
                                            {
                                                foreach($todayTimesheetData as $details)
                                                {
                                        ?>
                                                    <tr>
                                                        <td><?php echo $details['startTime']; ?></td>
                                                        <td><?php echo $details['endTime']; ?></td>
                                                        <td><?php echo $details['clientName']; ?></td>
                                                        <td><?php echo $details['contract_name']; ?></td>
                                                        <td><?php echo $details['serviceName']; ?></td>
                                                        <td><?php echo sprintf("%.2f",$details['Hours']); ?></td>
                                                        <td><?php echo $details['locationName']; ?></td>
                                                        <!-- <td><?php echo $details['activityName']; ?></td> -->
                                                        <!-- <td><?php echo $details['budgetedHours']; ?></td>
                                                        <td><?php echo $details['consumedHours']; ?></td> -->
                                                        <!-- <td><?php echo date("H:i",strtotime($details['workingHours'])); ?></td> -->
                                                        <!-- <td><?php echo $details['totalWorkingHours']; ?></td> -->
                                                        <?php
                                                            if($details['attachment']!="")
                                                            {
                                                        ?>
                                                                <td><a href='<?php echo base_url(); ?>/uploads/<?php echo $details['attachment']; ?>' target='_blank'>Click here</a></td>
                                                        <?php        
                                                            }
                                                            else
                                                            {
                                                        ?>
                                                                <td></td>
                                                        <?php        
                                                            }
                                                        ?>
                                                        
                                                        <td><?php echo $details['remarks']; ?></td>
                                                        <td style="text-align:center;">
                                                            <a href="#" class="btn btn-primary btn-xs activityDetails" client="<?php echo $details['clientId']; ?>" contract="<?php echo $details['contractId']; ?>" service="<?php echo $details['serviceId']; ?>" startTime="<?php echo $details['startTime']; ?>" endtime="<?php echo $details['endTime']; ?>">
                                                                <i class="material-icons">info_outline</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                        <?php            
                                                }
                                            }
                                            else
                                            {
                                        ?>
                                                <tr>
                                                    <td align="center" colspan="12">No record found</td>
                                                </tr>
                                        <?php        
                                            }
                                        ?>
                                    </tbody>
                                </table>    

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Default Size -->
<div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Enter Remarks</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <label class="col-sm-2">Remarks</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="remarks"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" id="save">SAVE CHANGES</button>
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Default Size -->
<div class="modal fade" id="activityModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defaultModalLabel">Activities</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <table class="table table-bordered activityDetailRow">
                        <thead>
                            <th>Activity</th>
                            <th>Hours</th>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>