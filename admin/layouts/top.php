<?php
include '../config/config.php';
include 'layouts/header.php';
$cur_page = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);

if ($cur_page != 'login.php' &&  $cur_page != 'forget-password.php' && $cur_page != 'reset-password.php') :
    include 'layouts/nav.php';
    include 'layouts/sidebar.php';
endif;
