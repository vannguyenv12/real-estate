<?php include 'layouts/top.php'; ?>

<?php
try {

    $statement = $pdo->prepare("SELECT * FROM properties WHERE FIND_IN_SET(?, amenities) > 0");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();

    if ($total) {
        throw new Exception("This amenity is used in properties. It can't be deleted!");
    }

    $statement = $pdo->prepare("DELETE FROM amenities WHERE id=?");
    $statement->execute([$_REQUEST['id']]);

    $success_message = "Amenity has been deleted successfully!";
    $_SESSION['success_message'] = $success_message;

    header('location: ' . ADMIN_URL . 'amenity-view.php');
    exit;
} catch (Exception $e) {
    $error_message = $e->getMessage();
    $_SESSION['error_message'] = $error_message;
    header('location: ' . ADMIN_URL . 'amenity-view.php');
    exit;
}
?>
