<?php include 'layouts/top.php'; ?>


<?php
if (isset($_POST['form_submit'])) {
    try {
        if ($_POST['name'] == "") {
            throw new Exception("Name can not be empty");
        }

        $statement = $pdo->prepare("SELECT * FROM locations WHERE name=? AND id != ?");
        $statement->execute([$_POST['name'], $_REQUEST['id']]);
        $total = $statement->rowCount();

        if ($total) {
            throw new Exception("Name already exist!");
        }

        if ($_POST['slug'] == "") {
            throw new Exception("Slug can not be empty");
        }

        if (!preg_match('/^[a-z][-a-z0-9]*$/', $_POST['slug'])) {
            throw new Exception("The slug is invalid");
        }

        $statement = $pdo->prepare("SELECT * FROM locations WHERE slug=? AND id != ?");
        $statement->execute([$_POST['slug'], $_REQUEST['id']]);
        $total = $statement->rowCount();

        if ($total) {
            throw new Exception("Slug already exist!");
        }

        // Update photo
        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path != "") {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time() . "." . $extension;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);

            if ($mime != 'image/jpeg' && $mime != 'image/png') {
                throw new Exception("Please upload a valid photo");
            }

            unlink('../uploads/' . $_POST['current_photo']);
            move_uploaded_file($path_tmp, '../uploads/' . $filename);
        } else {
            $filename = $_POST['current_photo'];
        }



        $statement = $pdo->prepare(
            "UPDATE locations SET 
                                    name=?,
                                    slug=?,
                                    photo=?
                                    WHERE id=?"
        );


        $statement->execute(array(
            $_POST['name'],
            $_POST['slug'],
            $filename,
            $_REQUEST['id']
        ));

        $success_message = "Location is added successfully.";

        $_SESSION['success_message'] = $success_message;
        header('location: ' . ADMIN_URL . 'location-edit.php?id=' . $_REQUEST['id']);
        exit;
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<?php
$statement = $pdo->prepare("SELECT * FROM locations WHERE id = ?");
$statement->execute([$_REQUEST['id']]);

$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
    <section class="section">
        <div class="section-header justify-content-between">
            <h1>Edit Location</h1>
            <div class="ml-auto">
                <a href="<?php echo ADMIN_URL; ?>location-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View Locations</a>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="current_photo" value="<?php echo $result[0]['photo']; ?>">
                                <div class="row">
                                    <div class="form-group mb-3">
                                        <label>Existing Photo *</label>
                                        <div class="">
                                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['photo'] ?>" class="w_200" alt="">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Existing Photo *</label>
                                        <input type="file" class="form-control" name="photo">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Name *</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name']; ?>">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Slug *</label>
                                        <input type="text" class="form-control" name="slug" value="<?php echo $result[0]['slug']; ?>">
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