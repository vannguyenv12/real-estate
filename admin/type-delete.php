<?php include 'layouts/top.php'; ?>

<?php

try {
    $statement = $pdo->prepare("SELECT * FROM properties WHERE type_id = ?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();

    if ($total) {
        throw new Exception("You can't delete this type, because one or more properties exit.");
    }

    $statement = $pdo->prepare("DELETE FROM types WHERE id=?");
    $statement->execute([$_REQUEST['id']]);

    $success_message = "Type has been deleted successfully!";
    $_SESSION['success_message'] = $success_message;

    header('location: ' . ADMIN_URL . 'type-view.php');
    exit;
} catch (Exception $e) {
    $error_message = $e->getMessage();
    $_SESSION['error_message'] = $error_message;
    header('location: ' . ADMIN_URL . 'type-view.php');
    exit;
}

?>
