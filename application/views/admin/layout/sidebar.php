<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?php echo base_url('assets/') ?>custom/media/logo/logo.png" alt="Triscon Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?php echo BRAND_NAME ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo base_url('assets/') ?>custom/media/user/user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo base_url('profile/').base64_encode($_SESSION['logged_in']['people_id'])?>" class="d-block"><?php echo  isset($_SESSION['logged_in']['Name']) ? $_SESSION['logged_in']['Name'] : '' ?></a>  
                
                <!-- <a href="#" class="d-block"><?php echo  isset($_SESSION['logged_in']['Name']) ? $_SESSION['logged_in']['Name'] : '' ?></a> -->
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <!-- Menus for Admin   -->
            <?php if ($_SESSION['logged_in']['role'] == ADMIN) { ?>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('people-dashboard') ?>" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                People master
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Admin/project') ?>" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Projects
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Admin/assignProject') ?>" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                               Managers
                            </p>
                        </a>
                    </li>
                  
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Masters
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right"></span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/confidentiality') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Confidentiality</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/designation') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Designations</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/') ?>department" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Departments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/document') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Documents</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/document_category') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Document Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/document_owner') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Document Owners</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/role') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Roles</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/skill') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Skills</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/services_category') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Service Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="<?php echo base_url('Admin/taskmaster') ?>" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Tasks</p>
                                </a>
                            </li>

                        </ul>
                    </li>

                   
                </ul>

            <?php } ?>
            <!-- Menus for Manager -->
            <?php if ($_SESSION['logged_in']['role'] == MANAGER) { ?>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="<?php echo base_url('Reports/')?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo base_url('Manager/project') ?>" class="nav-link" id="dashboard">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Projects
                            </p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="<?php echo base_url('Manager/users') ?>" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Team
                                <!-- <i class="fas fa-angle-left right"></i> -->
                                <!-- <span class="badge badge-info right"></span> -->
                            </p>
                        </a>
                      
                    </li>
                    
                    <li class="nav-item ">
                        <a href="<?php echo base_url('Manager/dailyTimesheet/').base64_encode($_SESSION['logged_in']['people_id']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                            <p>
                            My TimeSheet
                                <!-- <i class="fas fa-angle-left right"></i> -->
                                <!-- <span class="badge badge-info right"></span> -->
                            </p>
                        </a>
                      
                    </li>   
                    
                    <li class="nav-item ">
                        <a href="<?php echo base_url('Manager/booketimes/').base64_encode($_SESSION['logged_in']['people_id']) ?>" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                            <p>
                            Book My Time
                                <!-- <i class="fas fa-angle-left right"></i> -->
                                <!-- <span class="badge badge-info right"></span> -->
                            </p>
                        </a>
                      
                    </li>

                   
                </ul>
            <?php } ?>

            <!-- Menus for user -->
            <?php if ($_SESSION['logged_in']['role'] == USER) { ?>
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="<?php echo base_url('Reports/user')?>" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo base_url('Employee/dailytimesheet') ?>" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                               Daily Timesheet
                            </p>
                        </a>
                    </li>

                    <!-- <li class="nav-item">
                        <a href="<?php echo base_url('Employee/timesheet') ?>" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                               Weekly Timesheet
                            </p>
                        </a>
                    </li> -->
               

                    <!-- <li class="nav-item">
                        <a href="<?php echo base_url('Employee/allocatedTask') ?>" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Allocated Tasks
                            </p>
                        </a>
                    </li> -->
                </ul>
            <?php } ?>
        </nav>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>