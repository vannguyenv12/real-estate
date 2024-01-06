<?php include 'layouts/top.php'; ?>

<?php
$statement = $pdo->prepare("DELETE FROM packages WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Package has been deleted successfully!";
$_SESSION['success_message'] = $success_message;

header('location: ' . ADMIN_URL . 'package-view.php');
exit;
?>
