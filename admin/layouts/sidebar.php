<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?php echo ADMIN_URL ?>dashboard.php">Admin Panel</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html"></a>
        </div>

        <ul class="sidebar-menu">

            <li class="<?php if ($cur_page == 'dashboard.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL ?>dashboard.php"><i class="fas fa-hand-point-right"></i> <span>Dashboard</span></a></li>

            <li class="nav-item dropdown <?php if (
                                                $cur_page == 'location-view.php' ||
                                                $cur_page == 'location-add.php' ||
                                                $cur_page == 'location-edit.php' ||
                                                $cur_page == 'type-view.php' ||
                                                $cur_page == 'type-add.php' ||
                                                $cur_page == 'type-edit.php' ||
                                                $cur_page == 'amenity-view.php' ||
                                                $cur_page == 'amenity-add.php' ||
                                                $cur_page == 'amenity-edit.php'

                                            ) {
                                                echo 'active';
                                            } ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-hand-point-right"></i><span>Property Section</span></a>
                <ul class="dropdown-menu">
                    <li class="<?php if ($cur_page == 'location-view.php' || $cur_page == 'location-add.php' || $cur_page == 'location-edit.php') {
                                    echo 'active';
                                } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>location-view.php"><i class="fas fa-angle-right"></i> Location</a></li>

                    <li class="<?php if ($cur_page == 'type-view.php' || $cur_page == 'type-add.php' || $cur_page == 'type-edit.php') {
                                    echo 'active';
                                } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>type-view.php"><i class="fas fa-angle-right"></i> Type</a></li>

                    <li class="<?php if ($cur_page == 'amenity-view.php' || $cur_page == 'amenity-add.php' || $cur_page == 'amenity-edit.php') {
                                    echo 'active';
                                } ?>"><a class="nav-link" href="<?php echo ADMIN_URL; ?>amenity-view.php"><i class="fas fa-angle-right"></i> Amenity</a></li>
                </ul>
            </li>

            <!-- <li class="<?php if ($cur_page == 'setting.php') {
                                echo 'active';
                            } ?>"><a class="nav-link" href="<?php echo ADMIN_URL ?>setting.php"><i class="fas fa-hand-point-right"></i> <span>Setting</span></a></li> -->

            <li class="<?php if ($cur_page == 'package-view.php' || $cur_page == 'package-add.php' || $cur_page == 'package-edit.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL ?>package-view.php"><i class="fas fa-hand-point-right"></i> <span>Packages</span></a></li>

            <!-- <li class="<?php if ($cur_page == 'form.php') {
                                echo 'active';
                            } ?>"><a class="nav-link" href="<?php echo ADMIN_URL ?>form.php"><i class="fas fa-hand-point-right"></i> <span>Form</span></a></li>

            <li class="<?php if ($cur_page == 'table.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL ?>table.php"><i class="fas fa-hand-point-right"></i> <span>Table</span></a></li>

            <li class="<?php if ($cur_page == 'invoice.php') {
                            echo 'active';
                        } ?>"><a class="nav-link" href="<?php echo ADMIN_URL ?>invoice.php"><i class="fas fa-hand-point-right"></i> <span>Invoice</span></a></li> -->

        </ul>
    </aside>
</div>