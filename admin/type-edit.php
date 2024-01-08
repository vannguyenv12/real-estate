<?php include 'layouts/top.php'; ?>


<?php
if (isset($_POST['form_submit'])) {
    try {
        if ($_POST['name'] == "") {
            throw new Exception("Name can not be empty");
        }

        $statement = $pdo->prepare("SELECT * FROM types WHERE name=? AND id != ?");
        $statement->execute([$_POST['name'], $_REQUEST['id']]);
        $total = $statement->rowCount();

        if ($total) {
            throw new Exception("Name already exist!");
        }

        $statement = $pdo->prepare(
            "UPDATE types SET 
                                    name=?
                                    WHERE id=?"
        );


        $statement->execute(array(
            $_POST['name'],
            $_REQUEST['id']
        ));

        $success_message = "Type is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: ' . ADMIN_URL . 'type-edit.php?id=' . $_REQUEST['id']);
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM types WHERE id = ?");
$statement->execute([$_REQUEST['id']]);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Type</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>type-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="row">

                                    <div class="form-group mb-3">
                                        <label>Name *</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name']; ?>">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary" name="form_submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'layouts/footer.php'; ?>