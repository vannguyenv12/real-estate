<?php

include "header.php";
unset($_SESSION['agent']);
$_SESSION['success_message'] = "Logout successfully!";
header('location: ' . BASE_URL . 'agent-login');
exit;
