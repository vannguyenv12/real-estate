<?php

include "header.php";
unset($_SESSION['customer']);
$_SESSION['success_message'] = "Logout successfully!";
header('location: ' . BASE_URL . 'customer-login');
exit;
