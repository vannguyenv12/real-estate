<?php

include "layouts/top.php";
unset($_SESSION['admin']);
header('location: ' . ADMIN_URL . 'login.php');
exit;
