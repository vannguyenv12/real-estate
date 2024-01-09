<?php include 'layouts/top.php'; ?>

<?php
try {
    $statement = $pdo->prepare("SELECT * FROM properties WHERE location_id = ?");
    $statement->execute([$_REQUEST['id']]);
    $total = $statement->rowCount();

    if ($total) {
        throw new Exception("You can't delete this location, because one or more properties exit under this location.");
    }
} catch (Exception $e) {
    $error_message = $e->getMessage();
    $_SESSION['error_message'] = $error_message;
    header('location: ' . ADMIN_URL . 'location-view.php');
    exit;
}


$statement = $pdo->prepare("SELECT * FROM locations WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

unlink('../uploads/' . $result[0]['photo']);

$statement = $pdo->prepare("DELETE FROM locations WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Location has been deleted successfully!";
$_SESSION['success_message'] = $success_message;

header('location: ' . ADMIN_URL . 'location-view.php');
exit;
?>
