<?php include 'layouts/top.php'; ?>


<?php
if (isset($_POST['form_submit'])) {
    try {
        if ($_POST['name'] == "") {
            throw new Exception("Name can not be empty");
        }
        if ($_POST['price'] == "") {
            throw new Exception("Price can not be empty");
        }
        if ($_POST['allowed_days'] == "") {
            throw new Exception("Allowed Days can not be empty");
        }
        if ($_POST['allowed_properties'] == "") {
            throw new Exception("Allowed Properties can not be empty");
        }
        if ($_POST['allowed_featured_properties'] == "") {
            throw new Exception("Allowed Featured Properties can not be empty");
        }
        if ($_POST['allowed_photos'] == "") {
            throw new Exception("Allowed Photos can not be empty");
        }
        if ($_POST['allowed_videos'] == "") {
            throw new Exception("Allowed Videos can not be empty");
        }

        $statement = $pdo->prepare(
            "UPDATE packages SET 
                                    name=?,
                                    price=?,
                                    allowed_days=?,
                                    allowed_properties=?,
                                    allowed_featured_properties=?,
                                    allowed_photos=?,
                                    allowed_videos = ?
                                    WHERE id=?"
        );


        $statement->execute(array(
            $_POST['name'],
            $_POST['price'],
            $_POST['allowed_days'],
            $_POST['allowed_properties'],
            $_POST['allowed_featured_properties'],
            $_POST['allowed_photos'],
            $_POST['allowed_videos'],
            $_REQUEST['id']
        ));

        $success_message = "Package is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: ' . ADMIN_URL . 'package-edit.php?id=' . $_REQUEST['id']);
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
$statement->execute([$_REQUEST['id']]);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Package</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>package-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View Packages</a>
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
                                    <div class="form-group mb-3">
                                        <label>Price *</label>
                                        <input type="text" class="form-control" name="price" value="<?php echo $result[0]['price']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Allowed Days *</label>
                                        <input type="text" class="form-control" name="allowed_days" value="<?php echo $result[0]['allowed_days']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Allowed Properties *</label>
                                        <input type="text" class="form-control" name="allowed_properties" value="<?php echo $result[0]['allowed_properties']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Allowed Featured Properties *</label>
                                        <input type="text" class="form-control" name="allowed_featured_properties" value="<?php echo $result[0]['allowed_featured_properties']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Allowed Photos *</label>
                                        <input type="text" class="form-control" name="allowed_photos" value="<?php echo $result[0]['allowed_photos']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Allowed Videos *</label>
                                        <input type="text" class="form-control" name="allowed_videos" value="<?php echo $result[0]['allowed_videos']; ?>">
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