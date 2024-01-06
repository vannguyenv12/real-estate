<?php include 'header.php'; ?>

<?php
if (isset($_POST['form_update'])) {
    try {
        if ($_POST['full_name'] == '') {
            throw new Exception("Fullname can not be empty");
        }

        if ($_POST['email'] == '') {
            throw new Exception("Email can not be empty");
        }

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        }

        $statement = $pdo->prepare("UPDATE agents SET 
                                    full_name=?, 
                                    email=?,
                                    company=?,
                                    designation=?,
                                    biography=?,
                                    phone=?,
                                    country=?,
                                    address=?,
                                    state=?,
                                    city=?,
                                    zip_code=?,
                                    website=?,
                                    facebook=?,
                                    twitter=?,
                                    linkedin=?,
                                    pinterest=?,
                                    instagram=?,
                                    youtube=?

                                    WHERE id=?");
        $statement->execute([
            $_POST['full_name'],
            $_POST['email'],
            $_POST['company'],
            $_POST['designation'],
            $_POST['biography'],
            $_POST['phone'],
            $_POST['country'],
            $_POST['address'],
            $_POST['state'],
            $_POST['city'],
            $_POST['zip_code'],
            $_POST['website'],
            $_POST['facebook'],
            $_POST['twitter'],
            $_POST['linkedin'],
            $_POST['pinterest'],
            $_POST['instagram'],
            $_POST['youtube'],
            $_SESSION['agent']['id']
        ]);

        if ($_POST['password'] != '' || $_POST['retype_password'] != '') {
            if ($_POST['password'] != $_POST['retype_password']) {
                throw new Exception("Passwords do not match");
            } else {
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $statement = $pdo->prepare('UPDATE agents SET password = ? WHERE id = ?');
                $statement->execute([$password, $_SESSION['agent']['id']]);
            }
        }

        // Update photo
        $path = $_FILES['photo']['name'];
        $path_tmp = $_FILES['photo']['tmp_name'];

        if ($path != '') {
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $filename = time() . "." . $extension;

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $path_tmp);

            if ($mime == 'image/jpeg' || $mime == 'image/png') {
                if ($_SESSION['agent']['photo']) {
                    unlink('/uploads', $_SESSION['agent']['photo']);
                }

                move_uploaded_file($path_tmp, 'uploads/' . $filename);

                $statement = $pdo->prepare('UPDATE agents SET photo = ? WHERE id = ?');
                $statement->execute([$filename, $_SESSION['agent']['id']]);

                $_SESSION['agent']['photo'] = $filename;
            } else {
                throw new Exception("Please upload a valid photo");
            }
        }

        $_SESSION['agent']['full_name'] = $_POST['full_name'];
        $_SESSION['agent']['email'] = $_POST['email'];
        $_SESSION['agent']['company'] = $_POST['company'];
        $_SESSION['agent']['designation'] = $_POST['designation'];
        $_SESSION['agent']['biography'] = $_POST['biography'];
        $_SESSION['agent']['phone'] = $_POST['phone'];
        $_SESSION['agent']['country'] = $_POST['country'];
        $_SESSION['agent']['address'] = $_POST['address'];
        $_SESSION['agent']['state'] = $_POST['state'];
        $_SESSION['agent']['city'] = $_POST['city'];
        $_SESSION['agent']['zip_code'] = $_POST['zip_code'];
        $_SESSION['agent']['website'] = $_POST['website'];
        $_SESSION['agent']['facebook'] = $_POST['facebook'];
        $_SESSION['agent']['twitter'] = $_POST['twitter'];
        $_SESSION['agent']['linkedin'] = $_POST['linkedin'];
        $_SESSION['agent']['pinterest'] = $_POST['pinterest'];
        $_SESSION['agent']['instagram'] = $_POST['instagram'];
        $_SESSION['agent']['youtube'] = $_POST['youtube'];


        $success_message = 'Profile data is updated successfully!';
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Edit Profile</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <?php include 'agent-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="">Existing Photo</label>
                            <div class="form-group">
                                <?php if ($_SESSION['agent']['photo'] == '') : ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="" class="user-photo">
                                <?php else : ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $_SESSION['agent']['photo']; ?>" alt="" class="user-photo">
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Change Photo</label>
                            <div class="form-group">
                                <input type="file" name="photo">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Full Name *</label>
                            <div class="form-group">
                                <input type="text" name="full_name" class="form-control" value="<?php echo $_SESSION['agent']['full_name']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Email Address *</label>
                            <div class="form-group">
                                <input type="text" name="email" class="form-control" value="<?php echo $_SESSION['agent']['email']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Password</label>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Retype Password</label>
                            <div class="form-group">
                                <input type="password" name="retype_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Company</label>
                            <div class="form-group">
                                <input type="text" name="company" class="form-control" value="<?php echo $_SESSION['agent']['company']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Designation</label>
                            <div class="form-group">
                                <input type="text" name="designation" class="form-control" value="<?php echo $_SESSION['agent']['designation']; ?>">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="">Biography</label>
                            <textarea name="biography" class="form-control editor" cols="30" rows="10"><?php echo $_SESSION['agent']['biography']; ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Phone</label>
                            <div class="form-group">
                                <input type="text" name="phone" class="form-control" value="<?php echo $_SESSION['agent']['phone']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Country</label>
                            <div class="form-group">
                                <input type="text" name="country" class="form-control" value="<?php echo $_SESSION['agent']['country']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Address</label>
                            <div class="form-group">
                                <input type="text" name="address" class="form-control" value="<?php echo $_SESSION['agent']['address']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">State</label>
                            <div class="form-group">
                                <input type="text" name="state" class="form-control" value="<?php echo $_SESSION['agent']['state']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">City</label>
                            <div class="form-group">
                                <input type="text" name="city" class="form-control" value="<?php echo $_SESSION['agent']['city']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Zip Code</label>
                            <div class="form-group">
                                <input type="text" name="zip_code" class="form-control" value="<?php echo $_SESSION['agent']['zip_code']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Website</label>
                            <div class="form-group">
                                <input type="text" name="website" class="form-control" value="<?php echo $_SESSION['agent']['website']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Facebook</label>
                            <div class="form-group">
                                <input type="text" name="facebook" class="form-control" value="<?php echo $_SESSION['agent']['facebook']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Twitter</label>
                            <div class="form-group">
                                <input type="text" name="twitter" class="form-control" value="<?php echo $_SESSION['agent']['twitter']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Linkedin</label>
                            <div class="form-group">
                                <input type="text" name="linkedin" class="form-control" value="<?php echo $_SESSION['agent']['linkedin']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Pinterest</label>
                            <div class="form-group">
                                <input type="text" name="pinterest" class="form-control" value="<?php echo $_SESSION['agent']['pinterest']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Instagram</label>
                            <div class="form-group">
                                <input type="text" name="instagram" class="form-control" value="<?php echo $_SESSION['agent']['instagram']; ?>">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Youtube</label>
                            <div class="form-group">
                                <input type="text" name="youtube" class="form-control" value="<?php echo $_SESSION['agent']['youtube']; ?>">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input name="form_update" type="submit" class="btn btn-primary" value="Update">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>