<style type="text/css">
    .col-sm-6
    {
        margin-top:10px;
    }
    .profile-info
    {
        margin-top:15px;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row m-b-lg m-t-lg">
        <div class="col-md-6">
            <?php
                if(isset($userDetails[0]['image']) && $userDetails[0]['image']!="" && file_exists(FCPATH."uploads/userImage/".$userDetails[0]['image']))
                {
                    $imagePath = base_url()."uploads/userImage/".$userDetails[0]['image'];
                }
                else
                {
                    $imagePath = base_url()."assets/img/default.png";
                }
            ?>
            <div class="profile-image">
                <img src="<?php echo $imagePath; ?>" class="img-circle circle-border m-b-md" alt="profile">
                <input type="file" name="userImage" style="display: none;">
            </div>
            <div class="profile-info">
                <div class="">
                    <div>
                        <h2 class="no-margins">
                            <?php if(isset($userDetails[0]['name'])){ echo $userDetails[0]['name']; } ?>
                        </h2>
                        <h4><?php if(isset($userDetails[0]['designation'])){ echo $userDetails[0]['designation']; } ?></h4>
                        <small>
                            <i class="fa fa-envelope">&nbsp;</i><?php if(isset($userDetails[0]['email'])){ echo $userDetails[0]['email']; } ?>
                            <!-- There are many variations of passages of Lorem Ipsum available, but the majority
                            have suffered alteration in some form Ipsum available. -->
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>User Details</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#">Config option 1</a>
                            </li>
                            <li><a href="#">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form id="userForm">
                        <div class="row">
                            
                            <div class="col-sm-6">
                                <label class="col-sm-4">Name</label>
                                <div class="col-sm-8">
                                    <input type="text" name="name" class="form-control" value="<?php if(isset($userDetails[0]['name'])){ echo $userDetails[0]['name']; } ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Email</label>
                                <div class="col-sm-8">
                                    <input type="text" name="email" class="form-control" value="<?php if(isset($userDetails[0]['email'])){ echo $userDetails[0]['email']; } ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Mobile</label>
                                <div class="col-sm-8">
                                    <input type="text" name="mobile" class="form-control" value="<?php if(isset($userDetails[0]['phone'])){ echo $userDetails[0]['phone']; } ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Pincode</label>
                                <div class="col-sm-8">
                                    <input type="text" name="pincode" class="form-control" value="<?php if(isset($userDetails[0]['pincode'])){ echo $userDetails[0]['pincode']; } ?>">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Choose Image</label>
                                <div class="col-sm-8">
                                    <input type="file" name="userImage" accept=".jpg,.png,.gif">
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <label class="col-sm-4">Address</label>
                                <div class="col-sm-8">
                                    <textarea name="address" class="form-control"><?php if(isset($userDetails[0]['address'])){ echo $userDetails[0]['address']; } ?></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12" align="center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>    